/**
 * shop_detail
 */
define(function(require){

    var $ = require('jquery');
    var util = require('util');
    var pager = require('widget/pager/main');
    var config = require('shop_detail/config');
    var hogan = require('hogan');
    var login = require('common/login');
    var popup = require('widget/popup/main');
    var richEditor = require('widget/richeditor/main');
    var rating = require('widget/rating/main');


    var view = {};
    view.$shopIntro = $('#shop_intro');
    view.$seeMore = $('#see_more');
    view.$shopName = $('#shop-name');
    view.$showList = $('#showList');
    view.$showMap = $('#show-detailmap');
    view.$showImgPop = $('#showImgPop');
    view.$commentList = $('#comment_list');
    view.$favList = $('#fav_list');
    view.$shopInfo = $('#shop_info');


    var fixedable = require('widget/fixedable/main');
    fixedable.addEl("this_top", "side_bar");


    /**
     * ***********************************************
     * 点评晒单
     * ***********************************************
     */
    view.$showList.click(function (e) {
        if (window.$CONFIG.isLogin == 0) {
            login.show();
        }
        else {
            var args = util.json.queryToJson($(this).attr('node-data'));
            richEditor.show({
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
                                    // console.warn('已匹配的图片地址'+(i+1)+'：'+src[1]);
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
                                'shop_id': args && args.shop_id,
                                'score': rating.getResult()
                            },
                            'success': function(data){
                                if(data.code == '200'){
                                    richEditorPop.destroy();

                                    view.$commentList.prepend(data.html);

                                    popup.litePrompt('晒单成功！', {
                                        'timeout': 1500
                                    });
                                }
                                else{
                                    richEditorPop.destroy();
                                    popup.litePrompt(data.msg, {
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
                elemId: 'rating'
            });
        }
        e.stopPropagation();
        e.preventDefault();
    });

    view.$shopInfo.delegate(
            '[action-type=add_fav]',
            'click',
            function(e) {
                if (window.$CONFIG.isLogin == 0) {
                    login.show();
                }
                else {
                    var args = util.json.queryToJson($(this).attr('node-data'));
                    var fav_botton = $(this);
                    $.ajax({
                        'type': 'post',
                        'url': config.AJAX.ADD_FAV_SHOP,
                        'dataType': 'json',
                        'data': {
                            'shop_id': args && args.shop_id
                        },
                        'success': function(data){
                            if(data.code == '200'){
                                fav_botton.parent().html('<a href="javascript: void(0);" id="un_fav_list" action-type="un_fav" class="post_btn fr" node-data="shop_id='+args.shop_id+'" sl-processed="1">已收藏</a>');
                                popup.litePrompt('收藏成功！', {
                                    'timeout': 1500
                                });
                            }
                            else{
                                popup.litePrompt(data.msg, {
                                    'timeout': 1500
                                });
                            }
                        }
                    });
                }
                e.stopPropagation();
                e.preventDefault();
            }
        );

    view.$shopInfo.delegate(
            '[action-type=un_fav]',
            'click',
            function(e) {
                if (window.$CONFIG.isLogin == 0) {
                    login.show();
                }
                else {
                    var args = util.json.queryToJson($(this).attr('node-data'));
                    var fav_botton = $(this);
                    $.ajax({
                        'type': 'post',
                        'url': config.AJAX.DELETE_FAV_SHOP,
                        'dataType': 'json',
                        'data': {
                            'shop_id': args && args.shop_id
                        },
                        'success': function(data){
                            if(data.code == '200'){
                                fav_botton.parent().html('<a href="javascript: void(0);" action-type="add_fav" class="post_btn fr" node-data="shop_id='+args.shop_id+'" sl-processed="1">收藏</a>');
                                popup.litePrompt('取消收藏成功！', {
                                    'timeout': 1500
                                });
                            }
                            else{
                                popup.litePrompt(data.msg, {
                                    'timeout': 1500
                                });
                            }
                        }
                    });
                }
                e.stopPropagation();
                e.preventDefault();
            }
        );

    /**
     * ***********************************************
     * 回复
     * ***********************************************
     */
     var COMMENTTPL = ''
        + '<div class="textarea_wrap textb clearfix">'
        +   '<textarea class="send_textarea"></textarea>'
        +   '<div class="btn_wrap fr">'
        +       '<span>禁止发布色情、反动及广告内容！</span>'
        +       '<a href="javascript:void(0);" action-type="send_comment" action-data="{{actionDataStr}}" class="post_btn">发送</a>'
        +   '</div>'
        + '</div>';

    view.$commentList.delegate(
        '[action-type=reply]',
        'click',
        function(e) {
            if (window.$CONFIG.isLogin == 0) {
                login.show();
            }
            else {
                var COMMENTHTML = hogan.compile(COMMENTTPL).render({
                    actionDataStr: $(this).attr('action-data')
                });
                $(this).parent().parent().after(COMMENTHTML);
                $(this).attr('action-type', 'unreply');
            }
            e.stopPropagation();
            e.preventDefault();
        }
    );

    view.$commentList.delegate(
        '[action-type=unreply]',
        'click',
        function(e) {
            $(this).parent().parent().next().remove();
            $(this).attr('action-type', 'reply');
            e.stopPropagation();
            e.preventDefault();
        }
    );

    view.$commentList.delegate(
        '[action-type=send_comment]',
        'click',
        function(e) {
            if (window.$CONFIG.isLogin == 0) {
                login.show();
            }
            else {
                var $textareaWrap = $(this).parent().parent();
                var $textarea = $(this).parent().prev();
                if (util.str.trim($textarea.val())) {
                    var args = util.json.queryToJson($(this).attr('action-data'));
                    args.comment = encodeURIComponent($textarea.val());
                    $.ajax({
                        'type': 'post',
                        'url': config.AJAX.ADD_COMMENT,
                        'dataType': 'json',
                        'data': args,
                        'success': function (data) {
                            if (data.code == 200) {
                                popup.litePrompt('评论成功！', {
                                    'timeout': 1500,
                                    'hideCallback': function(){
                                        var btn = $(
                                            '[action-type=unreply]',
                                            $textareaWrap.prev()[0]
                                        )
                                        btn.attr('action-type', 'reply');
                                        $textareaWrap.remove();
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

            // $(e.el.parentNode).prev()[0];
            e.stopPropagation();
            e.preventDefault();
        }
    );

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
                                        window.location.reload();
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
                    var addDpArgs = util.json.queryToJson(
                        view.$showList.attr('node-data')
                    );
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
                                        'shop_id': addDpArgs && addDpArgs.shop_id,
                                        'score': rating.getResult(),
                                        'id': args.id
                                    },
                                    'success': function(addDpData){
                                        if (addDpData.code == '200') {
                                            richEditorPop.destroy();

                                            popup.litePrompt('晒单成功！', {
                                                'timeout': 1500,
                                                'hideCallback': function(){
                                                    if ($this[0].parentNode) {
                                                        if ($this[0].parentNode.parentNode) {
                                                            $this[0].parentNode.parentNode.outerHTML = addDpData.html;
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
     * 翻页
     * ***********************************************
     */
   pager.initialize(
        'page_container',
        'comment_list',
        config.AJAX.GET_COMMENT,
        bottomPagerHandle
     );
    /**
     * 下方分页的回调
     */
    function bottomPagerHandle() {
        $('#page_container_adapter').delegate(
            '[action-type=changePageAdapter]',
            'click',
            function(e){
            var curTarget = e.currentTarget;
                var $curTarget = $(curTarget);
                if ($curTarget.attr('node-type') === 'next') {
                    $('[action-type=changePage][node-type="next"]').click();
                }
                else {
                    $('[action-type=changePage][node-type="prev"]').click();
                }
            }
        );
    }

    bottomPagerHandle();


    /**
     * ***********************************************
     * 展开更多
     * ***********************************************
     */
    var storeIntroHeight = 0;
    var introHeight = parseInt(view.$shopIntro.css('height'), 10);
    if (isNaN(introHeight)) {
        introHeight = parseInt(view.$shopIntro[0].offsetHeight, 10);
    }
    storeIntroHeight = introHeight;

    if (introHeight > 56) {
        view.$shopIntro.css('height', '56');
        view.$seeMore.css('display', 'block');
        view.$seeMore.on('click', showMore);
    }else{
        view.$shopIntro.css('height', '56');
        view.$seeMore.css('display', 'none');
    }

    function showMore(e){
        view.$shopIntro.animate({
            height: storeIntroHeight
        }, 500, function() {
            // console.log('done');
        });
        view.$seeMore.html(
            '<a href="javascript:void(0);" class="linkb">收起</a>'
        );
        view.$seeMore.off('click', showMore);
        view.$seeMore.on('click', hideMore);
        e.preventDefault();
    }

    function hideMore(e){
        view.$shopIntro.animate({
            height: 56
        }, {
            duration: 500,
            queue: false,
            complete: function () {
                // console.log(132);
            }
        });
        $('html,body').animate({
            //scrollTop: view.$shopName.position().top
        }, {
            duration: 500,
            queue: false
        });

        view.$seeMore.html(
            '<a href="javascript:void(0);" class="linkb">更多</a>'
        );
        view.$seeMore.off('click', hideMore);
        view.$seeMore.on('click', showMore);
        e.preventDefault();
    }
    
    /**
     * ***********************************************
     * 地图弹层
     * ***********************************************
     */
    var MAPTPL = ''
        + '<div id="detailmap-layer-wraper">'
        +    '<div id="detailmap-canvas" style="height:{{height}}px;width:{{width}}px;">'
        +    '</div>'
        + '</div>';

    view.$showMap.click(function (e) {
        var winWidth = $(window).width();
        var winHeight = $(window).height();
        var MAPHTML = hogan.compile(MAPTPL).render({
            width: parseInt(winWidth - 150, 10),
            height: parseInt(winHeight - 100, 10)
        });
        var mapPopup = popup.createModulePopup({
            // 'isDrag': false
        });
        mapPopup.setContent(MAPHTML);

        mapPopup.show();
        mapPopup.setMiddle();

        var opts = {
            lat: $('#lat').html(),
            lon: $('#lon').html(),
            shopName: $('#shop_name').html(),
            shopDesc: $('#shop_desc').html(),
            shopAddr: $('#shop_address').html()
        };

        (function(opts) {
            var myLatlng = new google.maps.LatLng(opts.lon, opts.lat);
            var mapOptions = {
                zoom: 14,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            var map = new google.maps.Map($('#detailmap-canvas')[0], mapOptions);
            var contentString = ''
                + '<div style="overflow:hidden;width:300px;">'
                +   '<h2>'
                +       opts.shopName
                +   '</h2><br>'
                +   '<div>'
                +       opts.shopDesc
                +   '</div><br>'
                +   '<p>地址: '
                +       opts.shopAddr
                +   '</p>'
                + '</div>'

            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });

            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map
            });

            (function(m){
                google.maps.event.addListener(m, 'click', function() {
                    infowindow.open(map,m);
                });
            })(marker);

            setTimeout(function(){
                infowindow.open(map,marker);
            }, 1000);
        })(opts);
    });

    $("[action-type=show_more]").click(function (e){
        var shop_items = $(this).parent().parent().find(".discont_list").children();

        var len = shop_items.length;
        var show=0;
        for(var i=0; i<len; i++){
            if($(shop_items[i]).css("display") == 'none'){
                show = 1;
                $(shop_items[i]).css("display", "block");
            }else if($(shop_items[i]).css("display") == 'block'){
                $(shop_items[i]).css("display", "none");
            }
        }
        if(show){
            $(this).html('收起<span class="moreup"></span>') ;
        }else{
            $(this).html('更多<span class="moredown"></span>') ;
        }
    });


    $("[action-type=show_more_coupon_discount]").click(function (e){
        var coupon_discount_items = $(this).parent().parent().find(".discount_wrapV2").find(".discount_single");
        console.log(coupon_discount_items);
        var len = coupon_discount_items.length;
        var show=0;
        for(var i=0; i<len; i++){
            if($(coupon_discount_items[i]).css("display") == 'none'){
                show = 1;
                $(coupon_discount_items[i]).css("display", "block");
            }
        }
        if(show){
            $(this).parent().hide();
        }
    });

    $("[action-type=direction_more]").click(function (e){
        var desc_list = $(this).parent().parent().find(".desc_list");
        var show=0;

        if(desc_list.css("display") == 'none'){
            show = 1;
            desc_list.css("display", "block");
        }else if(desc_list.css("display") == 'block'){
            desc_list.css("display", "none");
        }
        
        if(show){
            $(this).html('收起<span class="arrow_up"></span>') ;
        }else{
            $(this).html('怎样到达<span class="arrow_down"></span>') ;
        }
    });



    // view.$sendPing = $('#send_ping');
    // view.$reply = $('#reply');
    // view.$pingContent = $('#ping_content');

    /*view.$sendPing.on('click', function(e) {
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
                            $('#comment_list').prepend(data.html);
                            view.$pingContent.val('');
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

    pager.initialize(
        'page_container',
        'comment_list',
        config.AJAX.GET_COMMENT
    );

    fixedable.addEl('tab_container');


    view.$commentContainer = $('#comment_list');
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
    );*/


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

    load('layer' , window.$CONFIG.normalUrl + '/js/layer/layer.min.js',function (){
        layer.use(window.$CONFIG.normalUrl+'/js/layer/extend/layer.ext.js');
        $("#showImgPop").click(function (){
            var shop_id = $(this).attr('node-data');
            $.ajax({
                url:'/aj/shop/get_shop_pic?'+shop_id ,
                dataType:'json',
                success:function (data){
                    var json = {'status':1,"start": 0} ;
                    json.data = [] ;
                    if(data.code == '200'){
                        var picdata = {};
                        var pics = data.msg.pics ;
                        for(var i in pics){
                            var picinfo = {} ;
                            picinfo.src = pics[i] ;
                            json.data[i] = picinfo ;
                        }
                        layer.photos({
                            json: json
                        });
                    } else {
                        layer.alert(data.msg) ;
                    }
                }
            }) ;
        }) ;
    });
    
    /*
    load('nivoslider' , window.$CONFIG.normalUrl + '/js/jquery/jquery.SuperSlide.2.1.1.js',function (){
        $("#brand_list").slide({mainCell:"#brand_list_ul",autoPlay:true,effect:"leftMarquee",vis:3,interTime:50,trigger:"click"});
    });
    */
});