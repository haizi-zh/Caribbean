$.ready(function(){

    var cityBg = $('#city-bg');
    $.cookie.remove('__curBgImg__');

    var cityList = $('#city-list');
    var cityContainer = cityList[0];
    var dEvt = $.delegatedEvent(cityContainer);
    var timer;

    function resizeBg() {
        var height = $(document).pageSize().page.height;
        cityBg.setStyle('height', height+'px');
    }
    resizeBg();
    window.onresize = function(){
        resizeBg();
    }

    function changeBg(e) {
        timer = setTimeout(function(){
            if (e.data.img) {
                var oldBgName = cityBg.getStyle('background-image');
                oldBgName = oldBgName.substring(oldBgName.lastIndexOf('/') + 1);
                oldBgName = oldBgName.substring(0, oldBgName.lastIndexOf('.'));

                var newBgNameStr = 'url(' + e.data.img + ')';
                var newBgName = newBgNameStr.substring(newBgNameStr.lastIndexOf('/') + 1);
                newBgName = newBgName.substring(0, newBgName.lastIndexOf('.'));
                if (oldBgName != newBgName) {
                    $.ani.tween(cityBg[0], {
                        'duration': 200,
                        'end': function() {
                            cityBg[0].style.backgroundImage = newBgNameStr;
                            // window.__curBgImg__ = newBgNameStr;
                            $.cookie.set('__curBgImg__', newBgNameStr, {
                                encode: false
                            });
                            $.ani.tween(cityBg[0], {
                                'duration': 200,
                                'end': function() {
                                }
                            }).play({
                                opacity: 1
                            });
                        }
                    }).play({
                        opacity: 0.7
                    });
                }
            }
        }, 300);
        $.evt.stopEvent();
    }

    dEvt.add('change-bg', 'mouseover', changeBg);

    dEvt.add('change-bg', 'mouseout', function(e) {
        timer && clearTimeout(timer);
    });
});