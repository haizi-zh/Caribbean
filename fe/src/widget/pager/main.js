/**
 * pager
 * 翻页模块
 */
define(function(require){
    var $ = require('jquery');
    var util = require('util');
    var browser = $.browser;

    var view = {};

    var params = {
        page: 0,
        allPages: 0
    };

    /**
     * 设置翻页的参数
     * 比如切换选项卡后再翻页的时候需要传入选项卡的参数
     */
    function setParams(opts) {
        params = $.extend({}, params, opts);
    }

    /**
     * 初始化翻页组件
     * @param  {String} elemId 翻页组件的容器id
     * @param  {String} contentId 翻页后内容区的id
     * @param  {String} ajaxUrl 获取数据的ajax地址
     */
    function initialize(elemId, contentId, ajaxUrl, callback) {
        view.$pageContainer = $('#' + elemId);
        view.$contentContainer = $('#' + contentId);
        view.$showDom = $('[node-type=show]', view.$pageContainer);
        view.$pageContainer.delegate(
            '[action-type=changePage]',
            'click',
            function(e) {
                var curTarget = e.currentTarget;
                var $curTarget = $(curTarget);
                params.allPages = parseInt(
                    $('[node-type=all]', view.$pageContainer).html(),
                    10
                );
                params.page = parseInt(view.$showDom.html(), 10);
                var curTargetParams = util.json.queryToJson(
                    $curTarget.attr('action-data')
                );
                var pageParams = $.extend({}, params, curTargetParams);
                if (pageParams.action === 'next') {
                    if (pageParams.page < pageParams.allPages) {
                        ++pageParams.page;
                        $.ajax({
                            'type': 'get',
                            'url': ajaxUrl,
                            'dataType': 'json',
                            'data': pageParams,
                            'success': function (data) {
                                view.$showDom.html(pageParams.page);
                                view.$contentContainer.html(data.html);
                                callback && callback();
                            }
                        });
                    }
                }
                else if (pageParams.action == 'prev') {
                    if(pageParams.page > 1){
                        --pageParams.page;
                        $.ajax({
                            'type': 'get',
                            'url': ajaxUrl,
                            'dataType': 'json',
                            'data': pageParams,
                            'success': function(data){
                                view.$showDom.html(pageParams.page);
                                view.$contentContainer.html(data.html);
                                callback && callback();
                            }
                        });
                    }
                }
                else if (pageParams.action == 'page') {
                    pageParams.page = 1;
                    $.ajax({
                        'type': 'get',
                        'url': ajaxUrl,
                        'dataType': 'json',
                        'data': pageParams,
                        'success': function(data){
                            view.$showDom.html(pageParams.page);
                            view.$contentContainer.html(data.html);
                            callback && callback();
                        }
                    });
                }
                e.stopPropagation();
                e.preventDefault();
            }
        );
    }

    function initialize_new(elemId, contentId, postId, ajaxUrl) {
        view.$pageContainer = $('#' + elemId);
        view.$contentContainer = $('#' + contentId);
        view.$postContainer = $('#'+postId);
        view.$pageContainer.delegate(
            '[action-type=changePage]',
            'click',
            function(e) {
                var curTarget = e.currentTarget;
                var $curTarget = $(curTarget);
                var curTargetParams = util.json.queryToJson(
                    $curTarget.attr('action-data')
                );

                var pageParams = $.extend({}, curTargetParams);
                if (pageParams.action == 'page') {
                    $.ajax({
                        'type': 'get',
                        'url': ajaxUrl,
                        'dataType': 'json',
                        'data': pageParams,
                        'success': function(data){
                            console.log(data.html);
                            view.$contentContainer.html(data.html);
                            $("body").animate({scrollTop: view.$postContainer.offset().top}, 100);
                            initialize_new(elemId, contentId, postId, ajaxUrl);
                        }
                    });
                }
                e.stopPropagation();
                e.preventDefault();
            }
        );
    }

    return {
        initialize: initialize,
        initialize_new: initialize_new,
        setParams: setParams
    }

});

