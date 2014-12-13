$.ready(function(){

    var getStrLen = function(str, bLength) {
        return bLength ? $.bLength(str) : str.length;
    };

    var toNumber = function(n) {
        n = new String(n);
        n = n.indexOf(".") > -1 ? parseFloat(n) : parseInt(n,10);
        return isNaN(n) ? 0 : n;
    };


    var validate = {
        email : function(val){
            return /\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/i.test(val);
        },

        moreThan : function(val,num,type,bLen){
            type = type || 'string';
            type = type.toLowerCase();
            bLen === undefined && (bLen = true);
            var _num = type == 'string' ? getStrLen(val,bLen) : toNumber(val);
            return _num >= num;
        },

        lessThan : function(val,num,type,bLen){
            type = type || 'string';
            type = type.toLowerCase();
            bLen === undefined && (bLen = true);
            var _num = type == 'string' ? getStrLen(val,bLen) : toNumber(val);
            return _num <= num;
        },

        range : function(val,min,max,type,bLen){
            type = type || 'string';
            type = type.toLowerCase();
            bLen === undefined && (bLen = true);
            return validate.moreThan(val,min,type,bLen) && validate.lessThan(val,max,type,bLen);
        }
    }


    var flag1 = false, flag2 = false, flag3 = false, flag4 = false;

    $('#reg-nickname').addEvent('focus', function(){
        $('#nickname-tips')[0].innerHTML = '4~30个字符组成';
    });

    $('#reg-nickname').addEvent('blur', function(){
        var val = $.trim($('#reg-nickname')[0].value);
        var tips = $('#nickname-tips')[0];
        if(val){
            if(!validate.range(val, 4, 30)){
                tips.innerHTML = '<em style="color: red">昵称为4~30位</em>';
                flag1 = false;
            }else{
                tips.innerHTML = '';
                flag1 = true;
            }
        }else{
            tips.innerHTML = '<em style="color: red">请输入昵称</em>';
            flag1 = false;
        }
    });

    $('#reg-email').addEvent('blur', function(){
        var val = $.trim($('#reg-email')[0].value);
        var tips = $('#email-tips')[0];
        tips.innerHTML = '';
        if(val){
            if(!validate.email(val)){
                tips.innerHTML = '<em style="color: red">请输入正确的邮箱</em>';
                flag2 = false;
            }else{
                tips.innerHTML = '';
                flag2 = true;
            }
        }else{
            tips.innerHTML = '<em style="color: red">请输入邮箱</em>';
            flag2 = false;
        }
    });


    $('#reg-passwd').addEvent('focus', function(){
        $('#passwd-tips')[0].innerHTML = '6~16个字符组成，区分大小写';
    });

    $('#reg-passwd').addEvent('blur', function(){
        var val = $.trim($('#reg-passwd')[0].value);
        var tips = $('#passwd-tips')[0];
        if(val){
            if(!validate.range(val, 6, 16)){
                tips.innerHTML = '<em style="color: red">密码为6~16位</em>';
                flag3 = false;
            }else{
                tips.innerHTML = '';
                flag3 = true;
            }
        }else{
            tips.innerHTML = '<em style="color: red">请输入密码</em>';
            flag3 = false;
        }
    });


    $('#reg-repasswd').addEvent('focus', function(){
        $('#repasswd-tips')[0].innerHTML = '重复密码要与密码一致';
    });

    $('#reg-repasswd').addEvent('blur', function(){
        var val = $.trim($('#reg-repasswd')[0].value);
        var tips = $('#repasswd-tips')[0];
        if(val){
            if(val != $.trim($('#reg-passwd')[0].value)){
                tips.innerHTML = '<em style="color: red">重复密码要与密码一致</em>';
                flag4 = false;
            }else{
                tips.innerHTML = '';
                flag4 = true;
            }
        }else{
            tips.innerHTML = '<em style="color: red">请输入重复密码</em>';
            flag4 = false;
        }
    });

    var queryToJson = function (QS, isDecode) {
        var _Qlist = QS.split("&");
        var _json = {};
        for (var i = 0, len = _Qlist.length; i < len; i++) {
            var _hsh = _Qlist[i].split("=");
            if (!_json[_hsh[0]]) {
                _json[_hsh[0]] = _hsh[1];
            } else {
                _json[_hsh[0]] = [_hsh[1]].concat(_json[_hsh[0]]);
            }
        }
        return _json;
    };
    $('#reg-register').addEvent('click', function(){
        var query = window.location.search.slice(1);
        var res = queryToJson(query, true);

        if(flag1 && flag2 && flag3 && flag4){
            $.io.ajax({
                'method': 'post',
                'url': '/aj/register/adduser',
                'args': {
                    'uname': $.trim($('#reg-nickname')[0].value),
                    'email': $.trim($('#reg-email')[0].value),
                    'passwd': $.trim($('#reg-passwd')[0].value)
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
                        $.litePrompt('注册成功！', {
                            'timeout': 1500,
                            'hideCallback': function(){
                                setTimeout(function(){
                                    window.location.href =  decodeURIComponent(res.source_url) ;
                                }, 20);
                            }
                        });
                    }
                }
            });
        }
        $.evt.stopEvent();
    });




});
