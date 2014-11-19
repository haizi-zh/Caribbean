/**
 * register
 */
define(function(require){

    var $ = require('jquery');
    var util = require('util');
    var config = require('register/config');
    var popup = require('widget/popup/main');

    function getStrLen(str, bLength) {
        return bLength ? util.str.bLength(str) : str.length;
    }

    function toNumber(n) {
        n = new String(n);
        n = n.indexOf('.') > -1 ? parseFloat(n) : parseInt(n,10);
        return isNaN(n) ? 0 : n;
    }

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
            return validate.moreThan(val,min,type,bLen)
                        && validate.lessThan(val,max,type,bLen);
        }
    }

    var view = {};

    view.$register = $('#reg-register');

    view.$nickName = $('#reg-nickname');
    view.$nickNameTips = $('#nickname-tips');

    view.$email = $('#reg-email');
    view.$emailTips = $('#email-tips');

    view.$passwd = $('#reg-passwd');
    view.$passwdTips = $('#passwd-tips');

    view.$repasswd = $('#reg-repasswd');
    view.$repasswdTips = $('#repasswd-tips');

    var flag1 = false;
    var flag2 = false;
    var flag3 = false;
    var flag4 = false;

    view.$nickName.focus(function() {
        view.$nickNameTips.html('4~30个字符组成');
    }).blur(function() {
        var val = util.str.trim(view.$nickName.val());
        if(val){
            if(!validate.range(val, 4, 30)){
                view.$nickNameTips.html(
                    '<em style="color: red">昵称为4~30位</em>'
                );
                flag1 = false;
            }else{
                view.$nickNameTips.html('');
                flag1 = true;
            }
        }else{
            view.$nickNameTips.html('<em style="color: red">请输入昵称</em>');
            flag1 = false;
        }
    });

    view.$email.blur(function() {
        var val = util.str.trim(view.$email.val());
        view.$emailTips.html('');
        if(val){
            if(!validate.email(val)){
                view.$emailTips.html(
                    '<em style="color: red">请输入正确的邮箱</em>'
                );
                flag2 = false;
            }else{
                view.$emailTips.html('');
                flag2 = true;
            }
        }else{
            view.$emailTips.html('<em style="color: red">请输入邮箱</em>');
            flag2 = false;
        }
    });

    view.$passwd.focus(function() {
        view.$passwdTips.html('6~16个字符组成，区分大小写');
    }).blur(function() {
        var val = util.str.trim(view.$passwd.val());
        if(val){
            if(!validate.range(val, 6, 16)){
                view.$passwdTips.html(
                    '<em style="color: red">密码为6~16位</em>'
                );
                flag3 = false;
            }else{
                view.$passwdTips.html('');
                flag3 = true;
            }
        }else{
            view.$passwdTips.html('<em style="color: red">请输入密码</em>');
            flag3 = false;
        }
    });

    view.$repasswd.focus(function() {
        view.$repasswdTips.html('重复密码要与密码一致');
    }).blur(function() {
        var val = util.str.trim(view.$repasswd.val());
        if(val){
            if(val != util.str.trim(view.$passwd.val())){
                view.$repasswdTips.html(
                    '<em style="color: red">重复密码要与密码一致</em>'
                );
                flag4 = false;
            }else{
                view.$repasswdTips.html('');
                flag4 = true;
            }
        }else{
            view.$repasswdTips.html(
                '<em style="color: red">请输入重复密码</em>'
            );
            flag4 = false;
        }
    });

    view.$register.on('click', function(e) {
        var query = window.location.search.slice(1);
        var res = util.json.queryToJson(query, true);

        if(flag1 && flag2 && flag3 && flag4){
            $.ajax({
                'type': 'POST',
                'url': config.AJAX.ADDUSER,
                'dataType': 'json',
                'data': {
                    'uname': util.str.trim(view.$nickName.val()),
                    'email': util.str.trim(view.$email.val()),
                    'passwd': util.str.trim(view.$passwd.val())
                },
                'success': function (data) {
                    if(data.code != 200){
                        errorMsg = data.msg;
                        popup.alertPopup(errorMsg);
                    }
                    else {
                        popup.litePrompt('注册成功！', {
                            'timeout': 1500,
                            'hideCallback': function(){
                                setTimeout(function(){
                                    window.location.href =
                                        decodeURIComponent(res.source_url);
                                }, 20);
                            }
                        });
                    }
                }
            });
        }
        e.stopPropagation();
        e.preventDefault();
    });

});