define(function(require){function e(){f.$textarea=$("#RE_textarea"),f.textarea=f.$textarea[0],f.$iframe=$("#RE_iframe"),f.iframe=f.$iframe[0],f.$toolbar=$("#RE_toolbar"),f.toolbar=f.$toolbar[0],f.$uploadForm=$("#upload_form"),f.uploadForm=f.$uploadForm[0],f.$uploadFile=$("#upload_file"),f.uploadFile=f.$uploadFile[0],f.$maskDiv=$("#RE_mask_div"),f.maskDiv=f.$maskDiv[0],f.iframeDocument=f.iframe.contentDocument||f.iframe.contentWindow.document,f.iframeDocument.designMode="on",f.iframeDocument.open(),f.iframeDocument.write('<html><head><style type="text/css">* {margin:0;padding:0;}body {font-family:arial;font-size:16px;background:white;border:0; word-wrap: break-word;}</style>'+u.content+"</head></html>"),f.iframeDocument.close(),n(),t(f.uploadForm,f.uploadFile,function(){return function(e){var t=e.fullurl+"!popup";a(t,function(){s=e.fullurl+"!popup",setTimeout(function(){o("insertimage",s),f.iframe.contentWindow.focus(),f.$maskDiv.css("display","none")},0)})}}())}function t(e,t,n){var r="ZB_"+ +new Date+("undefined"!=typeof cbnSuffix?cbnSuffix:"");$(t).on("change",function(){t.value&&$.ajax({type:"post",url:i.AJAX.GET_SECURITY_DATA,dataType:"json",data:{imgCallback:r},success:function(n){f.$maskDiv.css("display",""),$("[name=signature]").val(n.signature),$("[name=policy]").val(n.policy),e.submit(),t.value=""}})}),e.action=i.AJAX.UPLOADIMG,n&&(window[r]=n)}function n(){if(f.$toolbar.delegate("[action-type=toolbar-action]","click",r),$.browser.msie){var e;f.$iframe.on("beforedeactivate",function(){var t=f.iframeDocument.selection.createRange();e=t.getBookmark()}),f.$iframe.on("activate",function(){if(e){var t=f.iframeDocument.body.createTextRange();t.moveToBookmark(e),t.select(),e=null}})}}function r(e){var t=$(this).attr("command");switch(t){case"createlink":var n=prompt("请输入网址:","http://");o(t,n);break;case"insertimage":f.iframe.contentWindow.focus(),f.$uploadFile.click();break;case"fontname":break;case"fontsize":break;case"forecolor":case"backcolor":case"html":break;case"table":case"emoticons":return;default:o(t,"")}e.stopPropagation(),e.preventDefault()}function o(e,t){try{f.iframe.contentWindow.focus(),f.iframeDocument.execCommand(e,!1,t),"insertimage"==e&&($.browser.chrome&&(f.iframeDocument.execCommand("InsertParagraph"),f.iframeDocument.execCommand("InsertParagraph"),f.iframeDocument.execCommand("InsertParagraph")),s="")}catch(n){throw new Error(n)}}function a(e,t){var n=new Image;return n.complete?(t.call(n),void 0):(n.onload=function(){t.call(n)},n.onerror=function(){alert("加载图片错误！")},n.src=e,void 0)}var $=require("jquery"),i=(require("hogan"),require("./config")),u={},c={content:""},f={},s="";return{getContent:function(){return f.iframeDocument.body.innerHTML},init:function(t){u=$.extend({},c,t||{}),e()}}});