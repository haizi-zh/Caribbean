/**
 * home
 */
define(function(require){
    var $ = require('jquery');
    // var cookie = require('widget/cookie/main');
    var util = require('util');
    var config = require('home/config');
    var cookie = require('widget/cookie/main');
    var view = {};
    view.$wrapBg = $('#bg_wrap');
    // view.$wrapBg.css('background-image', cookie.get('__curBgImg__'));
    view.$stateName = $('#state-name');
    view.$cityList = $('#city-list');
    view.$stateList = $('#state-tab');

    var curSelectedState = 0; // 当前选中的州
    var aList = $('a', view.$stateList);
    var pageControlList = $('[node-type=page-down]', view.$cityList);
    var p1 = $('p', view.$stateName)[0];
    var p2 = $('p', view.$stateName)[1];

    function resizeBg() {
        var height = $(document).height();
        view.$wrapBg.css('height', height+'px');
    }

    if(cookie.get('__curBgImg__')){
        view.$wrapBg.css("background", cookie.get('__curBgImg__') + ' no-repeat');
        view.$wrapBg.css("background-size", 'cover');
    }

    resizeBg();

    $(window).on('resize', function () {
        resizeBg();
    });

    function resetSelected() {
        for (var i = 0, len = aList.length; i < len; i++) {
            $(aList[i]).removeClass('cur');
        }
    }

    function changePage(e) {
        var el = e.target || e.srcElement;
        var params = util.json.queryToJson($(el).attr('node-data'));
        $.ajax({
            'type': 'get',
            'url': config.AJAX.GET_AREA_CITY,
            'data': params,
            'dataType': 'json',
            'success': function(data){
                if (data.code == 200) {
                    var tmp = {
                        area: params.area,
                        page: data.data.page
                    }
                    $(el).attr('node-data', util.json.jsonToQuery(tmp));
                    var targetState = $('ul', view.$cityList)[curSelectedState];
                    $(targetState).animate({
                        opacity: 0
                    }, {
                        duration: 500,
                        complete: function () {
                            targetState.innerHTML = data.data.html;
                            $(targetState).animate({
                                opacity: 1
                            }, {
                                duration: 500
                            });
                        }
                    });
                }
            }
        });
        e.stopPropagation();
        e.preventDefault();
    }

    function init() {
        var query = window.location.search.slice(1);
        var res = util.json.queryToJson(query, true);
        var index = parseInt(res.area, 10) - 1;
        resetSelected();
        if (index == 1) {
            p1.innerHTML = '欧洲';
            p2.innerHTML = 'Europe';
            view.$cityList.css('left', '-830px');
            $(aList[index]).addClass('cur');
        }
        else if (index == 2) {
            p1.innerHTML = '亚太';
            p2.innerHTML = 'Asia <br/>Pacific';
            view.$cityList.css('left', '-1660px');
            $(aList[index]).addClass('cur');
        }
        else { // 默认是北美
            p1.innerHTML = '北美';
            p2.innerHTML = 'North <br/>America';
            index = 0;
            $(aList[index]).addClass('cur');
        }
        curSelectedState = index;

        for (var i = 0, len = pageControlList.length; i < len; i++) {
            $(pageControlList[i]).on('click', changePage);
        }
    }

    init();

    function changeState(e) {
        var curTarget = e.currentTarget;
        var $curTarget = $(curTarget);
        var args = util.json.queryToJson($curTarget.attr('action-data'));
        var index = parseInt(args.index, 10);
        if (index !== curSelectedState) {
            resetSelected();
            $curTarget.addClass('cur');
            if (index == 0) {
                p1.innerHTML = '北美';
                p2.innerHTML = 'North <br/>American';
            }
            else if (index == 1) {
                p1.innerHTML = '欧洲';
                p2.innerHTML = 'Europe';
            }
            else if (index == 2) {
                p1.innerHTML = '亚太';
                p2.innerHTML = 'Asia';
            }
            view.$stateList.undelegate(
                '[action-type=change-tab]',
                'click',
                changeState
            );
            var left = parseInt(view.$cityList.css('left'), 10);
            var sub;
            if (index > curSelectedState) {
                sub = -830 * (index - curSelectedState);
            }
            else {
                sub = 830 * (curSelectedState - index)
            }
            curSelectedState = index;

            view.$cityList.animate({
                left: left + sub
            }, {
                duration: 0,
                complete: function () {
                    view.$stateList.delegate(
                        '[action-type=change-tab]',
                        'click',
                        changeState
                    );
                }
            });
        }
        e.stopPropagation();
        e.preventDefault();
    }

    view.$stateList.delegate(
        '[action-type=change-tab]',
        'click',
        changeState
    );

});