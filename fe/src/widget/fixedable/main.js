/**
 * fixedable
 * 吸顶
 */
define(function(require){
    var $ = require('jquery');
    var browser = $.browser;

    var fixedableMap = {};

    /**
     * 添加要吸顶的元素
     * @param {String} elemId    元素的id
     * @param {String} customCls 吸顶的时候需要添加的自定义的css类
     */
    function addEl(elemId, barId, customCls) {
        var $el = $('#' + elemId);
        var $bar = $('#' + barId);
        var $footer = $(".footer");
        //console.log($bar.height());
        fixedableMap[elemId] = {
            $el: $el,
            $bar:$bar,
            $footer:$footer,
            barHeight:$bar.height(),
            pos: $el.position(),
            customCls: customCls,
            width:$el.width()
        }
    }

    function execute() {
        var sTop = $(document).scrollTop();
        
        for (var key in fixedableMap) {
            var item = fixedableMap[key];
            if (item && item.pos) {
                if( sTop + item.$el.height() + item.$footer.height() > $(document).height()){
                    item.$el.removeClass('fixedable');
                    item.$el.css({
                        'position': 'static'
                    });
                    item.customCls && item.$el.removeClass(item.customCls);
                } else if (sTop >= item.barHeight) {
                    if (browser.msie && parseInt(browser.version, 10) <= 6) {
                        item.$el.addClass('fixedable');
                        item.$el.css({
                            'position': 'absolute'
                        });
                    }
                    else {
                        item.$el.css({
                            'position': 'fixed',
                            'top': 0
                        });
                    }
                    item.customCls && item.$el.addClass(item.customCls);
                }
                else {
                    item.$el.removeClass('fixedable');
                    item.$el.css({
                        'position': 'static'
                    });
                    item.customCls && item.$el.removeClass(item.customCls);
                }
                item.$el.css({'width':item.width});
            }
        }
    }

    $(window).scroll(execute);

    return {
        addEl: addEl
    }

});