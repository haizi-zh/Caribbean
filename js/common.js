$.ready(function(){
    $('#login-btn') && $('#login-btn').addEvent('click', function (e) {
        var loginPop = $.createModulePopup();
        var loginPopTitleEl = loginPop.getDom('title');
        $(loginPopTitleEl).removeNode();
        loginPop.setContent($('#login-layer-wraper')[0].innerHTML);
        loginPop.show();
        loginPop.setMiddle();
        var headerLogin = $.sizzle('#header-login', loginPop.getInner())[0];
        function _inner (e) {
            var emailVal = $.sizzle('#email', loginPop.getInner())[0];
            var passVal = $.sizzle('#passwd', loginPop.getInner())[0];
            emailVal = $.trim(emailVal.value);
            passVal = $.trim(passVal.value);
            if (!emailVal) {
                $(document.body).removeEvent('keydown', keydownFn);
                var TEMP = '' +
                    '<div class="detail">' +
                        '<div class="clearfix">' +
                            '<div>' +
                                '<p>请填写邮箱</p>' +
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
                $.evt.custEvent.add(a, 'hide', function () {
                    $(document.body).addEvent('keydown', keydownFn);
                });
            }
            else if (!passVal) {
                $(document.body).removeEvent('keydown', keydownFn);
                var TEMP = '' +
                    '<div class="detail">' +
                        '<div class="clearfix">' +
                            '<div>' +
                                '<p>请填写密码</p>' +
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
                $.evt.custEvent.add(a, 'hide', function () {
                    $(document.body).addEvent('keydown', keydownFn);
                });
            }
            else {
                $.io.ajax({
                    'method': 'post',
                    'url': '/aj/register/login',
                    'args': {
                        'email': emailVal,
                        'passwd': passVal
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
            }
        }
        function keydownFn (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode == 13) { // enter
                _inner(e);
                $.evt.stopEvent();
            }
        }
        headerLogin && $(headerLogin).addEvent('click', _inner);
        $(document.body).addEvent('keydown', keydownFn);
        $.evt.stopEvent();
    });

    $('#login-btn2') && $('#login-btn2').addEvent('click', function (e) {
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
    });


    // var followFunc = function(){
    //     var elem = $('#follow')[0];
    //     $.io.ajax({
    //         'method': 'post',
    //         'url': '/aj/social/attention',
    //         'args': {
    //             to_uid: $.queryToJson(elem.getAttribute('action-data')).uid
    //         },
    //         'onComplete': function(data){
    //             if(data.code == 200){
    //                 $(elem).removeClassName('W_btn_b');
    //                 $(elem).addClassName('W_btn_a');
    //                 elem.innerHTML = '<span>已关注</span>';
    //                 $('#follow').removeEvent('click',followFunc);
    //             }else if(data.code == 202){
    //                 // var loginPop = $.createModulePopup();
    //                 // var loginPopTitleEl = loginPop.getDom('title');
    //                 // $(loginPopTitleEl).removeNode();
    //                 // loginPop.setContent($('#login-layer-wraper')[0].innerHTML);
    //                 // loginPop.show();
    //                 // loginPop.setMiddle();
    //                 var loginPop = $.createModulePopup();
    //                 var loginPopTitleEl = loginPop.getDom('title');
    //                 $(loginPopTitleEl).removeNode();
    //                 loginPop.setContent($('#login-layer-wraper')[0].innerHTML);
    //                 loginPop.show();
    //                 loginPop.setMiddle();
    //                 var headerLogin = $.sizzle('#header-login', loginPop.getInner())[0];
    //                 var emailVal = $.sizzle('#email', loginPop.getInner())[0];
    //                 var passVal = $.sizzle('#passwd', loginPop.getInner())[0];
    //                 headerLogin && $(headerLogin).addEvent('click', function (e) {
    //                     $.io.ajax({
    //                         'method': 'post',
    //                         'url': '/aj/register/login',
    //                         'args': {
    //                             'email': $.trim(emailVal.value),
    //                             'passwd': $.trim(passVal.value)
    //                         },
    //                         'onComplete': function(data){
    //                             if(data.code != 200){
    //                                 var TEMP = '' +
    //                                     '<div class="detail">' +
    //                                         '<div class="clearfix">' +
    //                                             '<div>' +
    //                                                 '<p>'+data.msg+'</p>' +
    //                                             '</div>' +
    //                                             '<div class="btn">' +
    //                                                 '<a class="W_btn_a" href="javascript:void(0);" node-type="cancelBtn">' +
    //                                                     '<span>确认</span>' +
    //                                                 '</a>' +
    //                                             '</div>' +
    //                                         '</div>' +
    //                                     '</div>';

    //                                 var a = $.createModulePopup();
    //                                 a.setTitle("提示");
    //                                 a.setContent(TEMP);
    //                                 a.show();
    //                                 a.setMiddle();

    //                                 var nodes = $.parseDOM($.builder(a.getInner()).list);
    //                                 $(nodes.cancelBtn).addEvent('click', function () {
    //                                     a.destroy();
    //                                 });
    //                             }else{
    //                                 $.litePrompt('登录成功！', {
    //                                     'timeout': 1500,
    //                                     'hideCallback': function(){
    //                                         setTimeout(function(){
    //                                             window.location.reload();
    //                                         }, 20);
    //                                     }
    //                                 });
    //                             }
    //                         }
    //                     });
    //                 });
    //             }else{
    //                 var TEMP = '' +
    //                     '<div class="detail">' +
    //                         '<div class="clearfix">' +
    //                             '<div>' +
    //                                 '<p>'+data.msg+'</p>' +
    //                             '</div>' +
    //                             '<div class="btn">' +
    //                                 '<a class="W_btn_a" href="javascript:void(0);" node-type="cancelBtn">' +
    //                                     '<span>确认</span>' +
    //                                 '</a>' +
    //                             '</div>' +
    //                         '</div>' +
    //                     '</div>';

    //                 var b = $.createModulePopup();
    //                 b.setTitle("提示");
    //                 b.setContent(TEMP);
    //                 b.show();
    //                 b.setMiddle();
    //                 var nodesP = $.parseDOM($.builder(b.getInner()).list);
    //                 $(nodesP.cancelBtn).addEvent('click', function () {
    //                     b.destroy();
    //                 });
    //             }
    //         }
    //     });
    // };
    // $('#follow').addEvent('click', followFunc);


    var bodyContainer = document.body;
    var bodyDevt = $.delegatedEvent(bodyContainer);

    bodyDevt.add('follow', 'click', function(e){
        $.io.ajax({
            'method': 'post',
            'url': '/aj/social/attention',
            'args': {
                to_uid: e.data.uid
            },
            'onComplete': function(data){
                if(data.code == 200){
                    $(e.el).removeClassName('W_btn_b');
                    $(e.el).addClassName('W_btn_a');
                    e.el.innerHTML = '<span>已关注</span>';
                    e.el.setAttribute('action-type', 'unfollow');
                }else if(data.code == 202){
                    // var loginPop = $.createModulePopup();
                    // var loginPopTitleEl = loginPop.getDom('title');
                    // $(loginPopTitleEl).removeNode();
                    // loginPop.setContent($('#login-layer-wraper')[0].innerHTML);
                    // loginPop.show();
                    // loginPop.setMiddle();
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
                                    '<p>'+data.msg+'</p>' +
                                '</div>' +
                                '<div class="btn">' +
                                    '<a class="W_btn_a" href="javascript:void(0);" node-type="cancelBtn">' +
                                        '<span>确认</span>' +
                                    '</a>' +
                                '</div>' +
                            '</div>' +
                        '</div>';

                    var b = $.createModulePopup();
                    b.setTitle("提示");
                    b.setContent(TEMP);
                    b.show();
                    b.setMiddle();
                    var nodesP = $.parseDOM($.builder(b.getInner()).list);
                    $(nodesP.cancelBtn).addEvent('click', function () {
                        b.destroy();
                    });
                }
            }
        });
    });

    bodyDevt.add('unfollow', 'click', function(e){
        $.io.ajax({
            'method': 'post',
            'url': '/aj/social/attention_del',
            'args': {
                to_uid: e.data.uid
            },
            'onComplete': function(data){
                if(data.code == 200){
                    $(e.el).removeClassName('W_btn_a');
                    $(e.el).addClassName('W_btn_b');
                    e.el.innerHTML = '<span>关注</span>';
                    e.el.setAttribute('action-type', 'follow');
                }else{
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

                    var b = $.createModulePopup();
                    b.setTitle("提示");
                    b.setContent(TEMP);
                    b.show();
                    b.setMiddle();
                    var nodesP = $.parseDOM($.builder(b.getInner()).list);
                    $(nodesP.cancelBtn).addEvent('click', function () {
                        b.destroy();
                    });
                }
            }
        });
    });

    var timer;

    bodyDevt.add('unfollow', 'mouseover', function(e){
        timer = setTimeout(function(){
            e.el.innerHTML = '<span>取消关注</span>';
        }, 100);
        $.evt.stopEvent();
    });

    bodyDevt.add('unfollow', 'mouseout', function(e){
        timer && clearTimeout(timer);
        if (!$.evt.hitTest(e.el, e.evt)){
            e.el.innerHTML = '<span>已关注</span>';
        }
        $.evt.stopEvent();
    });

    function createScript(src){
        var suggestionScript = document.createElement('script');
        suggestionScript.type = 'text/javascript';
        suggestionScript.id = 'suggestion_script';
        suggestionScript.src = src;
        document.getElementsByTagName("head")[0].appendChild(suggestionScript);
    }

    function textChange(e){
        var keyCode = e.keyCode ?e.keyCode : e.which;
        if (
            keyCode !== 40 && keyCode !== 38
            &&
            keyCode !== 37 && keyCode !== 39
            &&
            keyCode !== 13 && keyCode !== 32
        ) {
            if (e.propertyName) {
                if (e.propertyName.toLowerCase() == 'value') {
                    createScript('http://zanbai.com:8090/?piece='+$('#suggestion-text')[0].value+'&business=shop&limit=10&callback=suggestionJsonpCallback');
                }
            }
            else {
                createScript('http://zanbai.com:8090/?piece='+$('#suggestion-text')[0].value+'&business=shop&limit=10&callback=suggestionJsonpCallback');
            }
        }
        $.evt.stopEvent();
    }

    if($.browser.IE){
        $('#suggestion-text').addEvent('propertychange', textChange);
    }else{
        $('#suggestion-text').addEvent('keyup', textChange);
    }

    $('#suggestion-text').addEvent('focus', function(){
        if($.trim($('#suggestion-text')[0].value) == '商家名称联想'){
            $('#suggestion-text')[0].value = '';
            $('#suggestion-text').setStyle('color', '#000');
        }
    });

    $('#suggestion-text').addEvent('blur', function(){
        if($.trim($('#suggestion-text')[0].value) == ''){
            $('#suggestion-text')[0].value = '商家名称联想';
            $('#suggestion-text').setStyle('color', '#999');
        }
    });

    $(document).addEvent('keydown', documentKeyDown);

    var suggestionTarget = $('#suggestion-target');
    window.suggestionJsonpCallback = function(result) {
        suggestionTarget[0].innerHTML = '';
        $('#suggestion_script').removeNode();
        if(result && result.shop){
            var html = '';
            for(var i = 0, len = result.shop.length; i < len; i++){
                html += '<a target="_blank" href="http://zanbai.com/shop?shop_id='+result.shop[i].word_id+'">'+result.shop[i].word+'</a>'
            }
            suggestionTarget.setStyle('display', '');
            suggestionTarget.insertHTML(html, 'afterbegin');
        }
    };

    $(document).addEvent('click', function(e){
        var el = e.srcElement || e.target;
        if (el.parentNode && el.parentNode.id != 'suggestion-target') {
            suggestionTarget.setStyle('display', 'none');
        }

        var cityLayer = $('#zb-city-layer');
        if (cityLayer[0]) {
            if (
                !$.contains(cityLayer[0], el)
                &&
                el.getAttribute('id') != 'change-city'
                &&
                cityLayer.getStyle('display') != 'none'
            ) {
                cityLayer.setStyle('display', 'none');
                $.createModuleMask.hide();
            }
        }
    });

    function clearSelectedStyle() {
        var items = suggestionTarget[0].childNodes;
        var len = items.length;
        for (var i = 0; i < len; i++) {
            if ($(items[i]).hasClassName('selected')) {
                $(items[i]).removeClassName('selected');
            }
        }
    }

    function documentKeyDown(e) {
        var keyCode = e.keyCode ?e.keyCode : e.which;
        var display = suggestionTarget.getStyle('display');
        if (display !== 'none') {
            var items = suggestionTarget[0].childNodes;
            var len = items.length;
            var curSelectedObj; // 当前选中的那一个，即上下键盘按下时选择的起始位置
            for (var i = 0; i < len; i++) {
                if ($(items[i]).hasClassName('selected')) {
                    curSelectedObj = {
                        elem: items[i],
                        index: i
                    }
                    break;
                }
            }
            if (keyCode == 40) { // 下
                if (curSelectedObj) {
                    if (curSelectedObj.index + 1 === len) {
                        // $(items[curSelectedObj.index]).removeClassName('selected');
                        clearSelectedStyle();
                        $(items[0]).addClassName('selected');
                    }
                    else {
                        // $(items[curSelectedObj.index]).removeClassName('selected');
                        clearSelectedStyle();
                        $(items[curSelectedObj.index + 1]).addClassName('selected');
                    }
                }
                else {
                    curSelectedObj = {
                        elem: items[0],
                        index: 0
                    }
                    $(items[curSelectedObj.index]).addClassName('selected');
                }
            }
            else if (keyCode == 38) { // 上
                if (curSelectedObj) {
                    if (curSelectedObj.index === 0) {
                        // $(items[curSelectedObj.index]).removeClassName('selected');
                        clearSelectedStyle();
                        $(items[len - 1]).addClassName('selected');
                    }
                    else {
                        // $(items[curSelectedObj.index]).removeClassName('selected');
                        clearSelectedStyle();
                        $(items[curSelectedObj.index - 1]).addClassName('selected');
                    }
                }
                else {
                    curSelectedObj = {
                        elem: items[len - 1],
                        index: len - 1
                    }
                    $(items[curSelectedObj.index]).addClassName('selected');
                }
            }
            else if(keyCode == 13) { // 回车
                setTimeout(function(){
                    // window.location.href = curSelectedObj.elem.getAttribute('href');
                    curSelectedObj.elem && curSelectedObj.elem.click();
                }, 10);
            }
        }
    }

    suggestionTarget.addEvent('mouseover', function(e){
        var target = e.target || e.srcElement;
        var targetTagName = target.tagName.toLowerCase();
        if (targetTagName == 'a') {
            $(target).addClassName('selected');
        }
    });

    suggestionTarget.addEvent('mouseout', function(e){
        var target = e.target || e.srcElement;
        var targetTagName = target.tagName.toLowerCase();
        if (targetTagName == 'a') {
            // $(target).removeClassName('selected');
            clearSelectedStyle();
        }
    });



    $('#change-city') && $('#change-city').addEvent('click', function (e) {
        var cityLayer = $('#zb-city-layer');
        if (cityLayer[0]) {
            var display = cityLayer.getStyle('display');
            if (display == 'none') {
                display = '';
                $.createModuleMask.showUnderNode(cityLayer[0]);
            }
            else {
                display = 'none';
                $.createModuleMask.hide();
            }
            cityLayer.setStyle('display', display);
        }
    });
    //广告点击
    $("#ad_img").addEvent('click', function(e){
        $.io.ajax({
            'method': 'get',
            'url': '/aj/setting/add_click',
            'args': {},
            'onComplete': function(data){
            }
        });
    });


});
