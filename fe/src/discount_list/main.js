/**
 * discount_list 折扣信息
 */
define(function(require){
    var pager = require('widget/pager/main');
    var config = require('discount_list/config');
    pager.initialize(
        'page_container',
        'comment_list',
        config.AJAX.GET_PING_HTML
    );

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