/**
 * 富文本编辑器 base
 */
define(function(require){

    var $ = require('jquery');
    var hogan = require('hogan');
    var config = require('widget/richeditor/config');

    /*var FONTSIZETPL = ''
        + '<div node-type="RE_popup" style="display: none; width: 150px; position: absolute;" class="RE_popup_shadow RE_popup" unselectable="on">'
        +   '{{#data}}'
        +       '<div class="RE_popup_item" unselectable="on" action-type="popup_act" action-data="fontSize={{sizeValue}}" style="height: {{height}}px;">'
        +       '<div class="RE_popup_inline_block RE_popup_item_left">'
        +           '{{#checked}}'
        +               '<span class="RE_popup_inline_block RE_popup_item_checked"></span>'
        +           '{{/checked}}'
        +       '</div>'
        +       '<div class="RE_popup_inline_block RE_popup_item_right" style="line-height: 28px;">'
        +           '<span style="font-size:{{fontSize}};" unselectable="on">{{str}}</span>'
        +       '</div>'
        +   '{{/data}}'
        + '</div>'

    var fontSizeArr = [
        {
            fontSize:'xx-small',
            sizeValue:1,
            str:'1(8pt)',
            height: 31
        },
        {
            fontSize:'x-small',
            sizeValue:2,
            str:'2(10pt)',
            height: 32
        },
        {
            fontSize:'small',
            sizeValue:3,
            str:'3(12pt)',
            height: 33,
            checked:true
        },
        {
            fontSize:'medium',
            sizeValue:4,
            str:'4(14pt)',
            height: 34
        },
        {
            fontSize:'large',
            sizeValue:5,
            str:'5(18pt)',
            height: 35
        },
        {
            fontSize:'x-large',
            sizeValue:6,
            str:'6(24pt)',
            height: 36
        },
        {
            fontSize:'xx-large',
            sizeValue:7,
            str:'7(36pt)',
            height: 37
        }
    ];
    var FONTSIZEHTML = hogan.compile(FONTSIZETPL).render({
        data: fontSizeArr
    });

    var fontFamilyArr = [
        {
            'checked': true,
            'fontFamily': '宋体'
        },
        {
            'fontFamily': '经典中圆简'
        },
        {
            'fontFamily': '微软雅黑'
        },
        {
            'fontFamily': '黑体'
        },
        {
            'fontFamily': '楷体'
        },
        {
            'fontFamily': '隶书'
        },
        {
            'fontFamily': '幼圆'
        },
        {
            'fontFamily': 'Arial'
        },
        {
            'fontFamily': 'Arial Narrow'
        },
        {
            'fontFamily': 'Arial Black'
        },
        {
            'fontFamily': 'Comic Sans MS'
        },
        {
            'fontFamily': 'Courier New'
        },
        {
            'fontFamily': 'Georgia'
        },
        {
            'fontFamily': 'New Roman Times'
        },
        {
            'fontFamily': 'Verdana'
        }
    ];
    var FONTFAMILYTPL = ''
        + '<div node-type="RE_popup" style="display: none; width: 150px; position: absolute;" class="RE_popup_shadow RE_popup" unselectable="on">'
        +   '{{#data}}'
        +       '<div class="RE_popup_item" unselectable="on" action-type="popup_act" action-data="fontFamily={{fontFamily}}" style="height: 30px;">'
        +           '<div class="RE_popup_inline_block RE_popup_item_left">'
        +               '{{#checked}}'
        +                   '<span class="RE_popup_inline_block RE_popup_item_checked"></span>'
        +               '{{/checked}}'
        +           '</div>'
        +           '<div class="RE_popup_inline_block RE_popup_item_right" style="line-height: 28px;">'
        +               '<span style="font-family:{{fontFamily}};" unselectable="on">{{fontFamily}}</span>'
        +           '</div>'
        +       '</div>'
        +   '{{/data}}'
        + '</div>';

    var FONTFAMILYHTML = hogan.compile(FONTFAMILYTPL).render({
        data: fontFamilyArr
    });*/

    var conf = {};
    var defaults = {
        content: ''
    }

    var view = {};
    var fullUrl = '';

    function init () {
        view.$textarea = $('#RE_textarea');
        view.textarea = view.$textarea[0];

        view.$iframe = $('#RE_iframe');
        view.iframe = view.$iframe[0];

        view.$toolbar = $('#RE_toolbar');
        view.toolbar = view.$toolbar[0];

        view.$uploadForm = $('#upload_form');
        view.uploadForm = view.$uploadForm[0];

        view.$uploadFile = $('#upload_file');
        view.uploadFile = view.$uploadFile[0];

        view.$maskDiv = $('#RE_mask_div');
        view.maskDiv = view.$maskDiv[0];

        view.iframeDocument =
                view.iframe.contentDocument || view.iframe.contentWindow.document;

        view.iframeDocument.designMode = "on";
        view.iframeDocument.open();
        view.iframeDocument.write(''
            + '<html>'
            +     '<head>'
            +         '<style type="text/css">'
            +             '* {margin:0;padding:0;}'
            +             'body {font-family:arial;font-size:16px;background:white;border:0; word-wrap: break-word;}'
            +         '</style>'
            +          conf.content
            +     '</head>'
            + '</html>'
        )

        view.iframeDocument.close();

        bindEvt();

        uploadFormConfig(view.uploadForm, view.uploadFile, (function(){
            return function(o) {
                var imgSrc = o.fullurl + '!popup';
                loadImage(imgSrc, function(){
                    fullUrl = o.fullurl + '!popup';
                    setTimeout(function () {
                        _format('insertimage', fullUrl);
                        view.iframe.contentWindow.focus();
                        view.$maskDiv.css('display', 'none');
                    }, 0);
                });
            }
        })());
    }

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
                        view.$maskDiv.css('display', '');
                        $('[name=signature]').val(data.signature);
                        $('[name=policy]').val(data.policy);
                        form.submit();
                        input.value = '';
                    }
                });
            }
        });
        form.action = config.AJAX.UPLOADIMG;
        fn && (window[cbn] = fn);
    }

    function bindEvt () {
        view.$toolbar.delegate(
            '[action-type=toolbar-action]',
            'click',
            toolbarClick
        );

        if ($.browser.msie) {
            var bookmark;
            view.$iframe.on('beforedeactivate', function () { //在文档失去焦点之前
                var range = view.iframeDocument.selection.createRange();
                bookmark = range.getBookmark();
            });
            //恢复IE的编辑光标
            view.$iframe.on('activate', function () {
                if (bookmark) {
                    var range = view.iframeDocument.body.createTextRange();
                    range.moveToBookmark(bookmark);
                    range.select();
                    bookmark = null;
                }
            });
        }
    }

    function toolbarClick (e) {
        var command = $(this).attr('command');
        switch (command) {
            case 'createlink':
                var value = prompt('请输入网址:', 'http://');
                _format(command, value);
                break;
            case 'insertimage':
                view.iframe.contentWindow.focus();
                view.$uploadFile.click();
                break;
            case 'fontname': //字体
                // bindDOMFuns.showPopup(e.el, 'fontFamily');
                break;
            case 'fontsize': //字号
                // bindDOMFuns.showPopup(e.el, 'fontSize');
                break;
            case 'forecolor':
            case 'backcolor':
            case 'html': // 查看源代码
                // console.log( iframeDocument.body.innerHTML);
                break;
            case 'table':
            case 'emoticons':
                return;
            default: //其他执行fontEdit(cmd, null)命令
                _format(command, '');
                break;
        }
        e.stopPropagation();
        e.preventDefault();
    }

    function _format (x, y) {
        try {
            view.iframe.contentWindow.focus();
            view.iframeDocument.execCommand(x, false, y);
            if(x == 'insertimage'){
                if($.browser.chrome){
                    view.iframeDocument.execCommand('InsertParagraph');
                    view.iframeDocument.execCommand('InsertParagraph');
                    view.iframeDocument.execCommand('InsertParagraph');
                }
                fullUrl = '';
            }
        } catch (e) {
            throw new Error(e);
        }
    }

    function loadImage(url, callback) {
        var img = new Image(); //创建一个Image对象，实现图片的预下载
        if (img.complete) { // 如果图片已经存在于浏览器缓存，直接调用回调函数
            callback.call(img);
            return; // 直接返回，不用再处理onload事件
        }
        img.onload = function () { //图片下载完毕时异步调用callback函数。
            callback.call(img);//将回调函数的this替换为Image对象
        };
        img.onerror = function() {
            alert('加载图片错误！');
        };
        img.src = url;
    }

    return {
        getContent: function () {
            return view.iframeDocument.body.innerHTML;
        },

        init: function (opts) {
            conf = $.extend({}, defaults, opts || {});
            init();
        }
    }

});