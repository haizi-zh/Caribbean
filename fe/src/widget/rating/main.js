/**
 * rating
 */
define(function(require){
    var $ = require('jquery');
    var util = require('util');

    var defaults = {
        elemId: '',
        score: 0
    };

    var conf = {};
    var view = {};

    var storageRating = 0;
    var flag = false;

    function init (opts) {
        conf = $.extend({}, defaults, opts);
        view.$container = $('#' + conf.elemId);
        view.container = view.$container[0];

        view.ratingDoms = $('li', view.container);
        if (conf.score != 0) {
            $(view.ratingDoms[conf.score - 1]).addClass('hover');
            view.$container.attr('result', conf.score);
            storageRating = conf.score;
        }

        bindEvt();
    }

    function clearRatingDoms() {
        for (var i = view.ratingDoms.length - 1; i >= 0; i--) {
            $(view.ratingDoms[i]).removeClass('hover');
        }
    }

    function bindEvt () {
        view.$container.delegate(
            '[action-type=ratingAction]',
            'mouseover',
            function(e) {
                clearRatingDoms();
                $(this).parent().addClass('hover');
                // e.stopPropagation();
                e.preventDefault();
            }
        );

        view.$container.delegate(
            '[action-type=ratingAction]',
            'mouseout',
            function(e) {
                if(!flag){
                    $(this).parent().removeClass('hover');
                }
                // e.stopPropagation();
                e.preventDefault();
            }
        );

        view.$container.delegate(
            '[action-type=ratingAction]',
            'click',
            function(e) {
                var args = util.json.queryToJson($(this).attr('action-data'));
                flag = true;
                $(this).parent().addClass('hover');
                storageRating = args.rating;
                view.$container.attr('result', parseInt(storageRating, 10)+1);
                // e.stopPropagation();
                e.preventDefault();
            }
        );

        view.$container.on('mouseleave', function(e) {
            if(storageRating){
                for (var i = view.ratingDoms.length - 1; i >= 0; i--) {
                    if(i == storageRating){
                        clearRatingDoms();
                        $(view.ratingDoms[i]).addClass('hover');
                        break;
                    }
                }
            }
            // e.stopPropagation();
            e.preventDefault();
        })
    }

    return {
        init: init,
        getResult: function () {
            return view.$container.attr('result');
        }
    }

});