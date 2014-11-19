define("common/main1",function(require){function e(){for(var e=i.$suggestTarget.children(),t=e.length,n=0;t>n;n++)$(e[n]).hasClass("selected")&&$(e[n]).removeClass("selected")}var t=require("util"),n=require("common/config"),o=require("common/login"),i={};i.$suggestText=$("#suggestion-text"),i.$suggestTarget=$("#suggestion-target"),i.$login=$("#login-btn"),i.$suggestText.on("focus",function(){var e=$(this);"商家名称联想"===t.str.trim(e.val())&&(e.val(""),$(this).css({color:"#000"}))}),i.$suggestText.on("blur",function(){var e=$(this);""===t.str.trim(e.val())&&(e.val("商家名称联想"),$(this).css({color:"#999"}))}),i.$suggestText.on("keyup",function(e){var o=$(this);o.val()!==o.data("val")&&(o.data("val",o.val()),t.str.trim(o.val())?$.ajax({url:n.AJAX.SEARCH_SUGGESTION+o.val(),dataType:"jsonp",jsonp:"callback",success:function(e){if(e&&e.shop){for(var t="",n=e.shop.length,o=0;n>o;o++)t+='<a target="_blank" href="http://zanbai.com/shop?shop_id='+e.shop[o].word_id+'">'+e.shop[o].word+"</a>";i.$suggestTarget.css({display:""}),i.$suggestTarget.html(t)}else i.$suggestTarget.css({display:"none"}),i.$suggestTarget.html("")}}):(i.$suggestTarget.css({display:"none"}),i.$suggestTarget.html(""))),e.stopPropagation(),e.preventDefault()}),$(document).click(function(e){var t=e.srcElement||e.target;t.parentNode&&"suggestion-target"!==t.parentNode.id&&"suggestion-text"!==t.id&&i.$suggestTarget.css({display:"none"})}),$(document).keydown(function(t){var n=t.keyCode?t.keyCode:t.which,o=i.$suggestTarget.css("display");if("none"!==o){for(var a,s=i.$suggestTarget.children(),r=s.length,c=0;r>c;c++)if($(s[c]).hasClass("selected")){a={elem:s[c],index:c};break}40==n?(a?a.index+1===r?(e(),$(s[0]).addClass("selected")):(e(),$(s[a.index+1]).addClass("selected")):(a={elem:s[0],index:0},$(s[a.index]).addClass("selected")),t.stopPropagation(),t.preventDefault()):38==n?(a?0===a.index?(e(),$(s[r-1]).addClass("selected")):(e(),$(s[a.index-1]).addClass("selected")):(a={elem:s[r-1],index:r-1},$(s[a.index]).addClass("selected")),t.stopPropagation(),t.preventDefault()):13==n&&(setTimeout(function(){a.elem&&a.elem.click()},10),t.stopPropagation(),t.preventDefault())}}),i.$suggestTarget.mouseover(function(e){var t=e.target||e.srcElement,n=t.tagName.toLowerCase();"a"==n&&$(t).addClass("selected")}).mouseout(function(t){var n=t.target||t.srcElement,o=n.tagName.toLowerCase();"a"==o&&e()}),i.$login.click(function(){o.show()})}),define("home/main",function(){}),define("util",function(require){function e(e,t){var n=Object.prototype.toString.call(t).slice(8,-1);return void 0!==t&&null!==t&&n===e}var $=require("jquery"),t={};return t={isArray:function(t){return e("Array",t)},isObject:function(t){return e("Object",t)},isString:function(t){return e("String",t)},isFunction:function(t){return e("Function",t)},getUniqueKey:function(){var e=(new Date).getTime().toString(),t=1;return function(){return e+t++}}(),indexOf:function(e,t){if(t.indexOf)return t.indexOf(e);for(var n=0,o=t.length;o>n;n++)if(t[n]===e)return n;return-1},inArray:function(e,n){return t.indexOf(e,n)>-1},easyTemplate:function(){var e=function(t,n){if(!t)return"";t!==e.template&&(e.template=t,e.aStatement=e.parsing(e.separate(t)));var o=e.aStatement,i=function(e){return e&&(n=e),arguments.callee};return i.toString=function(){return new Function(o[0],o[1])(n)},i};return e.separate=function(e){var t=/\\'/g,n=e.replace(/(<(\/?)#(.*?(?:\(.*?\))*)>)|(')|([\r\n\t])|(\$\{([^\}]*?)\})/g,function(e,n,o,i,a,s,r,c){return n?"{|}"+(o?"-":"+")+i+"{|}":a?"\\'":s?"":r?"'+("+c.replace(t,"'")+")+'":void 0});return n},e.parsing=function(e){var t,n,o,i,a,s,r=["var aRet = [];"];s=e.split(/\{\|\}/);for(var c=/\s/;s.length;)if(o=s.shift())if(a=o.charAt(0),"+"===a||"-"===a)switch(i=o.split(c),i[0]){case"+et":t=i[1],n=i[2],r.push('aRet.push("<!--'+t+' start-->");');break;case"-et":r.push('aRet.push("<!--'+t+' end-->");');break;case"+if":i.splice(0,1),r.push("if"+i.join(" ")+"{");break;case"+elseif":i.splice(0,1),r.push("}else if"+i.join(" ")+"{");break;case"-if":r.push("}");break;case"+else":r.push("}else{");break;case"+list":r.push("if("+i[1]+".constructor === Array){with({i:0,l:"+i[1]+".length,"+i[3]+"_index:0,"+i[3]+":null}){for(i=l;i--;){"+i[3]+"_index=(l-i-1);"+i[3]+"="+i[1]+"["+i[3]+"_index];");break;case"-list":r.push("}}}")}else o="'"+o+"'",r.push("aRet.push("+o+");");return r.push('return aRet.join("");'),[n,r.join("")]},e}(),str:{trim:function(e){if("string"!=typeof e)throw"trim need a string as parameter";for(var t=e.length,n=0,o=/(\u3000|\s|\t|\u00A0)/;t>n&&o.test(e.charAt(n));)n+=1;for(;t>n&&o.test(e.charAt(t-1));)t-=1;return e.slice(n,t)},decodeHTML:function(e){if("string"!=typeof e)throw"decodeHTML need a string as parameter";return e.replace(/&quot;/g,'"').replace(/&lt;/g,"<").replace(/&gt;/g,">").replace(/&#39/g,"'").replace(/&nbsp;/g," ").replace(/&#32/g," ").replace(/&amp;/g,"&")},encodeHTML:function(e){if("string"!=typeof e)throw"encodeHTML need a string as parameter";return e.replace(/\&/g,"&amp;").replace(/"/g,"&quot;").replace(/\</g,"&lt;").replace(/\>/g,"&gt;").replace(/\'/g,"&#39;").replace(/\u00A0/g,"&nbsp;").replace(/(\u0020|\u000B|\u2028|\u2029|\f)/g,"&#32;")}},obj:{objSup:function(e,t){for(var n={},o=0,i=t.length;i>o;o+=1){if("function"!=typeof e[t[o]])throw"super need function list  as the second paramsters";n[t[o]]=function(t){return function(){return t.apply(e,arguments)}}(e[t[o]])}return n},cut:function(e,n){var o={};if(!t.isArray(n))throw"Lilac.cut need array as second parameter";for(var i in e)t.inArray(i,n)||(o[i]=e[i]);return o}},json:{jsonToQuery:function(e,n){var o=function(e,n){return e=null==e?"":e,e=t.str.trim(e.toString()),n?encodeURIComponent(e):e},i=[];if("object"==typeof e)for(var a in e)if("$nullName"!==a)if(e[a]instanceof Array)for(var s=0,r=e[a].length;r>s;s++)i.push(a+"="+o(e[a][s],n));else"function"!=typeof e[a]&&i.push(a+"="+o(e[a],n));else i=i.concat(e[a]);return i.length?i.join("&"):""},queryToJson:function(e,n){for(var o=t.str.trim(e).split("&"),i={},a=function(e){return n?decodeURIComponent(e):e},s=0,r=o.length;r>s;s++)if(o[s]){var c=o[s].split("="),l=c[0],d=c[1];c.length<2&&(d=l,l="$nullName"),i[l]?(1!=t.isArray(i[l])&&(i[l]=[i[l]]),i[l].push(a(d))):i[l]=a(d)}return i}},dom:{parseDOM:function(e){for(var t in e)e[t]&&1==e[t].length&&(e[t]=e[t][0]);return e},builder:function(e,t){var n="string"==typeof e,o=e;n&&(o=document.createElement("div"),o.innerHTML=e);var i,a={};if(t)for(c in selectorList)a[c]=$(t[c].toString(),o);else{i=$("[node-type]",o);for(var s=0,r=i.length;r>s;s+=1){var c=i[s].getAttribute("node-type");a[c]||(a[c]=[]),a[c].push(i[s])}}var l=e;if(n)for(l=document.createDocumentFragment();o.childNodes[0];)l.appendChild(o.childNodes[0]);return{box:l,list:a}},contains:function(e,t){if(e===t)return!1;if(e.compareDocumentPosition)return 16===(16&e.compareDocumentPosition(t));if(e.contains&&1===t.nodeType)return e.contains(t);for(;t=t.parentNode;)if(e===t)return!0;return!1},isNode:function(e){return void 0!=e&&Boolean(e.nodeName)&&Boolean(e.nodeType)}},evt:{custEvent:function(){var e="__custEventKey__",n=1,o={},i=function(t,n){var i="number"==typeof t?t:t[e];return i&&o[i]&&{obj:"string"==typeof n?o[i][n]:o[i],key:i}},a={},s=function(e,t,n,o,a){if(e&&"string"==typeof t&&n){var s=i(e,t);if(!s||!s.obj)throw"custEvent ("+t+") is undefined !";return s.obj.push({fn:n,data:o,once:a}),s.key}},r=function(e,t,n,o){var a=!0,s=function(){a=!1};if(e&&"string"==typeof t){var r,c=i(e,t);if(c&&(r=c.obj)){n="undefined"!=typeof n&&[].concat(n)||[];for(var l=r.length-1;l>-1&&r[l];l--){var d=r[l].fn,u=r[l].once;if(d&&d.apply)try{d.apply(e,[{obj:e,type:t,data:r[l].data,preventDefault:s}].concat(n)),u&&r.splice(l,1)}catch(p){throw"[error][custEvent]"+p.message,p.stack}}return a&&"function"==typeof o&&o(),c.key}}},c={define:function(t,i){if(t&&i){var a="number"==typeof t?t:t[e]||(t[e]=n++),s=o[a]||(o[a]={});i=[].concat(i);for(var r=0;r<i.length;r++)s[i[r]]||(s[i[r]]=[]);return a}},undefine:function(t,n){if(t){var i="number"==typeof t?t:t[e];if(i&&o[i])if(n){n=[].concat(n);for(var a=0;a<n.length;a++)n[a]in o[i]&&delete o[i][n[a]]}else delete o[i]}},add:function(e,t,n,o){return s(e,t,n,o,!1)},once:function(e,t,n,o){return s(e,t,n,o,!0)},remove:function(e,n,o){if(e){var a,s=i(e,n);if(s&&(a=s.obj)){if(t.isArray(a))if(o){for(var r=0;a[r]&&a[r].fn!==o;)r++;a.splice(r,1)}else a.splice(0,a.length);else for(var r in a)a[r]=[];return s.key}}},fire:function(e,t,n,o){return r(e,t,n,o)},hook:function(t,i,s){if(t&&i&&s){var l,d,u=[],p=t[e],f=p&&o[p],m=i[e]||(i[e]=n++);if(f){d=a[p+"_"+m]||(a[p+"_"+m]={});var g=function(e){var t=!0;r(i,d[e.type].type,Array.prototype.slice.apply(arguments,[1,arguments.length]),function(){t=!1}),t&&e.preventDefault()};for(var h in s){var v=s[h];d[h]||(l=f[h])&&(l.push({fn:g,data:void 0}),d[h]={fn:g,type:v},u.push(v))}c.define(i,u)}}},unhook:function(t,n,o){if(t&&n&&o){var i=t[e],s=n[e],r=a[i+"_"+s];if(r)for(var l in o){{o[l]}r[l]&&c.remove(t,l,r[l].fn)}}},destroy:function(){o={},n=1,a={}}};return c}()}}}),define("common/config",{AJAX:{SEARCH_SUGGESTION:"http://zanbai.com:8090/?business=shop&limit=10&piece="}}),define("common/login",function(require){function e(){}var t=(require("util"),require("common/config"),require("hogan")),n=require("widget/popup/main"),o='<div id="login-layer-wraper"><div class="layer_login detail"><p class="login_title"></p><div class="login_icon_wrap"><ul class="icon_list clearfix"><li><a class="cur" href="../callback/weibo/?source_url={{sourceUrl}}"><em class="icon_sns weibo_login"></em><span>weibo</span></a></li><li><a class="cur" href="../callback/qq/?source_url={{sourceUrl}}"><em class="icon_sns QQ_login"></em><span>tencent</span></a></li><li><a class="cur" href="../callback/douban"><em class="icon_sns douban_login"></em><span>douban</span></a></li><li><a class="cur" href="../callback/renren/?source_url={{sourceUrl}}"><em class="icon_sns renren_login"></em><span>renren</span></a></li><li><a href="javascript:void(0);"><em class="icon_sns facebook_login"></em><span>facebook</span></a></li><li><a href="javascript:void(0);"><em class="icon_sns twitter_login"></em><span>twitter</span></a></li></ul></div><div class="sign_wrap"><h3>使用Zanbai登陆</h3><div class="info_list clearfix"><div class="tit fl"><i>*</i>账号：</div><div class="inp"><input name="email" type="text" class="W_input" id="email" value=""></div></div><div class="info_list clearfix"><div class="tit fl"><i>*</i>密码：</div><div class="inp"><input name="passwd" type="password" class="W_input" id="passwd" value=""></div><div class="tips"></div></div></div><div class="btn_wrap"><a href="javascript:void(0);" id="header-login" class="login_btn">立即登陆</a><a target="_blank" href="/register/?source_url={{sourceUrl}}" class="sign_btn">立即注册</a></div></div></div>',i=t.compile(o).render({sourceUrl:$CONFIG.sourceUrl});return{show:function(){var t=n.createModulePopup({});t.setTitle("提示"),t.setContent(i),t.show(),t.setMiddle(),e(t)}}}),define("widget/popup/main",function(require){function e(e){var t=function(e,t){for(var n,o=(e+";"+t).replace(/(\s*(;)\s*)|(\s*(:)\s*)/g,"$2$4");o&&(n=o.match(/(^|;)([\w\-]+:)([^;]*);(.*;)?\2/i));)o=o.replace(n[1]+n[2]+n[3],"");return o};e=e||"";var n=[],o={push:function(e,t){return n.push(e+":"+t),o},remove:function(e){for(var t=0;t<n.length;t++)0==n[t].indexOf(e+":")&&n.splice(t,1);return o},getStyleList:function(){return n.slice()},getCss:function(){return t(e,n.join(";"))}};return o}function t(t,n,o){function i(){return"none"!=t.css("display")}function a(e){e=u.isArray(e)?e:[0,0];for(var t=0;2>t;t++)"number"!=typeof e[t]&&(e[t]=0);return e}function s(t,n,o){if(i()){var a,s,r,c,l="fixed",d=t.offsetWidth,u=t.offsetHeight,p=$(window).width(),m=$(window).height(),g=0,h=0,v=e(t.style.cssText);if(f)switch(a=c=o[1],s=r=o[0],n){case"lt":c=r="";break;case"lb":a=r="";break;case"rt":s=c="";break;case"rb":a=s="";break;case"c":default:a=(m-u)/2+o[1],s=(p-d)/2+o[0],c=r=""}else{switch(l="absolute",g=a=$(window).scrollTop(),h=s=$(window).scrollLeft(),n){case"lt":a+=o[1],s+=o[0];break;case"lb":a+=m-u-o[1],s+=o[0];break;case"rt":a+=o[1],s+=p-d-o[0];break;case"rb":a+=m-u-o[1],s+=p-d-o[0];break;case"c":default:a+=(m-u)/2+o[1],s+=(p-d)/2+o[0]}r=c=""}"c"==n&&(g>a&&(a=g),h>s&&(s=h)),v.push("position",l).push("top",a+"px").push("left",s+"px").push("right",r+"px").push("bottom",c+"px"),t.style.cssText=v.getCss()}}function r(e){e=e||window.event,u.evt.custEvent.fire(d,"beforeFix",e.type),!g||f&&"c"!=c||s(p,c,l)}var c,l,d,p=t[0],f=!(v||"CSS1Compat"!==document.compatMode&&Lilac.browser.IE),m=/^(c)|(lt)|(lb)|(rt)|(rb)$/,g=!0;if(u.dom.isNode(p)&&m.test(n)){var h={getNode:function(){return p},isFixed:function(){return g},setFixed:function(e){return(g=!!e)&&s(p,c,l),this},setAlign:function(e,t){return m.test(e)&&(c=e,l=a(t),g&&s(p,c,l)),this},destroy:function(){f||$(window).off("scroll",r),$(window).off("resize",r),u.evt.custEvent.undefine(d)}};return d=u.evt.custEvent.define(h,"beforeFix"),h.setAlign(n,o),f||$(window).on("scroll",r),$(window).on("resize",r),h}}function n(e){var t;return(t=e.getAttribute(h))||e.setAttribute(h,t=u.getUniqueKey()),">"+e.tagName.toLowerCase()+"["+h+'="'+t+'"]'}function o(){c||(c=$("<div></div>"));var n="<div>";v&&(n+='<div style="position:absolute;width:100%;height:100%;"></div>'),n+="</div>",c=$.parseHTML(n)[0],document.body.appendChild(c),g=!0,l=t($(c),"lt"),d=function(){var t=$(window).width(),n=$(window).height();c.style.cssText=e(c.style.cssText).push("width",t+"px").push("height",n+"px").getCss()},$(window).on("resize",d),u.evt.custEvent.add(l,"beforeFix",d),d()}function i(e){var t=function(e){var t={};return"none"==e.style.display?(e.style.visibility="hidden",e.style.display="",t.w=e.offsetWidth,t.h=e.offsetHeight,e.style.display="none",e.style.visibility="visible"):(t.w=e.offsetWidth,t.h=e.offsetHeight),t},n=function(e,n){n=n||"topleft";var o=null;if("none"==e.style.display?(e.style.visibility="hidden",e.style.display="",o=$(e).position(),e.style.display="none",e.style.visibility="visible"):o=$(e).position(),"topleft"!==n){var i=t(e);"topright"===n?o.l=o.l+i.w:"bottomleft"===n?o.t=o.t+i.h:"bottomright"===n&&(o.l=o.l+i.w,o.t=o.t+i.h)}return o},o=u.dom.builder(e),i=o.list.outer[0],a=o.list.inner[0],s=u.getUniqueKey(),r={},c=u.evt.custEvent.define(r,"show");u.evt.custEvent.define(c,"hide");var l=null;return r.show=function(){return i.style.display="",u.evt.custEvent.fire(c,"show"),r},r.hide=function(){return i.style.display="none",u.evt.custEvent.fire(c,"hide"),r},r.getPosition=function(e){return n(i,e)},r.getSize=function(e){return(e||!l)&&(l=t.apply(r,[i])),l},r.html=function(e){return void 0!==e&&(a.innerHTML=e),a.innerHTML},r.text=function(e){return void 0!==text&&(a.innerHTML=u.str.encodeHTML(e)),u.str.decodeHTML(a.innerHTML)},r.appendChild=function(e){return a.appendChild(e),r},r.getUniqueID=function(){return s},r.getOuter=function(){return i},r.getInner=function(){return a},r.getParentNode=function(){return i.parentNode},r.getDomList=function(){return o.list},r.getDomListByKey=function(e){return o.list[e]},r.getDom=function(e,t){return o.list[e]?o.list[e][t||0]:!1},r}function a(e,t){if(!e)throw"createModuleDialog need template as first parameter";var n,o,a,s,r,c,l,d,p,f,m=function(){n=$.extend({t:null,l:null,width:null,height:null},t),o=i(e,n),s=o.getOuter(),r=o.getDom("title"),c=o.getDom("inner"),l=o.getDom("close"),$(l).on("click",function(e){return e.preventDefault(),p(),!1})};return m(),f=u.obj.objSup(o,["show","hide"]),p=function(e){return"function"!=typeof d||e||d()!==!1?(f.hide(),u.dom.contains(document.body,o.getOuter())&&document.body.removeChild(o.getOuter()),a):!1},a=o,a.show=function(){return u.dom.contains(document.body,o.getOuter())||document.body.appendChild(o.getOuter()),f.show(),a},a.hide=p,a.setPosition=function(e){return s.style.top=e.t+"px",s.style.left=e.l+"px",a},a.setMiddle=function(){var e=$(window).width(),t=$(window).height(),n=o.getSize(!0),i=$(document).scrollTop()+(t-n.h)/2;return s.style.top=0>i?0:i+"px",s.style.left=(e-n.w)/2+"px",a},a.setTitle=function(e){return r.innerHTML=e,a},a.setContent=function(e){return"string"==typeof e?c.innerHTML=e:c.appendChild(e),a},a.clearContent=function(){for(;c.children.length;)$(c.children[0]).remove();return a},a.setBeforeHideFn=function(e){d=e},a.clearBeforeHideFn=function(){d=null},a}function s(e){var t,n=['<div class="W_layer" node-type="outer" style="display:none;position:absolute;z-index:10001">','<div class="bg">','<table border="0" cellspacing="0" cellpadding="0">',"<tbody>","<tr>","<td>",'<div class="content">','<div class="title" node-type="title">','<span node-type="title_content"></span>',"</div>",'<a href="javascript:void(0);" class="W_close" title="关闭" node-type="close"></a>','<div node-type="inner"></div>',"</div>","</td>","</tr>","</tbody>","</table>","</div>","</div>"].join(""),o=function(){var e=a(t.template);return t.isMask&&(u.evt.custEvent.add(e,"show",function(){y.showUnderNode(e.getOuter())}),u.evt.custEvent.add(e,"hide",function(){y.back(),e.setMiddle()})),t.isDrag&&p.drag(e.getDom("title"),{actObj:e,moveDom:e.getOuter()}),e.destroy=function(){i(e);try{e.hide(!0)}catch(t){}},e},i=function(e){e.setTitle("").clearContent()};t=$.extend({template:n,isHold:!1,isMask:!0,isDrag:!0},e);var s=t.isHold;t=u.obj.cut(t,["isHold"]);var r=o();return s||u.evt.custEvent.add(r,"hide",function(){u.evt.custEvent.remove(r,"hide",arguments.callee),i(r)}),r}function r(e,t){var n,o,a,s,t=$.extend({hideCallback:function(){},type:"succM",msg:"",timeout:""},t),r=t.template||'<#et temp data><div class="W_layer" node-type="outer"><div class="bg"><table cellspacing="0" cellpadding="0" border="0"><tbody><tr><td><div class="content layer_mini_info_big" node-type="inner"><p class="clearfix"><span class="icon_${data.type}"></span>${data.msg}&nbsp; &nbsp; &nbsp;</p></div></td></tr></tbody></table></div></div></#et>',c=u.easyTemplate(r,{type:t.type,msg:e}).toString();n={},o=i(c),s=o.getOuter(),u.evt.custEvent.add(o,"hide",function(){y.hide(),t.hideCallback&&t.hideCallback(),u.evt.custEvent.remove(o,"hide",arguments.callee),clearTimeout(a)}),u.evt.custEvent.add(o,"show",function(){document.body.appendChild(s),y.showUnderNode(s)}),o.show(),t.timeout&&(a=setTimeout(o.hide,t.timeout));var l=$(window).width(),d=$(window).height(),p=o.getSize(!0);return s.style.top=$(document).scrollTop()+(d-p.h)/2+"px",s.style.left=(l-p.w)/2+"px",n.layer=o,n}var c,l,d,$=require("jquery"),u=require("util"),p=require("widget/drag/main"),f=$.browser,m=[],g=!1,h="Lilac-Mask-Key",v=function(){return f.msie&&parseInt(f.version,10)<=6}(),y={getNode:function(){return c},show:function(e,t){return g?(e=$.extend({opacity:.3,background:"#000000"},e),c.style.background=e.background,$(c).css("opacity",e.opacity),c.style.display="",l.setAlign("lt"),t&&t()):(o(),y.show(e,t)),y},hide:function(){return c.style.display="none",nowIndex=void 0,m=[],y},showUnderNode:function(e,t){return u.dom.isNode(e)&&y.show(t,function(){$(c).css("zIndex",$(e).css("zIndex"));var t=n(e),o=u.indexOf(m,t);-1!=o&&m.splice(o,1),m.push(t),$(e).before($(c))}),y},back:function(){if(m.length<1)return y;var e,t;return m.pop(),m.length<1?y.hide():(t=m[m.length-1])&&(e=$(t,document.body)[0])?($(c).css("zIndex",$(e).css("zIndex")),$(e).before($(c))):y.back(),y},destroy:function(){u.evt.custEvent.remove(l),$(window).off("resize",d),c.style.display="none",lastNode=void 0,_cache={}}};return{createModulePopup:s,litePrompt:r}}),define("widget/drag/main",function(require){function e(e,t){var i=function(e){return e.cancelBubble=!0,!1},a=function(e,t){return e.clientX=t.clientX,e.clientY=t.clientY,e.pageX=t.clientX+$(document).scrollLeft(),e.pageY=t.clientY+$(document).scrollTop(),e};if(!n.dom.isNode(e))throw"dragBase need Element as first parameter";var s=$.extend({actRect:[],actObj:{}},t),r={},c=n.evt.custEvent.define(s.actObj,"dragStart"),l=(n.evt.custEvent.define(s.actObj,"dragEnd"),n.evt.custEvent.define(s.actObj,"draging"),function(e){var t=a({},e);return document.body.onselectstart=function(){return!1},$(document).on("mousemove",d),$(document).on("mouseup",u),$(document).on("click",i,!0),o.msie||(e.preventDefault(),e.stopPropagation()),n.evt.custEvent.fire(c,"dragStart",t),!1}),d=function(e){var t=a({},e);e.cancelBubble=!0,n.evt.custEvent.fire(c,"draging",t)},u=function(e){var t=a({},e);document.body.onselectstart=function(){return!0},$(document).off("mousemove",d),$(document).off("mouseup",u),$(document).off("click",i,!0),n.evt.custEvent.fire(c,"dragEnd",t)};return $(e).on("mousedown",l),r.destroy=function(){$(e).off("mousedown",l),s=null},r.getActObj=function(){return s.actObj},r}function t(t,o){var i,a,s,r,c,l,d,u,p=function(){f(),m()},f=function(){i=$.extend({moveDom:t,perchStyle:"border:solid #999999 2px;",dragtype:"perch",actObj:{},pagePadding:5,dragStart:function(){},dragEnd:function(){},draging:function(){}},o),s=i.moveDom,a={},r={},c=e(t,{actObj:i.actObj}),"perch"===i.dragtype&&(l=document.createElement("div"),d=!1,u=!1,s=l),t.style.cursor="move"},m=function(){n.evt.custEvent.add(i.actObj,"dragStart",g),n.evt.custEvent.add(i.actObj,"dragEnd",h),n.evt.custEvent.add(i.actObj,"draging",v)},g=function(e,n){if(document.body.style.cursor="move",r=$(i.moveDom).position(),r.pageX=n.pageX,r.pageY=n.pageY,r.height=i.moveDom.offsetHeight,r.width=i.moveDom.offsetWidth,r.pageHeight=$(document).height(),r.pageWidth=$(document).width(),"perch"===i.dragtype){var o=[];o.push(i.perchStyle),o.push("position:absolute"),o.push("z-index:"+(parseInt(i.moveDom.style.zIndex,10)+10)),o.push("width:"+i.moveDom.offsetWidth+"px"),o.push("height:"+i.moveDom.offsetHeight+"px"),o.push("left:"+r.left+"px"),o.push("top:"+r.top+"px"),l.style.cssText=o.join(";"),u=!0,setTimeout(function(){u&&(document.body.appendChild(l),d=!0)},100)}void 0!==t.setCapture&&t.setCapture(),i.dragStart(s,n,t)},h=function(e,n){document.body.style.cursor="auto",void 0!==t.setCapture&&t.releaseCapture(),"perch"===i.dragtype&&(u=!1,$(i.moveDom).css({left:parseInt(l.style.left),top:parseInt(l.style.top)}),d&&(document.body.removeChild(l),d=!1)),i.dragEnd(s,n,t)},v=function(e,n){var o=r.top+(n.pageY-r.pageY),a=r.left+(n.pageX-r.pageX),c=o+r.height,l=a+r.width,d=r.pageHeight-i.pagePadding,u=r.pageWidth-i.pagePadding;d>c&&o>0?$(s).css({top:o}):(0>o&&$(s).css({top:0}),c>=d&&$(s).css({top:d-r.height})),u>l&&a>0?$(s).css({left:a}):(0>a&&$(s).css({left:0}),l>=u&&$(s).css({left:u-r.width})),i.draging(s,n,t)};return p(),a.destroy=function(){document.body.style.cursor="auto","function"==typeof s.setCapture&&s.releaseCapture(),"perch"===i.dragtype&&(u=!1,d&&(document.body.removeChild(l),d=!1)),n.evt.custEvent.remove(i.actObj,"dragStart",g),n.evt.custEvent.remove(i.actObj,"dragEnd",h),n.evt.custEvent.remove(i.actObj,"draging",v),c.destroy&&c.destroy(),i=null,s=null,r=null,c=null,l=null,d=null,u=null},a.getActObj=function(){return i.actObj},a}var $=require("jquery"),n=require("util"),o=$.browser;return{drag:t}});