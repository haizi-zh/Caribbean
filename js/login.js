$.ready(function(){

    $('#login').addEvent('click', function(){
        $.io.ajax({
            'method': 'post',
            'url': '/aj/register/login',
            'args': {
                'email': $.trim($('#login-email')[0].value),
                'passwd': $.trim($('#login-passwd')[0].value)
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
        $.evt.stopEvent();
    });
});
