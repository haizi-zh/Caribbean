/**
 * ping
 */
define(function(require){
    // console.log(window.jQuery);
    // var $ = window.jQuery;
    var $ = require('jquery');
    var hogan = require('hogan');
    var util = require('util');
    var config = require('ping/config');
    var login = require('common/login');
    var popup = require('widget/popup/main');
    var pager = require('widget/pager/main');
    var fixedable = require('widget/fixedable/main');
    var richEditor = require('widget/richeditor/main');
    var rating = require('widget/rating/main');

    var view = {};
    view.$sendPing = $('#send_ping');
    view.$reply = $('#reply');
    view.$pingContent = $('#ping_content');
    view.$delDianping = $('#delDianping');
    view.$commentList = $('#comment_list');
    
    var fixedable = require('widget/fixedable/main');
    fixedable.addEl("this_top", "side_bar");
        
    view.$commentList.delegate(
        '[action-type=modifyDianping]',
        'click',
        function(e) {
            var $this = $(this);
            var args = util.json.queryToJson($(this).attr('action-data'));
            $.ajax({
                'type': 'get',
                'dataType': 'json',
                'url': config.AJAX.GET_DIANPING,
                'data': {
                    id: args.id
                },
                'success': function(data){
                    richEditor.show({
                        content: data.html.body,
                        confirmFn: function (content, richEditorPop) {
                            if (!util.str.trim(content)) {
                                popup.alertPopup('点评内容不能为空');
                            }
                            else {
                                var pids = '';
                                var srcReg = /src=[\'\"]?([^\'\"]*)[\'\"]?/i;
                                var arr = content.match(/<img.*?(?:>|\/>)/gi);
                                if(arr){
                                    for (var i = 0; i < arr.length; i++) {
                                        var src = arr[i].match(srcReg);
                                        if (src[1]) {
                                            pids += src[1].replace(/!popup$/, '') + ',';
                                        }
                                    }
                                }
                                $.ajax({
                                    'type': 'post',
                                    'url': config.AJAX.ADD_DIANPING,
                                    'dataType': 'json',
                                    'data': {
                                        'body': encodeURIComponent(content),
                                        'pics': pids.replace(/,$/, ''),
                                        'score': rating.getResult(),
                                        'source':'profile',
                                        'id': args.id
                                    },
                                    'success': function(addDpData){
                                        if (addDpData.code == '200') {
                                            richEditorPop.destroy();

                                            popup.litePrompt('晒单成功！', {
                                                'timeout': 1500,
                                                'hideCallback': function(){
                                                    window.location.reload();
                                                    if ($this[0].parentNode) {
                                                        if ($this[0].parentNode.parentNode) {
                                                            //$this[0].parentNode.parentNode.outerHTML = addDpData.html;
                                                        }
                                                    }
                                                }
                                            });
                                        }
                                        else {
                                            richEditorPop.destroy();
                                            popup.litePrompt(addDpData.msg, {
                                                'timeout': 1500
                                            });
                                        }
                                    }
                                });
                            }
                        }
                    });

                    setTimeout(
                        function () {
                            var contentDoc = $('#RE_iframe')[0].contentDocument
                                || $('#RE_iframe')[0].contentWindow.document;
                            $(contentDoc.body).focus().click();
                        },
                        200
                    );

                    rating.init({
                        elemId: 'rating',
                        score: data.html.score
                    });

                }
            });

            e.stopPropagation();
            e.preventDefault();
        }
    );



    /**
     * ***********************************************
     * 删除点评
     * ***********************************************
     */
    var CONFIRMHTML = ''
        + '<div class="detail">'
        +   '<div class="clearfix">'
        +       '<div style="text-align: center;">'
        +           '<p>确认删除？</p>'
        +       '</div>'
        +       '<div class="btn">'
        +           '<a class="W_btn_b" href="javascript:void(0);" node-type="confirmBtn">'
        +               '<span>确认</span>'
        +           '</a>'
        +           '<a class="W_btn_a" href="javascript:void(0);" node-type="cancelBtn">'
        +               '<span>取消</span>'
        +           '</a>'
        +       '</div>'
        +   '</div>'
        + '</div>';

    view.$commentList.delegate(
        '[action-type=delDianping]',
        'click',
        function(e) {

            var args = util.json.queryToJson($(this).attr('action-data'));
            var confirmPop = popup.createModulePopup();
            confirmPop.setTitle("提示");
            confirmPop.setContent(CONFIRMHTML);
            confirmPop.show();
            confirmPop.setMiddle();

            var confirmNodes = util.dom.parseDOM(
                util.dom.builder(confirmPop.getInner()).list
            );

            $(confirmNodes.confirmBtn).click(function (e) {
                $.ajax({
                    'type': 'get',
                    'url': config.AJAX.DELETE_DIANPING,
                    'dataType': 'json',
                    'data': args,
                    'success': function(data){
                        if(data.code == 200){
                            confirmPop.destroy();
                            popup.litePrompt('删除成功！', {
                                'timeout': 1500,
                                'hideCallback': function(){
                                    setTimeout(function(){
                                        window.location="/"
                                    }, 20);
                                }
                            });
                        }
                        else{
                            confirmPop.destroy();
                            popup.alertPopup('删除失败：' + data.msg);
                        }
                    }
                });
            });
            $(confirmNodes.cancelBtn).click(function (e) {
                confirmPop.destroy();
            });

            e.stopPropagation();
            e.preventDefault();
        }
    );



    view.$sendPing.on('click', function(e) {
        if (window.$CONFIG.isLogin == 0) {
            login.show();
        }
        else {
            var val = view.$pingContent.val();
            if(util.str.trim(val)){
                var el = view.$sendPing[0];
                var tmp = util.json.queryToJson(
                    view.$sendPing.attr('node-data')
                );
                tmp.comment = val;
                $.ajax({
                    'type': 'post',
                    'url': config.AJAX.ADD_COMMENT,
                    'dataType': 'json',
                    'data': tmp,
                    'success': function (data) {
                        if (data.code == 200) {
                            $('#ping_comment_list').prepend(data.html);
                            view.$pingContent.val('');
                            popup.litePrompt('评论成功！', {'timeout': 1500});
                        }
                        else {
                            popup.alertPopup('评论失败：' + data.msg);
                        }
                    }
                });
            }
        }
        e.stopPropagation();
        e.preventDefault();
    });

    view.$reply.on('click', function(e) {
        view.$pingContent.focus();
    });

    //fixedable.addEl('tab_container');


    view.$commentContainer = $('#ping_comment_list');
    view.$commentContainer.delegate(
        '[action-type=replyComment]',
        'mouseenter',
        function(e) {
            var curTarget = e.currentTarget;
            var $curTarget = $(curTarget);
            var $commentEl = $('div.reply_comment', $curTarget);
            if ($commentEl.css('display') == 'none') {
                $commentEl.css('display', 'block');
            }
            e.stopPropagation();
            e.preventDefault();
        }
    );

    view.$commentContainer.delegate(
        '[action-type=replyComment]',
        'mouseleave',
        function(e) {
            var curTarget = e.currentTarget;
            var $curTarget = $(curTarget);
            var $commentEl = $('div.reply_comment', $curTarget);
            if ($commentEl.css('display') != 'none') {
                $commentEl.css('display', 'none');
            }
            e.stopPropagation();
            e.preventDefault();
        }
    );

    view.$commentContainer.delegate(
        '[action-type=toggleReplyDiv]',
        'click',
        function(e) {
            var curTarget = e.currentTarget;
            var $curTarget = $(curTarget);
            var curReply = $curTarget.next();
            if(curReply.css('display') != 'none'){
                curReply.css('display', 'none');
            }else{
                curReply.css('display', 'block');
            }
            var curTextarea = $('textarea', curReply);
            if (curTextarea) {
                setTimeout(function(){
                    curTextarea.focus();
                }, 100);
            }
            e.stopPropagation();
            e.preventDefault();
        }
    );

    view.$commentContainer.delegate(
        '[action-type=sendComment]',
        'click',
        function(e) {
            if (window.$CONFIG.isLogin == 0) {
                login.show();
            }
            else {
                var curTarget = e.currentTarget;
                var $curTarget = $(curTarget);
                var replyContent = util.str.trim($curTarget.parent().prev().val());
                if (replyContent) {
                    var tmp = util.json.queryToJson(
                        $curTarget.attr('action-data')
                    );
                    tmp.comment = replyContent;
                    $.ajax({
                        'type': 'post',
                        'url': config.AJAX.ADD_COMMENT,
                        'dataType': 'json',
                        'data': tmp,
                        'success': function (data) {
                            if (data.code == 200) {
                                popup.litePrompt('评论成功！', {
                                    'timeout': 1500,
                                    'hideCallback': function(){
                                        setTimeout(function(){
                                            window.location.reload();
                                        }, 20);
                                    }
                                });
                            }
                            else {
                                popup.alertPopup('评论失败：' + data.msg);
                            }
                        }
                    });
                }
            }
            e.stopPropagation();
            e.preventDefault();
        }
    );

    $("#show_more_nearby_shops").click(function (e){
        var shop_items = $('[name="hidden_shops"]');
        var len = shop_items.length;
        var show=0;
        for(var i=0; i<len; i++){
            if($(shop_items[i]).css("display") == 'none'){
                show = 1;
                $(shop_items[i]).css("display", "block");
            }else{
                $(shop_items[i]).css("display", "none");
            }
        }
        if(show){
            $(this).html('收起<span class="moreup"></span>') ;
        }else{
            $(this).html('更多<span class="moredown"></span>') ;
        }
    });


    view.$commentInfo = $('.comment_info');
    $('img', view.$commentInfo).css('cursor', 'pointer');
    var showImgPopup;

    /**
     * ***********************************************
     * 图片弹层
     * ***********************************************
     */
    var SHOWIMGPOPTPL = ''
        + '<div class="detail">'
        +   '<div class="clearfix">'
        +       '<img id="popImg" width="700px" style="max-width: 700px;" src="{{imgSrc}}">'
        +   '</div>'
        + '</div>';

    view.$commentInfo.delegate(
        '[action-type=show_big_img]',
        'click',
        function(e) {
            var curTarget = e.currentTarget;
            var $curTarget = $(curTarget);

            var imgSrc = $curTarget.attr('src').replace('!pingbody', '');

            var htmlStr = hogan.compile(SHOWIMGPOPTPL).render({
                imgSrc: imgSrc
            });

            showImgPopup = null;

            showImgPopup = popup.createModulePopup({});
            showImgPopup.setContent(htmlStr);

            loadImage(
                imgSrc,
                function (d) {
                    setTimeout(function () {
                        showImgPopup.show();
                        showImgPopup.setMiddle();

                        $(document).on('click', docClick);

                        util.evt.custEvent.add(showImgPopup, 'hide', function () {
                            $(document).off('click', docClick);
                        });

                        $('#popImg').css('min-height', '300px');
                    }, 200);
                }
            )
            e.stopPropagation();
            e.preventDefault();
        }
    );

    function docClick(e) {
        var el = e.srcElement || e.target;
        if (!util.dom.contains(showImgPopup.getDom('outer'), el)) {
            showImgPopup.hide();
        }
    }

    function loadImage(url, callback) {
        var img = new Image();
        if (img.complete) {
            callback.call(img);
            return;
        }
        img.onload = function () {
            callback.call(img);
        };
        img.onerror = function() {
            alert('加载图片错误！');
        };
        img.src = url;
    };


    function isLoaded(id) {
        var ret = false;
        var scripts = document.getElementsByTagName('script');
        for (var i = 0, len = scripts.length; i < len; i++) {
            if (scripts[i].getAttribute('id') === id) {
                ret = true;
                break;
            }
        }
        return ret;
    }
    /**
     * 加载 jquery 插件资源
     *
     * @param  {string}   id       script id
     * @param  {string}   url      script url
     * @param  {Function} callback 加载完后的回调
     */
    function load(id, url, callback) {
        if (!isLoaded(id)) {
            var head = document.getElementsByTagName('head')[0]
                        || document.body;
            var script = document.createElement('script');
            script.setAttribute('type', 'text/javascript');
            script.setAttribute('src', url);
            script.setAttribute('id', id);

            if (callback != null) {
                script.onload = script.onreadystatechange = function () {
                    if (script.ready) {
                        return false;
                    }
                    if (!script.readyState
                        || script.readyState == 'loaded'
                        || script.readyState == 'complete'
                    ) {
                        script.ready = true;
                        callback();
                    }
                };
            }
            head.appendChild(script);
        }
    }


    load('nivoslider2' , window.$CONFIG.normalUrl + '/js/jquery/jquery.SuperSlide.2.1.1.js',function (){
        $(".picMarquee-left").slide({mainCell:"#recommend_shop_list",autoPlay:true,effect:"leftMarquee",vis:4,interTime:50,trigger:"click"});
    });
//jQuery(".picMarquee-left").slide({mainCell:".bd ul",autoPlay:true,effect:"leftMarquee",vis:3,interTime:50,trigger:"click"});


    pager.initialize_new(
        'page_container',
        'ping_comment_list',
        'comment_content',
        config.AJAX.GET_COMMENT
    );



});