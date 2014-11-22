define(function(require){var $=require("jquery"),e=require("shop_detail/config"),t=require("hogan"),n=require("util"),r=require("widget/popup/main"),a=require("widget/pager/main"),o=require("common/login"),i=require("widget/fixedable/main"),c=require("widget/richeditor/main"),u=require("widget/rating/main"),s={};s.$commentList=$("#comment_list");var f='<div class="detail"><div class="clearfix"><div style="text-align: center;"><p>确认删除？</p></div><div class="btn"><a class="W_btn_b" href="javascript:void(0);" node-type="confirmBtn"><span>确认</span></a><a class="W_btn_a" href="javascript:void(0);" node-type="cancelBtn"><span>取消</span></a></div></div></div>';s.$commentList.delegate("[action-type=delDianping]","click",function(t){var a=n.json.queryToJson($(this).attr("action-data")),o=r.createModulePopup();o.setTitle("提示"),o.setContent(f),o.show(),o.setMiddle();var i=n.dom.parseDOM(n.dom.builder(o.getInner()).list);$(i.confirmBtn).click(function(){$.ajax({type:"get",url:e.AJAX.DELETE_DIANPING,dataType:"json",data:a,success:function(e){200==e.code?(o.destroy(),r.litePrompt("删除成功！",{timeout:1500,hideCallback:function(){setTimeout(function(){window.location.reload()},20)}})):(o.destroy(),r.alertPopup("删除失败："+e.msg))}})}),$(i.cancelBtn).click(function(){o.destroy()}),t.stopPropagation(),t.preventDefault()});var l='<div class="textarea_wrap textb clearfix"><textarea class="send_textarea"></textarea><div class="btn_wrap fr"><span>禁止发布色情、反动及广告内容！</span><a href="javascript:void(0);" action-type="send_comment" action-data="{{actionDataStr}}" class="post_btn">发送</a></div></div>';s.$commentList.delegate("[action-type=reply]","click",function(e){if(0==window.$CONFIG.isLogin)o.show();else{var n=t.compile(l).render({actionDataStr:$(this).attr("action-data")});$(this).parent().parent().after(n),$(this).attr("action-type","unreply")}e.stopPropagation(),e.preventDefault()}),s.$commentList.delegate("[action-type=unreply]","click",function(e){$(this).parent().parent().next().remove(),$(this).attr("action-type","reply"),e.stopPropagation(),e.preventDefault()}),s.$commentList.delegate("[action-type=send_comment]","click",function(t){if(0==window.$CONFIG.isLogin)o.show();else{var a=$(this).parent().parent(),i=$(this).parent().prev();if(n.str.trim(i.val())){var c=n.json.queryToJson($(this).attr("action-data"));c.comment=encodeURIComponent(i.val()),$.ajax({type:"post",url:e.AJAX.ADD_COMMENT,dataType:"json",data:c,success:function(e){200==e.code?r.litePrompt("评论成功！",{timeout:1500,hideCallback:function(){var e=$("[action-type=unreply]",a.prev()[0]);e.attr("action-type","reply"),a.remove()}}):r.alertPopup("评论失败："+e.msg)}})}}t.stopPropagation(),t.preventDefault()}),s.$commentList.delegate("[action-type=modifyDianping]","click",function(t){var a=$(this),o=n.json.queryToJson($(this).attr("action-data"));$.ajax({type:"get",dataType:"json",url:e.AJAX.GET_DIANPING,data:{id:o.id},success:function(t){c.show({content:t.html.body,confirmFn:function(t,i){if(n.str.trim(t)){var c="",s=/src=[\'\"]?([^\'\"]*)[\'\"]?/i,f=t.match(/<img.*?(?:>|\/>)/gi);if(f)for(var l=0;l<f.length;l++){var p=f[l].match(s);p[1]&&(c+=p[1].replace(/!popup$/,"")+",")}$.ajax({type:"post",url:e.AJAX.ADD_DIANPING,dataType:"json",data:{body:encodeURIComponent(t),pics:c.replace(/,$/,""),score:u.getResult(),source:"profile",id:o.id},success:function(e){"200"==e.code?(i.destroy(),r.litePrompt("晒单成功！",{timeout:1500,hideCallback:function(){a[0].parentNode&&a[0].parentNode.parentNode&&(a[0].parentNode.parentNode.outerHTML=e.html)}})):(i.destroy(),r.litePrompt(e.msg,{timeout:1500}))}})}else r.alertPopup("点评内容不能为空")}}),u.init({elemId:"rating",score:t.html.score})}}),t.stopPropagation(),t.preventDefault()}),a.initialize("page_container","comment_list",e.AJAX.GET_PING_HTML),i.addEl("tab_container")});