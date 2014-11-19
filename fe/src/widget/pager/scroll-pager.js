/**
 * scroll-pager
 * 滚动翻页模块
 */
define(function(require){
    var $ = require('jquery');
    var util = require('util');

    var LOADING = ''
        + '<div id="loading" class="clearfix" style="border:1px solid #ccc;margin-right:17px;padding:5px;text-align:center;">'
        +   '加载中'
        + '</div>';

    var params = {
        container: null,
        curPage: 1,
        loadingHtml: LOADING,
        marginBottom: 30, //表示滚动条离底部的距离，0表示滚动到最底部才加载，可以根据需要修改
        ajaxUrl: '',
        ajaxParams: {},
        callback: function () {}
    };

    /**
     * 设置翻页的参数
     * 比如切换选项卡后再翻页的时候需要传入选项卡的参数
     */
    function setParams(opts) {
        params = $.extend({}, params, opts);
    }

    function initialize(opts) {
        setParams(opts);
        $(window).on('scroll', getData);
    }

    function getData(e) {
        if (
            $(window).height() + $(window).scrollTop()
            >=
            $(document).height() - params.marginBottom
        ) {
            $(window).off('scroll', getData);
            if (params.container) {
                if ($('#loading').length) {
                    $('#loading').remove();
                }
                params.container.append(params.loadingHtml);
            }
            params.ajaxParams.page = ++params.curPage;
            $.ajax({
                'type': 'get',
                'url': params.ajaxUrl,
                'dataType': 'json',
                'data': params.ajaxParams,
                'success': function(data){
                    if (data.code == '200' && data.html) {
                        setTimeout(function() {
                            $('#loading').remove();
                            $(window).on('scroll', getData);
                            params.callback && params.callback(data);
                        }, 500);
                    } else {
                        $('#loading').remove();
                    }
                },
                'error': function (data) {
                    $('#loading').remove();
                }
            });
        }
    }

    return {
        initialize: initialize
    }

});

