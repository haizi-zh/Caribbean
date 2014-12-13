$.ready(function () {

    var commentList = $('#comment_list')[0];

    var RICHEDITORHTML = '' +
        '<div class="shop-name">'+
            $('#shop-name')[0].innerHTML +
        '</div>' +
        '<div class="detail">' +
            '<div class="clearfix">' +
                '<p style="margin-bottom:5px;margin-top:10px;">星级评分</p><div class="rating_wrap_big_hover" id="rating">'+
                    '<ul>'+
                        '<li>'+
                            '<a class="star one_star " title="一般般" action-type="ratingAction" action-data="rating=0"></a>'+
                        '</li>'+
                        '<li>'+
                            '<a class="star two_stars " title="还不错" action-type="ratingAction" action-data="rating=1"></a>'+
                        '</li>'+
                        '<li>'+
                            '<a class="star three_stars " title="很不错" action-type="ratingAction" action-data="rating=2"></a>'+
                        '</li>'+
                        '<li>'+
                            '<a class="star four_stars " title="非常棒" action-type="ratingAction" action-data="rating=3"></a>'+
                        '</li>'+
                        '<li>'+
                            '<a class="star five_stars " title="超级赞" action-type="ratingAction" action-data="rating=4"></a>'+
                        '</li>'+
                    '</ul>'+
                '</div>'+
                '<br><p style="margin-bottom:5px;margin-top:20px;">晒单内容</p><div id="RE_container" style="border: 1px solid #CCC; /*width: 495px;*/width: 615px;">' +
                    // '<input type="hidden" value="" id="pids" node-type="pids">' +
                    '<div id="RE_toolbar">' +
                        // '<a class="button html" action-type="toolbar_act" title="查看源码" command="html" unselectable="on"></a>' +
                        // '<a class="button fontname" action-type="toolbar_act" title="字体" command="fontname" unselectable="on"></a>' +
                        // '<a class="button fontsize" action-type="toolbar_act" title="字号" command="fontsize" unselectable="on"></a>' +
                        '<a style="margin-left: 1px;" class="button removeformat" action-type="toolbar_act" title="删除格式" command="removeformat" unselectable="on"></a>' +
                        '<a class="button bold" action-type="toolbar_act" title="粗体" command="bold" unselectable="on"></a>' +
                        '<a class="button italic" action-type="toolbar_act" title="斜体" command="italic" unselectable="on"></a>' +
                        '<a class="button underline" action-type="toolbar_act" title="下划线" command="underline" unselectable="on"></a>' +
                        '<a class="button strikethrough" action-type="toolbar_act" title="删除线" command="strikethrough" unselectable="on"></a>' +
                        '<a class="button justifyleft" action-type="toolbar_act" title="左对齐" command="justifyleft" unselectable="on"></a>' +
                        '<a class="button justifycenter" action-type="toolbar_act" title="居中" command="justifycenter" unselectable="on"></a>' +
                        '<a class="button justifyright" action-type="toolbar_act" title="右对齐" command="justifyright" unselectable="on"></a>' +
                        '<a class="button justifyfull" action-type="toolbar_act" title="两端对齐" command="justifyfull" unselectable="on"></a>' +
                        '<a class="button indent" action-type="toolbar_act" title="增加缩进" command="indent" unselectable="on"></a>' +
                        '<a class="button outdent" action-type="toolbar_act" title="减少缩进" command="outdent" unselectable="on"></a>' +
                        // '<a class="button forecolor" action-type="toolbar_act" title="前景色" command="forecolor" unselectable="on"></a>' +
                        // '<a class="button backcolor" action-type="toolbar_act" title="背景色" command="backcolor" unselectable="on"></a>' +
                        // '<a class="button createlink" action-type="toolbar_act" title="超级连接" command="createlink" unselectable="on"></a>' +
                        '<a class="button insertorderedlist" action-type="toolbar_act" title="有序列表" command="insertorderedlist" unselectable="on"></a>' +
                        '<a class="button insertunorderedlist" action-type="toolbar_act" title="无序列表" command="insertunorderedlist" unselectable="on"></a>' +
                        '<a style="width: 43px;" class="button insertimage" action-type="toolbar_act" title="插入图片" command="insertimage" unselectable="on"></a>' +
                        // '<a class="button table" action-type="toolbar_act" title="表格" command="table" unselectable="on"></a>' +
                        // '<a class="button emoticons" action-type="toolbar_act" title="表情" command="emoticons" unselectable="on"></a>' +
                    '</div>' +
                    // visibility: hidden; outline: none; position: absolute; top: 135px; right: 380px; margin: 0; border: solid transparent; border-width: 40px 20px 30px 90px; opacity: 0; filter: alpha(opacity=0); -moz-transform: translate(-300px, 0) scale(4); direction: ltr; cursor: pointer; background: #000;
                    '<form style="position: absolute;top: 120px;left: 350px;" action="http://v0.api.upyun.com/zanbai/" target="ifmUpload" method="post" id="upload_form" name="upload_form" enctype="multipart/form-data">'+
                        '<input type="hidden" name="policy" id="policy">'+
                        '<input type="hidden" name="signature" id="signature">'+
                        '<input type="file" id="upload_file" name="file" style="-ms-filter:\'progid:DXImageTransform.Microsoft.Alpha(Opacity=0)\';filter:alpha(opacity=0);opacity:0; position: absolute;top: 28px;left: 278px;width: 40px;height: 32px;*height: 34px;">' +
                    '</form>'+
                    '<iframe id="RE_iframe" frameborder="no" scrolling="yes" style="width: 100%; height: 300px;"></iframe>' +
                    '<div id="RE_mask_div" style="display: none;color: #fff;width: 100%; height: 550px;background-color: rgb(0, 0, 0); filter:alpha(opacity=30);opacity: 0.3; top: 30px; left: 0px;position: absolute;">' +
                        '<span style="vertical-align:top;position: absolute;left: 320px;top: 100px;"><img src="'+window.$CONFIG.css_domain+'/images/common/loading.gif" style="margin-right: 10px;">正在上传图片</span>' +
                    '</div>' +
                    '<textarea id="RE_textarea" wrap="on" style="display: none; width: 684px; height: 300px;">' +
                    '</textarea>' +
                    '<iframe src="about:blank" name="ifmUpload" id="ifmUpload" style="display:none;"></iframe>' +
                '</div>' +
            '</div>' +
            '<div class="btn">' +
                '<a class="W_btn_b" href="javascript:void(0);" node-type="okBtn">' +
                    '<span>确认</span>' +
                '</a>' +
                '<a class="W_btn_a" href="javascript:void(0);" node-type="cancelBtn">' +
                    '<span>取消</span>' +
                '</a>' +
            '</div>' +
        '</div>';

    $('#showList').addEvent('click', function (e) {
        if($CONFIG.isLogin == 0){
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
            $.evt.stopEvent();
        }else{
            var el = $('#showList')[0];
            var tmp = $.queryToJson(el.getAttribute('node-data'));

            var a = $.createModulePopup();
            a.setContent(RICHEDITORHTML);
            a.show();
            a.setMiddle();

            $("#rating").rating();

            var rEditor = $('#RE_textarea').richEditor({
                id : 'editor',
                textareaId : 'textarea',
                b : 2,
                a : 4,
                content: ''
            });

            var nodes = $.parseDOM($.builder(a.getInner()).list);

            $(nodes.okBtn).addEvent('click', function(){
                // if (window.uploadImgFlag) {
                //     return;
                // }
                var pids = '';
                var srcReg = /src=[\'\"]?([^\'\"]*)[\'\"]?/i;
                var arr = rEditor.getContent().match(/<img.*?(?:>|\/>)/gi);
                if(arr){
                    for (var i = 0; i < arr.length; i++) {
                        var src = arr[i].match(srcReg);
                        if(src[1]){
                            pids += src[1].replace(/!popup$/, '') + ',';
                            // console.warn('已匹配的图片地址'+(i+1)+'：'+src[1]);
                        }
                        // 也可以替换src属性
                        // if (src[0]) {
                        //     var t = src[0].replace(/src/i, "href");
                        // }
                    }
                }
                $.io.ajax({
                    'method': 'post',
                    'url': '/aj/shop/add_dianping',
                    'args': {
                        'body': encodeURIComponent(rEditor.getContent()),
                        // 'pics': nodes.pids.value,
                        'pics': pids.replace(/,$/, ''),
                        'shop_id': tmp && tmp.shop_id,
                        'score': $("#rating")[0].getAttribute('result')
                    },
                    'onComplete': function(data){
                        if(data.code == '200'){
                            a.destroy();

                            $('#comment_list').insertHTML(data.html, 'afterbegin');

                            $.litePrompt('晒单成功！', {
                                'timeout': 1500
                            });
                        }else if(data.code == '202'){
                            a.destroy();
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
                            a.destroy();
                            $.litePrompt(data.msg, {
                                'timeout': 1500
                            });
                        }
                    }
                });
            });

            $(nodes.cancelBtn).addEvent('click', function () {
                a.destroy();
            });
        }
        $.evt.preventDefault(e);
    });
    
    var pageContainer = $('#page_container')[0]; // 翻页组件
    var pageDevt = $.delegatedEvent(document.body);
    //if(pageContainer){
       
        pageDevt.add('changePage', 'click', function(e){
            var showDom = $.sizzle('[node-type=show]', pageContainer)[0];
            var allPages = parseInt($.sizzle('[node-type=all]', pageContainer)[0].innerHTML, 10);

            var el = e.el;
            var curPage = parseInt(showDom.innerHTML, 10);
            if(e.data.action == 'next'){

                if(curPage < allPages){
                    $.io.ajax({
                        'method': 'get',
                        'url': '/aj/shop/get_paging_html',
                        'args': {
                            'shop_id': e.data.shop_id,
                            'page': ++curPage
                        },
                        'onComplete': function(data){
                            if(data.code == '200'){
                                commentList.innerHTML = '';
                                commentList.innerHTML = data.html;
                                showDom.innerHTML = curPage;
                            }
                        }
                    });
                }
            }else if(e.data.action =='prev'){
                if(curPage > 1){
                    $.io.ajax({
                        'method': 'get',
                        'url': '/aj/shop/get_paging_html',
                        'args': {
                            'shop_id': e.data.shop_id,
                            'page': --curPage
                        },
                        'onComplete': function(data){
                            if(data.code == '200'){
                                commentList.innerHTML = '';
                                commentList.innerHTML = data.html;
                                showDom.innerHTML = curPage;
                            }
                        }
                    });
                }
            }else if(e.data.action =='page'){
                pagenumber=e.data.page;
                curPage = pagenumber;
                $.io.ajax({
                    'method': 'get',
                    'url': '/aj/shop/get_paging_html',
                    'args': {
                        'shop_id': e.data.shop_id,
                        'page': pagenumber
                    },
                    'onComplete': function(data){
                        if(data.code == '200'){
                            commentList.innerHTML = '';
                            commentList.innerHTML = data.html;
                            showDom.innerHTML = curPage;
                        }
                    }
                });
            }


            $.evt.stopEvent();
        });



        pageDevt.add('changePageAdapter', 'click', function(e){
            var showDom = $.sizzle('[node-type=show]', pageContainer)[0];
            var allPages = parseInt($.sizzle('[node-type=all]', pageContainer)[0].innerHTML, 10);

            var el = e.el;
            var curPage = parseInt(showDom.innerHTML, 10);
            if(e.data.action == 'next'){

                if(curPage < allPages){
                    $.io.ajax({
                        'method': 'get',
                        'url': '/aj/shop/get_paging_html',
                        'args': {
                            'shop_id': e.data.shop_id,
                            'page': ++curPage
                        },
                        'onComplete': function(data){
                            if(data.code == '200'){
                                commentList.innerHTML = '';
                                commentList.innerHTML = data.html;
                                showDom.innerHTML = curPage;
                            }
                        }
                    });
                }
            }else if(e.data.action =='prev'){
                if(curPage > 1){
                    $.io.ajax({
                        'method': 'get',
                        'url': '/aj/shop/get_paging_html',
                        'args': {
                            'shop_id': e.data.shop_id,
                            'page': --curPage
                        },
                        'onComplete': function(data){
                            if(data.code == '200'){
                                commentList.innerHTML = '';
                                commentList.innerHTML = data.html;
                                showDom.innerHTML = curPage;
                            }
                        }
                    });
                }
            }else if(e.data.action =='page'){
                pagenumber=e.data.page;
                curPage = pagenumber;
                $.io.ajax({
                    'method': 'get',
                    'url': '/aj/shop/get_paging_html',
                    'args': {
                        'shop_id': e.data.shop_id,
                        'page': pagenumber
                    },
                    'onComplete': function(data){
                        if(data.code == '200'){
                            commentList.innerHTML = '';
                            commentList.innerHTML = data.html;
                            showDom.innerHTML = curPage;
                        }
                    }
                });
            }
            scroll(0,0);
            
            $.evt.stopEvent();
        });


   //}

    var COMMENTHTML = ['<#et userlist data>',
        '<div class="textarea_wrap textb clearfix">',
            '<textarea class="send_textarea"></textarea>',
            '<div class="btn_wrap fr">',
                '<span>禁止发布色情、反动及广告内容！</span>',
                '<a href="javascript:void(0);" action-type="send_comment" action-data="${data.actionDataStr}" class="post_btn">发送</a>',
            '</div>',
        '</div>',
    '</#et>'].join('');

    var dEvt1 = $.delegatedEvent(commentList);
    dEvt1.add('reply', 'click', function(e){
        if(!$CONFIG.isLogin){
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
            var data = {
                actionDataStr: $.jsonToQuery(e.data)
            }
            var tmp = $.easyTemplate(COMMENTHTML, data).toString();
            $(e.el.parentNode.parentNode).insertHTML(tmp, 'afterend');
            e.el.setAttribute('action-type', 'unreply');
        }
        $.evt.stopEvent();
    });

    dEvt1.add('unreply', 'click', function(e){
        $(e.el.parentNode.parentNode).next().removeNode();
        e.el.setAttribute('action-type', 'reply');
        $.evt.stopEvent();
    });


    dEvt1.add('send_comment', 'click', function(e){
        var curTextarea = $(e.el.parentNode).prev()[0];
        if(curTextarea.value){
            e.data.comment = curTextarea.value;
            $.io.ajax({
                'isEncode': true,
                'method': 'post',
                'url': '/aj/ping/addcomment',
                'args': e.data,
                'onComplete': function(data){
                    if(data.code == 200){
                        $.litePrompt('评论成功！', {
                            'timeout': 1500,
                            'hideCallback': function(){
                                var btn = $.sizzle('[action-type=unreply]', $(e.el.parentNode.parentNode).prev()[0])[0];
                                btn.setAttribute('action-type', 'reply');
                                $(e.el.parentNode.parentNode).removeNode();
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
        $.evt.stopEvent();
    });


    var showImgPopup = $.createModulePopup();

    var SHOWIMGPOPHTML = ['<#et userlist data>',
        '<div class="detail">',
            '<div class="clearfix">',
                '<span id="prevImg" class="leftcursor"></span>',
                // '<a href="javascript: void(0);" id="prevImg">前</a>',
                    '<img id="popImg" style="width: 450px;" src="${data.imgSrc}" imgindex="${data.imgIndex}">',
                // '<a href="javascript: void(0);" id="nextImg">后</a>',
                '<span id="nextImg" class="rightcursor"></span>',
            '</div>',
        '</div>',
    '</#et>'].join('');

    var htmlStr, imgData = [], shopId, lastId;

    function renderImg(imgIndex){
        htmlStr = $.easyTemplate(SHOWIMGPOPHTML, {imgSrc: imgData[imgIndex], imgIndex: imgIndex}).toString();
        showImgPopup.setContent(htmlStr);
        setTimeout(function(){
            if(imgIndex == 0){
                showImgPopup.show();
                showImgPopup.setMiddle();
                $('#popImg').setStyle('min-height', '300px');
            }
            $('#nextImg').addEvent('click', function(e){
                var imgIndex = parseInt($('#popImg')[0].getAttribute('imgindex'), 10);
                var nextIndex = imgIndex + 1;
                // if(nextIndex <= imgData.length){
                //     if(nextIndex == imgData.length){
                //         ajGetImg({
                //             lastId: lastId,
                //             imgIndex: nextIndex
                //         });
                //     }else{
                //         renderImg(nextIndex);
                //     }
                // }else{
                //     console.log(88888);
                // }
                if(lastId != 0){
                    if(nextIndex == imgData.length){
                        ajGetImg({
                            lastId: lastId,
                            imgIndex: nextIndex
                        });
                    }else{
                        renderImg(nextIndex);
                    }
                }else{
                    if(imgIndex + 1 != imgData.length){
                        
                        renderImg(nextIndex);
                    }
                }
            });

            $('#prevImg').addEvent('click', function(e){
                var imgIndex = parseInt($('#popImg')[0].getAttribute('imgindex'), 10);
                var nextIndex = imgIndex - 1;
                if(nextIndex >= 0){
                    renderImg(nextIndex);
                }
            });
        }, 200);
    }


    function ajGetImg(opts){
        $.io.ajax({
            'method': 'get',
            'url': '/aj/shop/get_shop_pic',
            'args': opts.lastId ?
                {'shop_id': shopId, 'last_id': opts.lastId} :
                {'shop_id': shopId},
            'onComplete': function(data){
                if(data.code == '200'){
                    lastId = data.msg.last_id;
                    //if(lastId != 0){
                        imgData = imgData.concat(data.msg.pics);
                        renderImg(opts.imgIndex ? opts.imgIndex : 0);
                    //}
                }
            }
        });
    }


    $('#showImgPop').addEvent('click', function(e){
        

        imgData = [];
        var el = $('#showImgPop')[0];
        var tmp = $.queryToJson(el.getAttribute('node-data'));
        shopId = tmp.shop_id;
        var opts = {};
        ajGetImg(opts);
        $.evt.preventDefault(e);
    });


    var $shopIntro = $('#shop_intro');
    var $seeMore = $('#see_more');

    var height = parseInt($shopIntro.getStyle('height'), 10);
    if(isNaN(height)){
        height = parseInt($shopIntro[0].offsetHeight, 10);
    }

    function showMore(e){
        $shopIntro.setStyle('height', 'auto');
        $seeMore[0].innerHTML = '<a href="javascript:void(0);" class="more">收起<span class="moreup"></span></a>';
        $seeMore.removeEvent('click', showMore);
        $seeMore.addEvent('click', hideMore);
        $.evt.preventDefault(e);
    }

    function hideMore(e){

        $shopIntro.setStyle('height', '56px');
        $seeMore[0].innerHTML = '<a href="javascript:void(0);" class="more">更多<span class="moredown"></span></a>';
        $seeMore.removeEvent('click', hideMore);
        $seeMore.addEvent('click', showMore);
        $.evt.preventDefault(e);
    }


    if(height > 56){
        $shopIntro.setStyle('height', '56px');
        $seeMore.setStyle('display', 'block');
        $seeMore.addEvent('click', showMore);
    }

    var CONFIRMHTML = '' +
        '<div class="detail">' +
            '<div class="clearfix">' +
                '<div style="text-align: center;">' +
                    '<p>确认删除？</p>' +
                '</div>' +
                '<div class="btn">' +
                    '<a class="W_btn_b" href="javascript:void(0);" node-type="confirmBtn">' +
                        '<span>确认</span>' +
                    '</a>' +
                    '<a class="W_btn_a" href="javascript:void(0);" node-type="cancelBtn">' +
                        '<span>取消</span>' +
                    '</a>' +
                '</div>' +
            '</div>' +
        '</div>';

    var commentContainer = $('#comment_list')[0];
    var commentDevt = $.delegatedEvent(commentContainer);
    commentDevt.add('delDianping', 'click', function(e){
        var confirmPop = $.createModulePopup();
        confirmPop.setTitle("提示");
        confirmPop.setContent(CONFIRMHTML);
        confirmPop.show();
        confirmPop.setMiddle();

        var confirmNodes = $.parseDOM($.builder(confirmPop.getInner()).list);
        $(confirmNodes.confirmBtn).addEvent('click', function () {
            $.io.ajax({
                'method': 'get',
                'url': '/aj/myprofile/delete',
                'args': e.data,
                'onComplete': function(data){
                    if(data.code == 200){
                        confirmPop.destroy();
                        $.litePrompt('删除成功！', {
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
                        confirmPop.destroy();
                        var TEMP = '' +
                            '<div class="detail">' +
                                '<div class="clearfix">' +
                                    '<div>' +
                                        '<p>删除失败</p>' +
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
        });
        $(confirmNodes.cancelBtn).addEvent('click', function () {
            confirmPop.destroy();
        });
        $.evt.stopEvent();
    });

    var DETAILMAPHTML = ''
        + '<div id="detailmap-layer-wraper">'
        +    '<div id="detailmap-canvas" style="height:{height}px;width:{width}px;">'
        +    '</div>'
        + '</div>';



    $('#show-detailmap').addEvent('click', function(e){
        
        var winSize = $.lo.winSize();
        DETAILMAPHTML = DETAILMAPHTML.replace('{height}', parseInt(winSize.height-100, 10));
        DETAILMAPHTML = DETAILMAPHTML.replace('{width}', parseInt(winSize.width-150, 10));
        var showMapPopup = $.createModulePopup();
        showMapPopup.setContent(DETAILMAPHTML);
        showMapPopup.show();
        showMapPopup.setMiddle();

        var lat = document.getElementById('lat').innerHTML;
        var lon = document.getElementById('lon').innerHTML;
        var shopName = document.getElementById('shop_name').innerHTML;
        var shopDesc = document.getElementById('shop_desc').innerHTML;
        var shopAddress = document.getElementById('shop_address').innerHTML;


        (function(lat,lon,shopName,shopDesc,shopAddress) {
              var myLatlng = new google.maps.LatLng(lon, lat);
              var mapOptions = {
                zoom: 14,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
              }
              var map = new google.maps.Map(document.getElementById('detailmap-canvas'), mapOptions);
              contentString ="<div style='overflow:hidden;width:300px;'><h2>"+
                shopName+
                "</h2><br/><div>"+
                shopDesc+
                "</div><br/><p>地址:"+
                shopAddress+
                "</p></div>"
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
        })(lat,lon,shopName,shopDesc,shopAddress)
    });



    commentDevt.add('modifyDianping', 'click', function(e){
        $.io.ajax({
            'method': 'get',
            'url': '/aj/shop/get_dianping',
            'args': {
                id: e.data.id
            },
            'onComplete': function(data){
                var el = $('#showList')[0];
                var tmp = $.queryToJson(el.getAttribute('node-data'));
                var a = $.createModulePopup();
                a.setContent(RICHEDITORHTML);
                a.show();
                a.setMiddle();

                $("#rating").rating({
                    score: data.html.score
                });

                var rEditor = $('#RE_textarea').richEditor({
                    id : 'editor',
                    textareaId : 'textarea',
                    b : 2,
                    a : 4,
                    content: data.html.body
                });

                var nodes = $.parseDOM($.builder(a.getInner()).list);

                $(nodes.okBtn).addEvent('click', function(){
                    var pids = '';
                    var srcReg = /src=[\'\"]?([^\'\"]*)[\'\"]?/i;
                    var arr = rEditor.getContent().match(/<img.*?(?:>|\/>)/gi);
                    if (arr) {
                        for (var i = 0; i < arr.length; i++) {
                            var src = arr[i].match(srcReg);
                            if (src[1]) {
                                pids += src[1].replace(/!popup$/, '') + ',';
                            }
                        }
                    }

                    $.io.ajax({
                        'method': 'post',
                        'url': '/aj/shop/add_dianping',
                        'args': {
                            'body': encodeURIComponent(rEditor.getContent()),
                            'pics': pids.replace(/,$/, ''),
                            'shop_id': tmp && tmp.shop_id,
                            'score': $("#rating")[0].getAttribute('result'),
                            'id': e.data.id
                        },
                        'onComplete': function(data){
                            if (data.code == '200') {
                                a.destroy();

                                $.litePrompt('晒单成功！', {
                                    'timeout': 1500,
                                    'hideCallback': function(){
                                        if (e.el.parentNode) {
                                            if (e.el.parentNode.parentNode) {
                                                e.el.parentNode.parentNode.outerHTML = data.html
                                            }
                                        }
                                    }
                                });
                            }
                            else {
                                a.destroy();
                                $.litePrompt(data.msg, {
                                    'timeout': 1500
                                });
                            }
                        }
                    });
                });

                $(nodes.cancelBtn).addEvent('click', function () {
                    a.destroy();
                });
                // if(data.code == '200'){
                //     lastId = data.msg.last_id;
                //     if(lastId != 0){
                //         imgData = imgData.concat(data.msg.pics);
                //         renderImg(opts.imgIndex ? opts.imgIndex : 0);
                //     }
                // }
            }
        });

        $.evt.stopEvent();
    });
    
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
});
