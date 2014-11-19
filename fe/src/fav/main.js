/**
 * fav
 */
define(function(require){
    var $ = require('jquery');
    var util = require('util');
    var config = require('fav/config');

    var view = {};
    view.$tabShopContainer = $('#shop_city_list');
    view.$tabCouponContainer = $('#coupon_city_list');

    view.$shopMore = $('#shop_more');
    view.$couponMore = $('#coupon_more');

    view.$shopAll = $('#shop_all');
    view.$couponAll = $('#coupon_all');

    view.$shopList = $('#shop_list');
    view.$couponList = $('#coupon_list');

    var shop_params = {
        type:0,
        city:0,
        page:2,
    };

    var coupon_params = {
        type:1,
        city:0,
        page:2,
    };

    view.$tabShopContainer.delegate(
        '[action-type=choose_shop_city]',
        'click',
        function (e) {
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

            renderShopAll(args);

            e.stopPropagation();
            e.preventDefault();
        }
    );

    function renderShopAll(args) {
        $.ajax({
            'type': 'get',
            'url': config.AJAX.GET_FAV_HTML,
            'dataType': 'json',
            'data': args,
            'success': function (data) {
                view.$shopAll.html(data.data.html);
                city = args.city;
                shop_params.city = city;
                shop_params.page = 2;
            }
        });
    }

    view.$shopAll.delegate(
        '[action-type=shop_more]',
        'click',
        function (e) {
            renderShopMore(shop_params);
            e.stopPropagation();
            e.preventDefault();
        }
    );

    function renderShopMore(args) {
        $.ajax({
            'type': 'get',
            'url': config.AJAX.GET_FAV_HTML,
            'dataType': 'json',
            'data': args,
            'success': function (data) {
                console.log(data.data.html);
                $("#shop_list").append(data.data.html);
                city = args.city;
                shop_params.city = city;
                shop_params.page = data.data.page;
                if(!data.data.page){
                    $("#shop_more").hide();
                }
            }
        });
    }

    // params.ajaxParams.page = ++params.curPage;

    view.$tabCouponContainer.delegate(
        '[action-type=choose_coupon_city]',
        'click',
        function (e) {
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

            renderCouponAll(args);

            e.stopPropagation();
            e.preventDefault();
        }
    );

    function renderCouponAll(args) {
        $.ajax({
            'type': 'get',
            'url': config.AJAX.GET_FAV_HTML,
            'dataType': 'json',
            'data': args,
            'success': function (data) {
                view.$couponAll.html(data.data.html);
                city = args.city;
                coupon_params.city = city;
                coupon_params.page = 2;
            }
        });
    }

    view.$couponAll.delegate(
        '[action-type=coupon_more]',
        'click',
        function (e) {
            renderCouponMore(coupon_params);
            e.stopPropagation();
            e.preventDefault();
        }
    );

    function renderCouponMore(args) {
        $.ajax({
            'type': 'get',
            'url': config.AJAX.GET_FAV_HTML,
            'dataType': 'json',
            'data': args,
            'success': function (data) {
                console.log(data.data.html);
                $("#coupon_list").append(data.data.html);
                city = args.city;
                coupon_params.city = city;
                coupon_params.page = data.data.page;
                
                if(!data.data.page){
                    $("#coupon_more").hide();
                }
            }
        });
    }



});