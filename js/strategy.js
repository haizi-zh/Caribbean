$.ready(function () {

    /*var pageContainer = $('#page_container')[0];
    var pageDevt = $.delegatedEvent(document.body);
    pageDevt.add('changePage', 'click', function(e){
        var showDom = $.sizzle('[node-type=show]', pageContainer)[0];
        var allPages = parseInt($.sizzle('[node-type=all]', pageContainer)[0].innerHTML, 10);
        var curPage = parseInt(showDom.innerHTML, 10);

        if(e.data.action == 'next'){
            if(curPage < allPages){
                $.io.ajax({
                    'method': 'get',
                    'url': '/aj/discount/getPingHtml_shoptips',
                    'args': {
                        'shop_id': e.data.shop_id,
                        'city': e.data.city,
                        'page': ++curPage
                    },
                    'onComplete': function(data){
                        if(data.code == '200'){
                            $('#comment_list')[0].innerHTML = data.html;
                            showDom.innerHTML = curPage;
                        }
                    }
                });
            }
        }else if(e.data.action =='prev'){
            if(curPage > 1){
                $.io.ajax({
                    'method': 'get',
                    'url': '/aj/discount/getPingHtml_shoptips',
                    'args': {
                        'shop_id': e.data.shop_id,
                        'city': e.data.city,
                        'page': --curPage
                    },
                    'onComplete': function(data){
                        if(data.code == '200'){
                            $('#comment_list')[0].innerHTML = data.html;
                            showDom.innerHTML = curPage;
                        }
                    }
                });
            }
        }
        $.evt.stopEvent();
    });



    // console.log($(document).pageSize());
    // console.log($.scrollPos());

    var footerTop = $(footerElem).getPos().t;
    var footerHeight = $(footerElem).getSize().height;*/


    // var scrolldelay;
    // function pageScroll() {
    //     window.scrollBy(0, -$.scrollPos().top);
    //     if ($.scrollPos().top != 0) {
    //         scrolldelay = setTimeout(pageScroll, 0);
    //     }
    //     else {
    //         scrolldelay && clearTimeout(scrolldelay);
    //         scrolldelay = null;
    //     }
    // }
    // setTimeout(function () {
    //     pageScroll();
    // }, 2000)

    var $commentList = $('#comment_list');
    var curPage = 1;
    var marginBottom = 300; //表示滚动条离底部的距离，0表示滚动到最底部才加载，可以根据需要修改


    var LOADING = ''
        + '<div id="loading" class="clearfix" style="border:1px solid #ccc;margin-right:17px;padding:5px;text-align:center;">'
        +   '加载中'
        + '</div>';

    //$commentList.insertHTML(LOADING, 'beforeend');

    $(window).addEvent('scroll', getData);

    function getData(e) {
        if (
            $(document).pageSize().win.height + $.scrollPos().top
            >=
            $(document).pageSize().page.height - marginBottom
        ) {
            $(window).removeEvent('scroll', getData);
            $.io.ajax({
                'method': 'get',
                'url': '/aj/discount/getPingHtml_shoptips',
                'args': {
                    'shop_id': $CONFIG.shop_id,
                    'city': $CONFIG.city,
                    'page': ++curPage
                },
                'onComplete': function(data){
                    if(data.code == '200' && data.html){
                        setTimeout(function () {
                            $('#comment_list').insertHTML(data.html, 'beforeend');
                            $(window).addEvent('scroll', getData);
                        }, 500);
                    }
                    else {
                        // $('#loading').setStyle('display', 'none');
                        $('#loading').removeNode();
                    }
                }
            });
        }
    }

});
