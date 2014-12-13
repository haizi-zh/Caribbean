$.ready(function(){

    function uploadFormConfig(form, input, fn) {
       var cbn = ("ZB_" + (+(new Date()))) + (typeof(cbnSuffix) !== "undefined" ? cbnSuffix : "");
        $(input).addEvent("change", function() {
            $.io.ajax({
                'method': 'post',
                'url': '/aj/uploadpic/getSecurityData',
                'args': {
                    'imgCallback': cbn
                },
                'onComplete': function(data){
                    $.sizzle('[name=signature]', form)[0].value = data.signature;
                    $.sizzle('[name=policy]', form)[0].value = data.policy;
                    form.submit();
                }
            });
        });
        form.action = "http://v0.api.upyun.com/zanbai/";
        fn && (window[cbn] = fn);
    }

    uploadFormConfig($('#uploadForm')[0], $('#uploadFile')[0], (function(){
        return function(o) {
            $('#originImg')[0].src = o.fullurl+'!settingimage';
            $('#originImg').setStyle('display', '');


            $('#preview1').setStyle('overflow', 'hidden');
            $('#preview2').setStyle('overflow', 'hidden');
            $('#preview3').setStyle('overflow', 'hidden');

            $.sizzle('#preview1 > img')[0].src = o.fullurl;
            $.sizzle('#preview2 > img')[0].src = o.fullurl;
            $.sizzle('#preview3 > img')[0].src = o.fullurl;

            $('#imgUrl')[0].value = o.fullurl;

            $($.sizzle('#preview1 > img')[0]).setStyle('display', '');
            $($.sizzle('#preview2 > img')[0]).setStyle('display', '');
            $($.sizzle('#preview3 > img')[0]).setStyle('display', '');

        }
    })());


    $('#fileUploadBtn').addEvent('click', function(e){
        $('#uploadFile')[0].click();
    });

    function preview(img, selection) {
        var scaleX1 = parseInt($('#preview1').getStyle('width'), 10)/ selection.width;
        var scaleY1 = parseInt($('#preview1').getStyle('height'), 10)/ selection.width;

        var scaleX2 = parseInt($('#preview2').getStyle('width'), 10)/ selection.width;
        var scaleY2 = parseInt($('#preview2').getStyle('height'), 10)/ selection.width;

        var scaleX3 = parseInt($('#preview3').getStyle('width'), 10)/ selection.width;
        var scaleY3 = parseInt($('#preview3').getStyle('height'), 10)/ selection.width;

        $($.sizzle('#preview1 > img')[0]).setStyle('width', Math.round(scaleX1 * 300) + 'px');
        $($.sizzle('#preview1 > img')[0]).setStyle('height', Math.round(scaleY1 * 300) + 'px');
        $($.sizzle('#preview1 > img')[0]).setStyle('marginLeft', '-' + Math.round(scaleX1 * selection.x1) + 'px');
        $($.sizzle('#preview1 > img')[0]).setStyle('marginTop', '-' + Math.round(scaleY1 * selection.y1) + 'px');


        $($.sizzle('#preview2 > img')[0]).setStyle('width', Math.round(scaleX2 * 300) + 'px');
        $($.sizzle('#preview2 > img')[0]).setStyle('height', Math.round(scaleY2 * 300) + 'px');
        $($.sizzle('#preview2 > img')[0]).setStyle('marginLeft', '-' + Math.round(scaleX2 * selection.x1) + 'px');
        $($.sizzle('#preview2 > img')[0]).setStyle('marginTop', '-' + Math.round(scaleY2 * selection.y1) + 'px');

        $($.sizzle('#preview3 > img')[0]).setStyle('width', Math.round(scaleX3 * 300) + 'px');
        $($.sizzle('#preview3 > img')[0]).setStyle('height', Math.round(scaleY3 * 300) + 'px');
        $($.sizzle('#preview3 > img')[0]).setStyle('marginLeft', '-' + Math.round(scaleX3 * selection.x1) + 'px');
        $($.sizzle('#preview3 > img')[0]).setStyle('marginTop', '-' + Math.round(scaleY3 * selection.y1) + 'px');
    };

     $('#originImg').imgClip({
        aspectRatio: '1:1',
        onSelectChange: preview
    });

    var popup;

    function showMsg(msg){
        var TEMP = '' +
        '<div class="detail">' +
            '<div class="clearfix">' +
                '<div>' +
                    '<p>'+msg+'</p>' +
                '</div>' +
                '<div class="btn">' +
                    '<a class="W_btn_a" href="javascript:void(0);" node-type="cancelBtn">' +
                        '<span>确认</span>' +
                    '</a>' +
                '</div>' +
            '</div>' +
        '</div>';

        if(popup){
            popup.destroy();
        }
        popup = $.createModulePopup();
        popup.setTitle("提示");
        popup.setContent(TEMP);
        popup.show();
        popup.setMiddle();
        var nodes = $.parseDOM($.builder(popup.getInner()).list);
        $(nodes.cancelBtn).addEvent('click', function () {
            popup.destroy();
        });
    };


    $('#saveSetting').addEvent('click', function(e){
        var imgUrl = $('#imgUrl')[0].value;
        var uname = $('#uname')[0].value;
        var gender = $('[name="gender"]:checked')[0].value;
        
        if(!imgUrl && ! uname){
            showMsg('昵称和头像必须选择一项');
        }else{
            $.io.ajax({
                'method': 'post',
                'url': '/aj/setting/modify_userinfo',
                'args': {
                    'image': imgUrl,
                    'gender':gender,
                    'uname': uname
                },
                'onComplete': function(data){
                    if(data.code == 200){
                        setTimeout(function(){
                            window.location.reload();
                        }, 20);
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
                        showMsg(data.msg);
                    }

                }
            });
        }
    });





});
