/**
 * profile
 */
define(function(require){
    var $ = require('jquery');

    var config = require('shop_detail/config');
    var hogan = require('hogan');
    var util = require('util');
    var popup = require('widget/popup/main');
    var pager = require('widget/pager/main');
    var login = require('common/login');
    var fixedable = require('widget/fixedable/main');
    var richEditor = require('widget/richeditor/main');
    var rating = require('widget/rating/main');
    var config = require('profile/config');

    var fixedable = require('widget/fixedable/main');
    fixedable.addEl("this_top", "side_bar");

    var view = {};
    view.$commentList = $('#comment_list');


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
     * 翻页
     * ***********************************************
     */
    pager.initialize(
        'page_container',
        'comment_list',
        config.AJAX.GET_PING_HTML,
        bottomPagerHandle
    );
    /**
     * 下方分页的回调
     */
    function bottomPagerHandle() {

        //$('body,html').animate({scrollTop:0},1000);

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
     * 翻页条吸顶
     * ***********************************************
     */
    fixedable.addEl('tab_container');



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
    
});