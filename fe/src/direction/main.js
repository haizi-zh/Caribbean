define(function(require){
	var $ = require('jquery');

    $("[action-type=show_more]").click(function (e){
        var shop_items = $(this).parent().parent().find(".discont_list").children();
        var len = shop_items.length;
        var show=0;
        for(var i=0; i<len; i++){
            if($(shop_items[i]).css("display") == 'none'){
                show = 1;
                $(shop_items[i]).css("display", "block");
            }else if($(shop_items[i]).css("display") == 'block'){
                $(shop_items[i]).css("display", "none");
            }
        }
        if(show){
            $(this).html('收起<span class="moreup"></span>') ;
        }else{
            $(this).html('更多<span class="moredown"></span>') ;
        }
    });

});