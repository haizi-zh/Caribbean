/**
 * brand
 */
define(function(require){

    var $ = require('jquery');
    var util = require('util');

    var config = require('brand/config');

    var fixedable = require('widget/fixedable/main');
    //fixedable.addEl('brand_list', 'brand-list-fixed');

    var popup = require('widget/popup/main');

    var view = {};
    view.$brandList = $('#brand_list');
    view.$allHerfList = $('[action-type="change_brand"]', view.$brandList);

    view.$anchorStoreList = $('#anchor_store_list');
    view.$showAnchor = $('#show_anchor');

    var brandContainerPos = view.$brandList.position();
    var brandContainerTop = brandContainerPos.top;
    var tmp = 0;
    var distance = 0;

    function removeCurClass() {
        for (var i = 0, len = view.$allHerfList.length; i < len; i++) {
            $(view.$allHerfList[i]).removeClass('cur');
        }
    }

    view.$brandList.delegate(
        '[action-type=change_brand]',
        'click',
        function(e) {
            var curTarget = e.currentTarget;
            var $curTarget = $(curTarget);
            var data = util.json.queryToJson(
                $curTarget.attr('action-data')
            );
            if($(window).scrollTop() < brandContainerTop){
                tmp = Math.abs(brandContainerTop - $(window).scrollTop());
                distance = 140;
            }else{
                tmp = 0;
                distance = 80;
            }
            var targetEl = $('[name=' + data.letter + ']');
            if (targetEl.length) {
                removeCurClass();
                $curTarget.addClass('cur');
                $('html,body').animate({
                    scrollTop: targetEl.position().top
                                    + view.$brandList.height() - distance
                }, 1000);
            }
            e.stopPropagation();
            e.preventDefault();
        }
    );

    view.$anchorStoreList.delegate(
        '[action-type=show_anchor_store]',
        'click',
        function (e) {
            var curTarget = e.currentTarget;
            var $curTarget = $(curTarget);
            var args = util.json.queryToJson(
                $curTarget.attr('action-data')
            );
            $.ajax({
                'type': 'get',
                'url': config.AJAX.GET_ANCHOR,
                'dataType': 'json',
                'data': {
                    'brand_id': args.brand_id
                },
                'success': function (data) {
                    if(data.code == '200'){
                        view.$showAnchor.html(data.data.html);
                        view.$showAnchor.css('display', '');

                        $('[node-type=cancelBtn]', view.$showAnchor).click(
                            function (e) {
                                view.$showAnchor.css('display', 'none');
                                popup.createModuleMask.hide();
                            }
                        );

                        popup.createModuleMask.showUnderNode(view.$showAnchor[0]);
                    }
                }
            });

        }
    );
});