define(function(require){function e(e,t){var n=parseInt(r.$preview1.css("width"),10)/t.width,o=parseInt(r.$preview1.css("height"),10)/t.width,i=parseInt(r.$preview2.css("width"),10)/t.width,a=parseInt(r.$preview2.css("height"),10)/t.width,s=parseInt(r.$preview3.css("width"),10)/t.width,c=parseInt(r.$preview3.css("height"),10)/t.width;$("#preview1 > img").css("width",Math.round(300*n)+"px"),$("#preview1 > img").css("height",Math.round(300*o)+"px"),$("#preview1 > img").css("marginLeft","-"+Math.round(n*t.x1)+"px"),$("#preview1 > img").css("marginTop","-"+Math.round(o*t.y1)+"px"),$("#preview2 > img").css("width",Math.round(300*i)+"px"),$("#preview2 > img").css("height",Math.round(300*a)+"px"),$("#preview2 > img").css("marginLeft","-"+Math.round(i*t.x1)+"px"),$("#preview2 > img").css("marginTop","-"+Math.round(a*t.y1)+"px"),$("#preview3 > img").css("width",Math.round(300*s)+"px"),$("#preview3 > img").css("height",Math.round(300*c)+"px"),$("#preview3 > img").css("marginLeft","-"+Math.round(s*t.x1)+"px"),$("#preview3 > img").css("marginTop","-"+Math.round(c*t.y1)+"px")}function t(e,t,n){var o="ZB_"+ +new Date+("undefined"!=typeof cbnSuffix?cbnSuffix:"");$(t).on("change",function(){t.value&&$.ajax({type:"post",url:a.AJAX.GET_SECURITY_DATA,dataType:"json",data:{imgCallback:o},success:function(t){$("[name=signature]").val(t.signature),$("[name=policy]").val(t.policy),e.submit()}})}),e.action=a.AJAX.UPLOADIMG,n&&(window[o]=n)}var n=require("widget/imgclip/main"),o=require("widget/popup/main"),i=require("util"),a=require("./config"),s=require("common/login"),r={};r.$preview1=$("#preview1"),r.$preview2=$("#preview2"),r.$preview3=$("#preview3"),r.$uploadForm=$("#uploadForm"),r.$uploadFile=$("#uploadFile"),r.$originImg=$("#originImg"),r.$fileUploadBtn=$("#fileUploadBtn"),r.$saveSetting=$("#saveSetting"),r.$imgUrl=$("#imgUrl"),r.$uname=$("#uname"),n.init(r.$originImg,{aspectRatio:"1:1",onSelectChange:e}),t(r.$uploadForm[0],r.$uploadFile[0],function(){return function(e){r.$originImg[0].src=e.fullurl+"!settingimage",r.$originImg.css("display",""),r.$preview1.css("overflow","hidden"),r.$preview2.css("overflow","hidden"),r.$preview3.css("overflow","hidden"),$("#preview1 > img")[0].src=e.fullurl,$("#preview2 > img")[0].src=e.fullurl,$("#preview3 > img")[0].src=e.fullurl,$("#imgUrl")[0].value=e.fullurl,$("#preview1 > img").css("display",""),$("#preview2 > img").css("display",""),$("#preview3 > img").css("display","")}}()),r.$fileUploadBtn.on("click",function(){r.$uploadFile.click()}),r.$saveSetting.on("click",function(){if(0==window.$CONFIG.isLogin)s.show();else{var e=i.str.trim(r.$imgUrl.val()),t=i.str.trim(r.$uname.val());e||t?$.ajax({type:"post",url:a.AJAX.MODIFY_USERINFO,dataType:"json",data:{image:e,uname:t},success:function(e){200==e.code?setTimeout(function(){window.location.reload()},20):o.alertPopup(e.msg)}}):o.alertPopup("昵称和头像必须选择一项")}})});