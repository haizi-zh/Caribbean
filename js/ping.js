$.ready(function () {

    $("#show_more_nearby_shops").addEvent('click', function (e){

        var shop_items = $('[name="hidden_shops"]');
        var len = shop_items.length;
        var show=0;
        for(var i=0; i<len; i++){
            if($(shop_items[i]).getStyle("display") == 'none'){
                show = 1;
                $(shop_items[i]).setStyle("display", "block");
            }else{
                $(shop_items[i]).setStyle("display", "none");
            }
        }
        if(show){
            $("#show_more_nearby_shops")[0].innerHTML = '收起<span class="moreup"></span>';
        }else{
            $("#show_more_nearby_shops")[0].innerHTML = '更多<span class="moredown"></span>';
        }
    });

    $('#send_ping').addEvent('click', function (e) {
        if($('#ping_content')[0].value){
            var el = $('#send_ping')[0];
            var tmp = $.queryToJson(el.getAttribute('node-data'));
            tmp.comment = $('#ping_content')[0].value;
            $.io.ajax({
                'isEncode': true,
                'method': 'post',
                'url': '/aj/ping/addcomment',
                'args': tmp,
                'onComplete': function(data){
                    if(data.code == 200){
                        $('#comment_list').insertHTML(data.html, 'afterbegin');
                        $('#ping_content')[0].value = '';
                    }else if(data.code == 202){
                        var loginPop = $.createModulePopup();
                        var loginPopTitleEl = loginPop.getDom('title');
                        $(loginPopTitleEl).removeNode();
                        loginPop.setContent($('#login-layer-wraper')[0].innerHTML);
                        loginPop.show();
                        loginPop.setMiddle();
                        var headerLogin = $.sizzle('#header-login', loginPop.getInner())[0];
                        var emailVal = $.sizzle('#email', loginPop.getInner())[0];
                        var passVal = $.sizzle('#passwd', loginPop.getInner())[0];
                        headerLogin && $(headerLogin).addEvent('click', function (e) {
                            $.io.ajax({
                                'method': 'post',
                                'url': '/aj/register/login',
                                'args': {
                                    'email': $.trim(emailVal.value),
                                    'passwd': $.trim(passVal.value)
                                },
                                'onComplete': function(data){
                                    if(data.code != 200){
                                        var TEMP = '' +
                                            '<div class="detail">' +
                                                '<div class="clearfix">' +
                                                    '<div>' +
                                                        '<p>'+data.msg+'</p>' +
                                                    '</div>' +
                                                    '<div class="btn">' +
                                                        '<a class="W_btn_a" href="javascript:void(0);" node-type="cancelBtn">' +
                                                            '<span>确认</span>' +
                                                        '</a>' +
                                                    '</div>' +
                                                '</div>' +
                                            '</div>';

                                        var a = $.createModulePopup();
                                        a.setTitle("提示");
                                        a.setContent(TEMP);
                                        a.show();
                                        a.setMiddle();

                                        var nodes = $.parseDOM($.builder(a.getInner()).list);
                                        $(nodes.cancelBtn).addEvent('click', function () {
                                            a.destroy();
                                        });
                                    }else{
                                        $.litePrompt('登录成功！', {
                                            'timeout': 1500,
                                            'hideCallback': function(){
                                                setTimeout(function(){
                                                    window.location.reload();
                                                }, 20);
                                            }
                                        });
                                    }
                                }
                            });
                        });
                    }else{
                        var TEMP = '' +
                            '<div class="detail">' +
                                '<div class="clearfix">' +
                                    '<div>' +
                                        '<p>评论失败</p>' +
                                        '<p>'+data.msg+'</p>' +
                                    '</div>' +
                                    '<div class="btn">' +
                                        '<a class="W_btn_a" href="javascript:void(0);" node-type="cancelBtn">' +
                                            '<span>确认</span>' +
                                        '</a>' +
                                    '</div>' +
                                '</div>' +
                            '</div>';

                        var a = $.createModulePopup();
                        a.setTitle("提示");
                        a.setContent(TEMP);
                        a.show();
                        a.setMiddle();

                        var nodes = $.parseDOM($.builder(a.getInner()).list);
                        $(nodes.cancelBtn).addEvent('click', function () {
                            a.destroy();
                        });
                    }
                }
            });
        }
        $.evt.stopEvent();
    });

    $('#reply').addEvent('click', function(e){
        $('#ping_content')[0].focus();
    });



    var tabContainer = $('#tab_container')[0];

    var tabContainerPos = $(tabContainer).getPos(),
        tabContainerTop = tabContainerPos.t;

    setInterval(function(){
        var sTop = $.scrollPos().top;
        if(sTop >= tabContainerTop){
            if($.browser.IE){
                $(tabContainer).setStyle('position', 'absolute');
                $(tabContainer).setStyle('top', sTop);
            }else{
                $(tabContainer).setStyle('position', 'fixed');
                $(tabContainer).setStyle('top', '0');
            }
        }else{
            $(tabContainer).setStyle('position', 'static');
        }
    },100);


    var pageContainer = $('#page_container')[0];
    var pageDevt = $.delegatedEvent(pageContainer);
    pageDevt.add('changePage', 'click', function(e){
        var showDom = $.sizzle('[node-type=show]', pageContainer)[0];
        var allPages = parseInt($.sizzle('[node-type=all]', pageContainer)[0].innerHTML, 10);
        var curPage = parseInt(showDom.innerHTML, 10);
        if(e.data.action == 'next'){
            if(curPage < allPages){
                $.io.ajax({
                    'method': 'get',
                    'url': '/aj/ping/getcommenthtml',
                    'args': {
                        'dianping_id': e.data.dianping_id,
                        'shop_id': e.data.shop_id,
                        'page': ++curPage
                    },
                    'onComplete': function(data){
                        if(data.code == '200'){
                            $('#comment_list')[0].innerHTML = data.html;
                            showDom.innerHTML = curPage;
                        }
                    }
                });
            }
        }else if(e.data.action =='prev'){
            if(curPage > 1){
                $.io.ajax({
                    'method': 'get',
                    'url': '/aj/ping/getcommenthtml',
                    'args': {
                        'dianping_id': e.data.dianping_id,
                        'shop_id': e.data.shop_id,
                        'page': --curPage
                    },
                    'onComplete': function(data){
                        if(data.code == '200'){
                            $('#comment_list')[0].innerHTML = data.html;
                            showDom.innerHTML = curPage;
                        }
                    }
                });
            }
        }
        $.evt.stopEvent();
    });



    var commentContainer = $('#comment_list')[0];
    var commentDevt = $.delegatedEvent(commentContainer);
    commentDevt.add('replyComment', 'mouseover', function(e){
        var commentEl = $.sizzle('div.reply_comment', e.el)[0];
        if($(commentEl).getStyle('display') == 'none'){
            $(commentEl).setStyle('display', 'block');
        }
        $.evt.stopEvent();
    });

    commentDevt.add('replyComment', 'mouseout', function(e){
        var commentEl = $.sizzle('div.reply_comment', e.el)[0];
        if($(commentEl).getStyle('display') != 'none'){
            $(commentEl).setStyle('display', 'none');
        }
    });


    commentDevt.add('toggleReplyDiv', 'click', function(e){
        var curReplyDiv = $(e.el).next();
        if($.sizzle('textarea',curReplyDiv[0])){
            setTimeout(function(){
                $.sizzle('textarea',curReplyDiv[0])[0].focus();
            }, 100);
        }
        if(curReplyDiv.getStyle('display') != 'none'){
            curReplyDiv.setStyle('display', 'none');
        }else{
            curReplyDiv.setStyle('display', 'block');
        }
    });


    commentDevt.add('sendComment', 'click', function(e){
        var replyContent = $(e.el.parentNode).prev()[0].value;
        if(replyContent){
            e.data.comment = replyContent;
            $.io.ajax({
                'isEncode': true,
                'method': 'post',
                'url': '/aj/ping/addcomment',
                'args': e.data,
                'onComplete': function(data){
                    if(data.code == 200){
                        // $('#comment_list').insertHTML(data.html, 'afterbegin');
                        // $(e.el.parentNode.parentNode).setStyle('display', 'none');
                        $.litePrompt('评论成功！', {
                            'timeout': 1500,
                            'hideCallback': function(){
                                setTimeout(function(){
                                    window.location.reload();
                                }, 20);
                            }
                        });
                    }else if(data.code == 202){
                        var loginPop = $.createModulePopup();
                        var loginPopTitleEl = loginPop.getDom('title');
                        $(loginPopTitleEl).removeNode();
                        loginPop.setContent($('#login-layer-wraper')[0].innerHTML);
                        loginPop.show();
                        loginPop.setMiddle();
                        var headerLogin = $.sizzle('#header-login', loginPop.getInner())[0];
                        var emailVal = $.sizzle('#email', loginPop.getInner())[0];
                        var passVal = $.sizzle('#passwd', loginPop.getInner())[0];
                        headerLogin && $(headerLogin).addEvent('click', function (e) {
                            $.io.ajax({
                                'method': 'post',
                                'url': '/aj/register/login',
                                'args': {
                                    'email': $.trim(emailVal.value),
                                    'passwd': $.trim(passVal.value)
                                },
                                'onComplete': function(data){
                                    if(data.code != 200){
                                        var TEMP = '' +
                                            '<div class="detail">' +
                                                '<div class="clearfix">' +
                                                    '<div>' +
                                                        '<p>'+data.msg+'</p>' +
                                                    '</div>' +
                                                    '<div class="btn">' +
                                                        '<a class="W_btn_a" href="javascript:void(0);" node-type="cancelBtn">' +
                                                            '<span>确认</span>' +
                                                        '</a>' +
                                                    '</div>' +
                                                '</div>' +
                                            '</div>';

                                        var a = $.createModulePopup();
                                        a.setTitle("提示");
                                        a.setContent(TEMP);
                                        a.show();
                                        a.setMiddle();

                                        var nodes = $.parseDOM($.builder(a.getInner()).list);
                                        $(nodes.cancelBtn).addEvent('click', function () {
                                            a.destroy();
                                        });
                                    }else{
                                        $.litePrompt('登录成功！', {
                                            'timeout': 1500,
                                            'hideCallback': function(){
                                                setTimeout(function(){
                                                    window.location.reload();
                                                }, 20);
                                            }
                                        });
                                    }
                                }
                            });
                        });
                    }else{
                        var TEMP = '' +
                            '<div class="detail">' +
                                '<div class="clearfix">' +
                                    '<div>' +
                                        '<p>评论失败</p>' +
                                        '<p>'+data.msg+'</p>' +
                                    '</div>' +
                                    '<div class="btn">' +
                                        '<a class="W_btn_a" href="javascript:void(0);" node-type="cancelBtn">' +
                                            '<span>确认</span>' +
                                        '</a>' +
                                    '</div>' +
                                '</div>' +
                            '</div>';

                        var a = $.createModulePopup();
                        a.setTitle("提示");
                        a.setContent(TEMP);
                        a.show();
                        a.setMiddle();

                        var nodes = $.parseDOM($.builder(a.getInner()).list);
                        $(nodes.cancelBtn).addEvent('click', function () {
                            a.destroy();
                        });
                    }
                }
            });
        }
    });


    var commentInfo = $.sizzle('.comment_info');
    var commentInfoDevt = $.delegatedEvent(commentInfo[0]);

    var imgs = $($.sizzle('img', commentInfo[0]));
    for (var i = 0, len = imgs.length; i < len; i++) {
        $(imgs[i]).setStyle('cursor', 'pointer');
    }

    commentInfoDevt.add('show_big_img', 'click', function (e) {
        var imgSrc = e.el.getAttribute('src');
        var SHOWIMGPOPTPL = ''
            + '<div class="detail">'
            +   '<div class="clearfix">'
            +       '<img id="popImg" style="width: 450px;" src="{{imgSrc}}">'
            +   '</div>'
            + '</div>';
        SHOWIMGPOPTPL = SHOWIMGPOPTPL.replace('{{imgSrc}}', imgSrc);
        var a = $.createModulePopup();
        a.setTitle("提示");
        a.setContent(SHOWIMGPOPTPL);
        a.show();
        a.setMiddle();
    });

});
