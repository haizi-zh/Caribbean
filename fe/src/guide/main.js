define(function(require){
    var $ = require('jquery');
    var hogan = require('hogan');
    var util = require('util');
    var config = require('guide/config');
    var login = require('common/login');
    var popup = require('widget/popup/main');
    var pager = require('widget/pager/main');
    var fixedable = require('widget/fixedable/main');
    var richEditor = require('widget/richeditor/main');
    var rating = require('widget/rating/main');

    var view = {};
    view.$sendPing = $('#send_ping');
    view.$reply = $("#reply");
    view.$pingContent = $("#ping_content");
    view.$delDianping = $("#delDianping");
    view.$commentList = $("#comment_list");

    view.$sendPing.on('click', function(e){
        if(window.$CONFIG.isLogin == 0){
            login.show();
        }else{
            var val = view.$pingContent.val();
            if(util.str.trim(val)){
                var el = view.$sendPing[0];
                var tmp = util.json.queryToJson(view.$sendPing.attr('node-data'));
                tmp.comment = val;
                $.ajax({
                    'type':'post',
                    'url':config.AJAX.ADD_COMMENT,
                    'dataType':'json',
                    'data':tmp,
                    'success':function(data){
                        if(data.code == 200){
                            $('#ping_comment_list').prepend(data.html);
                            view.$pingContent.val('');
                            popup.litePrompt('评论成功！', {'timeout': 1500});
                        }else{
                            popup.alertPopup('评论失败:'+data.msg);
                        }
                    }
                });
            }
        }
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


    pager.initialize_new(
        'page_container',
        'ping_comment_list',
        'comment_content',
        config.AJAX.GET_COMMENT
    );

});