$.ready(function(){

    var anchorList = $('#anchor_store_list');
    var anchorContainer = anchorList[0];
    var dAnchorEvt = $.delegatedEvent(anchorContainer);

    dAnchorEvt.add('show_anchor_store', 'click', function(e){
        var brandLayer = $('#show_anchor');
        $.io.ajax({
            'method': 'get',
            'url': '/aj/ebusiness/get_anchor_layer/',
            'args': {
                'id': e.data.id
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


