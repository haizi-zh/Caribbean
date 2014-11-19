/**
 * fav
 */
define(function(require){
    var $ = require('jquery');
    var util = require('util');
    var config = require('fav/config');
    var popup = require('widget/popup/main');

    $('#login').on('click', function(){
        $.ajax({
            'type': 'post',
            'url': '/aj/register/login',
            'dataType': 'json',
            'data': {
                'email': $.trim($('#login-email')[0].value),
                'passwd': $.trim($('#login-passwd')[0].value)
            },
            'success': function(data){
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

                    var nodes = $.parseDOM($.builder(a.getInner()).list);
                    $(nodes.cancelBtn).addEvent('click', function () {
                        a.destroy();
                    });
                }else{
                    popup.litePrompt('登录成功！', {
                        'timeout': 1500,
                        'hideCallback': function(){
                            setTimeout(function(){
                                window.location="/"
                            }, 20);
                        }
                    });
                }
            }
        });
    });


});