/**
 * 浮层
 */
define(function(require){

    var $ = require('jquery');
    var util = require('util');
    var drag = require('widget/drag/main');

    var browser = $.browser;

    var maskNode;
    var nodeRegList = [];
    var domFix;
    var maskInBody = false;
    var maskNodeKey = 'Lilac-Mask-Key';
    var _beforeFixFn;

    var isIE6 = (function(){
        return browser.msie && parseInt(browser.version, 10) <= 6;
    })();

    function cssText(oldCss) {
        var _getNewCss = function (oldCss, addCss) {
            // 去没必要的空白
            var _newCss = (oldCss + ';' + addCss)
                .replace(/(\s*(;)\s*)|(\s*(:)\s*)/g, '$2$4'), _m;
            //循环去除前后重复的前的那个 如 width:9px;height:0px;width:8px; -> height:0px;width:8px;
            while (_newCss && (_m = _newCss.match(/(^|;)([\w\-]+:)([^;]*);(.*;)?\2/i))) {
                _newCss = _newCss.replace(_m[1] + _m[2] + _m[3], '');
            }
            return _newCss;
        };
        oldCss = oldCss || '';
        var _styleList = [];
        var that = {

            /**
             * 向样式缓存列表里添加样式
             */
            push:function (property, value) {
                _styleList.push(property + ':' + value);
                return that;
            },

            /**
             * 从样式缓存列表删除样式
             */
            remove:function (property) {
                for (var i = 0; i < _styleList.length; i++) {
                    if (_styleList[i].indexOf(property + ':') == 0) {
                        _styleList.splice(i, 1);
                    }
                }
                return that;
            },

            /**
             * 返回样式缓存列表
             */
            getStyleList:function () {
                return _styleList.slice();
            },

            /**
             * 得到·
             */
            getCss:function () {
                return _getNewCss(oldCss, _styleList.join(';'));
            }
        };
        return that;
    }

    function fixPos($dom, type, offset) {
        var elem = $dom[0];
        //dom 扩展数据
        var _canFix =
            !(isIE6 || (document.compatMode !== 'CSS1Compat'
                            && browser.IE));

        var _typeReg = /^(c)|(lt)|(lb)|(rt)|(rb)$/;

        function _visible() {
            return $dom.css('display') != 'none';
        };

        function _createOffset(offset) {
            offset = util.isArray(offset) ? offset : [0, 0];
            for (var i = 0; i < 2; i++) {
                if (typeof offset[i] != 'number') offset[i] = 0;
            }
            return offset;
        };

        //处理div位置
        function _draw(elem, type, offset) {
            if (!_visible()) return;
            var _position = 'fixed';
            var _top;
            var _left;
            var _right;
            var _bottom;
            var _width = elem.offsetWidth;
            var _height = elem.offsetHeight;
            var _winWidth = $(window).width();
            var _winHeight = $(window).height();
            var _limitTop = 0;
            var _limitLeft = 0;
            var _cssText = cssText(elem.style.cssText);

            if (!_canFix) {
                _position = 'absolute';
                _limitTop = _top = $(window).scrollTop();
                _limitLeft = _left = $(window).scrollLeft();
                switch (type) {
                    case 'lt'://左上
                        _top += offset[1];
                        _left += offset[0];
                        break;
                    case 'lb'://左下
                        _top += _winHeight - _height - offset[1];
                        _left += offset[0];
                        break;
                    case 'rt'://右上
                        _top += offset[1];
                        _left += _winWidth - _width - offset[0];
                        break;
                    case 'rb'://右下
                        _top += _winHeight - _height - offset[1];
                        _left += _winWidth - _width - offset[0];
                        break;
                    case 'c'://中心
                    default:
                        _top += (_winHeight - _height) / 2 + offset[1];
                        _left += (_winWidth - _width) / 2 + offset[0];
                }
                _right = _bottom = '';
            } else {
                _top = _bottom = offset[1];
                _left = _right = offset[0];
                switch (type) {
                    case 'lt'://左上
                        _bottom = _right = '';
                        break;
                    case 'lb'://左下
                        _top = _right = '';
                        break;
                    case 'rt'://右上
                        _left = _bottom = '';
                        break;
                    case 'rb'://右下
                        _top = _left = '';
                        break;
                    case 'c'://中心
                    default:
                        _top = (_winHeight - _height) / 2 + offset[1];
                        _left = (_winWidth - _width) / 2 + offset[0];
                        _bottom = _right = '';
                }
            }
            if (type == 'c') {
                if (_top < _limitTop) _top = _limitTop;
                if (_left < _limitLeft) _left = _limitLeft;
            }
            _cssText.push('position', _position)
                .push('top', _top + 'px')
                .push('left', _left + 'px')
                .push('right', _right + 'px')
                .push('bottom', _bottom + 'px');
            elem.style.cssText = _cssText.getCss();
        }

        var _type;
        var _offset;
        var _fixed = true;
        var _ceKey;

        if (util.dom.isNode(elem) && _typeReg.test(type)) {
            var that = {
                /**
                 * 得到节点
                 */
                getNode:function () {
                    return elem;
                },
                /**
                 * 检测位置固定的可用性
                 */
                isFixed:function () {
                    return _fixed;
                },
                /**
                 * 设置位置固定的可用性
                 */
                setFixed:function (fixed) {
                    (_fixed = !!fixed) && _draw(elem, _type, _offset);
                    return this;
                },
                /**
                 * 设置对齐方式
                 * @method setAlign
                 * @param {String} type
                 * @param {Array} offset
                 * [
                 *     0,//和边框的横向距离 type == 'c'时无效
                 *     0//和边框的纵向距离 type == 'c'时无效
                 * ]
                 * @return  {Object} this
                 */
                setAlign:function (type, offset) {
                    if (_typeReg.test(type)) {
                        _type = type;
                        _offset = _createOffset(offset);
                        _fixed && _draw(elem, _type, _offset);
                    }
                    return this;
                },
                /**
                 * 销毁
                 * @method destroy
                 * @return {void}
                 */
                destroy:function () {
                    if (!_canFix) {
                        $(window).off('scroll', _evtFun);
                    }
                    $(window).off('resize', _evtFun);
                    util.evt.custEvent.undefine(_ceKey);
                }
            }
            _ceKey = util.evt.custEvent.define(that, 'beforeFix');
            that.setAlign(type, offset);
            function _evtFun(event) {
                event = event || window.event;
                /**
                 * 系统事件导致的重绘前事件
                 */
                util.evt.custEvent.fire(_ceKey, 'beforeFix', event.type);
                if (_fixed && (!_canFix || _type == 'c')) {
                    _draw(elem, _type, _offset);
                }
            };
            if (!_canFix) {
                $(window).on('scroll', _evtFun);
            }
            $(window).on('resize', _evtFun);
            return that;
        }
    }

    function getNodeMaskReg(node) {
        var keyValue;
        if (!(keyValue = node.getAttribute(maskNodeKey))) {
            node.setAttribute(maskNodeKey, keyValue = util.getUniqueKey());
        }
        return '>' + node.tagName.toLowerCase() + '[' + maskNodeKey + '="' + keyValue + '"]';
    }

    //初始化遮罩容器
    function initMask() {
        if (!maskNode) {
            maskNode = $('<div></div>');
        }
        // var _html = '<div node-type="outer">';
        var _html = '<div>';

        if (isIE6) {
            _html +=
                '<div style="position:absolute;width:100%;height:100%;"></div>';
        }
        _html += '</div>';
        maskNode = $.parseHTML(_html)[0];
        document.body.appendChild(maskNode);
        maskInBody = true;
        domFix = fixPos($(maskNode), 'lt');
        _beforeFixFn = function () {
            var _winWidth = $(window).width();
            var _winHeight = $(window).height();
            maskNode.style.cssText = cssText(maskNode.style.cssText)
                .push('width', _winWidth + 'px')
                .push('height', _winHeight + 'px').getCss();
        };

        $(window).on('resize', _beforeFixFn);
        util.evt.custEvent.add(domFix, 'beforeFix', _beforeFixFn);
        _beforeFixFn();
    };

    var createModuleMask = {
        getNode: function(){
            return maskNode;
        },

        show: function(option, cb){
            if (maskInBody) {
                option = $.extend({
                    opacity:0.3,
                    background:'#000000'
                }, option);
                maskNode.style.background = option.background;
                $(maskNode).css('opacity', option.opacity);
                maskNode.style.display = '';
                domFix.setAlign('lt');
                cb && cb();
            } else {
                initMask();
                createModuleMask.show(option, cb);
            }
            return createModuleMask;
        },

        hide: function(){
            maskNode.style.display = 'none';
            nowIndex = undefined;
            nodeRegList = [];
            return createModuleMask;
        },

        showUnderNode: function(elem, option){
            if (util.dom.isNode(elem)) {
                createModuleMask.show(option, function () {
                    $(maskNode).css('zIndex', $(elem).css('zIndex'));
                    var keyValue = getNodeMaskReg(elem);
                    var keyIndex = util.indexOf(nodeRegList, keyValue);
                    if (keyIndex != -1) {
                        nodeRegList.splice(keyIndex, 1);
                    }
                    nodeRegList.push(keyValue);
                    // $(elem).insertElement(maskNode, "beforebegin");
                    $(elem).before($(maskNode));
                });
            }
            return createModuleMask;
        },

        back: function(){
            if (nodeRegList.length < 1) {
                return createModuleMask;
            }
            var elem, nodeReg;
            nodeRegList.pop();
            if (nodeRegList.length < 1) {
                createModuleMask.hide();
            } else if ((nodeReg = nodeRegList[nodeRegList.length - 1]) && (elem = $(nodeReg, document.body)[0])) {
                $(maskNode).css('zIndex', $(elem).css('zIndex'));
                // $(elem).insertElement(maskNode, "beforebegin");
                $(elem).before($(maskNode));
            } else {
                createModuleMask.back();
            }
            return createModuleMask;
        },

        destroy: function(){
            util.evt.custEvent.remove(domFix);
            $(window).off('resize', _beforeFixFn);
            maskNode.style.display = "none";
            lastNode = undefined;
            _cache = {};
        }
    };

    function createModuleLayer (template) {
        var getSize = function (box) {
            var ret = {};
            if (box.style.display == 'none') {
                box.style.visibility = 'hidden';
                box.style.display = '';
                ret.w = box.offsetWidth;
                ret.h = box.offsetHeight;
                box.style.display = 'none';
                box.style.visibility = 'visible';
            }
            else {
                ret.w = box.offsetWidth;
                ret.h = box.offsetHeight;
            }
            return ret;
        };

        var getPosition = function (el, key) {
            key = key || 'topleft';
            var posi = null;
            if (el.style.display == 'none') {
                el.style.visibility = 'hidden';
                el.style.display = '';
                posi = $(el).position();
                el.style.display = 'none';
                el.style.visibility = 'visible';
            }
            else {
                posi = $(el).position();
            }

            if (key !== 'topleft') {
                var size = getSize(el);
                if (key === 'topright') {
                    posi['l'] = posi['l'] + size['w'];
                }
                else if (key === 'bottomleft') {
                    posi['t'] = posi['t'] + size['h'];
                }
                else if (key === 'bottomright') {
                    posi['l'] = posi['l'] + size['w'];
                    posi['t'] = posi['t'] + size['h'];
                }
            }
            return posi;
        };

        var dom = util.dom.builder(template);
        var outer = dom.list['outer'][0];
        var inner = dom.list['inner'][0];
        var uniqueID = util.getUniqueKey();
        var that = {};
        //事件 显示 隐藏
        var custKey = util.evt.custEvent.define(that, 'show');
        util.evt.custEvent.define(custKey, 'hide');

        var sizeCache = null;
        that.show = function () {
            outer.style.display = '';
            util.evt.custEvent.fire(custKey, 'show');
            return that;
        };
        that.hide = function () {
            outer.style.display = 'none';
            util.evt.custEvent.fire(custKey, "hide");
            return that;
        };
        that.getPosition = function (key) {
            return getPosition(outer, key);
        };
        that.getSize = function (isFlash) {
            if (isFlash || !sizeCache) {
                sizeCache = getSize.apply(that, [outer]);
            }
            return sizeCache;
        };
        that.html = function (html) {
            if (html !== undefined) {
                inner.innerHTML = html;
            }
            return inner.innerHTML;
        };
        that.text = function (str) {
            if (text !== undefined) {
                inner.innerHTML = util.str.encodeHTML(str);
            }
            return util.str.decodeHTML(inner.innerHTML);
        };
        that.appendChild = function (node) {
            inner.appendChild(node);
            return that;
        };
        that.getUniqueID = function () {
            return uniqueID;
        };
        that.getOuter = function () {
            return outer;
        };
        that.getInner = function () {
            return inner;
        };
        that.getParentNode = function () {
            return outer.parentNode;
        };
        that.getDomList = function () {
            return dom.list;
        };
        that.getDomListByKey = function (key) {
            return dom.list[key];
        };
        that.getDom = function (key, index) {
            if (!dom.list[key]) {
                return false;
            }
            return dom.list[key][index || 0];
        };
        return that;
    };

    function createModuleDialog (template, spec) {
        if (!template) {
            throw 'createModuleDialog need template as first parameter';
        }
        var conf;
        var layer;
        var that;
        var box;
        var title;
        var content;
        var close;
        var supportEsc;
        var beforeHideFn;
        var diaHide;
        var sup;
        /* supportEsc = true;
         var escClose = function () {
         if (supportEsc !== false) {
         layer.hide();
         }
         };*/
        var init = function () {
            conf = $.extend({
                't':null,
                'l':null,
                'width':null,
                'height':null
            }, spec);
            layer = createModuleLayer(template, conf);
            box = layer.getOuter();
            title = layer.getDom('title');
            content = layer.getDom('inner');
            close = layer.getDom('close');
            $(close).on('click', function (e) {
                e.preventDefault();
                diaHide();
                return false;
            });

            /*$.evt.custEvent.add(layer, 'show', function () {
             $.hotKey.add(document.documentElement, ['esc'], escClose, {'type':'keyup', 'disableInInput':true});
             });
             $.evt.custEvent.add(layer, 'hide', function () {
             $.hotKey.remove(document.documentElement, ['esc'], escClose, {'type':'keyup'});
             supportEsc = true;
             });*/

        };
        init();
        sup = util.obj.objSup(layer, ['show', 'hide']);
        diaHide = function (isForce) {
            if (typeof beforeHideFn === 'function' && !isForce) {
                if (beforeHideFn() === false) {
                    return false;
                }
            }
            sup.hide();
            if (util.dom.contains(document.body, layer.getOuter())) {
                document.body.removeChild(layer.getOuter());
            }
            return that;
        };

        that = layer;

        that.show = function () {
            if (!util.dom.contains(document.body, layer.getOuter())) {
                document.body.appendChild(layer.getOuter());
            }
            sup.show();
            return that;
        };
        that.hide = diaHide;

        that.setPosition = function (pos) {
            box.style.top = pos['t'] + 'px';
            box.style.left = pos['l'] + 'px';
            return that;
        };
        that.setMiddle = function () {
            var winWidth = $(window).width();
            var winHeight = $(window).height();
            var dia = layer.getSize(true);
            var _top = $(document).scrollTop() + (winHeight - dia.h) / 2;
            box.style.top = _top < 0 ? 0 : _top + 'px';
            box.style.left = (winWidth - dia.w) / 2 + 'px';
            return that;
        };
        that.setTitle = function (txt) {
            title.innerHTML = txt;
            return that;
        };
        that.setContent = function (cont) {
            if (typeof cont === 'string') {
                content.innerHTML = cont;
            } else {
                content.appendChild(cont);
            }
            return that;
        };
        that.clearContent = function () {
            while (content.children.length) {
                $(content.children[0]).remove();
            }
            return that;
        };
        that.setBeforeHideFn = function (fn) {
            beforeHideFn = fn;
        };
        that.clearBeforeHideFn = function () {
            beforeHideFn = null;
        };
        /* that.unsupportEsc = function () {
         supportEsc = false;
         };
         that.supportEsc = function () {
         supportEsc = true;
         };*/
        return that;
    };

    function createModulePopup (spec) {
        var TEMP = [
            '<div class="W_layer" node-type="outer" style="display:none;position:absolute;z-index:10001">',
                '<div class="bg">',
                    '<table border="0" cellspacing="0" cellpadding="0">',
                        '<tbody>',
                            '<tr>',
                                '<td>',
                                    '<div class="content">',
                                        '<div class="title" node-type="title">',
                                            '<span node-type="title_content"></span>',
                                        '</div>',
                                        '<a href="javascript:void(0);" class="W_close" title="关闭" node-type="close"></a>',
                                        '<div node-type="inner"></div>',
                                    '</div>',
                                '</td>',
                            '</tr>',
                        '</tbody>',
                    '</table>',
                '</div>',
            '</div>'
        ].join('');

        var cache = null, conf;

        var createDialog = function () {
            var dia = createModuleDialog(conf['template']);
            if(conf.isMask){
                util.evt.custEvent.add(dia, 'show', function () {
                    createModuleMask.showUnderNode(dia.getOuter());
                });
                util.evt.custEvent.add(dia, 'hide', function () {
                    createModuleMask.back();
                    dia.setMiddle();
                });
            }
            if(conf.isDrag){
                drag.drag(dia.getDom('title'), {
                    'actObj': dia,
                    'moveDom': dia.getOuter()
                });
            }
            dia.destroy = function () {
                clearDialog(dia);
                try {
                    dia.hide(true);
                } catch (exp) {

                }
            };
            return dia;
        };

        var clearDialog = function (dia) {
            dia.setTitle('').clearContent();
        };

        conf = $.extend({
            'template': TEMP,
            'isHold': false,
            'isMask': true,
            'isDrag': true
        }, spec);
        var isHold = conf['isHold'];
        conf = util.obj.cut(conf, ['isHold']);
        //      if(!cache){
        //          cache = $.kit.extra.reuse(createDialog);
        //      }
        var that = createDialog();
        if (!isHold) {
            util.evt.custEvent.add(that, 'hide', function () {
                util.evt.custEvent.remove(that, 'hide', arguments.callee);
                clearDialog(that);
            });
        }
        return that;
    };

    function litePrompt(msg, spec) {
        var conf;
        var that;
        var layer;
        var tm;
        var box;
        var spec = $.extend({
            hideCallback: function(){},
            type: 'succM', //del/succ/error/warn
            msg: '', //信息
            timeout:''
        }, spec);
        var template = spec.template ||
        '<#et temp data>'+
            '<div class="W_layer" node-type="outer">'+
                '<div class="bg">'+
                    '<table cellspacing="0" cellpadding="0" border="0">' +
                        '<tbody><tr><td>' +
                            '<div class="content layer_mini_info_big" node-type="inner">'+
                                '<p class="clearfix"><span class="icon_${data.type}"></span>${data.msg}&nbsp; &nbsp; &nbsp;</p>'+
                            '</div>' +
                        '</td></tr></tbody>' +
                    '</table>'+
                '</div>'+
            '</div>'+
        '</#et>';

        var finalTemplate = util.easyTemplate(template, {
            type: spec.type,
            msg: msg
        }).toString();

        that = {};
        layer = createModuleLayer(finalTemplate);
        box = layer.getOuter();
        util.evt.custEvent.add(layer, 'hide', function(){
            createModuleMask.hide();
            spec.hideCallback && spec.hideCallback();
            util.evt.custEvent.remove(layer,'hide',arguments.callee);
            clearTimeout(tm);
        });
        util.evt.custEvent.add(layer, 'show', function(){
            document.body.appendChild(box);
            createModuleMask.showUnderNode(box);
        });
        layer.show();

        if(spec['timeout']){
            tm = setTimeout(layer.hide,spec['timeout']);
        }

        var winWidth = $(window).width();
        var winHeight = $(window).height();
        var dia = layer.getSize(true);
        box.style.top = $(document).scrollTop() + (winHeight - dia.h)/2 + 'px';
        box.style.left = (winWidth - dia.w)/2 + 'px';

        that.layer = layer;
        return that;
    };



    var hogan = require('hogan');
    /**
     * alert框
     * @return {[type]} [description]
     */
    function alertPopup(msg) {
        var MSGTPL = ''
            + '<div class="detail">'
            +     '<div class="clearfix">'
            +         '<div>'
            +             '<p>{{msg}}</p>'
            +         '</div>'
            +         '<div class="btn">'
            +             '<a class="W_btn_a" href="javascript:void(0);" '
            +                   'node-type="cancel_btn">'
            +                 '<span>确认</span>'
            +             '</a>'
            +         '</div>'
            +     '</div>'
            + '</div>';

        var MSGHTML = hogan.compile(MSGTPL).render({
            msg: msg
        });
        var msgPopup = createModulePopup();
        msgPopup.setTitle('提示');
        msgPopup.setContent(MSGHTML);
        msgPopup.show();
        msgPopup.setMiddle();
        var msgNodes = util.dom.parseDOM(
            util.dom.builder(msgPopup.getInner()).list
        );
        $(msgNodes.cancel_btn).on('click', function () {
            msgPopup.destroy();
        });
    }

    return {
        createModulePopup: createModulePopup,
        litePrompt: litePrompt,
        alertPopup: alertPopup,
        createModuleMask: createModuleMask
    }
});