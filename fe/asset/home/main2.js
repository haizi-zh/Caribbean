define(function(require){function e(){var e=$(document).height();r.$wrapBg.css("height",e+"px")}function t(){for(var e=0,t=l.length;t>e;e++)$(l[e]).removeClass("cur")}function n(e){var t=e.target||e.srcElement,n=a.json.queryToJson($(t).attr("node-data"));$.ajax({type:"get",url:s.AJAX.GET_AREA_CITY,data:n,dataType:"json",success:function(e){if(200==e.code){var o={area:n.area,page:e.data.page};$(t).attr("node-data",a.json.jsonToQuery(o));var i=$("ul",r.$cityList)[c];$(i).animate({opacity:0},{duration:500,complete:function(){i.innerHTML=e.data.html,$(i).animate({opacity:1},{duration:500})}})}}}),e.stopPropagation(),e.preventDefault()}function o(){var e=window.location.search.slice(1),o=a.json.queryToJson(e,!0),i=parseInt(o.area,10)-1;t(),1==i?(u.innerHTML="欧洲",p.innerHTML="Europe",r.$cityList.css("left","-830px"),$(l[i]).addClass("cur")):2==i?(u.innerHTML="亚太",p.innerHTML="Asia <br/>Pacific",r.$cityList.css("left","-1660px"),$(l[i]).addClass("cur")):(u.innerHTML="北美",p.innerHTML="North <br/>America",i=0,$(l[i]).addClass("cur")),c=i;for(var s=0,f=d.length;f>s;s++)$(d[s]).on("click",n)}function i(e){var n=e.currentTarget,o=$(n),s=a.json.queryToJson(o.attr("action-data")),l=parseInt(s.index,10);if(l!==c){t(),o.addClass("cur"),0==l?(u.innerHTML="北美",p.innerHTML="North <br/>American"):1==l?(u.innerHTML="欧洲",p.innerHTML="Europe"):2==l&&(u.innerHTML="亚太",p.innerHTML="Asia"),r.$stateList.undelegate("[action-type=change-tab]","click",i);var d,f=parseInt(r.$cityList.css("left"),10);d=l>c?-830*(l-c):830*(c-l),c=l,r.$cityList.animate({left:f+d},{duration:0,complete:function(){r.$stateList.delegate("[action-type=change-tab]","click",i)}})}e.stopPropagation(),e.preventDefault()}var $=require("jquery"),a=require("util"),s=require("./config"),r={};r.$wrapBg=$("#bg_wrap"),r.$stateName=$("#state-name"),r.$cityList=$("#city-list"),r.$stateList=$("#state-tab");var c=0,l=$("a",r.$stateList),d=$("[node-type=page-down]",r.$cityList),u=$("p",r.$stateName)[0],p=$("p",r.$stateName)[1];e(),$(window).on("resize",function(){e()}),o(),r.$stateList.delegate("[action-type=change-tab]","click",i)});