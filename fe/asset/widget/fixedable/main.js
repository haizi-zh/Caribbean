define(function(require){function t(t,e){var n=$("#"+t);o[t]={$el:n,pos:n.position(),customCls:e}}function e(){var t=$(document).scrollTop();for(var e in o){var i=o[e];i&&i.pos&&(t>=i.pos.top?(n.msie&&parseInt(n.version,10)<=6?(i.$el.addClass("fixedable"),i.$el.css({position:"absolute"})):i.$el.css({position:"fixed",top:0}),i.customCls&&i.$el.addClass(i.customCls)):(i.$el.removeClass("fixedable"),i.$el.css({position:"static"}),i.customCls&&i.$el.removeClass(i.customCls)))}}var $=require("jquery"),n=$.browser,o={};return $(window).scroll(e),{addEl:t}});