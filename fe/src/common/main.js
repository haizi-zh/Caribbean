/**
 * common模块
 */
// define(['jquery'], function($, require){
define(function(require){
    var $ = require('jquery');
    var util = require('util');
    var cookie = require('widget/cookie/main');
    var config = require('common/config');
    var login = require('common/login');
    var popup = require('widget/popup/main');


    var view = {};
    view.$suggestText = $('#suggestion-text');
    view.$suggestTarget = $('#suggestion-target');
    view.$login = $('#login-btn');

    view.$changeCity = $('#change-city');
    view.$cityLayer = $('#zb-city-layer');

    view.$suggestText.on('focus', function(e){
        var $this = $(this);
        if (util.str.trim($this.val()) === '商家名称联想') {
            $this.val('');
            $(this).css({
                color: '#000'
            });
        }
    });

    view.$suggestText.on('blur', function(e){
        var $this = $(this);
        if (util.str.trim($this.val()) === '') {
            $this.val('商家名称联想');
            $(this).css({
                color: '#999'
            });
        }
    });

    view.$suggestText.on('keyup', function(e) {
        var $this = $(this);
        if ($this.val() !== $this.data('val')) {
            $this.data('val', $this.val());
            if (util.str.trim($this.val())) {
                $.ajax({
                    url: config.AJAX.SEARCH_SUGGESTION + $this.val(),
                    dataType: 'jsonp',
                    jsonp: 'callback',
                    success: function(data) {
                        if (data && data.shop) {
                            var html = '';
                            var len  = data.shop.length;
                            for (var i = 0; i < len; i++) {
                                html += '<a target="_blank" '
                                     + 'href="http://www.zanbai.com/shop?shop_id='
                                     + data.shop[i].word_id
                                     + '">'
                                     + data.shop[i].word
                                     + '</a>';
                            }
                            view.$suggestTarget.css({
                                'display': ''
                            });
                            view.$suggestTarget.html(html);
                        }
                        else {
                            view.$suggestTarget.css({
                                'display': 'none'
                            });
                            view.$suggestTarget.html('');
                        }
                    }
                });
            }
            else {
                view.$suggestTarget.css({
                    'display': 'none'
                });
                view.$suggestTarget.html('');
            }
        }
        e.stopPropagation();
        e.preventDefault();
    });

    $(document).click(function(e) {
        
        var el = e.srcElement || e.target;
        if (
            el.parentNode
                && el.parentNode.id !== 'suggestion-target'
                && el.id !== 'suggestion-text'
            )
        {
            view.$suggestTarget.css({
                'display': 'none'
            });
        }

        var cityLayer = view.$cityLayer[0];
        if (cityLayer && cityLayer.style.display !== 'none') {
            if (
                !util.dom.contains(cityLayer, el)
                &&
                el.getAttribute('id') != 'change-city'
            ) {
                cityLayer.style.display = 'none';
                popup.createModuleMask.hide();
            }
        }

    });

    function clearSelectedStyle() {
        var items = view.$suggestTarget.children();
        var len = items.length;
        for (var i = 0; i < len; i++) {
            if ($(items[i]).hasClass('selected')) {
                $(items[i]).removeClass('selected');
            }
        }
    }

    $(document).keydown(function(e) {
        var keyCode = e.keyCode ?e.keyCode : e.which;
        var display = view.$suggestTarget.css('display');
        if (display !== 'none') {
            var items = view.$suggestTarget.children();
            var len = items.length;
            var curSelectedObj; // 当前选中的那一个，即上下键盘按下时选择的起始位置
            for (var i = 0; i < len; i++) {
                if ($(items[i]).hasClass('selected')) {
                    curSelectedObj = {
                        elem: items[i],
                        index: i
                    }
                    break;
                }
            }
            if (keyCode == 40) { // 下
                if (curSelectedObj) {
                    if (curSelectedObj.index + 1 === len) {
                        clearSelectedStyle();
                        $(items[0]).addClass('selected');
                    }
                    else {
                        clearSelectedStyle();
                        $(items[curSelectedObj.index + 1]).addClass('selected');
                    }
                }
                else {
                    curSelectedObj = {
                        elem: items[0],
                        index: 0
                    }
                    $(items[curSelectedObj.index]).addClass('selected');
                }
                e.stopPropagation();
                e.preventDefault();
            }
            else if (keyCode == 38) { // 上
                if (curSelectedObj) {
                    if (curSelectedObj.index === 0) {
                        clearSelectedStyle();
                        $(items[len - 1]).addClass('selected');
                    }
                    else {
                        clearSelectedStyle();
                        $(items[curSelectedObj.index - 1]).addClass('selected');
                    }
                }
                else {
                    curSelectedObj = {
                        elem: items[len - 1],
                        index: len - 1
                    }
                    $(items[curSelectedObj.index]).addClass('selected');
                }
                e.stopPropagation();
                e.preventDefault();
            }
            else if(keyCode == 13) { // 回车
                setTimeout(function(){
                    // window.location.href = curSelectedObj.elem.getAttribute('href');
                    curSelectedObj.elem && curSelectedObj.elem.click();
                }, 10);
                e.stopPropagation();
                e.preventDefault();
            }
        }
    });

    view.$suggestTarget.mouseover(function(e) {
        var target = e.target || e.srcElement;
        var targetTagName = target.tagName.toLowerCase();
        if (targetTagName == 'a') {
            $(target).addClass('selected');
        }
    }).mouseout(function(e) {
        var target = e.target || e.srcElement;
        var targetTagName = target.tagName.toLowerCase();
        if (targetTagName == 'a') {
            clearSelectedStyle();
        }
    });

    view.$login.click(function(e) {
        login.show();
    });


    view.$changeCity.on('click', function(e) {
        var el = view.$cityLayer[0];
        if (el) {
            var display = view.$cityLayer.css('display');
            if (display == 'none') {
                display = '';
            }
            else {
                display = 'none';
            }
            view.$cityLayer.css('display', display);
            popup.createModuleMask.showUnderNode(el);
            // popup.createModuleMask.show();
        }
    });

    $(document.body).delegate(
        '[action-type=follow]',
        'click',
        function(e) {
            if (window.$CONFIG.isLogin == 0) {
                login.show();
            }
            else {
                var curTarget = e.currentTarget;
                var $curTarget = $(curTarget);
                var tmp = util.json.queryToJson($curTarget.attr('action-data'));
                $.ajax({
                    'type': 'post',
                    'url': config.AJAX.FOLLOW,
                    'dataType': 'json',
                    'data': {
                        to_uid: tmp.uid
                    },
                    'success': function (data) {
                        if (data.code == 200) {
                            $curTarget.removeClass('W_btn_b');
                            $curTarget.addClass('W_btn_a');
                            $curTarget.html('<span>已关注</span>');
                            $curTarget.attr('action-type', 'unfollow');
                        }
                        else {
                            popup.alertPopup(data.msg);
                        }
                    }
                });
            }
            e.stopPropagation();
            e.preventDefault();
        }
    );

    $(document.body).delegate(
        '[action-type=unfollow]',
        'click',
        function(e) {
            var curTarget = e.currentTarget;
            var $curTarget = $(curTarget);
            var tmp = util.json.queryToJson($curTarget.attr('action-data'));
            $.ajax({
                'type': 'post',
                'url': config.AJAX.UNFOLLOW,
                'dataType': 'json',
                'data': {
                    to_uid: tmp.uid
                },
                'success': function (data) {
                    $curTarget.removeClass('W_btn_a');
                    $curTarget.addClass('W_btn_b');
                    $curTarget.html('<span>关注</span>');
                    $curTarget.attr('action-type', 'follow');
                }
            });
            e.stopPropagation();
            e.preventDefault();
        }
    );

    $(document.body).delegate(
        '[action-type=unfollow]',
        'mouseenter',
        function(e) {
            var curTarget = e.currentTarget;
            var $curTarget = $(curTarget);
            $curTarget.html('<span>取消关注</span>');
            e.stopPropagation();
            e.preventDefault();
        }
    );

    $(document.body).delegate(
        '[action-type=unfollow]',
        'mouseleave',
        function(e) {
            var curTarget = e.currentTarget;
            var $curTarget = $(curTarget);
            $curTarget.html('<span>已关注</span>');
            e.stopPropagation();
            e.preventDefault();
        }
    );


    $(document.body).delegate(
        '[action-type=fav]',
        'click',
        function(e) {
            if (window.$CONFIG.isLogin == 0) {
                login.show();
            }
            else {
                var curTarget = e.currentTarget;
                var $curTarget = $(curTarget);
                var tmp = util.json.queryToJson($curTarget.attr('action-data'));
                var noclass = tmp.noclass;

                $.ajax({
                    'type': 'post',
                    'url': config.AJAX.FAV,
                    'dataType': 'json',
                    'data': {
                        id: tmp.id,
                        type: tmp.type
                    },
                    'success': function (data) {
                        if (data.code == 200) {
                            if(!noclass){
                                console.log(noclass==1);
                                $curTarget.removeClass('favor_btn');
                                $curTarget.addClass('disable_btn');
                            }
                            $curTarget.html('已收藏');
                            $curTarget.attr('action-type', 'unfav');
                        }
                        else {
                            popup.alertPopup(data.msg);
                        }
                    }
                });
            }
            e.stopPropagation();
            e.preventDefault();
        }
    );

    $(document.body).delegate(
        '[action-type=unfav]',
        'click',
        function(e) {
            var curTarget = e.currentTarget;
            var $curTarget = $(curTarget);
            var tmp = util.json.queryToJson($curTarget.attr('action-data'));
            var noclass = tmp.noclass;
            $.ajax({
                'type': 'post',
                'url': config.AJAX.UNFAV,
                'dataType': 'json',
                'data': {
                    id: tmp.id,
                    type: tmp.type
                },
                'success': function (data) {
                    if(!noclass){
                        $curTarget.removeClass('disable_btn');
                        $curTarget.addClass('favor_btn');
                    }
                    $curTarget.html('收藏');
                    $curTarget.attr('action-type', 'fav');
                }
            });
            e.stopPropagation();
            e.preventDefault();
        }
    );

    $(document.body).delegate(
        '[action-type=unfav]',
        'mouseenter',
        function(e) {
            var curTarget = e.currentTarget;
            var $curTarget = $(curTarget);
            $curTarget.html('取消收藏');
            e.stopPropagation();
            e.preventDefault();
        }
    );

    $(document.body).delegate(
        '[action-type=unfav]',
        'mouseleave',
        function(e) {
            var curTarget = e.currentTarget;
            var $curTarget = $(curTarget);
            $curTarget.html('已收藏');
            e.stopPropagation();
            e.preventDefault();
        }
    );


    $(document.body).delegate(
        '[action-type=ad_img]',
        'click',
        function(e) {
            $.ajax({
                'type': 'get',
                'url':  config.AJAX.ADIMG,
                'args': {},
                'success': function(data){
                }
            });
        }
    );

    $(document.body).delegate(
        '[action-type=need_login]',
        'click',
        function(e) {
            login.show();
            e.stopPropagation();
            e.preventDefault();
        }
    );

    
    (function() {
        var goto_top_html = '<div class="goToTop" style="position: fixed;bottom: 100px;"><a class="toTop" href="javascript:void(0)"></a></div>' ;
        var $backToTopEle = $(goto_top_html).appendTo($("body")).click(function() {
                $("html, body").animate({ scrollTop: 0 }, 300);
        }), $backToTopFun = function() {
            var st = $(document).scrollTop(), winh = $(window).height();
            (st > 0)? $backToTopEle.show(): $backToTopEle.hide();    
            //IE6下的定位
            if (!window.XMLHttpRequest) {
                $backToTopEle.css("top", st + winh - 166);    
            }
        };
        $(window).bind("scroll", $backToTopFun);
        $(function() { $backToTopFun(); });
    })();
    
    /*
    $(window).scroll(
        function () {
            if ($(window).scrollTop() > 100) {
                $('#goToTop').fadeIn(500);
            }
            else {
                $('#goToTop').fadeOut(500);
            }
        }
    );

    $('#goToTop').click(
        function () {
            $('body,html').animate({scrollTop:0},1000);
            return false;
        }
    );*/

	function isLoaded(id) {
        var ret = false;
        var scripts = document.getElementsByTagName('script');
        for (var i = 0, len = scripts.length; i < len; i++) {
            if (scripts[i].getAttribute('id') === id) {
                ret = true;
                break;
            }
        }
        return ret;
    }


    /**
     * 加载 jquery 插件资源
     *
     * @param  {string}   id       script id
     * @param  {string}   url      script url
     * @param  {Function} callback 加载完后的回调
     */
    function load(id, url, callback) {
        if (!isLoaded(id)) {
            var head = document.getElementsByTagName('head')[0]
                        || document.body;
            var script = document.createElement('script');
            script.setAttribute('type', 'text/javascript');
            script.setAttribute('src', url);
            script.setAttribute('id', id);

            if (callback != null) {
                script.onload = script.onreadystatechange = function () {
                    if (script.ready) {
                        return false;
                    }
                    if (!script.readyState
                        || script.readyState == 'loaded'
                        || script.readyState == 'complete'
                    ) {
                        script.ready = true;
                        callback();
                    }
                };
            }
            head.appendChild(script);
        }
    }

    /*
    load('nivoslider' , window.$CONFIG.normalUrl + '/js/jquery/jquery.nivo.slider.js',function (){
        $('#slider').nivoSlider({
            effect: 'fade',
            controlNav: false,
            animSpeed:500,
            pauseTime:4000,
            prevText: '<',
            nextText: '>',
        });
    });
    */
    load('nivoslider' , window.$CONFIG.normalUrl + '/js/jquery/jquery.SuperSlide.2.1.1.js',function (){
        $(".focusimg-pic").slide({mainCell:"#slide_ul",autoPlay:true,delayTime:1000,interTime:6000,triggerTime:200,});
    });

    $("#favorites").click(function () {　　　　//$里面是链接的id  
        var ctrl = (navigator.userAgent.toLowerCase()).indexOf('mac') != -1 ? 'Command/Cmd' : 'CTRL';  
        if (document.all) {  
        window.external.addFavorite('http://www.zanbai.com/', '百度')  
        } else if (window.sidebar) {  
        window.sidebar.addPanel('百度', 'http://www.zanbai.com/', "")  
        } else {　　　　//添加收藏的快捷键  
        alert('添加失败\n您可以尝试通过快捷键' + ctrl + ' + D 加入到收藏夹~')  
        }  
    });

    setTimeout(function(){$("#popfloating_float_level").hide();}, 50000);

    $("#floating_app_close").click(function(){
        $("#popfloating_float_level").hide();
        cookie.set("close_app_pop", 1, {expire:259200000});
        //var cookieValue = cookie.get("close_app_pop");
        //console.log(cookieValue);
    });

});