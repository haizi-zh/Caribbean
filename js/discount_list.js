$.ready(function () {
    var pageContainer = $('#page_container')[0];
    var pageDevt = $.delegatedEvent(document.body);
    pageDevt.add('changePage', 'click', function(e){
        var showDom = $.sizzle('[node-type=show]', pageContainer)[0];
        var allPages = parseInt($.sizzle('[node-type=all]', pageContainer)[0].innerHTML, 10);
        var curPage = parseInt(showDom.innerHTML, 10);

        if(e.data.action == 'next'){
            if(curPage < allPages){
                $.io.ajax({
                    'method': 'get',
                    'url': '/aj/discount/getPingHtml',
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
                    'url': '/aj/discount/getPingHtml',
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
        }else if(e.data.action =='page'){
            pagenumber=e.data.page;
            curPage = pagenumber;
            $.io.ajax({
                'method': 'get',
                'url': '/aj/discount/getPingHtml',
                'args': {
                    'shop_id': e.data.shop_id,
                    'city': e.data.city,
                    'page': pagenumber
                },
                'onComplete': function(data){
                    if(data.code == '200'){
                        $('#comment_list')[0].innerHTML = data.html;
                        showDom.innerHTML = curPage;
                    }
                }
            });
        }
        $.evt.stopEvent();
    });


    pageDevt.add('changePageAdapter', 'click', function(e){
        var showDom = $.sizzle('[node-type=show]', pageContainer)[0];
        var allPages = parseInt($.sizzle('[node-type=all]', pageContainer)[0].innerHTML, 10);
        var curPage = parseInt(showDom.innerHTML, 10);

        if(e.data.action == 'next'){
            if(curPage < allPages){
                $.io.ajax({
                    'method': 'get',
                    'url': '/aj/discount/getPingHtml',
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
                    'url': '/aj/discount/getPingHtml',
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
        }else if(e.data.action =='page'){
            pagenumber=e.data.page;
            curPage = pagenumber;
            $.io.ajax({
                'method': 'get',
                'url': '/aj/discount/getPingHtml',
                'args': {
                    'shop_id': e.data.shop_id,
                    'city': e.data.city,
                    'page': pagenumber
                },
                'onComplete': function(data){
                    if(data.code == '200'){
                        $('#comment_list')[0].innerHTML = data.html;
                        showDom.innerHTML = curPage;
                    }
                }
            });
        }
        $.evt.stopEvent();
    });



});
