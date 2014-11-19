$.ready(function () {

    var contentContainer = $('#shop_content')[0];
    var dEvt = $.delegatedEvent(contentContainer);
    var allChooseKeys = $.sizzle('[action-type=choose_key]', contentContainer);

    

    var tabContainer = $('#tab_container')[0];
    var dEvt1 = $.delegatedEvent(tabContainer);
    var allTabs = $.sizzle('[action-type=change_tab]', tabContainer);

    dEvt.add('choose_key', 'click', function(e){
        for (var i = allChooseKeys.length - 1; i >= 0; i--) {
            $(allChooseKeys[i]).removeClassName('cur');
        }

        $(e.el).addClassName('cur');
        $.io.ajax({
            'method': 'get',
            'url': '/aj/city/get_brand_html',
            'args': e.data,
            'onComplete': function(data){
                $('#toggle_list')[0].innerHTML = data.html;
            }
        });
        $.evt.stopEvent();
    });

    dEvt.add('all_brand', 'click', function(e){
        var allBrands = $.sizzle('[action-type=brand]', contentContainer);
        for (var i = allBrands.length - 1; i >= 0; i--) {
            $(allBrands[i]).removeClassName('cur');
        }

        
        var allBrandsA = $.sizzle('[action-type=all_brand_cur]', contentContainer);
        for (var i = allBrandsA.length - 1; i >= 0; i--) {
            tab = $(allBrandsA[i]);
            tab.addClassName('cur');
        }
        $.io.ajax({
            'method': 'get',
            'url': '/aj/city/get_shop_html_by_tab',
            'args': e.data,
            'onComplete': function(data){
                $.sizzle('[node-type=show]', $('#page_container')[0])[0].innerHTML = 1;
                $.sizzle('[node-type=all]', $('#page_container')[0])[0].innerHTML = data.page_cnt;
                var actionDataClone = {};
                var tab;
                for (var i = allTabs.length - 1; i >= 0; i--) {
                    tab = $(allTabs[i]);
                    if(i != 0){
                        tab.removeClassName('cur');
                    }else{
                        tab.addClassName('cur');
                    }
                    actionDataClone = $.extend($.queryToJson(tab[0].getAttribute('action-data')), e.data);
                    
                    tab[0].setAttribute('action-data', $.jsonToQuery(actionDataClone));
                }

                $('#shop_list')[0].innerHTML = data.html;
            }
        });
        $.evt.stopEvent();
    });

    dEvt.add('brand', 'click', function(e){
        var allBrands = $.sizzle('[action-type=brand]', contentContainer);
        for (var i = allBrands.length - 1; i >= 0; i--) {
            $(allBrands[i]).removeClassName('cur');
        }
        $(e.el).addClassName('cur');

        var allBrandsA = $.sizzle('[action-type=all_brand_cur]', contentContainer);
        for (var i = allBrandsA.length - 1; i >= 0; i--) {
            tab = $(allBrandsA[i]);
            tab.removeClassName('cur');
        }

        $.io.ajax({
            'method': 'get',
            'url': '/aj/city/get_shop_html_by_tab',
            'args': e.data,
            'onComplete': function(data){
                $.sizzle('[node-type=show]', $('#page_container')[0])[0].innerHTML = 1;
                $.sizzle('[node-type=all]', $('#page_container')[0])[0].innerHTML = data.page_cnt;
                var actionDataClone = {};
                var tab;
                for (var i = allTabs.length - 1; i >= 0; i--) {
                    tab = $(allTabs[i]);
                    if(i != 0){
                        tab.removeClassName('cur');
                    }else{
                        tab.addClassName('cur');
                    }
                    actionDataClone = $.extend($.queryToJson(tab[0].getAttribute('action-data')), e.data);
                    tab[0].setAttribute('action-data', $.jsonToQuery(actionDataClone));
                }

                $('#shop_list')[0].innerHTML = data.html;
            }
        });
        $.evt.stopEvent();
    });


    dEvt1.add('change_tab', 'click', function(e){
        $.io.ajax({
            'method': 'get',
            'url': '/aj/city/get_shop_html_by_tab',
            'args': e.data,
            'onComplete': function(data){
                $.sizzle('[node-type=show]', $('#page_container')[0])[0].innerHTML = 1;
                $.sizzle('[node-type=all]', $('#page_container')[0])[0].innerHTML = data.page_cnt;
                for (var i = allTabs.length - 1; i >= 0; i--) {
                    $(allTabs[i]).removeClassName('cur');
                }
                $(e.el).addClassName('cur');
                $('#shop_list')[0].innerHTML = data.html;
            }
        });
        $.evt.stopEvent();
    });


    var tabContainerPos = $(tabContainer).getPos(),
        tabContainerTop = tabContainerPos.t;

    setInterval(function(){
        var sTop = $.scrollPos().top;
        if(sTop >= tabContainerTop){
            if($.browser.IE){
                $(tabContainer).setStyle('position', 'absolute');
                $(tabContainer).setStyle('top', sTop);
            }else{
                $(tabContainer).setStyle('position', 'fixed');
                $(tabContainer).setStyle('top', '0');
            }
        }else{
            $(tabContainer).setStyle('position', 'static');
        }
    },100);


    var pageContainer = $('#page_container')[0];



    var pageDevt = $.delegatedEvent(document.body);
    pageDevt.add('changePage', 'click', function(e){
        var showDom = $.sizzle('[node-type=show]', pageContainer)[0];
        var allPages = parseInt($.sizzle('[node-type=all]', pageContainer)[0].innerHTML, 10);

        var el = e.el;
        var curPage = parseInt(showDom.innerHTML, 10);

        var tmp = {};


        for (var i = allTabs.length - 1; i >= 0; i--) {
            tab = $(allTabs[i]);
            if(tab.hasClassName('cur')){
                tmp = $.queryToJson(tab[0].getAttribute('action-data'));
                break;
            }
        }
        var s = $.extend(e.data, tmp);

        if(e.data.action == 'next'){
            if(curPage < allPages){
                $.io.ajax({
                    'method': 'get',
                    'url': '/aj/city/get_shop_html_by_tab',
                    'args': {
                        'brand_id': s.brand_id,
                        'property': s.property,
                        'city': s.city,
                        'page': ++curPage
                    },
                    'onComplete': function(data){
                        if(data.code == '200'){
                            $('#shop_list')[0].innerHTML = data.html;
                            showDom.innerHTML = curPage;
                        }
                    }
                });
            }
        }else if(e.data.action =='prev'){
            if(curPage > 1){
                $.io.ajax({
                    'method': 'get',
                    'url': '/aj/city/get_shop_html_by_tab',
                    'args': {
                        'brand': s.brand_id,
                        'property': s.property,
                        'city': s.city,
                        'page': --curPage
                    },
                    'onComplete': function(data){
                        if(data.code == '200'){
                            $('#shop_list')[0].innerHTML = data.html;
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
                'url': '/aj/city/get_shop_html_by_tab',
                'args': {
                    'brand': s.brand_id,
                    'property': s.property,
                    'city': s.city,
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
