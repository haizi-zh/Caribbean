(function ($) {

    var dEvt, popupDevt;

    var it;

    var textarea, toolbar, br, iframe, iframeDocument, popup;

    var FONTSIZEPOPUP = ['<#et userlist data>',
        '<div node-type="RE_popup" style="display: none; width: 150px; position: absolute;" class="RE_popup_shadow RE_popup" unselectable="on">',
        '<#if (data.length>0)>',
        '<#list data as item>',
        '<div class="RE_popup_item" unselectable="on" action-type="popup_act" action-data="fontSize=${item.sizeValue}" style="height: ${item.sizeValue+30}px;">',
        '<div class="RE_popup_inline_block RE_popup_item_left">',
        '<#if (item.checked)>',
        '<span class="RE_popup_inline_block RE_popup_item_checked"></span>',
        '</#if>',
        '</div>',
        '<div class="RE_popup_inline_block RE_popup_item_right" style="line-height: 28px;">',
        '<span style="font-size:${item.fontSize};" unselectable="on">${item.str}</span>',
        '</div>',
        '</div>',
        '</#list>',
        '</#if>',
        '</div>',
        '</#et>'].join('');

    var FONTFAMILYPOPUP = ['<#et userlist data>',
        '<div node-type="RE_popup" style="display: none; width: 150px; position: absolute;" class="RE_popup_shadow RE_popup" unselectable="on">',
        '<#if (data.length>0)>',
        '<#list data as item>',
        '<div class="RE_popup_item" unselectable="on" action-type="popup_act" action-data="fontFamily=${item.fontFamily}" style="height: 30px;">',
        '<div class="RE_popup_inline_block RE_popup_item_left">',
        '<#if (item.checked)>',
        '<span class="RE_popup_inline_block RE_popup_item_checked"></span>',
        '</#if>',
        '</div>',
        '<div class="RE_popup_inline_block RE_popup_item_right" style="line-height: 28px;">',
        '<span style="font-family:${item.fontFamily};" unselectable="on">${item.fontFamily}</span>',
        '</div>',
        '</div>',
        '</#list>',
        '</#if>',
        '</div>',
        '</#et>'].join('');


    var fontSizeArr = [
        {
            fontSize:'xx-small',
            sizeValue:1,
            // str:'特小'
            str:'1(8pt)'
        },
        {
            fontSize:'x-small',
            sizeValue:2,
            // str:'很小'
            str:'2(10pt)'
        },
        {
            fontSize:'small',
            sizeValue:3,
            // str:'小',
            str:'3(12pt)',
            checked:true
        },
        {
            fontSize:'medium',
            sizeValue:4,
            // str:'中'
            str:'4(14pt)'
        },
        {
            fontSize:'large',
            sizeValue:5,
            // str:'大'
            str:'5(18pt)'
        },
        {
            fontSize:'x-large',
            sizeValue:6,
            // str:'很大'
            str:'6(24pt)'
        },
        {
            fontSize:'xx-large',
            sizeValue:7,
            // str:'特大'
            str:'7(36pt)'
        }
    ];

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

    function createImg(src){
        var tmpImg = document.createElement('img');
        tmpImg.id = 'RE_tmpimg';
        tmpImg.style.visibility = 'hidden';
        tmpImg.src = src;
        $(document.body).insertElement(tmpImg, 'beforeend');
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
    };

    var uploadForm, uploadFile;

    var fullUrl = '';

    var handler = {
        init:function () {

            textarea = $('#RE_textarea')[0];
            iframe = $('#RE_iframe')[0];
            toolbar = $('#RE_toolbar')[0];
           /* br = $.C('br'); //用于清除浮动
            textarea.parentNode.insertBefore(br, textarea);
            br.style.cssText = "clear:both";*/
            iframeDocument = iframe.contentDocument || iframe.contentWindow.document;
            iframeDocument.designMode = "on";
            iframeDocument.open();
            iframeDocument.write(''
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

            iframeDocument.close();
            handler.bind();

            // iframeDocument.body.innerHTML = '<font style="color: rgb(210, 210, 210)">可以填写您的整个经历和感受，所购买的货品，分享购物的喜悦</font>';

            handler.uploadFormConfig($('#upload_form')[0], $('#upload_file')[0], (function(){
                
                return function(o) {
                    

                    var imgSrc = o.fullurl+'!popup';
                    
                    // createImg(imgSrc);
                    
                    loadImage(imgSrc, function(){
                        // var okBtn = $.sizzle('[node-type=okBtn]')[0];
                        // okBtn.innerHTML = '<span>确定</span>';
                        // $(okBtn).setStyle('width', '74px');
                        // window.uploadImgFlag = false;
                        fullUrl = o.fullurl+'!popup';
                        setTimeout(function(){
                            handler._format('insertimage', fullUrl);
                            iframe.contentWindow.focus();
                            $('#RE_mask_div').setStyle('display', 'none');
                        }, 0);
                    });
                    // console.log($('#RE_tmpimg'));

                    /*var okBtn = $.sizzle('[node-type=okBtn]')[0];
                    okBtn.innerHTML = '<span>确定</span>';
                    $(okBtn).setStyle('width', '74px');
                    window.uploadImgFlag = false;
                    handler._format('insertimage', o.fullurl+'!popup');
                    fullUrl = o.fullurl+'!popup';
                    // var pids = $('#pids')[0].value;
                    // if(pids){
                    //     pids += ',' + o.fullurl;
                    // }else{
                    //     pids += o.fullurl;
                    // }
                    // $('#pids')[0].value = pids;
                    iframe.contentWindow.focus();*/
                }
            })());
        },

        _format:function (x, y) {
            try {
                iframe.contentWindow.focus();
                iframeDocument.execCommand(x, false, y);
                if(x == 'insertimage'){
                    if($.browser.CHROME){
                        iframeDocument.execCommand('InsertParagraph');
                        iframeDocument.execCommand('InsertParagraph');
                        iframeDocument.execCommand('InsertParagraph');
                    }
                    fullUrl = '';
                }
            } catch (e) {
                throw new Error(e);
            }
        },

        bind:function () {
            dEvt = $.delegatedEvent(toolbar);
            dEvt.add('toolbar_act', 'click', bindDOMFuns.toolbarClick);

            if ($.browser.IE) {
                var bookmark;
                $(iframe).addEvent("beforedeactivate", function () { //在文档失去焦点之前
                    var range = iframeDocument.selection.createRange();
                    bookmark = range.getBookmark();
                });
                //恢复IE的编辑光标
                $(iframe).addEvent("activate", function () {
                    if (bookmark) {
                        var range = iframeDocument.body.createTextRange();
                        range.moveToBookmark(bookmark);
                        range.select();
                        bookmark = null;
                    }
                });
            }

            /*if($.browser.IE7){
                $(iframe).addEvent("focus", function () {
                    // var html = iframeDocument.body.innerHTML;
                    // html = html ? html.toLowerCase() : '';
                    // if(
                    //     html == '<font style="color: rgb(210,210,210)">可以填写您的整个经历和感受，所购买的货品，分享购物的喜悦</font>'
                    //         || html == '<font style="color: rgb(210, 210, 210)">可以填写您的整个经历和感受，所购买的货品，分享购物的喜悦</font>'
                    // ){
                    //     iframeDocument.body.innerHTML = '';
                    // }

                    var html = iframeDocument.body.innerHTML.replace(/<[^>]+>|\&\w+;/g, '');

                    if (html === '可以填写您的整个经历和感受，所购买的货品，分享购物的喜悦') {
                        iframeDocument.body.innerHTML = '';
                    }

                    fullUrl && handler._format('insertimage', fullUrl);
                });
                $(iframe).addEvent("blur", function () {
                    // var html = iframeDocument.body.innerHTML;
                    // html = html ? html.toLowerCase() : '';
                    // html = html.replace(/<p\>\&nbsp;\<\/p\>/ig, '');
                    // if($.trim(html) == '' ){
                    //     iframeDocument.body.innerHTML = '<font style="color: rgb(210,210,210)">可以填写您的整个经历和感受，所购买的货品，分享购物的喜悦</font>';
                    // }
                    var html = iframeDocument.body.innerHTML.replace(/<[^>]+>|\&\w+;/g, '');
                    if($.trim(html) == '' ){
                        iframeDocument.body.innerHTML = '<font style="color: rgb(210,210,210)">可以填写您的整个经历和感受，所购买的货品，分享购物的喜悦</font>';
                    }
                });
            }else{
                $(iframe.contentWindow).addEvent("focus", function () {
                    // var html = iframeDocument.body.innerHTML;
                    // html = html ? html.toLowerCase() : '';
                    // if(
                    //     html == '<font style="color: rgb(210,210,210)">可以填写您的整个经历和感受，所购买的货品，分享购物的喜悦</font>'
                    //         || html == '<font style="color: rgb(210, 210, 210)">可以填写您的整个经历和感受，所购买的货品，分享购物的喜悦</font>'
                    // ){
                    //     iframeDocument.body.innerHTML = '';
                    // }

                    var html = iframeDocument.body.innerHTML.replace(/<[^>]+>|\&\w+;/g, '');
                    if (html === '可以填写您的整个经历和感受，所购买的货品，分享购物的喜悦') {
                        iframeDocument.body.innerHTML = '';
                    }
                    fullUrl && handler._format('insertimage', fullUrl);
                });

                $(iframe.contentWindow).addEvent("blur", function () {
                    // var html = iframeDocument.body.innerHTML;
                    // html = html ? html.toLowerCase() : '';
                    // html = html.replace(/<p\>|\&nbsp;|\<\/p\>|\<br\>/ig, '');
                    // console.log(html);
                    // if($.trim(html) == '' ){
                    //     iframeDocument.body.innerHTML = '<font style="color: rgb(210,210,210)">可以填写您的整个经历和感受，所购买的货品，分享购物的喜悦</font>';
                    // }

                    var html = iframeDocument.body.innerHTML.replace(/<[^(>|img)]+>|\&\w+;/g, '');
                    if($.trim(html) == '' ){
                        iframeDocument.body.innerHTML = '<font style="color: rgb(210,210,210)">可以填写您的整个经历和感受，所购买的货品，分享购物的喜悦</font>';
                    }
                });
            }*/
        },

        changeFontSizeChecked: function(curSize){
            for (var i = fontSizeArr.length - 1; i >= 0; i--) {
                if (fontSizeArr[i].checked) {
                    delete fontSizeArr[i].checked;
                }
                if (fontSizeArr[i].sizeValue == curSize) {
                    fontSizeArr[i].checked = true;
                }
            }
        },

        changeFontFamilyChecked: function(curFamily){
            for (var i = fontFamilyArr.length - 1; i >= 0; i--) {
                if (fontFamilyArr[i].checked) {
                    delete fontFamilyArr[i].checked;
                }
                if (fontFamilyArr[i].fontFamily == curFamily) {
                    fontFamilyArr[i].checked = true;
                }
            }
        },

        uploadFormConfig: function(form, input, fn) {
            var cbn = ("ZB_" + (+(new Date()))) + (typeof(cbnSuffix) !== "undefined" ? cbnSuffix : "");
            $(input).addEvent("change", function(e) {
                if(input.value){
                    $.io.ajax({
                        'method': 'post',
                        'url': '/aj/uploadpic/getSecurityData',
                        'args': {
                            'imgCallback': cbn
                        },
                        'onComplete': function(data){
                            // var okBtn = $.sizzle('[node-type=okBtn]')[0];
                            // okBtn.innerHTML = '<span>正在上传图片…</span>';
                            // $(okBtn).setStyle('width', '100px');
                            $('#RE_mask_div').setStyle('display', '');
                            // window.uploadImgFlag = true;
                            $.sizzle('[name=signature]')[0].value = data.signature;
                            $.sizzle('[name=policy]')[0].value = data.policy;
                            form.submit();
                            input.value = '';
                        }
                    });
                }
            });
            form.action = "http://v0.api.upyun.com/zanbai/";
            fn && (window[cbn] = fn);
        }
    };



    var bindDOMFuns = {
        showPopup:function (button, type) {
            if (!popup) {
                var tmp, command;
                switch (type) {
                    case 'fontSize':
                        tmp = $.easyTemplate(FONTSIZEPOPUP, fontSizeArr).toString();
                        popup = $.builder(tmp).list.RE_popup[0];
                        $('#RE_container')[0].appendChild(popup);
                        command = button.getAttribute("command");
                        if ('backcolor' == command) {
                            command = $.browser.IE ? 'backcolor' : 'hilitecolor';
                        }
                        popup.setAttribute("id", type);
                        popup.setAttribute("title", command); //转移命令
                        $(popup).setStyle('display', '');
                        popup.style.left = button.offsetLeft + 'px';
                        popup.style.top = (button.clientHeight + button.offsetTop) + 'px';
                    break;

                    case 'fontFamily':
                        tmp = $.easyTemplate(FONTFAMILYPOPUP, fontFamilyArr).toString();
                        popup = $.builder(tmp).list.RE_popup[0];
                        $('#RE_container')[0].appendChild(popup);
                        command = button.getAttribute("command");
                        if ('backcolor' == command) {
                            command = $.browser.IE ? 'backcolor' : 'hilitecolor';
                        }
                        popup.setAttribute("id", type);
                        popup.setAttribute("title", command); //转移命令
                        $(popup).setStyle('display', '');
                        popup.style.left = button.offsetLeft + 'px';
                        popup.style.top = (button.clientHeight + button.offsetTop) + 'px';
                    break
                }

                popupDevt = $.delegatedEvent(popup);
                popupDevt.add('popup_act', 'click', bindDOMFuns.popupClick);

                $(document).addEvent('click', bindDOMFuns.hidePopup);
                $(iframeDocument).addEvent("click", bindDOMFuns.hidePopup);
                $.evt.stopEvent($.evt.fixEvent());
            }
        },

        hidePopup:function (e) {
            popup && $(popup).removeNode() && (popup = null);
            $(document).removeEvent('click', bindDOMFuns.hidePopup);
            $(iframeDocument).removeEvent("click", bindDOMFuns.hidePopup);
        },

        popupClick:function (e) {
            var popupId = popup.getAttribute('id');
            var command = popup.getAttribute('title');
            switch (popupId) {
                case 'fontSize':
                    try {
                        handler.changeFontSizeChecked(e.data.fontSize);
                        handler._format('fontsize', e.data.fontSize);
                    } catch (e) {
                        throw new Error(e);
                    }
                break;
                case 'fontFamily':
                    try {
                        handler.changeFontFamilyChecked(e.data.fontFamily);
                        handler._format('fontname', e.data.fontFamily);
                    } catch (e) {
                        throw new Error(e);
                    }
                break;
            }
        },

        uploadClick: function(){
            $.io.ajax({
                'url': '/aj/uploadpic/getSecurityData',
                'onComplete': function(data){
                    $.sizzle('[name=signature]')[0].value = data.signature;
                    $.sizzle('[name=policy]')[0].value = data.policy;
                }
            });
        },

        toolbarClick:function (e) {
            var command = e.el.getAttribute('command');
            switch (command) {
                case 'createlink':
                    var value = prompt('请输入网址:', 'http://');
                    handler._format(command, value);
                    break;
                case 'insertimage':
                    // var value = prompt('请输入网址:', 'http://');
                    // handler._format(command, value);

                    // $(uploadFile).addEvent("click", bindDOMFuns.uploadClick);
                    // $(uploadFile).addEvent("change", function() {
                    //     uploadForm.submit();
                    // });

                    // uploadFile.click();

                    // $('#upload_file').addEvent("click", bindDOMFuns.uploadClick);
                    // $('#upload_file').addEvent("change", function() {
                    //     $('#upload_form')[0].submit();
                    // });
                    iframe.contentWindow.focus();
                    $('#upload_file')[0].click();

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
                    console.log( iframeDocument.body.innerHTML);
                    break;
                case 'table':
                case 'emoticons':
                    return;
                default: //其他执行fontEdit(cmd, null)命令
                    handler._format(command, '');
                    break;
            }
        }
    };

    it = {
        getContent: function(){
            return iframeDocument.body.innerHTML;
        }
    }

    var conf = {};

    $.lo.richEditor = function (opts) {
        conf = $.extend($.lo.richEditor.defaults, opts || {});
        handler.init();
        return it;
    };

    $.lo.richEditor.defaults = {
        a:1,
        content: ''
    };


})(Lilac);
