define(function(require){function e(e){var i=t.dom.parseDOM(t.dom.builder(e.getInner()).list);$(i.header_login).on("click",function(a){var s=$(i.email),r=$(i.passwd),c=t.str.trim(s.val()),l=t.str.trim(r.val()),d="";c?l?$.ajax({type:"POST",url:n.AJAX.LOGIN,dataType:"json",data:{email:t.str.trim(s.val()),passwd:t.str.trim(r.val())},success:function(t){200!=t.code?(d=t.msg,o.alertPopup(d)):(e.destroy(),o.litePrompt("登录成功！",{timeout:1500,hideCallback:function(){setTimeout(function(){window.location.reload()},20)}}))}}):(d="请输入密码",o.alertPopup(d)):(d="请输入邮箱",o.alertPopup(d)),a.stopPropagation(),a.preventDefault()})}var $=require("jquery"),t=require("util"),n=require("common/config"),o=require("widget/popup/main"),i=require("hogan"),a='<div id="login-layer-wraper"><div class="layer_login detail"><p class="login_title"></p><div class="login_icon_wrap"><ul class="icon_list clearfix"><li><a class="cur" href="../callback/weibo/?source_url={{sourceUrl}}"><em class="icon_sns weibo_login"></em><span>weibo</span></a></li><li><a class="cur" href="../callback/qq/?source_url={{sourceUrl}}"><em class="icon_sns QQ_login"></em><span>tencent</span></a></li><li><a class="cur" href="../callback/douban"><em class="icon_sns douban_login"></em><span>douban</span></a></li><li><a class="cur" href="../callback/renren/?source_url={{sourceUrl}}"><em class="icon_sns renren_login"></em><span>renren</span></a></li><li><a href="javascript:void(0);"><em class="icon_sns facebook_login"></em><span>facebook</span></a></li><li><a href="javascript:void(0);"><em class="icon_sns twitter_login"></em><span>twitter</span></a></li></ul></div><div class="sign_wrap"><h3>使用Zanbai登陆</h3><div class="info_list clearfix"><div class="tit fl"><i>*</i>账号：</div><div class="inp"><input name="email" type="text" class="W_input" node-type="email" value=""></div></div><div class="info_list clearfix"><div class="tit fl"><i>*</i>密码：</div><div class="inp"><input name="passwd" type="password" class="W_input" node-type="passwd" value=""></div><div class="tips"></div></div></div><div class="btn_wrap"><a href="javascript:void(0);" node-type="header_login" class="login_btn">立即登陆</a><a target="_blank" href="/register/?source_url={{sourceUrl}}" class="sign_btn">立即注册</a></div></div></div>',s=i.compile(a).render({sourceUrl:$CONFIG.sourceUrl});return{show:function(){var t=o.createModulePopup({});t.setTitle("提示"),t.setContent(s),t.show(),t.setMiddle(),e(t)}}});