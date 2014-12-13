(function ($) {
    var maskNode, nodeRegList = [], domFix, maskInBody = false, maskNodeKey = "Lilac-Mask-Key";
    var _beforeFixFn;
    //初始化遮罩容器
    function initMask() {
        if(!maskNode){
            maskNode = $.C("div");
        }
        var _html = '<div node-type="outer">';
        if ($.browser.IE6) {
            _html += '<div style="position:absolute;width:100%;height:100%;"></div>';
        }
        _html += '</div>';
        maskNode = $.builder(_html).list["outer"][0];
        document.body.appendChild(maskNode);
        maskInBody = true;
        domFix = $(maskNode).fixPos("lt");
        _beforeFixFn = function () {
            var _winSize = $.lo.winSize();
            maskNode.style.cssText = $.cssText(maskNode.style.cssText)
                .push("width", _winSize.width + "px")
                .push("height", _winSize.height + "px").getCss();
        };

        $.evt.add($(window), 'resize', _beforeFixFn);
        $.evt.custEvent.add(domFix, "beforeFix", _beforeFixFn);
        _beforeFixFn();
    }

    function getNodeMaskReg(node) {
        var keyValue;
        if (!(keyValue = node.getAttribute(maskNodeKey))) {
            node.setAttribute(maskNodeKey, keyValue = $.getUniqueKey());
        }
        return '>' + node.tagName.toLowerCase() + '[' + maskNodeKey + '="' + keyValue + '"]';
    }

    $.extend({
        createModuleMask:{
            getNode:function () {
                return maskNode;
            },
            show:function (option, cb) {
                if (maskInBody) {
                    option = $.extend({
                        opacity:0.3,
                        background:"#000000"
                    }, option);
                    maskNode.style.background = option.background;
                    $(maskNode).setStyle("opacity", option.opacity);
                    maskNode.style.display = "";
                    domFix.setAlign("lt");
                    cb && cb();
                } else {
                    initMask();
                    $.createModuleMask.show(option, cb);
                }
                return $.createModuleMask;
            },
            hide:function () {
                maskNode && (maskNode.style.display = "none");
                nowIndex = undefined;
                nodeRegList = [];
                return $.createModuleMask;
            },
            showUnderNode:function (elem, option) {
                if ($(elem).isNode()) {
                    $.createModuleMask.show(option, function () {
                        $(maskNode).setStyle('zIndex', $(elem).getStyle('zIndex'));
                        var keyValue = getNodeMaskReg(elem);
                        var keyIndex = $.arr.indexOf(nodeRegList, keyValue);
                        if (keyIndex != -1) {
                            nodeRegList.splice(keyIndex, 1);
                        }
                        nodeRegList.push(keyValue);
                        $(elem).insertElement(maskNode, "beforebegin");
                    });
                }
                return $.createModuleMask;
            },
            back:function () {
                if (nodeRegList.length < 1) {
                    return $.createModuleMask;
                }
                var elem, nodeReg;
                nodeRegList.pop();
                if (nodeRegList.length < 1) {
                    $.createModuleMask.hide();
                } else if ((nodeReg = nodeRegList[nodeRegList.length - 1]) && (elem = $.sizzle(nodeReg, document.body)[0])) {
                    $(maskNode).setStyle("zIndex", $(elem).getStyle("zIndex"));
                    $(elem).insertElement(maskNode, "beforebegin");
                } else {
                    $.createModuleMask.back();
                }
                return $.createModuleMask;
            },
            destroy:function () {
                $.evt.custEvent.remove(domFix);
                $.evt.remove($(window), 'resize', _beforeFixFn);
                maskNode.style.display = "none";
                lastNode = undefined;
                _cache = {};
            }
        },

        createModuleLayer:function (template) {
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
                    posi = $(el).getPos();
                    el.style.display = 'none';
                    el.style.visibility = 'visible';
                }
                else {
                    posi = $(el).getPos();
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

            var dom = $.builder(template);
            var outer = dom.list['outer'][0], inner = dom.list['inner'][0];
            var uniqueID = $(outer).uniqueID();
            var that = {};
            //事件 显示 隐藏
            var custKey = $.evt.custEvent.define(that, "show");
            $.evt.custEvent.define(custKey, "hide");

            var sizeCache = null;
            that.show = function () {
                outer.style.display = '';
                $.evt.custEvent.fire(custKey, "show");
                return that;
            };
            that.hide = function () {
                outer.style.display = 'none';
                $.evt.custEvent.fire(custKey, "hide");
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
                    inner.innerHTML = $.encodeHTML(str);
                }
                return $.decodeHTML(inner.innerHTML);
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

        },

        createModuleDialog:function (template, spec) {
            if (!template) {
                throw 'createModuleDialog need template as first parameter';
            }
            var conf, layer, that, box, title, content, close, supportEsc, beforeHideFn, diaHide, sup;
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
                layer = $.createModuleLayer(template, conf);
                box = layer.getOuter();
                title = layer.getDom('title');
                content = layer.getDom('inner');
                close = layer.getDom('close');
                $(close).addEvent('click', function (e) {
                    $.evt.preventDefault(e);
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
            sup = $.objSup(layer, ['show', 'hide']);
            diaHide = function (isForce) {
                if (typeof beforeHideFn === 'function' && !isForce) {
                    if (beforeHideFn() === false) {
                        return false;
                    }
                }
                sup.hide();
                if ($.contains(document.body, layer.getOuter())) {
                    document.body.removeChild(layer.getOuter());
                }
                return that;
            };

            that = layer;

            that.show = function () {
                if (!$.contains(document.body, layer.getOuter())) {
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
                var win = $.lo.winSize();
                var dia = layer.getSize(true);
                var _top = $.scrollPos()['top'] + (win.height - dia.h) / 2;
                box.style.top = _top < 0 ? 0 : _top + 'px';
                box.style.left = (win.width - dia.w) / 2 + 'px';
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
                    $(content.children[0]).removeNode();
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

        },

        createModulePopup:function (spec) {
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
                var dia = $.createModuleDialog(conf['template']);
                if(conf.isMask){
                    $.evt.custEvent.add(dia, 'show', function () {
                        $.createModuleMask.showUnderNode(dia.getOuter());
                    });
                    $.evt.custEvent.add(dia, 'hide', function () {
                        $.createModuleMask.back();
                        dia.setMiddle();
                    });
                }
                if(conf.isDrag){
                    $.drag(dia.getDom('title'), {
                        'actObj':dia,
                        'moveDom':dia.getOuter()
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
                'template':TEMP,
                'isHold':false,
                'isMask': true,
                'isDrag': true
            }, spec);
            var isHold = conf['isHold'];
            conf = $.cut(conf, ['isHold']);
            //		if(!cache){
            //			cache = $.kit.extra.reuse(createDialog);
            //		}
            var that = createDialog();
            if (!isHold) {
                $.evt.custEvent.add(that, 'hide', function () {
                    $.evt.custEvent.remove(that, 'hide', arguments.callee);
                    clearDialog(that);
                });
            }
            return that;

        },

        litePrompt: function(msg, spec){
            var conf, that, layer, tm, box;
            var spec = $.extend({
                hideCallback: function(){},
                type: "succM", //del/succ/error/warn
                msg: "", //信息
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

            var finalTemplate = $.easyTemplate(template, {
                type: spec.type,
                msg: msg
            }).toString();

            that = {};
            layer = $.createModuleLayer(finalTemplate);
            box = layer.getOuter();
            $.evt.custEvent.add(layer, 'hide', function(){
                $.createModuleMask.hide();
                spec.hideCallback && spec.hideCallback();
                $.evt.custEvent.remove(layer,'hide',arguments.callee);
                clearTimeout(tm);
            });
            $.evt.custEvent.add(layer, 'show', function(){
                document.body.appendChild(box);
                $.createModuleMask.showUnderNode(box);
            });
            layer.show();

            if(spec['timeout']){
                tm = setTimeout(layer.hide,spec['timeout']);
            }

            var win = $.lo.winSize();
            var dia = layer.getSize(true);
            box.style.top = $.scrollPos()['top'] + (win.height - dia.h)/2 + 'px';
            box.style.left = (win.width - dia.w)/2 + 'px';

            that.layer = layer;
            return that;
        }
    });
})(Lilac);
