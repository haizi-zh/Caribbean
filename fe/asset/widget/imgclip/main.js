define(function(require){function t(t,e){function n(t){return parseInt(t+w.left+D.left-_.left,10)}function o(t){return parseInt(t+w.top+D.top-_.top,10)}function i(t){return parseInt(t-w.left-D.left+_.left,10)}function a(t){return parseInt(t-w.top-D.top+_.top,10)}function r(t){return parseInt(t.pageX+D.left-_.left,10)}function s(t){return parseInt(t.pageY+D.top-_.top,10)}function c(){w=$(t).position(),C=parseInt($(t).css("width"),10),k=parseInt($(t).css("height"),10),"body"==$(M)[0].tagName.toLowerCase()?_=D={left:0,top:0}:(_=$(M).position(),D={left:M.scrollLeft,top:M.scrollTop}),R=n(0),G=o(0)}function l(){try{U.css("left",n(ne.x1)+"px"),U.css("top",o(ne.y1)+"px"),U.css("width",Math.max(ne.width-2*e.borderWidth,0)+"px"),U.css("height",Math.max(ne.height-2*e.borderWidth,0)+"px"),B.css("left",n(ne.x1)+"px"),B.css("top",o(ne.y1)+"px"),B.css("width",Math.max(ne.width-2*e.borderWidth,0)+"px"),B.css("height",Math.max(ne.height-2*e.borderWidth,0)+"px"),q.css("left",n(ne.x1)+"px"),q.css("top",o(ne.y1)+"px"),q.css("width",Math.max(ne.width-2*e.borderWidth,0)+"px"),q.css("height",Math.max(ne.height-2*e.borderWidth,0)+"px"),J.css("left",R+"px"),J.css("top",G+"px"),J.css("width",ne.x1+"px"),J.css("height",k+"px"),X.css("left",R+ne.x1+"px"),X.css("top",G+"px"),X.css("width",ne.width+"px"),X.css("height",ne.y1+"px"),K.css("left",R+ne.x2+"px"),K.css("top",G+"px"),K.css("width",C-ne.x2+"px"),K.css("height",k+"px"),Y.css("left",R+ne.x1+"px"),Y.css("top",G+ne.y2+"px"),Y.css("width",ne.width+"px"),Y.css("height",k-ne.y2+"px")}catch(t){}}function d(t){if(!T){c(),T=!0;var n=function(){T=!1,U.on("mouseout",n)},o=function(){T=!1,B.on("mouseout",o)},l=function(){T=!1,q.on("mouseout",o)};U.on("mouseout",n),B.on("mouseout",o),q.on("mouseout",l)}z=i(r(t))-ne.x1,F=a(s(t))-ne.y1,V=[],e.resizable&&(Z>=F?V[te]="n":F>=ne.height-Z&&(V[te]="s"),Z>=z?V[ee]="w":z>=ne.width-Z&&(V[ee]="e")),q.css("cursor",V.length?V.join("")+"-resize":e.movable?"move":"")}function u(i){if(1!=i.which)return!1;if(c(),e.resizable&&V.length>0){$("body").css("cursor",V.join("")+"-resize"),S=n("w"==V[ee]?ne.x2:ne.x1),O=o("n"==V[te]?ne.y2:ne.y1),$(document).on("mousemove",h),q.off("mousemove",d);var a=function(){V=[],$("body").css("cursor",""),e.autoHide&&(U.css("display","none"),B.css("display","none"),q.css("display","none"),J.css("display","none"),X.css("display","none"),K.css("display","none"),Y.css("display","none")),e.onSelectEnd(t,ne),$(document).off("mousemove",h),q.on("mousemove",d),$(document).off("mouseup",a)};$(document).on("mouseup",a)}else if(e.movable){$=ne.x1+R,L=ne.y1+G,E=r(i),I=s(i),$(document).on("mousemove",v);var a=function(){e.onSelectEnd(t,ne),$(document).off("mousemove",v),$(document).off("mouseup",a)};$(document).on("mouseup",a)}return!1}function p(){H=Math.max(R,Math.min(R+C,S+Math.abs(W-O)*P*(H>=S?1:-1))),W=Math.round(Math.max(G,Math.min(G+k,O+Math.abs(H-S)/P*(W>=O?1:-1)))),H=Math.round(H)}function f(){W=Math.max(G,Math.min(G+k,O+Math.abs(H-S)/P*(W>=O?1:-1))),H=Math.round(Math.max(R,Math.min(R+C,S+Math.abs(W-O)*P*(H>=S?1:-1)))),W=Math.round(W)}function m(n,o){H=n,W=o,e.minWidth&&Math.abs(H-S)<e.minWidth&&(H=S-e.minWidth*(S>H?1:-1),R>H?S=R+e.minWidth:H>R+C&&(S=R+C-e.minWidth)),e.minHeight&&Math.abs(W-O)<e.minHeight&&(W=O-e.minHeight*(O>W?1:-1),G>W?O=G+e.minHeight:W>G+k&&(O=G+k-e.minHeight)),H=Math.max(R,Math.min(H,R+C)),W=Math.max(G,Math.min(W,G+k)),P&&(Math.abs(H-S)/P>Math.abs(W-O)?f():p()),e.maxWidth&&Math.abs(H-S)>e.maxWidth&&(H=S-e.maxWidth*(S>H?1:-1),P&&f()),e.maxHeight&&Math.abs(W-O)>e.maxHeight&&(W=O-e.maxHeight*(O>W?1:-1),P&&p()),ne.x1=i(Math.min(S,H)),ne.x2=i(Math.max(S,H)),ne.y1=a(Math.min(O,W)),ne.y2=a(Math.max(O,W)),ne.width=Math.abs(H-S),ne.height=Math.abs(W-O),l(),e.onSelectChange(t,ne)}function h(t){return H=!V.length||V[ee]||P?r(t):n(ne.x2),W=!V.length||V[te]||P?s(t):o(ne.y2),m(H,W),!1}function y(n,o){H=(S=n)+ne.width,W=(O=o)+ne.height,ne.x1=i(S),ne.y1=a(O),ne.x2=i(H),ne.y2=a(W),l(),e.onSelectChange(t,ne)}function v(t){var e=Math.max(R,Math.min($+r(t)-E,R+C-ne.width)),n=Math.max(G,Math.min(L+s(t)-I,G+k-ne.height));return y(e,n),t.preventDefault(),!1}function g(n){function o(n){c(),ne.x1=ne.x2=i(E=S=H=r(n)),ne.y1=ne.y2=a(I=O=W=s(n)),ne.width=0,ne.height=0,V=[],l(),U.css("display",""),B.css("display",""),q.css("display",""),J.css("display",""),X.css("display",""),K.css("display",""),Y.css("display",""),$(document).off("mouseup",u),$(document).on("mousemove",h),q.off("mousemove",d),e.onSelectStart(t,ne);var p=function(){(e.autoHide||ne.width*ne.height==0)&&(U.css("display","none"),B.css("display","none"),q.css("display","none"),J.css("display","none"),X.css("display","none"),K.css("display","none"),Y.css("display","none")),e.onSelectEnd(t,ne),$(document).off("mousemove",h),q.on("mousemove",d),$(document).off("mouseup",p)};$(document).on("mouseup",p),$(document).off("mousemove",o)}function u(){$(document).off("mousemove",o),U.css("display","none"),B.css("display","none"),q.css("display","none"),J.css("display","none"),X.css("display","none"),K.css("display","none"),Y.css("display","none"),$(document).off("mouseup",u)}return 1!=n.which?!1:($(document).on("mousemove",o),$(document).on("mouseup",u),!1)}function b(){c(),l(!1),S=n(ne.x1),O=o(ne.y1),H=n(ne.x2),W=o(ne.y2)}function x(i){for(e=$.extend(e,i),null!=i.x1&&(ne.x1=i.x1,ne.y1=i.y1,ne.x2=i.x2,ne.y2=i.y2,i.show=!0),i.keys&&(e.keys=$.extend({shift:1,ctrl:"resize"},i.keys===!0?{}:i.keys)),M=$(e.parent)[0],c(),A=$(t);A.length&&"body"!=A[0].tagName.toLowerCase();)!isNaN(A.css("z-index"))&&A.css("z-index")>Q&&(Q=A.css("z-index")),"fixed"==A.css("position")&&(j=!0),A=$(A[0].parentNode);S=n(ne.x1),O=o(ne.y1),H=n(ne.x2),W=o(ne.y2),ne.width=H-S,ne.height=W-O,l(),i.hide?(U.css("display","none"),B.css("display","none"),q.css("display","none"),J.css("display","none"),X.css("display","none"),K.css("display","none"),Y.css("display","none")):i.show&&(U.css("display",""),B.css("display",""),q.css("display",""),J.css("display",""),X.css("display",""),K.css("display",""),Y.css("display","")),J.addClass(e.classPrefix+"-outer"),X.addClass(e.classPrefix+"-outer"),K.addClass(e.classPrefix+"-outer"),Y.addClass(e.classPrefix+"-outer"),U.addClass(e.classPrefix+"-selection"),B.addClass(e.classPrefix+"-border1"),q.addClass(e.classPrefix+"-border2"),U.css("borderWidth",e.borderWidth+"px"),B.css("borderWidth",e.borderWidth+"px"),q.css("borderWidth",e.borderWidth+"px"),U.css("backgroundColor",e.selectionColor),U.css("opacity",e.selectionOpacity),B.css("borderStyle","solid"),B.css("borderColor",e.borderColor1),B.css("borderStyle","dashed"),B.css("borderColor",e.borderColor2),J.css("opacity",e.outerOpacity),J.css("backgroundColor",e.outerColor),X.css("opacity",e.outerOpacity),X.css("backgroundColor",e.outerColor),K.css("opacity",e.outerOpacity),K.css("backgroundColor",e.outerColor),Y.css("opacity",e.outerOpacity),Y.css("backgroundColor",e.outerColor),P=e.aspectRatio&&(N=e.aspectRatio.split(/:/))?N[0]/N[1]:null,e.disable||e.enable===!1?(U.off("mousemove",d),U.off("mousedown",u),B.off("mousemove",d),B.off("mousedown",u),q.off("mousemove",d),q.off("mousedown",u),$(t).off("mousedown",g),J.off("mousedown",g),X.off("mousedown",g),K.off("mousedown",g),Y.off("mousedown",g),$(window).off("resize",b)):(e.enable||e.disable===!1)&&((e.resizable||e.movable)&&(U.on("mousemove",d),U.on("mousedown",u),B.on("mousemove",d),B.on("mousedown",u),q.on("mousemove",d),q.on("mousedown",u)),e.persistent||($(t).on("mousedown",g),J.on("mousedown",g),X.on("mousedown",g),K.on("mousedown",g),Y.on("mousedown",g)),$(window).on("resize",b)),$(e.parent)[0].appendChild(J[0]),$(e.parent)[0].appendChild(X[0]),$(e.parent)[0].appendChild(K[0]),$(e.parent)[0].appendChild(Y[0]),$(e.parent)[0].appendChild(J[0]),$(e.parent)[0].appendChild(U[0]),$(e.parent)[0].appendChild(B[0]),$(e.parent)[0].appendChild(q[0]),e.enable=e.disable=void 0}var w,C,k,M,_,D,T,j,A,E,I,$,L,N,P,S,H,O,W,z,F,R,G,U=$("<div/>"),B=$("<div/>"),q=$("<div/>"),J=$("<div/>"),X=$("<div/>"),K=$("<div/>"),Y=$("<div/>"),Q=0,Z=10,V=[],te=0,ee=1,ne={x1:0,y1:0,x2:0,y2:0,width:0,height:0};U.attr("id","area"),B.attr("id","border1"),q.attr("id","border2"),J.attr("id","outLeft"),X.attr("id","outTop"),K.attr("id","outRight"),Y.attr("id","outBottom"),$.browser.msie&&t.attr("unselectable","on"),U.css("display","none"),U.css("position",j?"fixed":"absolute"),U.css("overflow","hidden"),U.css("zIndex",Q>0?Q:"0"),B.css("display","none"),B.css("position",j?"fixed":"absolute"),B.css("overflow","hidden"),B.css("zIndex",Q>0?Q:"0"),q.css("display","none"),q.css("position",j?"fixed":"absolute"),q.css("overflow","hidden"),q.css("zIndex",Q>0?Q:"0"),J.css("display","none"),J.css("position",j?"fixed":"absolute"),J.css("overflow","hidden"),J.css("zIndex",Q>0?Q:"0"),X.css("display","none"),X.css("position",j?"fixed":"absolute"),X.css("overflow","hidden"),X.css("zIndex",Q>0?Q:"0"),K.css("display","none"),K.css("position",j?"fixed":"absolute"),K.css("overflow","hidden"),K.css("zIndex",Q>0?Q:"0"),Y.css("display","none"),Y.css("position",j?"fixed":"absolute"),Y.css("overflow","hidden"),Y.css("zIndex",Q>0?Q:"0"),U.css("borderStyle","solid");var oe={borderColor1:"#000",borderColor2:"#fff",borderWidth:1,classPrefix:"imgClip",movable:!0,resizable:!0,selectionColor:"#fff",selectionOpacity:.2,outerColor:"#000",outerOpacity:.2,parent:"body",onSelectStart:function(){},onSelectChange:function(){},onSelectEnd:function(){}};e=$.extend(oe,e),x(e)}var $=require("jquery");return{init:function(e,n){n=n||{},n.enable=!0,new t(e,n)}}});