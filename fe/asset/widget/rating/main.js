define(function(require){function t(t){i=$.extend({},o,t),r.$container=$("#"+i.elemId),r.container=r.$container[0],r.ratingDoms=$("li",r.container),0!=i.score&&($(r.ratingDoms[i.score-1]).addClass("hover"),r.$container.attr("result",i.score),c=i.score),n()}function e(){for(var t=r.ratingDoms.length-1;t>=0;t--)$(r.ratingDoms[t]).removeClass("hover")}function n(){r.$container.delegate("[action-type=ratingAction]","mouseover",function(t){e(),$(this).parent().addClass("hover"),t.preventDefault()}),r.$container.delegate("[action-type=ratingAction]","mouseout",function(t){s||$(this).parent().removeClass("hover"),t.preventDefault()}),r.$container.delegate("[action-type=ratingAction]","click",function(t){var e=a.json.queryToJson($(this).attr("action-data"));s=!0,$(this).parent().addClass("hover"),c=e.rating,r.$container.attr("result",parseInt(c,10)+1),t.preventDefault()}),r.$container.on("mouseleave",function(t){if(c)for(var n=r.ratingDoms.length-1;n>=0;n--)if(n==c){e(),$(r.ratingDoms[n]).addClass("hover");break}t.preventDefault()})}var $=require("jquery"),a=require("util"),o={elemId:"",score:0},i={},r={},c=0,s=!1;return{init:t,getResult:function(){return r.$container.attr("result")}}});