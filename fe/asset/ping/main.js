define(function(require){var $=require("jquery"),e=require("util"),t=require("ping/config"),n=require("common/login"),o=require("widget/popup/main"),i=require("widget/pager/main"),a=require("widget/fixedable/main"),s={};s.$sendPing=$("#send_ping"),s.$reply=$("#reply"),s.$pingContent=$("#ping_content"),s.$sendPing.on("click",function(i){if(0==window.$CONFIG.isLogin)n.show();else{var a=s.$pingContent.val();if(e.str.trim(a)){var r=(s.$sendPing[0],e.json.queryToJson(s.$sendPing.attr("node-data")));r.comment=a,$.ajax({type:"post",url:t.AJAX.ADD_COMMENT,dataType:"json",data:r,success:function(e){200==e.code?($("#comment_list").prepend(e.html),s.$pingContent.val("")):o.alertPopup("评论失败："+e.msg)}})}}i.stopPropagation(),i.preventDefault()}),s.$reply.on("click",function(){s.$pingContent.focus()}),i.initialize("page_container","comment_list",t.AJAX.GET_COMMENT),a.addEl("tab_container"),s.$commentContainer=$("#comment_list"),s.$commentContainer.delegate("[action-type=replyComment]","mouseenter",function(e){var t=e.currentTarget,n=$(t),o=$("div.reply_comment",n);"none"==o.css("display")&&o.css("display","block"),e.stopPropagation(),e.preventDefault()}),s.$commentContainer.delegate("[action-type=replyComment]","mouseleave",function(e){var t=e.currentTarget,n=$(t),o=$("div.reply_comment",n);"none"!=o.css("display")&&o.css("display","none"),e.stopPropagation(),e.preventDefault()}),s.$commentContainer.delegate("[action-type=toggleReplyDiv]","click",function(e){var t=e.currentTarget,n=$(t),o=n.next();"none"!=o.css("display")?o.css("display","none"):o.css("display","block");var i=$("textarea",o);i&&setTimeout(function(){i.focus()},100),e.stopPropagation(),e.preventDefault()}),s.$commentContainer.delegate("[action-type=sendComment]","click",function(i){if(0==window.$CONFIG.isLogin)n.show();else{var a=i.currentTarget,s=$(a),r=e.str.trim(s.parent().prev().val());if(r){var c=e.json.queryToJson(s.attr("action-data"));c.comment=r,$.ajax({type:"post",url:t.AJAX.ADD_COMMENT,dataType:"json",data:c,success:function(e){200==e.code?o.litePrompt("评论成功！",{timeout:1500,hideCallback:function(){setTimeout(function(){window.location.reload()},20)}}):o.alertPopup("评论失败："+e.msg)}})}}i.stopPropagation(),i.preventDefault()})});