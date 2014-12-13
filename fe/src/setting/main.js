/**
 * setting
 */
define(function(require){
    var imgClip = require('widget/imgclip/main');
    var popup = require('widget/popup/main');
    var util = require('util');
    var config = require('setting/config');
    var login = require('common/login');

    var view = {};
    view.$preview1 = $('#preview1');
    view.$preview2 = $('#preview2');
    view.$preview3 = $('#preview3');

    view.$uploadForm = $('#uploadForm');
    view.$uploadFile = $('#uploadFile');
    view.$originImg = $('#originImg');
    view.$fileUploadBtn = $('#fileUploadBtn');
    view.$saveSetting = $('#saveSetting');
    view.$imgUrl = $('#imgUrl');
    view.$uname = $('#uname');


    function preview(img, selection) {
        var scaleX1 = parseInt(view.$preview1.css('width'), 10)/ selection.width;
        var scaleY1 = parseInt(view.$preview1.css('height'), 10)/ selection.width;

        var scaleX2 = parseInt(view.$preview2.css('width'), 10)/ selection.width;
        var scaleY2 = parseInt(view.$preview2.css('height'), 10)/ selection.width;

        var scaleX3 = parseInt(view.$preview3.css('width'), 10)/ selection.width;
        var scaleY3 = parseInt(view.$preview3.css('height'), 10)/ selection.width;

        $('#preview1 > img').css('width', Math.round(scaleX1 * 300) + 'px');
        $('#preview1 > img').css('height', Math.round(scaleY1 * 300) + 'px');
        $('#preview1 > img').css('marginLeft', '-' + Math.round(scaleX1 * selection.x1) + 'px');
        $('#preview1 > img').css('marginTop', '-' + Math.round(scaleY1 * selection.y1) + 'px');


        $('#preview2 > img').css('width', Math.round(scaleX2 * 300) + 'px');
        $('#preview2 > img').css('height', Math.round(scaleY2 * 300) + 'px');
        $('#preview2 > img').css('marginLeft', '-' + Math.round(scaleX2 * selection.x1) + 'px');
        $('#preview2 > img').css('marginTop', '-' + Math.round(scaleY2 * selection.y1) + 'px');

        $('#preview3 > img').css('width', Math.round(scaleX3 * 300) + 'px');
        $('#preview3 > img').css('height', Math.round(scaleY3 * 300) + 'px');
        $('#preview3 > img').css('marginLeft', '-' + Math.round(scaleX3 * selection.x1) + 'px');
        $('#preview3 > img').css('marginTop', '-' + Math.round(scaleY3 * selection.y1) + 'px');
    };

    imgClip.init(view.$originImg, {
        aspectRatio: '1:1',
        onSelectChange: preview
    });

    function uploadFormConfig(form, input, fn) {
        var cbn = ('ZB_' + (+new Date()))
            + (typeof(cbnSuffix) !== 'undefined' ? cbnSuffix : '');

        $(input).on('change', function(e) {
            if(input.value){
                $.ajax({
                    'type': 'post',
                    'url': config.AJAX.GET_SECURITY_DATA,
                    'dataType': 'json',
                    'data': {
                        'imgCallback': cbn
                    },
                    'success': function(data){
                        $('[name=signature]').val(data.signature);
                        $('[name=policy]').val(data.policy);
                        form.submit();
                    }
                });
            }
        });
        form.action = config.AJAX.UPLOADIMG;
        fn && (window[cbn] = fn);
    }


    uploadFormConfig(view.$uploadForm[0], view.$uploadFile[0], (function(){
        return function(o) {
            view.$originImg[0].src = o.fullurl+'!settingimage';
            view.$originImg.css('display', '');


            view.$preview1.css('overflow', 'hidden');
            view.$preview2.css('overflow', 'hidden');
            view.$preview3.css('overflow', 'hidden');

            $('#preview1 > img')[0].src = o.fullurl;
            $('#preview2 > img')[0].src = o.fullurl;
            $('#preview3 > img')[0].src = o.fullurl;

            $('#imgUrl')[0].value = o.fullurl;

            $('#preview1 > img').css('display', '');
            $('#preview2 > img').css('display', '');
            $('#preview3 > img').css('display', '');

        }
    })());

    view.$fileUploadBtn.on('click', function(e){
        view.$uploadFile.click();
    });

    view.$saveSetting.on('click', function(e){
        if (window.$CONFIG.isLogin == 0) {
            login.show();
        }
        else {
            var imgUrl = util.str.trim(view.$imgUrl.val());
            var uname = util.str.trim(view.$uname.val());
            var gender = util.str.trim($('[name="gender"]:checked').val());
            
            if(!imgUrl && ! uname){
                popup.alertPopup('昵称和头像必须选择一项');
            }else{
                $.ajax({
                    'type': 'post',
                    'url': config.AJAX.MODIFY_USERINFO,
                    'dataType': 'json',
                    'data': {
                        'image': imgUrl,
                        'gender': gender,
                        'uname': uname
                    },
                    'success': function(data){
                        if(data.code == 200){
                            setTimeout(function(){
                                window.location.reload();
                            }, 20);
                        }
                        else {
                            popup.alertPopup(data.msg);
                        }
                    }
                });
            }
        }
    });

});