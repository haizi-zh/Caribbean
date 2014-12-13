/**
 * login模块
 */
// define(['jquery'], function($, require){
define(function(require){

    var $ = require('jquery');
    var util = require('util');
    var config = require('common/config');
    var popup = require('widget/popup/main');
    var hogan = require('hogan');

    var LOGINTPL = ''
        + '<div id="login-layer-wraper">'
        +     '<div class="layer_login detail">'
        +         '<p class="login_title"></p>'
        +         '<div class="login_icon_wrap">'
        +             '<ul class="icon_list clearfix">'
        +                 '<li>'
        +                     '<a class="cur" href="http://www.zanbai.com/callback/weibo/?source_url={{sourceUrl}}">'
        +                         '<em class="icon_sns weibo_login"></em><span>weibo</span>'
        +                     '</a>'
        +                 '</li>'
        +                 '<li>'
        +                     '<a class="cur" href="http://www.zanbai.com/callback/qq/?source_url={{sourceUrl}}">'
        +                         '<em class="icon_sns QQ_login"></em><span>tencent</span>'
        +                     '</a>'
        +                 '</li>'
        +             '</ul>'
        +         '</div>'
        +         '<div class="sign_wrap">'
        +             '<h3>使用Zanbai登录</h3>'
        +             '<div class="info_list clearfix">'
        +                 '<div class="tit fl"><i>*</i>账号：</div>'
        +                 '<div class="inp">'
        +                     '<input name="email" type="text" class="W_input" node-type="email" value="">'
        +                 '</div>'
        +             '</div>'
        +             '<div class="info_list clearfix">'
        +                 '<div class="tit fl"><i>*</i>密码：</div>'
        +                 '<div class="inp">'
        +                     '<input name="passwd" type="password" class="W_input" node-type="passwd" value="">'
        +                 '</div>'
        +                 '<div class="tips"></div>'
        +             '</div>'
        +         '</div>'
        +         '<div class="btn_wrap">'
        +             '<div class="tit fl"></div>'
        +             '<a href="javascript:void(0);" node-type="header_login" class="login_btn">立即登录</a>'
        //+             '<a target="_blank" href="/register/?source_url={{sourceUrl}}" class="sign_btn">立即注册</a>'
        +         '</div>'
        +     '</div>'
        + '</div>';
        
var LOGINTPL = ''
+'<div id="login-layer-wraper">'
+'<div class="login_layer_content">'
+'<div class="loginbtns_list">'
+'<a href="http://www.zanbai.com/callback/weibo/?source_url={{sourceUrl}}" class="weibo loginbtn">使用微博账号登录</a>'
+'<a href="http://www.zanbai.com/callback/qq/?source_url={{sourceUrl}}" class="qq loginbtn">使用QQ账号登录</a>'
+'</div>'
+'</div>'
+'</div>'

    var LOGINHTML = hogan.compile(LOGINTPL).render({
        sourceUrl: $CONFIG.sourceUrl
    });

    function bindEvts(loginPopup) {
        var loginNodes = util.dom.parseDOM(
            util.dom.builder(loginPopup.getInner()).list
        );
        $(loginNodes.header_login).on('click', function(e) {
            var email = $(loginNodes.email);
            var pass = $(loginNodes.passwd);
            var emailVal = util.str.trim(email.val());
            var passVal = util.str.trim(pass.val());
            var errorMsg = '';
            if (!emailVal) {
                errorMsg = '请输入邮箱';
                popup.alertPopup(errorMsg);
            }
            else if(!passVal) {
                errorMsg = '请输入密码';
                popup.alertPopup(errorMsg);
            }
            else {
                $.ajax({
                    'type': 'POST',
                    'url': config.AJAX.LOGIN,
                    'dataType': 'json',
                    'data': {
                        'email': util.str.trim(email.val()),
                        'passwd': util.str.trim(pass.val())
                    },
                    'success': function (data) {
                        if(data.code != 200){
                            errorMsg = data.msg;
                            popup.alertPopup(errorMsg);
                        }
                        else {
                            loginPopup.destroy();
                            popup.litePrompt('登录成功！', {
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
            e.stopPropagation();
            e.preventDefault();
        });
    }

    return {
        show: function(){
            var loginPopup = popup.createModulePopup({
                // 'isDrag': false
            });
            loginPopup.setTitle('提示');
            loginPopup.setContent(LOGINHTML);
            loginPopup.show();
            loginPopup.setMiddle();
            bindEvts(loginPopup);
        }
    }
});