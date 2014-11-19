$.ready(function(){

    var wrapBg = $('#bg_wrap');
    wrapBg[0].style.backgroundImage = $.cookie.get('__curBgImg__');

    var curSelectedState = 0; // 当前选中的州
    var stateName = $('#state-name');
    var cityList = $('#city-list');
    var stateList = $('#state-tab');
    var stateContainer = stateList[0];
    var dEvt = $.delegatedEvent(stateContainer);
    var aList = $.sizzle('a', stateList[0]);
    var p1 = $.sizzle('p', stateName[0])[0];
    var p2 = $.sizzle('p', stateName[0])[1];
    var pageControlList = $.sizzle('[node-type=page-down]', cityList[0]);

    function resizeBg() {
        var cityBg = $('#bg_wrap');
        var height = $(document).pageSize().page.height
        cityBg.setStyle('height', height+'px');
    }

    resizeBg();
    window.onresize = function(){
        resizeBg();
    }

    function init() {
        var query = window.location.search.slice(1);
        var res = $.queryToJson(query, true);
        var index = parseInt(res.area, 10) - 1;
        resetSelected();
        if (index == 1) {
            p1.innerHTML = '欧洲';
            p2.innerHTML = 'Europe';
            $(cityList[0]).setStyle('left', '-830px');
            $(aList[index]).addClassName('cur');
        }
        else if (index == 2) {
            p1.innerHTML = '亚太';
            p2.innerHTML = 'Asia <br/>Pacific';
            $(cityList[0]).setStyle('left', '-1660px');
            $(aList[index]).addClassName('cur');
        }
        else { // 默认是北美
            p1.innerHTML = '北美';
            p2.innerHTML = 'North <br/>America';
            index = 0;
            $(aList[index]).addClassName('cur');
        }
        curSelectedState = index;

        for (var i = 0, len = pageControlList.length; i < len; i++) {
            $(pageControlList[i]).addEvent('click', changePage);
        }
    }

    init();

    function resetSelected() {
        for (var i = 0, len = aList.length; i < len; i++) {
            $(aList[i]).removeClassName('cur');
        }
    }

    function changeState(e) {
        var index = parseInt(e.data.index, 10);
        if (index !== curSelectedState) {
            resetSelected();
            $(e.el).addClassName('cur');
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
            dEvt.remove('change-tab', 'click');
            var left = parseInt($(cityList[0]).getStyle('left'), 10);
            var sub;
            if (index > curSelectedState) {
                sub = -830 * (index - curSelectedState);
            }
            else {
                sub = 830 * (curSelectedState - index)
            }
            curSelectedState = index;
            $.ani.tween(cityList[0], {
                'duration': 0,
                'end': function() {
                    dEvt.add('change-tab', 'click', changeState);
                }
            }).play({
                left: left + sub
            });
        }
        $.evt.stopEvent();
    }

    dEvt.add('change-tab', 'click', changeState);

    function changePage(e) {
        var el = e.target || e.srcElement;
        var params = $.queryToJson(el.getAttribute('node-data'));
        $.io.ajax({
            'method': 'get',
            'url': '/aj/city/get_area_city',
            'args': params,
            'onComplete': function(data){
                if (data.code == 200) {
                    var tmp = {
                        area: params.area,
                        page: data.data.page
                    }
                    el.setAttribute('node-data', $.jsonToQuery(tmp));
                    var targetState = $.sizzle('ul', cityList[0])[curSelectedState];
                    $.ani.tween(targetState, {
                        'duration': 500,
                        'end': function() {
                            targetState.innerHTML = data.data.html;
                            $.ani.tween(targetState, {
                                'duration': 500,
                                'end': function() {
                                }
                            }).play({
                                opacity: 1
                            });
                        }
                    }).play({
                        opacity: 0
                    });
                }
            }
        });
        $.evt.stopEvent();
    }

});