/**
 * strategy
 */
define(function(require){
    var scrollPager = require('widget/pager/scroll-pager');
    var config = require('strategy/config');

    var view = {};
    view.$commentList = $('#comment_list');

    /**
     * ***********************************************
     * 滚动翻页
     * ***********************************************
     */
    /*
    scrollPager.initialize({
        container: view.$commentList,
        ajaxUrl: config.AJAX.GET_SHOP_TIPS,
        ajaxParams: {
            'shop_id': $CONFIG.shop_id,
            'city': $CONFIG.city
        },
        callback: function (data) {
            view.$commentList.append(data.html);
        }
    });
    */

});