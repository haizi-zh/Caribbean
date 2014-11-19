(function($) {
    $.lo.rating = function(opts) {
        var defaults = {
            score: 0
        };

        var conf = $.extend(defaults, opts);

        var $container = this;
        var container = $container[0];

        var storageRating, ratingDoms = $.sizzle('li', container);

        if (conf.score != 0) {
            $(ratingDoms[conf.score - 1]).addClassName('hover');
            container.setAttribute('result', conf.score);
        }

        var clearRatingDoms = function(){
            for (var i = ratingDoms.length - 1; i >= 0; i--) {
                $(ratingDoms[i]).removeClassName('hover');
            };
        };

        var flag = false;

        var dEvt = $.delegatedEvent(container);
        dEvt.add('ratingAction', 'mouseover', function(e){
            clearRatingDoms();
            $(e.el.parentNode).addClassName('hover');
            $.evt.stopEvent();
        });

        dEvt.add('ratingAction', 'mouseout', function(e){
            if(!flag){
                $(e.el.parentNode).removeClassName('hover');
            }
            $.evt.stopEvent();
        });

        dEvt.add('ratingAction', 'click', function(e){
            flag = true;
            $(e.el.parentNode).addClassName('hover');
            storageRating = e.data.rating;
            container.setAttribute('result', parseInt(storageRating, 10)+1);
            $.evt.stopEvent();
        });

        $('#rating').addEvent('mouseout', function(){
            var ev = $.evt.getEvent();
            var hit1 = $.evt.hitTest(container, ev); // 光标在 container上时为true，否则false
            if(storageRating && !hit1){ // 光标已经离开rating的div 这时应该记录之前的rating
                for (var i = ratingDoms.length - 1; i >= 0; i--) {
                    if(i == storageRating){
                        $(ratingDoms[i]).addClassName('hover');
                    }
                }
            }
            $.evt.stopEvent();
        })

    }
})(Lilac);
