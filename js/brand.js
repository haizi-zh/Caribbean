$.ready(function(){
    var brandList = $('#brand_list');
    var brandContainer = brandList[0];

    var dEvt = $.delegatedEvent(brandContainer);

    var brandContainerPos = brandList.getPos(),
        brandContainerTop = brandContainerPos.t,
        tmp = 0,
        allHrefList = $.sizzle('[action-type="change_brand"]');

    function removeCurClass() {
        for (var i = 0, len = allHrefList.length; i < len; i++) {
            $(allHrefList[i]).removeClassName('cur');
        }
    }

    dEvt.add('change_brand', 'click', function(e){
        if($.scrollPos().top < brandContainerTop){
            tmp = Math.abs(brandContainerTop - $.scrollPos().top);
        }else{
            tmp = 0;
        }
        var targetEl = $.sizzle('[name='+e.data.letter+']')[0];
        if (targetEl) {
            removeCurClass();
            $(e.el).addClassName('cur');
            $.scrollTo(targetEl,{
                top: 60 + tmp
            });

        }
        $.evt.stopEvent();
    });

    setInterval(function(){
        var sTop = $.scrollPos().top;
        if(sTop >= brandContainerTop){
            if($.browser.IE){
                brandList.setStyle('position', 'absolute');
                brandList.setStyle('top', sTop);
                brandList.addClassName('brand-list-fixed');
            }else{
                brandList.setStyle('position', 'fixed');
                brandList.setStyle('top', '0');
                brandList.addClassName('brand-list-fixed');
            }
        }else{
            brandList.removeClassName('brand-list-fixed');
            brandList.setStyle('position', 'static');
        }
    },100);

    var anchorList = $('#anchor_store_list');
    var anchorContainer = anchorList[0];
    var dAnchorEvt = $.delegatedEvent(anchorContainer);

    dAnchorEvt.add('show_anchor_store', 'click', function(e){
        var brandLayer = $('#show_anchor');
        $.io.ajax({
            'method': 'get',
            'url': '/aj/brand/get_anchor_layer/',
            'args': {
                'brand_id': e.data.brand_id
            },
            'onComplete': function(data){
                if(data.code == '200'){
                    var TEMP = data.data.html;
                    brandLayer.setStyle('display', '');
                    brandLayer[0].innerHTML = TEMP;
                    var nodes = $.parseDOM($.builder(brandLayer[0]).list);
                    $(nodes.cancelBtn).addEvent('click', function () {
                       brandLayer.setStyle('display', 'none');
                       $.createModuleMask.hide();
                    });
                    $.createModuleMask.showUnderNode(brandLayer[0]);
                }
            }
        });
    });



});


