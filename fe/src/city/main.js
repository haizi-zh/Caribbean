/**
 * city
 */
define(function (require) {
    var $ = require('jquery');
    var util = require('util');
    var pager = require('widget/pager/main');
    var config = require('city/config');
    var browser = $.browser;

    var brandId = 0;

    var view = {};

    var fixedable = require('widget/fixedable/main');
    //fixedable.addEl("this_top", "side_bar");
    
    view.$shopList = $('#shop_list');

    // 上方分类筛选
    view.$tabNewContainer = $('#tab_container_new');

    // 上方分页容器
    view.$pageContainer = $('#page_container');

    // 全部品牌容器
    view.$toggleList = $('#toggle_list');

    // 品牌商店容器
    view.$wordWrap = $('.word_wrap');

    function getSearch(paramStr) {
        var search = '';
        var match = paramStr.match(/\d+/g);
        if (match) {
            search = match.join(':');
        }
        return search;
    }

    /**
     * 获取上方cate每行的search参数
     */
    function getAllCateSearch() {
        var search = '';
        var cateRows = $('.cate_wrap', view.$tabNewContainer);

        // 每行被选中的cate
        var selectedCates = cateRows.find('.cur');

        for (var i = 0, len = selectedCates.length; i < len; i++) {
            search += getSearch($(selectedCates[i]).attr('action-data')) + '|';
        }

        var sLen = search.length;
        search = search.substring(0, sLen - 1);

        return search;
    }

    /**
     * 渲染品牌商店下方的全部品牌列表
     *
     * @param  {Object} args ajax参数
     */
    function renderBrand(args) {
        $.ajax({
            'type': 'get',
            'url': config.AJAX.GET_BRAND,
            'dataType': 'json',
            'data': args,
            'success': function (data) {
                view.$toggleList.html(data.html);
            }
        });
    }

    /**
     * 渲染shop数据
     *
     * @param  {Object} args ajax参数
     */
    function renderShop(args) {
        $.ajax({
            'type': 'get',
            'url': config.AJAX.GET_SHOP_BY_TAB_NEW,
            'dataType': 'json',
            'data': args,
            'success': function (data) {
                if (data.code == 200) {
                    $('[node-type=show]', view.$pageContainer).html(1);
                    $('[node-type=all]', view.$pageContainer).html(data.page_cnt);
                    view.$shopList.html(data.html);
                    bottomPagerHandle();
                }
            }
        });
    }

    /**
     * 初始化品牌商店
     */
    function initBrand() {
        view.$wordWrap.children().removeClass('cur');

        var $curTarget = $(view.$wordWrap.children()[0]);
        $curTarget.addClass('cur');
        var args = util.json.queryToJson(
            $curTarget.attr('action-data')
        );
        brandId = 0;
        renderBrand(args);
    }

    /**
     * 初始化上方类别筛选条件
     */
    function initCate() {
        var cateRows = $('.cate_wrap', view.$tabNewContainer);
        cateRows.children().removeClass('cur');
        for (var i = 0, len = cateRows.length; i < len; i++) {
            var $child = $(cateRows[i]);
            $($child.children()[0]).addClass('cur');
        }
        brandId = 0;
    }

    /**
     * 上方分类筛选的回调
     */
    view.$tabNewContainer.delegate(
        '[action-type=change_tab_new]',
        'click',
        function(e) {
            var curTarget = e.currentTarget;
            var $curTarget = $(curTarget);

            var args = util.json.queryToJson(
                $curTarget.attr('action-data')
            );

            $curTarget
                .parent()
                .find('.cur')
                .removeClass('cur')
                .end()
                .end()
                .addClass('cur');

            var search = getAllCateSearch();
            args.search = search;

            pager.setParams({
                search: search,
                brand_id: brandId
            });

            initBrand();

            renderShop(args);

            e.stopPropagation();
            e.preventDefault();
        }
    );

    /**
     * 分页设置参数
     */
    pager.setParams({
        search: getAllCateSearch(),
        brand_id: brandId
    });

    /**
     * 初始化分页
     */
    pager.initialize(
        'page_container',
        'shop_list',
        config.AJAX.GET_SHOP_BY_TAB_NEW,
        bottomPagerHandle
    );

    /**
     * 下方分页的回调
     */
    function bottomPagerHandle() {
        $('#page_container_adapter').delegate(
            '[action-type=changePageAdapter]',
            'click',
            function(e){
                var curTarget = e.currentTarget;
                var $curTarget = $(curTarget);
                if ($curTarget.attr('node-type') === 'next') {
                    $('[action-type=changePage][node-type="next"]').click();
                }
                else {
                    $('[action-type=changePage][node-type="prev"]').click();
                }
            }
        );
    }

    bottomPagerHandle();

    /**
     * 点击左侧品牌商店的回调
     */
    view.$wordWrap.delegate(
        '[action-type=choose_key]',
        'click',
        function (e) {
            var curTarget = e.currentTarget;
            var $curTarget = $(curTarget);

            var args = util.json.queryToJson(
                $curTarget.attr('action-data')
            );

            // view.$wordWrap.trigger('testEvt', 'asdsad');

            $curTarget
                .parent()
                .find('.cur')
                .removeClass('cur')
                .end()
                .end()
                .addClass('cur');

            renderBrand(args);

            e.stopPropagation();
            e.preventDefault();
        }
    );

    /**
     * 点击品牌的回调
     */
    view.$toggleList.delegate(
        '[action-type=all_brand]',
        'click',
        function (e) {
            var curTarget = e.currentTarget;
            var $curTarget = $(curTarget);

            var args = util.json.queryToJson(
                $curTarget.attr('action-data')
            );
            $("[action-type='brand']").removeClass('cur');
            $curTarget.children().addClass('cur');

            brandId = 0;

            pager.setParams({
                brand_id: 0
            });

            initCate();

            renderShop(args);

            e.stopPropagation();
            e.preventDefault();
        }
    );

    /**
     * 点击全部品牌的回调
     */
    view.$toggleList.delegate(
        '[action-type=brand]',
        'click',
        function (e) {
            var curTarget = e.currentTarget;
            var $curTarget = $(curTarget);

            var args = util.json.queryToJson(
                $curTarget.attr('action-data')
            );
            $("[action-type='all_brand_cur']").html("全部品牌").removeClass('cur');
            $curTarget
                .parent()
                .find('.cur')
                .removeClass('cur')
                .end()
                .end()
                .addClass('cur');

            brandId = args.brand_id;

            pager.setParams({
                brand_id: brandId
            });

            initCate();

            renderShop(args);

            e.stopPropagation();
            e.preventDefault();
        }
    );

    
});