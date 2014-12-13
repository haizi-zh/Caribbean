(function ($) {
    $.extend({
        dragBase:function (actEl, spec) {
            var stopClick = function (e) {
                e.cancelBubble = true;
                return false;
            };

            var getParams = function (args, evt) {
                args['clientX'] = evt.clientX;
                args['clientY'] = evt.clientY;
                args['pageX'] = evt.clientX + $.scrollPos()['left'];
                args['pageY'] = evt.clientY + $.scrollPos()['top'];
                return args;
            };


            if (!$(actEl).isNode()) {
                throw 'Lilac.dragBase need Element as first parameter';
            }
            var conf = $.extend({
                'actRect':[],
                'actObj':{}
            }, spec);

            var that = {};

            var dragStartKey = $.evt.custEvent.define(conf.actObj, 'dragStart');
            var dragEndKey = $.evt.custEvent.define(conf.actObj, 'dragEnd');
            var dragingKey = $.evt.custEvent.define(conf.actObj, 'draging');

            var startFun = function (e) {
                var args = getParams({}, e);
                document.body.onselectstart = function () {
                    return false;
                };
                $(document).addEvent('mousemove', dragFun);
                $(document).addEvent('mouseup', endFun);
                $(document).addEvent('click', stopClick, true);
                if (!$.browser.IE) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                $.evt.custEvent.fire(dragStartKey, 'dragStart', args);
                return false;
            };

            var dragFun = function (e) {
                var args = getParams({}, e);
                e.cancelBubble = true;
                $.evt.custEvent.fire(dragStartKey, 'draging', args);
            };

            var endFun = function (e) {
                var args = getParams({}, e);
                document.body.onselectstart = function () {
                    return true;
                };
                $(document).removeEvent('mousemove', dragFun);
                $(document).removeEvent('mouseup', endFun);
                $(document).removeEvent('click', stopClick, true);
                $.evt.custEvent.fire(dragStartKey, 'dragEnd', args);
            };

            $(actEl).addEvent('mousedown', startFun);

            that.destroy = function () {
                $(actEl).removeEvent('mousedown', startFun);
                conf = null;
            };

            that.getActObj = function () {
                return conf.actObj;
            };

            return that;
        },

        drag:function (actDom, spec) {
            var conf, that, beDragged, dragState, dragObj, perch, perchIn, perchAction;

            var init = function () {
                initParams();
                bindEvent();
            };

            var initParams = function () {
                conf = $.extend({
                    'moveDom':actDom,
                    'perchStyle':'border:solid #999999 2px;',
                    'dragtype':'perch',
                    'actObj':{},
                    'pagePadding':5,
                    'dragStart':function () {
                    },
                    'dragEnd':function () {
                    },
                    'draging':function () {
                    }
                }, spec);
                beDragged = conf.moveDom;
                that = {};
                dragState = {};
                dragObj = $.dragBase(actDom, {
                    'actObj':conf.actObj
                });
                if (conf['dragtype'] === 'perch') {
                    perch = $.C('div');
                    perchIn = false;
                    perchAction = false;
                    beDragged = perch;
                }
                actDom.style.cursor = 'move';
            };

            var bindEvent = function () {
                $.evt.custEvent.add(conf.actObj, 'dragStart', dragStart);
                $.evt.custEvent.add(conf.actObj, 'dragEnd', dragEnd);
                $.evt.custEvent.add(conf.actObj, 'draging', draging);
            };

            var dragStart = function (evt, op) {
                document.body.style.cursor = 'move';
                var p = $.lo.pageSize()['page'];
                dragState = $(conf.moveDom).getPos();
                dragState.pageX = op.pageX;
                dragState.pageY = op.pageY;
                dragState.height = conf.moveDom.offsetHeight;
                dragState.width = conf.moveDom.offsetWidth;
                dragState.pageHeight = p['height'];
                dragState.pageWidth = p['width'];
                if (conf['dragtype'] === 'perch') {
                    var style = [];
                    style.push(conf['perchStyle']);
                    style.push('position:absolute');
                    style.push('z-index:' + (conf.moveDom.style.zIndex + 10));
                    style.push('width:' + conf.moveDom.offsetWidth + 'px');
                    style.push('height:' + conf.moveDom.offsetHeight + 'px');
                    style.push('left:' + dragState['l'] + 'px');
                    style.push('top:' + dragState['t'] + 'px');
                    perch.style.cssText = style.join(';');
                    perchAction = true;
                    setTimeout(function () {
                        if (perchAction) {
                            document.body.appendChild(perch);
                            perchIn = true;
                        }
                    }, 100);
                }
                if (actDom.setCapture !== undefined) {
                    actDom.setCapture();
                }
                conf.dragStart(beDragged, op, actDom)
            };

            var dragEnd = function (evt, op) {
                document.body.style.cursor = 'auto';
                if (actDom.setCapture !== undefined) {
                    actDom.releaseCapture();
                }
                if (conf['dragtype'] === 'perch') {
                    perchAction = false;
                    $(conf.moveDom).setPos({'l':parseInt(perch.style.left), 't':parseInt(perch.style.top)})
                    if (perchIn) {
                        document.body.removeChild(perch);
                        perchIn = false;
                    }
                }
                conf.dragEnd(beDragged, op, actDom)
            };

            var draging = function (evt, op) {
                var y = dragState.t + (op.pageY - dragState.pageY);
                var x = dragState.l + (op.pageX - dragState.pageX);
                var yandh = y + dragState['height'];
                var xandw = x + dragState['width'];
                var pageh = dragState['pageHeight'] - conf['pagePadding'];
                var pagew = dragState['pageWidth'] - conf['pagePadding'];
                if (yandh < pageh && y > 0) {
                    $(beDragged).setPos({'t':y});
                } else {
                    if (y < 0) {
                        $(beDragged).setPos({'t':0});
                    }
                    if (yandh >= pageh) {
                        $(beDragged).setPos({'t':pageh - dragState['height']})
                    }
                }
                if (xandw < pagew && x > 0) {
                    $(beDragged).setPos({'l':x});
                } else {
                    if (x < 0) {
                        $(beDragged).setPos({'l':0});
                    }
                    if (xandw >= pagew) {
                        $(beDragged).setPos({'l':pagew - dragState['width']});
                    }
                }
                conf.draging(beDragged, op, actDom)
            };

            init();
            that.destroy = function () {
                document.body.style.cursor = 'auto';
                if (typeof beDragged.setCapture === 'function') {
                    beDragged.releaseCapture();
                }
                if (conf['dragtype'] === 'perch') {
                    perchAction = false;
                    if (perchIn) {
                        document.body.removeChild(perch);
                        perchIn = false;
                    }
                }
                $.evt.custEvent.remove(conf.actObj, 'dragStart', dragStart);
                $.evt.custEvent.remove(conf.actObj, 'dragEnd', dragEnd);
                $.evt.custEvent.remove(conf.actObj, 'draging', draging);
                if (dragObj.destroy) {
                    dragObj.destroy();
                }
                conf = null;
                beDragged = null;
                dragState = null;
                dragObj = null;
                perch = null;
                perchIn = null;
                perchAction = null;
            };
            that.getActObj = function () {
                return conf.actObj;
            };
            return that;


        }

    });
})(Lilac);