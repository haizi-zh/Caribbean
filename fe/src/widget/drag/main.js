/**
 * 拖拽
 */
define(function(require){

    var $ = require('jquery');
    var util = require('util');

    var browser = $.browser;

    function dragBase(actEl, spec) {
        var stopClick = function (e) {
            e.cancelBubble = true;
            return false;
        };

        var getParams = function (args, evt) {
            args['clientX'] = evt.clientX;
            args['clientY'] = evt.clientY;
            args['pageX'] = evt.clientX + $(document).scrollLeft();
            args['pageY'] = evt.clientY + $(document).scrollTop();
            return args;
        };


        if (!util.dom.isNode(actEl)) {
            throw 'dragBase need Element as first parameter';
        }
        var conf = $.extend({
            'actRect': [],
            'actObj': {}
        }, spec);

        var that = {};

        var dragStartKey = util.evt.custEvent.define(conf.actObj, 'dragStart');
        var dragEndKey = util.evt.custEvent.define(conf.actObj, 'dragEnd');
        var dragingKey = util.evt.custEvent.define(conf.actObj, 'draging');

        var startFun = function (e) {
            var args = getParams({}, e);
            document.body.onselectstart = function () {
                return false;
            };
            $(document).on('mousemove', dragFun);
            $(document).on('mouseup', endFun);
            $(document).on('click', stopClick, true);
            if (!browser.msie) {
                e.preventDefault();
                e.stopPropagation();
            }
            util.evt.custEvent.fire(dragStartKey, 'dragStart', args);
            return false;
        };

        var dragFun = function (e) {
            var args = getParams({}, e);
            e.cancelBubble = true;
            util.evt.custEvent.fire(dragStartKey, 'draging', args);
        };

        var endFun = function (e) {
            var args = getParams({}, e);
            document.body.onselectstart = function () {
                return true;
            };
            $(document).off('mousemove', dragFun);
            $(document).off('mouseup', endFun);
            $(document).off('click', stopClick, true);
            util.evt.custEvent.fire(dragStartKey, 'dragEnd', args);
        };

        $(actEl).on('mousedown', startFun);

        that.destroy = function () {
            $(actEl).off('mousedown', startFun);
            conf = null;
        };

        that.getActObj = function () {
            return conf.actObj;
        };

        return that;
    }

    function drag(actDom, spec) {
        var conf;
        var that;
        var beDragged;
        var dragState;
        var dragObj;
        var perch;
        var perchIn;
        var perchAction;

        var init = function () {
            // debugger
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
            dragObj = dragBase(actDom, {
                'actObj':conf.actObj
            });
            if (conf['dragtype'] === 'perch') {
                perch = document.createElement('div');
                perchIn = false;
                perchAction = false;
                beDragged = perch;
            }
            actDom.style.cursor = 'move';
        };

        var bindEvent = function () {
            util.evt.custEvent.add(conf.actObj, 'dragStart', dragStart);
            util.evt.custEvent.add(conf.actObj, 'dragEnd', dragEnd);
            util.evt.custEvent.add(conf.actObj, 'draging', draging);
        };

        var dragStart = function (evt, op) {
            document.body.style.cursor = 'move';
            // var p = $.lo.pageSize()['page'];
            dragState = $(conf.moveDom).position();
            dragState.pageX = op.pageX;
            dragState.pageY = op.pageY;
            dragState.height = conf.moveDom.offsetHeight;
            dragState.width = conf.moveDom.offsetWidth;
            dragState.pageHeight = $(document).height();//p['height'];
            dragState.pageWidth = $(document).width();//p['width'];
            if (conf['dragtype'] === 'perch') {
                var style = [];
                style.push(conf['perchStyle']);
                style.push('position:absolute');
                style.push('z-index:' +
                        (parseInt(conf.moveDom.style.zIndex, 10) + 10));
                style.push('width:' + conf.moveDom.offsetWidth + 'px');
                style.push('height:' + conf.moveDom.offsetHeight + 'px');
                style.push('left:' + dragState['left'] + 'px');
                style.push('top:' + dragState['top'] + 'px');
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
                $(conf.moveDom).css({
                    'left': parseInt(perch.style.left),
                    'top': parseInt(perch.style.top)
                });
                if (perchIn) {
                    document.body.removeChild(perch);
                    perchIn = false;
                }
            }
            conf.dragEnd(beDragged, op, actDom)
        };

        var draging = function (evt, op) {
            var y = dragState.top + (op.pageY - dragState.pageY);
            var x = dragState.left + (op.pageX - dragState.pageX);
            var yandh = y + dragState['height'];
            var xandw = x + dragState['width'];
            var pageh = dragState['pageHeight'] - conf['pagePadding'];
            var pagew = dragState['pageWidth'] - conf['pagePadding'];
            if (yandh < pageh && y > 0) {
                $(beDragged).css({'top':y});
            } else {
                if (y < 0) {
                    $(beDragged).css({'top':0});
                }
                if (yandh >= pageh) {
                    $(beDragged).css({'top':pageh - dragState['height']})
                }
            }
            if (xandw < pagew && x > 0) {
                $(beDragged).css({'left':x});
            } else {
                if (x < 0) {
                    $(beDragged).css({'left':0});
                }
                if (xandw >= pagew) {
                    $(beDragged).css({'left':pagew - dragState['width']});
                }
            }
            conf.draging(beDragged, op, actDom);
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
            util.evt.custEvent.remove(conf.actObj, 'dragStart', dragStart);
            util.evt.custEvent.remove(conf.actObj, 'dragEnd', dragEnd);
            util.evt.custEvent.remove(conf.actObj, 'draging', draging);
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

    return {
        drag: drag
    }
});