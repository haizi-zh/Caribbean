(function($) {

    $.lo.slider = function(opts){

        var lo = this;

        var defaults = {
            loopTime: 3000,
            page: 0
        };

        var conf, container, nodes, dEvt, timer;

        var handler = {
            init: function(){
                handler.parseArgs();
                handler.bind();
                handler.build();
            },

            parseArgs: function(){
                if(!lo.isNode()){
                    throw "[lilac.slider] require node!";
                }
                conf = $.extend(defaults, opts || {});
                container = lo[0];
                dEvt = $.delegatedEvent(container);
                nodes = $.parseDOM($.builder(container).list);
            },

            bind: function(){
                dEvt.add('slideDot', 'click', handler.slideDot);
                dEvt.add('pause', 'mouseover', handler.pause);
                dEvt.add('pause', 'mouseout', handler.pause);
            },

            build: function(){
                conf.totalPage = $.sizzle('li', nodes.slider).length;
                $(nodes.slider).setStyle('left', '0');
                handler.loop();
            },

            firstChild: function(el){
                if(el.firstElementChild){
                    return el.firstElementChild;
                }
                var firstChild = el.firstChild;
                if(firstChild && firstChild.nodeType != 1){
                    handler.firstChild(firstChild);
                }
                return firstChild;
            },

            animate: function(pos, end, time) {
                time = time || 500;
                pos = pos == 'next' ? -940 : 0;
                $.ani.tween(nodes.slider, {
                    'animationType': 'easeoutcubic',
                    'duration': time,
                    'end': end
                }).play({
                    left: pos
                });
            },

            autoslide: function(e) {
                conf.page = Math.abs((++conf.page + conf.totalPage) % conf.totalPage);
                handler.animate('next', function() {
                    var moveNode = handler.firstChild(nodes.slider);
                    $(nodes.slider).setStyle('left', 0);
                    $(nodes.slider).insertElement(moveNode, 'beforeend');
                });
                handler.changeStyle(conf.page);

            },

            slideDot: function(e){
                var list = $.sizzle('li', nodes.slider);
                var moveNode = $.sizzle('[action-data=' + e.data.page + ']', nodes.slider)[0];
                var len = $.arr.findout(list, moveNode)[0];
                for(var i = 0; i < len; i++) {
                    $(nodes.slider).insertElement(handler.firstChild(nodes.slider), 'beforeend');
                }
                conf.page = e.data.page;
                handler.changeStyle(conf.page);
                $.evt.preventDefault();
            },

            changeStyle: function(curNum){
                $($.sizzle('.cur', nodes.sliderDot)[0]).removeClassName('cur');
                $($.sizzle('li', nodes.sliderDot)[curNum]).addClassName('cur');
            },

            loop: function() {
                timer = setTimeout(function() {
                    handler.autoslide();
                    timer = setTimeout(arguments.callee, conf.loopTime);
                }, conf.loopTime);
            },

            pause: function(e){
                clearTimeout(timer);
                if(e.evt.type == 'mouseout') {
                    handler.loop();
                    return true;
                }
            }

        }

        handler.init();
    };

})(Lilac);
