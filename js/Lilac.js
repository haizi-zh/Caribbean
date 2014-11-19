(function (window, undefined) {
    var document = window.document, location = window.location, navigator = window.navigator;

    // Lilac 继承自 Lilac.lo
    // Lilac.lo.init 继承自 Lilac.lo
    // Lilac 指向 Lilac.lo.init ，
    var Lilac = function (selector, context) {
        return new Lilac.lo.init(selector, context || document);
    };

    // Lilac.lo 里面的方法会挂载到 Lilac 对象上 ( lo 即 Lilac Obj )
    // Lilac.prototype = Lilac.lo 让 Lilac 继承自 Lilac.lo
    Lilac.prototype = Lilac.lo = {
        // constructor:Lilac,
        init:function (selector, context) {
            if (selector.nodeType) {
                this[0] = selector;
                return this;
            } else {
                if (typeof (selector) == "string") {
                    var el;
                    if (selector.charAt(0) == '#') {
                        el = document.getElementById(selector.replace('#', ''));
                        if(el){
                            return Lilac(el);
                        }else{
                            return undefined;
                        }
                    } else {
                        return Lilac(Lilac.sizzle(selector, context));
                    }
                } else {
                    Array.prototype.push.apply(this, Lilac.arr.toArray(selector));
                    return this;
                }
            }
        },

        winSize:function (_target) {
            var w, h;
            var target;
            if (_target) {
                target = _target.document;
            }
            else {
                target = document;
            }

            if (target.compatMode === "CSS1Compat") {
                w = target.documentElement[ "clientWidth" ];
                h = target.documentElement[ "clientHeight" ];
            } else if (self.innerHeight) { // all except Explorer
                if (_target) {
                    target = _target.self;
                }
                else {
                    target = self;
                }
                w = target.innerWidth;
                h = target.innerHeight;

            } else if (target.documentElement && target.documentElement.clientHeight) { // Explorer 6 Strict Mode
                w = target.documentElement.clientWidth;
                h = target.documentElement.clientHeight;

            } else if (target.body) { // other Explorers
                w = target.body.clientWidth;
                h = target.body.clientHeight;
            }
            return {
                width:w,
                height:h
            };

        },

        pageSize: function(_target){
            var target;
            if (_target) {
                target = _target.document;
            }
            else {
                target = document;
            }
            var _rootEl = (target.compatMode == "CSS1Compat" ? target.documentElement : target.body);
            var xScroll, yScroll;
            var pageHeight, pageWidth;
            if (window.innerHeight && window.scrollMaxY) {
                xScroll = _rootEl.scrollWidth;
                yScroll = window.innerHeight + window.scrollMaxY;
            }
            else if (_rootEl.scrollHeight > _rootEl.offsetHeight) {
                xScroll = _rootEl.scrollWidth;
                yScroll = _rootEl.scrollHeight;
            }
            else {
                xScroll = _rootEl.offsetWidth;
                yScroll = _rootEl.offsetHeight;
            }
            var win_s = this.winSize(_target);
            if (yScroll < win_s.height) {
                pageHeight = win_s.height;
            }
            else {
                pageHeight = yScroll;
            }
            if (xScroll < win_s.width) {
                pageWidth = win_s.width;
            }
            else {
                pageWidth = xScroll;
            }
            return {
                'page':{
                    width:pageWidth,
                    height:pageHeight
                },
                'win':{
                    width:win_s.width,
                    height:win_s.height
                }
            };
        }
    };

    Lilac.prototype.constructor = Lilac; // 还原 Lilac 的 constructor

    Lilac.lo.init.prototype = Lilac.lo; // 让 Lilac.lo.init 继承自 Lilac.lo

    Lilac.lo.init.prototype.constructor = Lilac.lo.init; // 还原 Lilac.lo.init 的 constructor

    Lilac.extend = Lilac.lo.extend = function () {
        var target = arguments[0] || {},
            argsIndex = 1,
            length = arguments.length,
            obj;
        if (length == argsIndex) {
            target = this;
            --argsIndex;
        }
        if ((obj = arguments[argsIndex]) != null) {
            for (var name in obj) {
                var src = target[name],
                    copy = obj[name];
                if (target === copy) {
                    continue;
                }
                if (copy && typeof copy == "object" && !copy.nodeType) {
                    target[name] = Lilac.extend(src || (copy instanceof Array ? [] : {}), copy);
                } else if (copy !== undefined) {
                    target[name] = copy;
                }

            }
        }
        return target;
    };


    //-----------------------------------------------------------------------------------------------//
    //-----------------------------                Event                -----------------------------//
    //-----------------------------------------------------------------------------------------------//
    /**
     * Event 模块
     * @type {Object}
     */
    Lilac.evt = {
        /**
         * 绑定事件
         * @param lo    Lilac 对象
         * @param type  事件类型
         * @param cb    回调函数
         * @return {Boolean}
         */
        add:function (lo, type, cb) {
            elem = lo[0];
            if (elem == null) {
                return false;
            }
            if (typeof cb !== 'function') {
                return false;
            }
            if (elem.addEventListener) {
                elem.addEventListener(type, cb, false);
            } else if (elem.attachEvent) {
                elem.attachEvent('on' + type, cb);
            } else {
                elem['on' + type] = cb;
            }
            return true;
        },

        /**
         * 解除绑定事件
         * @param lo    Lilac 对象
         * @param type  事件类型
         * @param cb    回调函数
         * @return {Boolean}
         */
        remove:function (lo, type, cb) {
            elem = lo[0];
            if (elem == null) {
                return false;
            }
            if (typeof cb !== "function") {
                return false;
            }
            if (elem.removeEventListener) {
                elem.removeEventListener(type, cb, false);
            } else if (elem.detachEvent) {
                elem.detachEvent("on" + type, cb);
            }
            elem['on' + type] = null;
            return true;
        },

        /**
         * 阻止默认事件
         * @param e 事件对象
         */
        preventDefault:function (e) {
            e = e || Lilac.evt.getEvent();
            if (e.preventDefault) {
                e.preventDefault();
            } else {
                e.returnValue = false;
            }
        },

        /**
         * 获取事件对象
         */
        getEvent:(function () {
            if (document.addEventListener) {
                return function () {
                    var o = arguments.callee;
                    var e;
                    do {
                        e = o.arguments[0];
                        if (e && (e.constructor == Event || e.constructor == MouseEvent || e.constructor == KeyboardEvent)) {
                            return e;
                        }
                    } while (o = o.caller);
                    return e;
                };
            } else {
                return function (el, type, fn) {
                    return window.event;
                };
            }
        })(),

        /**
         * Fix the difference of event in each browser
         * @param e
         */
        fixEvent:function (e) {
            e = e || Lilac.evt.getEvent();
            if (!e.target) {
                e.target = e.srcElement || document;
            }
            if (e.pageX == null && e.clientX != null) {
                var html = document.documentElement;
                var body = document.body;

                e.pageX = e.clientX + (html.scrollLeft || body && body.scrollLeft || 0) - (html.clientLeft || body && body.clientLeft || 0);
                e.pageY = e.clientY + (html.scrollTop || body && body.scrollTop || 0) - (html.clientTop || body && body.clientTop || 0);
            }
            if (!e.which && e.button) {
                if (e.button & 1) {
                    e.which = 1;
                }
                else if (e.button & 4) {
                    e.which = 2;
                }
                else if (e.button & 2) {
                    e.which = 3;
                }
            }

            if (e.relatedTarget === undefined) {
                e.relatedTarget = e.fromElement || e.toElement;
            }

            if (e.layerX == null && e.offsetX != null) {
                e.layerX = e.offsetX;
                e.layerY = e.offsetY;
            }
            return e;
        },

        stopEvent: function(event){
            event = event || Lilac.evt.getEvent();
            if (event.preventDefault) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                event.cancelBubble = true;
                event.returnValue = false;
            }

            return false;
        },

        /**
         * 浏览器事件支持检测
         * @param evtName   需要检测的事件类型
         * @param tagName   HTML tagName
         */
        hasEvent:function (evtName, tagName) {
            var resCache = {};
            if (typeof tagName !== 'string') {
                throw new Error('[Lilac.evt.hasEvent] tagName is not a String!');
            }
            tagName = tagName.toLowerCase();
            evtName = 'on' + evtName;
            if (resCache[tagName] && resCache[tagName][evtName] !== undefined) {
                return resCache[tagName][evtName];
            }
            var el = Lilac.C(tagName),
                isSupported = (evtName in el);
            if (!isSupported) {
                el.setAttribute(evtName, 'return;');
                isSupported = typeof el[evtName] === 'function';
            }
            resCache[tagName] || (resCache[tagName] = {});
            resCache[tagName][evtName] = isSupported;
            el = null;
            return isSupported;
        },

        custEvent:(function () {
            var custEventAttribute = "__custEventKey__", custEventKey = 1, custEventCache = {};
            /**
             * 从缓存中查找相关对象
             * 当已经定义时
             *     有type时返回缓存中的列表 没有时返回缓存中的对象
             * 没有定义时返回false
             * @param {Object|number} obj 对象引用或获取的key
             * @param {String} type 自定义事件名称
             */
            var findCache = function (obj, type) {
                var _key = (typeof obj == "number") ? obj : obj[custEventAttribute];
                return (_key && custEventCache[_key]) && {
                    obj:(typeof type == "string" ? custEventCache[_key][type] : custEventCache[_key]),
                    key:_key
                };
            };
            //事件迁移相关
            var hookCache = {};//arr key -> {origtype-> {fn, desttype}}
            //
            var add = function (obj, type, fn, data, once) {
                if (obj && typeof type == "string" && fn) {
                    var _cache = findCache(obj, type);
                    if (!_cache || !_cache.obj) {
                        throw "custEvent (" + type + ") is undefined !";
                    }
                    _cache.obj.push({fn:fn, data:data, once:once});
                    return _cache.key;
                }
            };

            var fire = function (obj, type, args, defaultAction) {
                //事件默认行为阻止
                var preventDefaultFlag = true;
                var preventDefault = function () {
                    preventDefaultFlag = false;
                };
                if (obj && typeof type == "string") {
                    var _cache = findCache(obj, type), _obj;
                    if (_cache && (_obj = _cache.obj)) {
                        args = typeof args != 'undefined' && [].concat(args) || [];
                        for (var i = _obj.length - 1; i > -1 && _obj[i]; i--) {
                            var fn = _obj[i].fn;
                            var isOnce = _obj[i].once;
                            if (fn && fn.apply) {
                                try {
                                    fn.apply(obj, [
                                        {obj:obj, type:type, data:_obj[i].data, preventDefault:preventDefault}
                                    ].concat(args));
                                    if (isOnce) {
                                        _obj.splice(i, 1);
                                    }
                                } catch (e) {
                                    throw ("[error][custEvent]" + e.message, e, e.stack);
                                }
                            }
                        }

                        if (preventDefaultFlag && typeof (defaultAction) === 'function') {
                            defaultAction();
                        }
                        return _cache.key;
                    }
                }
            };

            var that = {
                /**
                 * 对象自定义事件的定义 未定义的事件不得绑定
                 * @method define
                 * @static
                 * @param {Object|number} obj 对象引用或获取的下标(key); 必选
                 * @param {String|Array} type 自定义事件名称; 必选
                 * @return {number} key 下标
                 */
                define:function (obj, type) {
                    if (obj && type) {
                        var _key = (typeof obj == "number") ? obj : obj[custEventAttribute] || (obj[custEventAttribute] = custEventKey++),
                            _cache = custEventCache[_key] || (custEventCache[_key] = {});
                        type = [].concat(type);
                        for (var i = 0; i < type.length; i++) {
                            _cache[type[i]] || (_cache[type[i]] = []);
                        }
                        return _key;
                    }
                },
                /**
                 * 对象自定义事件的取消定义
                 * 当对象的所有事件定义都被取消时 删除对对象的引用
                 * @method define
                 * @static
                 * @param {Object|number} obj 对象引用或获取的(key); 必选
                 * @param {String} type 自定义事件名称; 可选 不填可取消所有事件的定义
                 */
                undefine:function (obj, type) {
                    if (obj) {
                        var _key = (typeof obj == "number") ? obj : obj[custEventAttribute];
                        if (_key && custEventCache[_key]) {
                            if (type) {
                                type = [].concat(type);
                                for (var i = 0; i < type.length; i++) {
                                    if (type[i] in custEventCache[_key]) delete custEventCache[_key][type[i]];
                                }
                            } else {
                                delete custEventCache[_key];
                            }
                        }
                    }
                },

                /**
                 * 事件添加或绑定
                 * @method add
                 * @static
                 * @param {Object|number} obj 对象引用或获取的(key); 必选
                 * @param {String} type 自定义事件名称; 必选
                 * @param {Function} fn 事件处理方法; 必选
                 * @param {Any} data 扩展数据任意类型; 可选
                 * @return {number} key 下标
                 */
                add:function (obj, type, fn, data) {
                    return add(obj, type, fn, data, false);
                },
                /**
                 * 单次事件绑定
                 * @method once
                 * @static
                 * @param {Object|number} obj 对象引用或获取的(key); 必选
                 * @param {String} type 自定义事件名称; 必选
                 * @param {Function} fn 事件处理方法; 必选
                 * @param {Any} data 扩展数据任意类型; 可选
                 * @return {number} key 下标
                 */
                once:function (obj, type, fn, data) {
                    return add(obj, type, fn, data, true);
                },
                /**
                 * 事件删除或解绑
                 * @method remove
                 * @static
                 * @param {Object|number} obj 对象引用或获取的(key); 必选
                 * @param {String} type 自定义事件名称; 可选; 为空时删除对象下的所有事件绑定
                 * @param {Function} fn 事件处理方法; 可选; 为空且type不为空时 删除对象下type事件相关的所有处理方法
                 * @return {number} key 下标
                 */
                remove:function (obj, type, fn) {
                    if (obj) {
                        var _cache = findCache(obj, type), _obj, index;
                        if (_cache && (_obj = _cache.obj)) {
                            if (Lilac.arr.isArray(_obj)) {
                                if (fn) {
                                    //for (var i = 0; i < _obj.length && _obj[i].fn !== fn; i++);
                                    var i = 0;
                                    while (_obj[i]) {
                                        if (_obj[i].fn === fn) {
                                            break;
                                        }
                                        i++;
                                    }
                                    _obj.splice(i, 1);
                                } else {
                                    _obj.splice(0, _obj.length);
                                }
                            } else {
                                for (var i in _obj) {
                                    _obj[i] = [];
                                }
                            }
                            return _cache.key;
                        }
                    }
                },
                /**
                 * 事件触发
                 * @method fire
                 * @static
                 * @param {Object|number} obj 对象引用或获取的(key); 必选
                 * @param {String} type 自定义事件名称; 必选
                 * @param {Any|Array} args 参数数组或单个的其他数据; 可选
                 * @param {Function} defaultAction 触发事件列表结束后的默认Function; 可选 注：当args不需要时请用undefined/null填充,以保证该参数为第四个参数
                 * @return {number} key 下标
                 */
                fire:function (obj, type, args, defaultAction) {
                    return fire(obj, type, args, defaultAction);
                },
                /**
                 * 事件由源对象迁移到目标对象
                 * @method hook
                 * @static
                 * @param {Object} orig 源对象
                 * @param {Object} dest 目标对象
                 * @param {Object} typeMap 事件名称对照表
                 * {
                 *  	源事件名->目标事件名
                 * }
                 */
                hook:function (orig, dest, typeMap) {
                    if (!orig || !dest || !typeMap) {
                        return;
                    }
                    var destTypes = [],
                        origKey = orig[custEventAttribute],
                        origKeyCache = origKey && custEventCache[origKey],
                        origTypeCache,
                        destKey = dest[custEventAttribute] || (dest[custEventAttribute] = custEventKey++),
                        keyHookCache;
                    if (origKeyCache) {
                        keyHookCache = hookCache[origKey + '_' + destKey] || (hookCache[origKey + '_' + destKey] = {});
                        var fn = function (event) {
                            var preventDefaultFlag = true;
                            fire(dest, keyHookCache[event.type].type, Array.prototype.slice.apply(arguments, [1, arguments.length]), function () {
                                preventDefaultFlag = false
                            });
                            preventDefaultFlag && event.preventDefault();
                        };
                        for (var origType in typeMap) {
                            var destType = typeMap[origType];
                            if (!keyHookCache[origType]) {
                                if (origTypeCache = origKeyCache[origType]) {
                                    origTypeCache.push({fn:fn, data:undefined});
                                    keyHookCache[origType] = {
                                        fn:fn,
                                        type:destType
                                    };
                                    destTypes.push(destType);
                                }
                            }
                        }
                        that.define(dest, destTypes);
                    }
                },
                /**
                 * 取消事件迁移
                 * @method unhook
                 * @static
                 * @param {Object} orig 源对象
                 * @param {Object} dest 目标对象
                 * @param {Object} typeMap 事件名称对照表
                 * {
                		 * 	源事件名->目标事件名
                		 * }
                 */
                unhook:function (orig, dest, typeMap) {
                    if (!orig || !dest || !typeMap) {
                        return;
                    }
                    var origKey = orig[custEventAttribute],
                        destKey = dest[custEventAttribute],
                        keyHookCache = hookCache[origKey + '_' + destKey];
                    if (keyHookCache) {
                        for (var origType in typeMap) {
                            var destType = typeMap[origType];
                            if (keyHookCache[origType]) {
                                that.remove(orig, origType, keyHookCache[origType].fn);
                            }
                        }
                    }
                },
                /**
                 * 销毁
                 * @method destroy
                 * @static
                 */
                destroy:function () {
                    custEventCache = {};
                    custEventKey = 1;
                    hookCache = {};
                }
            }
            return that;
        })(),

        delegatedEvent: function(actEl,expEls){
            var checkContains = function (list, el) {
                for (var i = 0, len = list.length; i < len; i += 1) {
                    if (Lilac.contains(list[i], el)) {
                        return true;
                    }
                }
                return false;
            };

            if(!Lilac(actEl).isNode()){
                throw 'Lilac.evt.delegatedEvent need an Element as first Parameter';
            }
            if (!expEls) {
                expEls = [];
            }
            if (Lilac.arr.isArray(expEls)) {
                expEls = [expEls];
            }
            var evtList = {};
            var bindEvent = function (e) {
                var evt = Lilac.evt.fixEvent(e);
                var el = evt.target;
                var type = e.type;
                doDelegated(el, type, evt);
            };
            var doDelegated = function (el, type, evt) {
                var actionType = null;
                var changeTarget = function () {
                    var path, lis, tg;
                    path = el.getAttribute('lilac-target');
                    if (path) {
                        lis = Lilac.sizzle(path, actEl);
                        if (lis.length) {
                            tg = evt.target = lis[0];
                        }
                    }
                    changeTarget = function(){};
                    return tg;
                };
                var checkBuble = function () {
                    var tg = changeTarget() || el;
                    if (evtList[type] && evtList[type][actionType]) {
                        return evtList[type][actionType]({
                            'evt':evt,
                            'el':tg,
                            'box':actEl,
                            'data':Lilac.queryToJson(tg.getAttribute('action-data') || '')
                        });
                    } else {
                        return true;
                    }
                };
                if (checkContains(expEls, el)) {
                    return false;
                } else if (!Lilac.contains(actEl, el)) {
                    return false;
                } else {
                    while (el && el !== actEl) {
                        if (el.nodeType === 1) {
                            actionType = el.getAttribute('action-type');
                            if (actionType && checkBuble() === false) {
                                break;
                            }
                        }
                        el = el.parentNode;
                    }

                }
            };
            var that = {};
            /**
             * 添加代理事件
             * @method add
             * @param {String} funcName
             * @param {String} evtType
             * @param {Function} process
             * @return {void}
             * @example
             *         document.body.innerHTML = '<div id="outer"><a href="###" action_type="alert" action_data="test=123">test</a><div id="inner"></div></div>'
             *         var a = STK.core.evt.delegatedEvent($.E('outer'),$.E('inner'));
             *         a.add('alert','click',function(spec){window.alert(spec.data.test)});
             *
             */
            that.add = function (funcName, evtType, process) {
                if (!evtList[evtType]) {
                    evtList[evtType] = {};
                    $(actEl).addEvent(evtType, bindEvent);
                }
                var ns = evtList[evtType];
                ns[funcName] = process;
            };
            /**
             * 移出代理事件
             * @method remove
             * @param {String} funcName
             * @param {String} evtType
             * @return {void}
             * @example
             *         document.body.innerHTML = '<div id="outer"><a href="###" action_type="alert" action_data="test=123">test</a><div id="inner"></div></div>'
             *         var a = STK.core.evt.delegatedEvent($.E('outer'),$.E('inner'));
             *         a.add('alert','click',function(spec){window.alert(spec.data.test)});
             *         a.remove('alert','click');
             */
            that.remove = function (funcName, evtType) {
                if (evtList[evtType]) {
                    delete evtList[evtType][funcName];
                    if (Lilac.isEmpty(evtList[evtType])) {
                        delete evtList[evtType];
                        $(actEl).removeEvent(evtType, bindEvent);
                    }
                }
            };

            /**
             * 添加略过节点
             * @method pushExcept
             * @param {Node} el
             * @example
             *         document.body.innerHTML = '<div id="outer"><a href="###" action_type="alert" action_data="test=123">test</a><div id="inner"></div></div>'
             *         var a = STK.core.evt.delegatedEvent($.E('outer'));
             *         a.add('alert','click',function(spec){window.alert(spec.data.test)});
             *         a.pushExcept($.E('inner'));
             */
            that.pushExcept = function (el) {
                expEls.push(el);
            };

            /**
             * 移出略过节点
             * @method removeExcept
             * @param {Node} el
             * @example
             *         document.body.innerHTML = '<div id="outer"><a href="###" action_type="alert" action_data="test=123">test</a><div id="inner"></div></div>'
             *         var a = STK.core.evt.delegatedEvent($.E('outer'));
             *         a.add('alert','click',function(spec){window.alert(spec.data.test)});
             *         a.pushExcept($.E('inner'));
             *         a.removeExcept($.E('inner'));
             */
            that.removeExcept = function (el) {
                if (!el) {
                    expEls = [];
                } else {
                    for (var i = 0, len = expEls.length; i < len; i += 1) {
                        if (expEls[i] === el) {
                            expEls.splice(i, 1);
                        }
                    }
                }

            };
            /**
             * 晴空略过节点
             * @method clearExcept
             * @example
             *         document.body.innerHTML = '<div id="outer"><a href="###" action_type="alert" action_data="test=123">test</a><div id="inner"></div></div>'
             *         var a = STK.core.evt.delegatedEvent($.E('outer'));
             *         a.add('alert','click',function(spec){window.alert(spec.data.test)});
             *         a.pushExcept($.E('inner'));
             *         a.clearExcept();
             */
            that.clearExcept = function (el) {
                expEls = [];
            };
            /**
             * 支持外调action 非基于节点的代理事件触发
             * @method fireAction
             * @param {string} actionType
             * @param {string} evtType
             * @param {Event} [evt]
             * @param {hash} [params]
             * @example
             *         document.body.innerHTML = '<div id="outer"><a href="###" action_type="alert" action_data="test=123">test</a><div id="inner"></div></div>'
             *         var a = STK.core.evt.delegatedEvent($.E('outer'));
             *         a.add('alert','click',function(spec){window.alert(spec.data.test)});
             *         a.fireAction('alert', 'click', null, {
            		 * 			actionData : 'test1=1&test2=2'
            		 * 		});
             *
             */
            that.fireAction = function (actionType, evtType, evt, params) {
                var actionData = '';
                if (params && params['actionData']) {
                    actionData = params['actionData'];
                }
                if (evtList[evtType] && evtList[evtType][actionType]) {
                    evtList[evtType][actionType]({
                        'evt':evt,
                        'el':null,
                        'box':actEl,
                        'data':Lilac.queryToJson(actionData),
                        'fireFrom':'fireAction'
                    });
                }
            };
            /**
             * 支持外调节点 可以将某代理事件代理区域外节点的事件转嫁到该代理事件上
             * @method fireInject
             * @param {Element} dom
             * @param {string} evtType
             * @param {Event} [evt]
             * @example
             *         document.body.innerHTML = '<div id="outer"><a href="###" action_type="alert" action_data="test=123">test</a><div id="inner"></div></div><button id='inject'>click me!</button>'
             *         var a = STK.core.evt.delegatedEvent($.E('outer'));
             *         a.add('alert','click',function(spec){window.alert(spec.data.test)});
             *         var button = STK.E('inject');
             *         STK.addEvent(button, 'click', function(evt) {
            		 * 			a.fireInject(button, 'click', evt);
            		 * 		});
             */
            that.fireInject = function (dom, evtType, evt) {
                var actionType = dom.getAttribute('action-type');
                var actionData = dom.getAttribute('action-data');
                if (actionType && evtList[evtType] && evtList[evtType][actionType]) {
                    evtList[evtType][actionType]({
                        'evt':evt,
                        'el':dom,
                        'box':actEl,
                        'data':Lilac.queryToJson(actionData || ''),
                        'fireFrom':'fireInject'
                    });
                }
            };

            /**
             * 支持节点触发 解决直接fire节点的某事件不冒泡引起代理事件不生效而添加的方法
             * @method fireDom
             * @param {Element} dom
             * @param {string} evtType
             * @param {Event} [evt]
             * @example
             *         document.body.innerHTML = '<div id="outer"><a href="###" action_type="alert" action_data="test=123">test</a><div id="inner"></div></div>'
             *         var a = STK.core.evt.delegatedEvent($.E('outer'));
             *         a.add('alert','click',function(spec){window.alert(spec.data.test)});
             *         a.fireDom(a, 'click', null);
             */
            that.fireDom = function (dom, evtType, evt) {
                doDelegated(dom, evtType, evt || {});
            };
            /**
             * 销毁
             * @method destroy
             */
            that.destroy = function () {
                for (var k in evtList) {
                    for (var l in evtList[k]) {
                        delete evtList[k][l];
                    }
                    delete evtList[k];
                    $(actEl).removeEvent(k, bindEvent);
                }
            };
            return that;
        },

        hitTest: function(oNode, oEvent){
            function getNodeInfo(oNode) {
                var node = Lilac(oNode)[0];
                var pos = Lilac(node).getPos();
                var area = {
                    left: pos.l,
                    top: pos.t,
                    right: pos.l + node.offsetWidth,
                    bottom: pos.t + node.offsetHeight
                };
                return area;
            }
            var node1Area = getNodeInfo(oNode);
            if (oEvent == null) {
                oEvent = Lilac.evt.getEvent();
            }else if (oEvent.nodeType == 1) {
                var node2Area = getNodeInfo(oEvent);

                if (node1Area.right > node2Area.left && node1Area.left < node2Area.right &&
                    node1Area.bottom > node2Area.top && node1Area.top < node2Area.bottom) {
                    return true;
                }
                return false;
            }
            else if (oEvent.clientX == null) {
                throw 'Lilac.evt.hitTest: [' + oEvent + ':oEvent] is not a valid value';
            }

            var scrollPos = Lilac.scrollPos();

            var evtX = oEvent.clientX + scrollPos.left;
            var evtY = oEvent.clientY + scrollPos.top;


            return (evtX >= node1Area.left && evtX <= node1Area.right) && (evtY >= node1Area.top && evtY <= node1Area.bottom);
        }
    };

    /**
     * Event 模块挂载到 Lilac 对象上
     */
    Lilac.extend(Lilac.evt);

    /**
     * Event
     * Lilac.lo 的扩展方法会挂载到 Lilac(expr) 对象上
     */
    Lilac.lo.extend({
        addEvent:function (type, cb) {
            Lilac.evt.add(this, type, cb);
        },

        removeEvent:function (type, cb) {
            Lilac.evt.remove(this, type, cb);
        }
    });


    //-----------------------------------------------------------------------------------------------//
    //---------------------     Lilac.lo的扩展方法，会挂载到Lilac(expr)对象上     ----------------------//
    //---------------------                     DOM                            ----------------------//
    //-----------------------------------------------------------------------------------------------//
    Lilac.lo.extend({
        uniqueID:function () {
            var elem = this[0];
            return elem && (elem.uniqueID || (elem.uniqueID = Lilac.getUniqueKey()));
        },

        isNode:function () {
            var elem = this[0];
            return (elem != undefined) && Boolean(elem.nodeName) && Boolean(elem.nodeType);
        },

        addHTML:function (html) {
            var elem = this[0];
            if (elem.insertAdjacentHTML) {
                elem.insertAdjacentHTML('BeforeEnd', html);
            } else {
                var oRange = elem.ownerDocument.createRange();
                oRange.setStartBefore(elem);
                var oFrag = oRange.createContextualFragment(html);
                elem.appendChild(oFrag);
            }
            return Lilac(elem);
        },

        insertHTML:function (html, where) {
            var elem = this[0];
            where = where ? where.toLowerCase() : "beforeend";
            if (elem.insertAdjacentHTML) {
                switch (where) {
                    case "beforebegin":
                        elem.insertAdjacentHTML('BeforeBegin', html);
                        return Lilac(elem.previousSibling);
                    case "afterbegin":
                        elem.insertAdjacentHTML('AfterBegin', html);
                        return Lilac(elem.firstChild);
                    case "beforeend":
                        elem.insertAdjacentHTML('BeforeEnd', html);
                        return Lilac(elem.lastChild);
                    case "afterend":
                        elem.insertAdjacentHTML('AfterEnd', html);
                        return Lilac(elem.nextSibling);
                }
                throw 'Illegal insertion point -> "' + where + '"';
            }
            else {
                var range = elem.ownerDocument.createRange();
                var frag;
                switch (where) {
                    case "beforebegin":
                        range.setStartBefore(elem);
                        frag = range.createContextualFragment(html);
                        elem.parentNode.insertBefore(frag, elem);
                        return Lilac(elem.previousSibling);
                    case "afterbegin":
                        if (elem.firstChild) {
                            range.setStartBefore(elem.firstChild);
                            frag = range.createContextualFragment(html);
                            elem.insertBefore(frag, elem.firstChild);
                            return Lilac(elem.firstChild);
                        }
                        else {
                            elem.innerHTML = html;
                            return Lilac(elem.firstChild);
                        }
                        break;
                    case "beforeend":
                        if (elem.lastChild) {
                            range.setStartAfter(elem.lastChild);
                            frag = range.createContextualFragment(html);
                            elem.appendChild(frag);
                            return Lilac(elem.lastChild);
                        }
                        else {
                            elem.innerHTML = html;
                            return Lilac(elem.lastChild);
                        }
                        break;
                    case "afterend":
                        range.setStartAfter(elem);
                        frag = range.createContextualFragment(html);
                        elem.parentNode.insertBefore(frag, elem.nextSibling);
                        return Lilac(elem.nextSibling);
                }
                throw 'Illegal insertion point -> "' + where + '"';
            }
        },

        insertElement:function (element, where) {
            var elem = this[0];

            where = where ? where.toLowerCase() : "beforeend";
            switch (where) {
                case "beforebegin":
                    elem.parentNode.insertBefore(element, elem);
                    break;
                case "afterbegin":
                    elem.insertBefore(element, elem.firstChild);
                    break;
                case "beforeend":
                    elem.appendChild(element);
                    break;
                case "afterend":
                    if (elem.nextSibling) {
                        elem.parentNode.insertBefore(element, elem.nextSibling);
                    }
                    else {
                        elem.parentNode.appendChild(element);
                    }
                    break;
            }
            return Lilac(elem);
        },

        removeNode:function () {
            var elem = this[0];
            try {
                elem.parentNode.removeChild(elem);
            }
            catch (e) {
            }
            return this;
        },

        next:function () {
            var elem = this[0];
            var next = elem.nextSibling;
            while (next && next.nodeType !== 1) {
                next = next.nextSibling;
            }
            if (next) {
                return Lilac(next);
            } else {
                return Lilac(document);
            }
        },

        prev:function () {
            var elem = this[0];
            var prev = elem.previousSibling;
            while (prev && prev.nodeType !== 1) {
                prev = prev.previousSibling;
            }
            if (prev) {
                return Lilac(prev);
            } else {
                return Lilac(document);
            }
        },

        getPos:function (spec) {
            var generalPosition = function (el) {
                var box, scroll, body, docElem, clientTop, clientLeft;
                box = el.getBoundingClientRect();
                scroll = Lilac.scrollPos();
                body = el.ownerDocument.body;
                docElem = el.ownerDocument.documentElement;
                clientTop = docElem.clientTop || body.clientTop || 0;
                clientLeft = docElem.clientLeft || body.clientLeft || 0;
                return {
                    l:parseInt(box.left + scroll['left'] - clientLeft, 10) || 0,
                    t:parseInt(box.top + scroll['top'] - clientTop, 10) || 0
                };
            };

            var countPosition = function (el, shell) {
                var pos, parent;
                pos = [el.offsetLeft, el.offsetTop];
                parent = el.offsetParent;
                if (parent !== el && parent !== shell) {
                    while (parent) {
                        pos[0] += parent.offsetLeft;
                        pos[1] += parent.offsetTop;
                        parent = parent.offsetParent;
                    }
                }

                if (Lilac.browser.OPERA != -1 || (Lilac.browser.SAFARI != -1 && el.style.position == 'absolute')) {
                    pos[0] -= document.body.offsetLeft;
                    pos[1] -= document.body.offsetTop;
                }
                if (el.parentNode) {
                    parent = el.parentNode;
                }
                else {
                    parent = null;
                }
                while (parent && !/^body|html$/i.test(parent.tagName) && parent !== shell) { // account for any scrolled ancestors
                    if (parent.style.display.search(/^inline|table-row.*$/i)) {
                        pos[0] -= parent.scrollLeft;
                        pos[1] -= parent.scrollTop;
                    }
                    parent = parent.parentNode;
                }
                return {
                    l:parseInt(pos[0], 10),
                    t:parseInt(pos[1], 10)
                };
            };

            var elem = this[0];
            if (elem == document.body) {
                return false;
            }
            if (elem.parentNode == null) {
                return false;
            }
            if (elem.style.display == 'none') {
                return false;
            }

            var conf = Lilac.extend({
                'parent':null
            }, spec);

            if (elem.getBoundingClientRect) {// IE6+  FF3+ chrome9+ safari5+ opera11+
                if (conf.parent) {
                    var o = generalPosition(elem);
                    var p = generalPosition(conf.parent);
                    return {
                        'l':o.l - p.l,
                        't':o.t - p.t
                    };
                } else {
                    return generalPosition(elem);
                }
            } else { //old browser
                return countPosition(elem, conf.parent || document.body);
            }
        },

        setPos:function (pos) {
            var elem = this[0];
            var pos_style = this.getStyle('position');
            if (pos_style == "static") {
                this.setStyle('position', 'relative');
                pos_style = "relative";
            }
            var page_xy = this.getPos();
            if (page_xy == false) {
                return;
            }
            var delta = {
                'l':parseInt(this.getStyle('position', 'left'), 10),
                't':parseInt(this.getStyle('position', 'top'), 10)
            };

            if (isNaN(delta['l'])) {
                delta['l'] = (pos_style == "relative") ? 0 : elem.offsetLeft;
            }
            if (isNaN(delta['t'])) {
                delta['t'] = (pos_style == "relative") ? 0 : elem.offsetTop;
            }

            if (pos['l'] != null) {
                elem.style.left = pos['l'] - page_xy['l'] + delta['l'] + "px";
            }
            if (pos['t'] != null) {
                elem.style.top = pos['t'] - page_xy['t'] + delta['t'] + "px";
            }
            return Lilac(elem);
        },

        fixPos:function (type, offset) {
            var lo = this;
            var elem = lo[0];
            //dom 扩展数据
            var _canFix = !(Lilac.browser.IE6 || (document.compatMode !== "CSS1Compat" && Lilac.browser.IE)),
                _typeReg = /^(c)|(lt)|(lb)|(rt)|(rb)$/;

            function _visible() {
                return lo.getStyle("display") != "none";
            }

            function _createOffset(offset) {
                offset = Lilac.arr.isArray(offset) ? offset : [0, 0];
                for (var i = 0; i < 2; i++) {
                    if (typeof offset[i] != "number") offset[i] = 0;
                }
                return offset;
            }

            //处理div位置
            function _draw(elem, type, offset) {
                if (!_visible()) return;
                var _position = "fixed", _top, _left, _right, _bottom
                    , _width = elem.offsetWidth, _height = elem.offsetHeight
                    , _winSize = Lilac.lo.winSize(), _limitTop = 0, _limitLeft = 0
                    , _cssText = Lilac.cssText(elem.style.cssText);
                if (!_canFix) {
                    _position = 'absolute';
                    var _scrlPos = Lilac.scrollPos();
                    _limitTop = _top = _scrlPos.top;
                    _limitLeft = _left = _scrlPos.left;
                    switch (type) {
                        case 'lt'://左上
                            _top += offset[1];
                            _left += offset[0];
                            break;
                        case 'lb'://左下
                            _top += _winSize.height - _height - offset[1];
                            _left += offset[0];
                            break;
                        case 'rt'://右上
                            _top += offset[1];
                            _left += _winSize.width - _width - offset[0];
                            break;
                        case 'rb'://右下
                            _top += _winSize.height - _height - offset[1];
                            _left += _winSize.width - _width - offset[0];
                            break;
                        case 'c'://中心
                        default:
                            _top += (_winSize.height - _height) / 2 + offset[1];
                            _left += (_winSize.width - _width) / 2 + offset[0];
                    }
                    _right = _bottom = "";
                } else {
                    _top = _bottom = offset[1];
                    _left = _right = offset[0];
                    switch (type) {
                        case 'lt'://左上
                            _bottom = _right = "";
                            break;
                        case 'lb'://左下
                            _top = _right = "";
                            break;
                        case 'rt'://右上
                            _left = _bottom = "";
                            break;
                        case 'rb'://右下
                            _top = _left = "";
                            break;
                        case 'c'://中心
                        default:
                            _top = (_winSize.height - _height) / 2 + offset[1];
                            _left = (_winSize.width - _width) / 2 + offset[0];
                            _bottom = _right = "";
                    }
                }
                if (type == 'c') {
                    if (_top < _limitTop) _top = _limitTop;
                    if (_left < _limitLeft) _left = _limitLeft;
                }
                _cssText.push("position", _position)
                    .push("top", _top + "px")
                    .push("left", _left + "px")
                    .push("right", _right + "px")
                    .push("bottom", _bottom + "px");
                elem.style.cssText = _cssText.getCss();
            }

            var _type, _offset, _fixed = true, _ceKey;

            if (lo.isNode() && _typeReg.test(type)) {
                var that = {
                    /**
                     * 得到节点
                     * @method getNode
                     * @return {Node}
                     */
                    getNode:function () {
                        return elem;
                    },
                    /**
                     * 检测位置固定的可用性
                     * @method isFixed
                     * @return {Boolean}
                     */
                    isFixed:function () {
                        return _fixed;
                    },
                    /**
                     * 设置位置固定的可用性
                     * @method setFixed
                     * @param {Boolean} fixed 位置固定的可用性
                     * @return {Object} this
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
                            Lilac.evt.remove(window, "scroll", _evtFun);
                        }
                        Lilac.evt.remove(window, "resize", _evtFun);
                        Lilac.evt.custEvent.undefine(_ceKey);
                    }
                }
                _ceKey = Lilac.evt.custEvent.define(that, "beforeFix");
                that.setAlign(type, offset);
                function _evtFun(event) {
                    event = event || window.event;
                    /**
                     * 系统事件导致的重绘前事件
                     * @event beforeFix
                     * @param {String} type 事件类型  scroll/resize
                     */
                    Lilac.evt.custEvent.fire(_ceKey, "beforeFix", event.type);
                    if (_fixed && (!_canFix || _type == "c")) {
                        _draw(elem, _type, _offset);
                    }
                };
                if (!_canFix) {
                    Lilac.evt.add(window, "scroll", _evtFun);
                }
                Lilac.evt.add(window, "resize", _evtFun);
                return that;
            }
        }
    });


    //-----------------------------------------------------------------------------------------------//
    //---------------------     Lilac.lo的扩展方法，会挂载到Lilac(expr)对象上     ----------------------//
    //---------------------                     CSS                            ----------------------//
    //-----------------------------------------------------------------------------------------------//
    Lilac.lo.extend({
        getSize:function () {
            var _size = function (dom) {
                if (!Lilac(dom).isNode()) {
                    throw 'Lilac.lo.getSize need Element as first parameter';
                }
                return {
                    'width':dom.offsetWidth,
                    'height':dom.offsetHeight
                };
            };
            var _getSize = function (dom) {
                var ret = null;
                if (dom.style.display === 'none') {
                    dom.style.visibility = 'hidden';
                    dom.style.display = '';
                    ret = _size(dom);
                    dom.style.display = 'none';
                    dom.style.visibility = 'visible';
                } else {
                    ret = _size(dom);
                }
                return ret;
            };

            var elem = this[0];
            var ret = {};
            if (!elem.parentNode) {
                Lilac.hideContainer.appendChild(elem);
                ret = _getSize(elem);
                Lilac.hideContainer.removeChild(elem);
            } else {
                ret = _getSize(elem);
            }
            return ret;
        },

        hasClassName:function (clsName) {
            var elem = this[0];
            if (!elem) return false;
            return (new RegExp('(^|\\s)' + clsName + '($|\\s)').test(elem.className));
        },

        addClassName:function (clsName) {
            var elem = this[0];
            if (elem && elem.nodeType === 1) {
                if (!this.hasClassName(clsName)) {
                    elem.className = Lilac.trim(elem.className) + ' ' + clsName;
                }
            }
            return Lilac(elem);
        },

        removeClassName:function (clsName) {
            var elem = this[0];
            if (elem && elem.nodeType === 1) {
                if (this.hasClassName(clsName)) {
                    elem.className = elem.className.replace(new RegExp('(^|\\s)' + clsName + '($|\\s)'), ' ');
                }
            }
            return Lilac(elem);
        },

        toggleClassName:function (clsName) {
            var elem = this[0];
            if (this.hasClassName(clsName)) {
                this.removeClassName(clsName);
            } else {
                this.addClassName(clsName);
            }
        },

        getStyle:function (property) {
            function supportFilters() {
                if ('y' in supportFilters) {
                    return supportFilters.y;
                }
                return supportFilters.y = ('filters' in Lilac.C('div'));
            }

            var elem = this[0];
            if (supportFilters()) {
                switch (property) {
                    case "opacity":
                        var val = 100;
                        try {
                            val = elem.filters['DXImageTransform.Microsoft.Alpha'].opacity;
                        }
                        catch (e) {
                            try {
                                val = elem.filters('alpha').opacity;
                            }
                            catch (e) {
                            }
                        }
                        return val / 100;
                    case "float":
                        property = "styleFloat";
                    default:
                        var value = elem.currentStyle ? elem.currentStyle[property] : null;
                        return (elem.style[property] || value);
                }
            }
            else {
                // 浮动
                if (property == "float") {
                    property = "cssFloat";
                }
                // 获取集合
                try {
                    var computed = document.defaultView.getComputedStyle(elem, "");
                }
                catch (e) {
                }
                return elem.style[property] || computed ? computed[property] : null;
            }
        },

        setStyle:function (property, val) {
            function supportFilters() {
                if ('y' in supportFilters) {
                    return supportFilters.y;
                }
                return supportFilters.y = ('filters' in Lilac.C('div'));
            }

            var elem = this[0];
            if (supportFilters()) {
                switch (property) {
                    case "opacity":
                        elem.style.filter = "alpha(opacity=" + (val * 100) + ")";
                        if (!elem.currentStyle || !elem.currentStyle.hasLayout) {
                            elem.style.zoom = 1;
                        }
                        break;
                    case "float":
                        property = "styleFloat";
                    default:
                        elem.style[property] = val;
                }
            } else {
                if (property == "float") {
                    property = "cssFloat";
                }
                elem.style[property] = val;
            }
            return Lilac(elem);
        }
    });


    //-----------------------------------------------------------------------------------------------//
    //------------------------------------     Lilac类扩展方法     -----------------------------------//
    //-----------------------------------------------------------------------------------------------//
    Lilac.extend({
        ready:function (oFunc) {
            var funcList = [];
            var inited = false;
            var checkReady = function () {
                if (!inited) {
                    if (document.readyState === 'complete') {
                        return true;
                    }
                }
                return inited;
            };
            // 执行数组里的函数列表
            var execFuncList = function () {
                if (inited == true) {
                    return;
                }
                inited = true;

                for (var i = 0, len = funcList.length; i < len; i++) {
                    if (typeof (funcList[i]) === 'function') {
                        try {
                            funcList[i].call();
                        } catch (exp) {

                        }
                    }
                }
                funcList = [];
            };

            var scrollMethod = function () {
                if (checkReady()) {
                    execFuncList();
                    return;
                }
                try {
                    document.documentElement.doScroll("left");
                } catch (e) {
                    setTimeout(arguments.callee, 25);
                    return;
                }
                execFuncList();
            };

            var readyStateMethod = function () {
                if (checkReady()) {
                    execFuncList();
                    return;
                }
                setTimeout(arguments.callee, 25);
            };

            var domloadMethod = function () {
                Lilac(document).addEvent('DOMContentLoaded', execFuncList);
            };
            var windowloadMethod = function () {
                Lilac(window).addEvent('load', execFuncList);
            };

            if (!checkReady()) {
                if (Lilac.browser.IE && window === window.top) {
                    scrollMethod();
                }
                domloadMethod();
                readyStateMethod();
                windowloadMethod();
            }

            if (checkReady()) {
                if (typeof (oFunc) === 'function') {
                    oFunc.call();
                }
            } else {// 如果还没有DOMLoad, 则把方法传入数组
                funcList.push(oFunc);
            }
        },

        builder:function (sHTML, oSelector) {
            var isHTML = (typeof (sHTML) === "string");

            // 写入HTML
            var container = sHTML;

            if (isHTML) {
                container = Lilac.C('div');
                container.innerHTML = sHTML;
            }

            var domList, totalList;
            domList = {};

            if (oSelector) {
                for (key in selectorList) {
                    domList[key] = Lilac.sizzle(oSelector[key].toString(), container);
                }
            } else {
                totalList = Lilac.sizzle('[node-type]', container);
                for (var i = 0, len = totalList.length; i < len; i += 1) {
                    var key = totalList[i].getAttribute('node-type');
                    if (!domList[key]) {
                        domList[key] = [];
                    }
                    domList[key].push(totalList[i]);
                }
            }

            // 把结果放入到文档碎片中
            var domBox = sHTML;

            if (isHTML) {
                domBox = Lilac.C('buffer');
                while (container.childNodes[0]) {
                    domBox.appendChild(container.childNodes[0]);
                }
            }

            // 返回文档碎片跟节点列表
            return {
                'box':domBox,
                'list':domList
            };
        },

        trim:function (str) {
            if (typeof str !== 'string') {
                throw 'trim need a string as parameter';
            }
            var len = str.length;
            var s = 0;
            var reg = /(\u3000|\s|\t|\u00A0)/;

            while (s < len) {
                if (!reg.test(str.charAt(s))) {
                    break;
                }
                s += 1;
            }
            while (len > s) {
                if (!reg.test(str.charAt(len - 1))) {
                    break;
                }
                len -= 1;
            }
            return str.slice(s, len);
        },

        C:function (tagName) {
            var dom;
            tagName = tagName.toUpperCase();
            if (tagName == 'TEXT') {
                dom = document.createTextNode('');
            } else if (tagName == 'BUFFER') {
                dom = document.createDocumentFragment();
            } else {
                dom = document.createElement(tagName);
            }
            return dom;
        },

        browser:(function () {
            var ua = navigator.userAgent.toLowerCase();
            var external = window.external || '';
            var core, m, extra, version, os;

            var numberify = function (s) {
                var c = 0;
                return parseFloat(s.replace(/\./g, function () {
                    return (c++ == 1) ? '' : '.';
                }));
            };
            try {
                if ((/windows|win32/i).test(ua)) {
                    os = 'windows';
                } else if ((/macintosh/i).test(ua)) {
                    os = 'macintosh';
                } else if ((/rhino/i).test(ua)) {
                    os = 'rhino';
                }

                if ((m = ua.match(/applewebkit\/([^\s]*)/)) && m[1]) {
                    core = 'webkit';
                    version = numberify(m[1]);
                } else if ((m = ua.match(/presto\/([\d.]*)/)) && m[1]) {
                    core = 'presto';
                    version = numberify(m[1]);
                } else if (m = ua.match(/msie\s([^;]*)/)) {
                    core = 'trident';
                    version = 1.0;
                    if ((m = ua.match(/trident\/([\d.]*)/)) && m[1]) {
                        version = numberify(m[1]);
                    }
                } else if (/gecko/.test(ua)) {
                    core = 'gecko';
                    version = 1.0;
                    if ((m = ua.match(/rv:([\d.]*)/)) && m[1]) {
                        version = numberify(m[1]);
                    }
                }

                if (/world/.test(ua)) {
                    extra = 'world';
                } else if (/360se/.test(ua)) {
                    extra = '360';
                } else if ((/maxthon/.test(ua)) || typeof external.max_version == 'number') {
                    extra = 'maxthon';
                } else if (/tencenttraveler\s([\d.]*)/.test(ua)) {
                    extra = 'tt';
                } else if (/se\s([\d.]*)/.test(ua)) {
                    extra = 'sogou';
                }
            } catch (e) {
            }
            var ret = {
                'OS':os,
                'CORE':core,
                'Version':version,
                'EXTRA':(extra ? extra : false),
                'IE':/msie/.test(ua),
                'OPERA':/opera/.test(ua),
                'MOZ':/gecko/.test(ua) && !/(compatible|webkit)/.test(ua),
                'IE5':/msie 5 /.test(ua),
                'IE55':/msie 5.5/.test(ua),
                'IE6':/msie 6/.test(ua),
                'IE7':/msie 7/.test(ua),
                'IE8':/msie 8/.test(ua),
                'IE9':/msie 9/.test(ua),
                'SAFARI':!/chrome\/([\d.]*)/.test(ua) && /\/([\da-f.]*) safari/.test(ua),
                'CHROME':/chrome\/([\d.]*)/.test(ua),
                'IPAD':/\(ipad/i.test(ua),
                'IPHONE':/\(iphone/i.test(ua),
                'ITOUCH':/\(itouch/i.test(ua),
                'MOBILE':/mobile/i.test(ua)
            };
            return ret;
        })(),

        hideContainer:(function () {
            var hideDiv;
            var initDiv = function () {
                if (hideDiv) return;
                hideDiv = Lilac.C("div");
                hideDiv.style.cssText = "position:absolute;top:-9999px;left:-9999px;";
                document.getElementsByTagName("head")[0].appendChild(hideDiv);
            };

            var that = {
                appendChild:function (el) {
                    if (el.isNode()) {
                        initDiv();
                        hideDiv.appendChild(el[0]);
                    }
                },
                removeChild:function (el) {
                    if (el.isNode()) {
                        hideDiv && hideDiv.removeChild(el[0]);
                    }
                }
            };
            return that;
        })(),

        contains:function (parent, node) {
            if (parent === node) {
                return false;
            } else if (parent.compareDocumentPosition) {
                return ((parent.compareDocumentPosition(node) & 16) === 16);

            } else if (parent.contains && node.nodeType === 1) {
                return   parent.contains(node);

            } else {
                while (node = node.parentNode) {
                    if (parent === node) {
                        return true;
                    }
                }
            }
            return false;
        },

        scrollPos:function (oDocument) {
            oDocument = oDocument || document;
            var dd = oDocument.documentElement;
            var db = oDocument.body;
            return {
                top:Math.max(window.pageYOffset || 0, dd.scrollTop, db.scrollTop),
                left:Math.max(window.pageXOffset || 0, dd.scrollLeft, db.scrollLeft)
            };
        },

        /**
         * @example
         *  var a = Lilac.cssText($("#test1")[0].style.cssText);
         *  a.push("width", "150px").push("height", "40px");
         *  $("#test1")[0].style.cssText = a.getCss();
         */
        cssText:function (oldCss) {
            var _getNewCss = function (oldCss, addCss) {
                // 去没必要的空白
                var _newCss = (oldCss + ";" + addCss)
                    .replace(/(\s*(;)\s*)|(\s*(:)\s*)/g, "$2$4"), _m;
                //循环去除前后重复的前的那个 如 width:9px;height:0px;width:8px; -> height:0px;width:8px;
                while (_newCss && (_m = _newCss.match(/(^|;)([\w\-]+:)([^;]*);(.*;)?\2/i))) {
                    _newCss = _newCss.replace(_m[1] + _m[2] + _m[3], "");
                }
                return _newCss;
            };
            oldCss = oldCss || "";
            var _styleList = [];
            var that = {
                /**
                 * 向样式缓存列表里添加样式
                 * @method push
                 * @param {String} property 属性名
                 * @param {String} value 属性值
                 * @return {Object} this
                 */
                push:function (property, value) {
                    _styleList.push(property + ":" + value);
                    return that;
                }
                /**
                 * 从样式缓存列表删除样式
                 * @method remove
                 * @param {String} property 属性名
                 * @return {Object} this
                 */, remove:function (property) {
                    for (var i = 0; i < _styleList.length; i++) {
                        if (_styleList[i].indexOf(property + ":") == 0) {
                            _styleList.splice(i, 1);
                        }
                    }
                    return that;
                }
                /**
                 * 返回样式缓存列表
                 * @method getStyleList
                 * @return {Array} styleList
                 */, getStyleList:function () {
                    return _styleList.slice();
                }
                /**
                 * 得到·
                 * @method getCss
                 * @param {String} property 属性名
                 * @param {String} value 属性值
                 * @return {Object} this
                 */, getCss:function () {
                    return _getNewCss(oldCss, _styleList.join(";"));
                }
            };
            return that;
        },

        reuse:function (createFn, spec) {
            var conf, that, cache;
            conf = Lilac.extend({}, spec);
            cache = [];
            var create = function () {
                var ret = createFn();
                cache.push({
                    'store':ret,
                    'used':true
                });
                return ret;
            };
            var setUsed = function (obj) {
                Lilac.arr.foreach(cache, function (item, index) {
                    if (obj === item['store']) {
                        item['used'] = true;
                        return false;
                    }
                });
            };
            var setUnused = function (obj) {
                Lilac.arr.foreach(cache, function (item, index) {
                    if (obj === item['store']) {
                        item['used'] = false;
                        return false;
                    }
                });
            };
            var getOne = function () {
                for (var i = 0, len = cache.length; i < len; i += 1) {
                    if (cache[i]['used'] === false) {
                        cache[i]['used'] = true;
                        return cache[i]['store'];
                    }
                };
                return create();
            };
            that = {};
            that.setUsed = setUsed;
            that.setUnused = setUnused;
            that.getOne = getOne;
            that.getLength = function () {
                return cache.length;
            };
            return that;
        },

        getUniqueKey:(function () {
            var _loadTime = (new Date()).getTime().toString(), _i = 1;
            return function () {
                return _loadTime + (_i++);
            };
        })(),

        decodeHTML:function (str) {
            if (typeof str !== 'string') {
                throw 'decodeHTML need a string as parameter';
            }
            return str.replace(/&quot;/g, '"').
                replace(/&lt;/g, '<').
                replace(/&gt;/g, '>').
                replace(/&#39/g, '\'').
                replace(/&nbsp;/g, '\u00A0').
                replace(/&#32/g, '\u0020').
                replace(/&amp;/g, '\&');
        },

        encodeHTML:function (str) {
            if (typeof str !== 'string') {
                throw 'encodeHTML need a string as parameter';
            }
            return str.replace(/\&/g, '&amp;').
                replace(/"/g, '&quot;').
                replace(/\</g, '&lt;').
                replace(/\>/g, '&gt;').
                replace(/\'/g, '&#39;').
                replace(/\u00A0/g, '&nbsp;').
                replace(/(\u0020|\u000B|\u2028|\u2029|\f)/g, '&#32;');
        },

        objSup:function (obj, fList) {
            var that = {};
            for (var i = 0, len = fList.length; i < len; i += 1) {
                if (typeof obj[fList[i]] !== 'function') {
                    throw 'super need function list as the second paramsters';
                }
                that[fList[i]] = (function (fun) {
                    return function () {
                        return fun.apply(obj, arguments);
                    };
                })(obj[fList[i]]);
            }
            return that;
        },

        cut:function(obj, list){
            var ret = {};
            if (!Lilac.arr.isArray(list)) {
                throw 'Lilac.cut need array as second parameter';
            }
            for (var k in obj) {
                if (!Lilac.arr.inArray(k, list)) {
                    ret[k] = obj[k];
                }
            }
            return ret;
        },

        parseDOM: function(list){
            for (var a in list) {
                if (list[a] && (list[a].length == 1)) {
                    list[a] = list[a][0];
                }
            }
            return list;
        },

        isEmpty: function(o, isprototype){
            for (var k in o) {
                if (isprototype || o.hasOwnProperty(k)) {
                    return false;
                }
            }
            return true;
        },

        strToJson: function(source, reviver){
            var at,
                ch,
                escapee = {
                    '"': '"',
                    '\\': '\\',
                    '/': '/',
                    b: '\b',
                    f: '\f',
                    n: '\n',
                    r: '\r',
                    t: '\t'
                }, text,
                error = function(m){
                    throw {
                        name: 'SyntaxError',
                        message: m,
                        at: at,
                        text: text
                    };
                },
                next = function(c){
                    // If a c parameter is provided, verify that it matches the current character.

                    if (c && c !== ch) {
                        error("Expected '" + c + "' instead of '" + ch + "'");
                    }

                    // Get the next character. When there are no more characters,
                    // return the empty string.

                    ch = text.charAt(at);
                    at += 1;
                    return ch;
                },
                number = function(){
                    var number, string = '';

                    if (ch === '-') {
                        string = '-';
                        next('-');
                    }
                    while (ch >= '0' && ch <= '9') {
                        string += ch;
                        next();
                    }
                    if (ch === '.') {
                        string += '.';
                        while (next() && ch >= '0' && ch <= '9') {
                            string += ch;
                        }
                    }
                    if (ch === 'e' || ch === 'E') {
                        string += ch;
                        next();
                        if (ch === '-' || ch === '+') {
                            string += ch;
                            next();
                        }
                        while (ch >= '0' && ch <= '9') {
                            string += ch;
                            next();
                        }
                    }
                    number = +string;
                    if (isNaN(number)) {
                        error("Bad number");
                    }
                    else {
                        return number;
                    }
                },
                string = function(){

                    // Parse a string value.

                    var hex, i, string = '', uffff;

                    // When parsing for string values, we must look for " and \ characters.

                    if (ch === '"') {
                        while (next()) {
                            if (ch === '"') {
                                next();
                                return string;
                            }
                            else
                                if (ch === '\\') {
                                    next();
                                    if (ch === 'u') {
                                        uffff = 0;
                                        for (i = 0; i < 4; i += 1) {
                                            hex = parseInt(next(), 16);
                                            if (!isFinite(hex)) {
                                                break;
                                            }
                                            uffff = uffff * 16 + hex;
                                        }
                                        string += String.fromCharCode(uffff);
                                    }
                                    else
                                        if (typeof escapee[ch] === 'string') {
                                            string += escapee[ch];
                                        }
                                        else {
                                            break;
                                        }
                                }
                                else {
                                    string += ch;
                                }
                        }
                    }
                    error("Bad string");
                },
                white = function(){

                    // Skip whitespace.

                    while (ch && ch <= ' ') {
                        next();
                    }
                },
                word = function(){

                    // true, false, or null.

                    switch (ch) {
                        case 't':
                            next('t');
                            next('r');
                            next('u');
                            next('e');
                            return true;
                        case 'f':
                            next('f');
                            next('a');
                            next('l');
                            next('s');
                            next('e');
                            return false;
                        case 'n':
                            next('n');
                            next('u');
                            next('l');
                            next('l');
                            return null;
                    }
                    error("Unexpected '" + ch + "'");
                },
                value, // Place holder for the value function.
                array = function(){

                    // Parse an array value.

                    var array = [];

                    if (ch === '[') {
                        next('[');
                        white();
                        if (ch === ']') {
                            next(']');
                            return array; // empty array
                        }
                        while (ch) {
                            array.push(value());
                            white();
                            if (ch === ']') {
                                next(']');
                                return array;
                            }
                            next(',');
                            white();
                        }
                    }
                    error("Bad array");
                },
                object = function(){
                    var key, object = {};

                    if (ch === '{') {
                        next('{');
                        white();
                        if (ch === '}') {
                            next('}');
                            return object; // empty object
                        }
                        while (ch) {
                            key = string();
                            white();
                            next(':');
                            if (Object.hasOwnProperty.call(object, key)) {
                                error('Duplicate key "' + key + '"');
                            }
                            object[key] = value();
                            white();
                            if (ch === '}') {
                                next('}');
                                return object;
                            }
                            next(',');
                            white();
                        }
                    }
                    error("Bad object");
                };
                value = function(){

                    // Parse a JSON value. It could be an object, an array, a string, a number,
                    // or a word.

                    white();
                    switch (ch) {
                        case '{':
                            return object();
                        case '[':
                            return array();
                        case '"':
                            return string();
                        case '-':
                            return number();
                        default:
                            return ch >= '0' && ch <= '9' ? number() : word();
                    }
                };

            if(window.JSON && window.JSON.parse){
                return window.JSON.parse(source, reviver);
            }

            var result;

            text = source;
            at = 0;
            ch = ' ';
            result = value();
            white();
            if (ch) {
                error("Syntax error");
            }

            // If there is a reviver function, we recursively walk the new structure,
            // passing each name/value pair to the reviver function for possible
            // transformation, starting with a temporary root object that holds the result
            // in an empty key. If there is not a reviver function, we simply return the
            // result.

            return typeof reviver === 'function' ? (function walk(holder, key){
                var k, v, value = holder[key];
                if (value && typeof value === 'object') {
                    for (k in value) {
                        if (Object.hasOwnProperty.call(value, k)) {
                            v = walk(value, k);
                            if (v !== undefined) {
                                value[k] = v;
                            }
                            else {
                                delete value[k];
                            }
                        }
                    }
                }
                return reviver.call(holder, key, value);
            }({
                '': result
            }, '')) : result;
        },

        queryToJson: function(QS, isDecode){
            var _Qlist = Lilac.trim(QS).split("&");
            var _json = {};
            var _fData = function (data) {
                if (isDecode) {
                    return decodeURIComponent(data);
                } else {
                    return data;
                }
            };
            for (var i = 0, len = _Qlist.length; i < len; i++) {
                if (_Qlist[i]) {
                    var _hsh = _Qlist[i].split("=");
                    var _key = _hsh[0];
                    var _value = _hsh[1];
                    // 如果只有key没有value, 那么将全部丢入一个$nullName数组中
                    if (_hsh.length < 2) {
                        _value = _key;
                        _key = '$nullName';
                    }
                    // 如果缓存堆栈中没有这个数据
                    if (!_json[_key]) {
                        _json[_key] = _fData(_value);
                    }
                    // 如果堆栈中已经存在这个数据，则转换成数组存储
                    else {
                        if (Lilac.arr.isArray(_json[_key]) != true) {
                            _json[_key] = [_json[_key]];
                        }
                        _json[_key].push(_fData(_value));
                    }
                }
            }
            return _json;
        },

        jsonToQuery: function(JSON,isEncode){
            var _fdata   = function(data,isEncode){
                data = data == null? '': data;
                data = Lilac.trim(data.toString());
                if(isEncode){
                    return encodeURIComponent(data);
                }
                return data;

            };

            var _Qstring = [];
            if(typeof JSON == "object"){
                for(var k in JSON){
                    if(k === '$nullName'){
                        _Qstring = _Qstring.concat(JSON[k]);
                        continue;
                    }
                    if(JSON[k] instanceof Array){
                        for(var i = 0, len = JSON[k].length; i < len; i++){
                            _Qstring.push(k + "=" + _fdata(JSON[k][i],isEncode));
                        }
                    }else{
                        if(typeof JSON[k] != 'function'){
                            _Qstring.push(k + "=" +_fdata(JSON[k],isEncode));
                        }
                    }
                }
            }
            if(_Qstring.length){
                return _Qstring.join("&");
            }
            return "";
        },

        parseURL: function(url){
            var parse_url = /^(?:([A-Za-z]+):(\/{0,3}))?([0-9.\-A-Za-z]+\.[0-9A-Za-z]+)?(?::(\d+))?(?:\/([^?#]*))?(?:\?([^#]*))?(?:#(.*))?$/;
            var names = ['url', 'scheme', 'slash', 'host', 'port', 'path', 'query', 'hash'];
            var results = parse_url.exec(url);
            var that = {};
            for (var i = 0, len = names.length; i < len; i += 1) {
                that[names[i]] = results[i] || '';
            }
            return that;
        },

        URL: function(sURL,args){
            var opts = Lilac.extend({
                'isEncodeQuery'  : false,
                'isEncodeHash'   : false
            },args||{});
            var that = {};
            var url_json = Lilac.parseURL(sURL);

            var query_json = Lilac.queryToJson(url_json.query);
            var hash_json = Lilac.queryToJson(url_json.hash);

            /**
             * Describe 设置query值
             * @method setParam
             * @param {String} sKey
             * @param {String} sValue
             * @example
             */
            that.setParam = function(sKey, sValue){
                query_json[sKey] = sValue;
                return this;
            };
            /**
             * Describe 取得query值
             * @method getParam
             * @param {String} sKey
             * @example
             */
            that.getParam = function(sKey){
                return query_json[sKey];
            };
            /**
             * Describe 设置query值(批量)
             * @method setParams
             * @param {Json} oJson
             * @example
             */
            that.setParams = function(oJson){
                for (var key in oJson) {
                    that.setParam(key, oJson[key]);
                }
                return this;
            };
            /**
             * Describe 设置hash值
             * @method setHash
             * @param {String} sKey
             * @param {String} sValue
             * @example
             */
            that.setHash = function(sKey, sValue){
                hash_json[sKey] = sValue;
                return this;
            };
            /**
             * Describe 设置hash值
             * @method getHash
             * @param {String} sKey
             * @example
             */
            that.getHash = function(sKey){
                return hash_json[sKey];
            };
            /**
             * Describe 取得URL字符串
             * @method toString
             * @example
             */
            that.valueOf = that.toString = function(){
                var url = [];
                var query = Lilac.jsonToQuery(query_json, opts.isEncodeQuery);
                var hash = Lilac.jsonToQuery(hash_json, opts.isEncodeQuery);
                if (url_json.scheme != '') {
                    url.push(url_json.scheme + ':');
                    url.push(url_json.slash);
                }
                if (url_json.host != '') {
                    url.push(url_json.host);
                    if(url_json.port != ''){
                        url.push(':');
                        url.push(url_json.port);
                    }
                }
                url.push('/');
                url.push(url_json.path);
                if (query != '') {
                    url.push('?' + query);
                }
                if (hash != '') {
                    url.push('#' + hash);
                }
                return url.join('');
            };

            return that;
        },

        color: function(colorStr, spec){
            var analysisHash = /^#([a-fA-F0-9]{3,8})$/;
            var testRGBorRGBA = /^rgb[a]?\s*\((\s*([0-9]{1,3})\s*,){2,3}(\s*([0-9]{1,3})\s*)\)$/;
            var analysisRGBorRGBA = /([0-9]{1,3})/ig;
            var splitRGBorRGBA = /([a-fA-F0-9]{2})/ig;

            var analysis = function(str){
                var ret = [];
                var list = [];
                if(analysisHash.test(str)){
                    list = str.match(analysisHash);
                    if(list[1].length <= 4){
                        ret = Lilac.arr.foreach(list[1].split(''),function(value, index){
                            return parseInt(value + value, 16);
                        });
                    } else if( list[1].length <= 8) {
                        ret = Lilac.arr.foreach(list[1].match(splitRGBorRGBA),function(value, index){
                            return parseInt(value, 16);
                        });
                    }
                    return ret;
                }
                if(testRGBorRGBA.test(str)){
                    list = str.match(analysisRGBorRGBA);
                    ret = Lilac.arr.foreach(list, function(value, index){
                        return parseInt(value, 10);
                    });
                    return ret;
                }
                return false;
            };

            var ret = analysis(colorStr);
            if(!ret){
                return false;
            }
            var that = {};
            /**
             * Describe 获取red
             * @method getR
             * @return {Number}
             * @example
             */
            that.getR = function(){
                return ret[0];
            };
            /**
             * Describe 获取green
             * @method getG
             * @return {Number}
             * @example
             */
            that.getG = function(){
                return ret[1];
            };
            /**
             * Describe 获取blue
             * @method getB
             * @return {Number}
             * @example
             */
            that.getB = function(){
                return ret[2];
            };
            /**
             * Describe 获取alpha
             * @method getA
             * @return {Number}
             * @example
             */
            that.getA = function(){
                return ret[3];
            };
            return that;
        },

        merge: function(origin, cover, opts){
            var checkCell = function(obj){
                if(obj === undefined){
                    return true;
                }
                if(obj === null){
                    return true;
                }
                if(Lilac.arr.inArray( (typeof obj), ['number','string','function','boolean'])){
                    return true;
                }

                if($(obj).isNode()){
                    return true;
                }
                return false;
            };

            var deep = function(ret, key, coverItem){
                if(checkCell(coverItem)){
                    ret[key] = coverItem;
                    return;
                }
                if(Lilac.arr.isArray(coverItem)){
                    if(!Lilac.arr.isArray(ret[key])){
                        ret[key] = [];
                    }
                    for(var i = 0, len = coverItem.length; i < len; i += 1){
                        deep(ret[key], i, coverItem[i]);
                    }
                    return;
                }
                if(typeof coverItem === 'object'){
                    if(checkCell(ret[key]) || Lilac.arr.isArray(ret[key])){
                        ret[key] = {};
                    }
                    for(var k in coverItem){
                        deep(ret[key], k, coverItem[k]);
                    }
                    return;
                }
            };

            var merge = function(origin, cover, isDeep){
                var ret = {};
                if(isDeep){
                    for(var k in origin){
                        deep(ret, k, origin[k]);
                    }
                    for(var k in cover){
                        deep(ret, k, cover[k]);
                    }
                }else{
                    for(var k in origin){
                        ret[k] = origin[k];
                    }
                    for(var k in cover){
                        ret[k] = cover[k];
                    }
                }
                return ret;
            };

            var conf = Lilac.extend({
                'isDeep' : false
            }, opts);

            return merge(origin, cover, conf.isDeep);
        },

        easyTemplate: (function(){
            var easyTemplate = function(s,d){
                if(!s){return '';}
                if(s!==easyTemplate.template){
                    easyTemplate.template = s;
                    easyTemplate.aStatement = easyTemplate.parsing(easyTemplate.separate(s));
                }
                var aST = easyTemplate.aStatement;
                var process = function(d2){
                    if(d2){d = d2;}
                    return arguments.callee;
                };
                process.toString = function(){
                    return (new Function(aST[0],aST[1]))(d);
                };
                return process;
            };
            easyTemplate.separate = function(s){
                var r = /\\'/g;
                var sRet = s.replace(/(<(\/?)#(.*?(?:\(.*?\))*)>)|(')|([\r\n\t])|(\$\{([^\}]*?)\})/g,function(a,b,c,d,e,f,g,h){
                    if(b){return '{|}'+(c?'-':'+')+d+'{|}';}
                    if(e){return '\\\'';}
                    if(f){return '';}
                    if(g){return '\'+('+h.replace(r,'\'')+')+\'';}
                });
                return sRet;
            };
            easyTemplate.parsing = function(s){
                var mName,vName,sTmp,aTmp,sFL,sEl,aList,aStm = ['var aRet = [];'];
                aList = s.split(/\{\|\}/);
                var r = /\s/;
                while(aList.length){
                    sTmp = aList.shift();
                    if(!sTmp){continue;}
                    sFL = sTmp.charAt(0);
                    if(sFL!=='+'&&sFL!=='-'){
                        sTmp = '\''+sTmp+'\'';aStm.push('aRet.push('+sTmp+');');
                        continue;
                    }
                    aTmp = sTmp.split(r);
                    switch(aTmp[0]){
                        case '+et':mName = aTmp[1];vName = aTmp[2];aStm.push('aRet.push("<!--'+mName+' start--\>");');break;
                        case '-et':aStm.push('aRet.push("<!--'+mName+' end--\>");');break;
                        case '+if':aTmp.splice(0,1);aStm.push('if'+aTmp.join(' ')+'{');break;
                        case '+elseif':aTmp.splice(0,1);aStm.push('}else if'+aTmp.join(' ')+'{');break;
                        case '-if':aStm.push('}');break;
                        case '+else':aStm.push('}else{');break;
                        case '+list':aStm.push('if('+aTmp[1]+'.constructor === Array){with({i:0,l:'+aTmp[1]+'.length,'+aTmp[3]+'_index:0,'+aTmp[3]+':null}){for(i=l;i--;){'+aTmp[3]+'_index=(l-i-1);'+aTmp[3]+'='+aTmp[1]+'['+aTmp[3]+'_index];');break;
                        case '-list':aStm.push('}}}');break;
                        default:break;
                    }
                }
                aStm.push('return aRet.join("");');
                return [vName,aStm.join('')];
            };

            return easyTemplate;
        })(),

        bLength: function(str){
            if (!str) {
                return 0;
            }
            var aMatch = str.match(/[^\x00-\xff]/g);
            return (str.length + (!aMatch ? 0 : aMatch.length));
        },

        timer: (function(){
            return (function(){
                var that = {};


                var list = {};

                var refNum = 0;
                var clock = null;
                var allpause = false;

                var delay = 25;

                var loop = function(){
                    for (var k in list) {
                        if (!list[k]['pause']) {
                            list[k]['fun']();
                        }
                    }
                    return that;
                };

                that.add = function(fun){
                    if (typeof fun != 'function') {
                        throw ('The timer needs add a function as a parameters');
                    }
                    var key = '' +
                    (new Date()).getTime() +
                    (Math.random()) * Math.pow(10, 17);

                    list[key] = {
                        'fun': fun,
                        'pause': false
                    };
                    if (refNum <= 0) {
                        that.start();
                    }
                    refNum++;
                    return key;
                };

                that.remove = function(key){
                    if (list[key]) {
                        delete list[key];
                        refNum--;
                    }
                    if (refNum <= 0) {
                        that.stop();
                    }
                    return that;
                };

                that.pause = function(key){
                    if (list[key]) {
                        list[key]['pause'] = true;
                    }
                    return that;
                };

                that.play = function(key){
                    if (list[key]) {
                        list[key]['pause'] = false;
                    }
                    return that;
                };

                that.stop = function(){
                    clearInterval(clock);
                    clock = null;
                    return that;
                };

                that.start = function(){
                    clock = setInterval(loop, delay);
                    return that;
                };

                that.loop = loop;
                that.get = function(key){
                    if (key === 'delay') {
                        return delay;
                    }
                    if (key === 'functionList'){
                        return list;
                    }
                };

                that.set = function(key,value){
                    if(key === 'delay'){
                        if(typeof value === 'number'){
                            delay = Math.max(25,Math.min(value,200));
                        }
                    }
                };
                return that;
            })();
        })(),

        shine: function(el,spec){
            var revList = function(list){
                return list.slice(0,list.length - 1).concat(list.concat([]).reverse());//[1,2,3,4] ===> [1,2,3,4,3,2,1]
            };

            var conf = Lilac.extend({
                'start' : '#fff',
                'color' : '#fbb',
                'times' : 2,//2^n
                'step'  : 5
            },spec);
            var starts = conf['start'].split('');
            var colors = conf['color'].split('');
            var orbit = [];

            for(var i = 0; i < conf['step']; i += 1){// step for shine
                var str = starts[0];
                for(var j = 1; j < 4; j += 1){//about rgb
                    var sta = parseInt(starts[j],16);
                    var end = parseInt(colors[j],16);
                    str += Math.floor(parseInt(sta + (end - sta)*i/conf['step'],10)).toString(16);
                }
                orbit.push(str);
            }
            for(var i = 0; i < conf['times']; i += 1){//shine times 2^n
                orbit = revList(orbit);
            }

            var key = false;
            var timer = $.timer.add(function(){
                if(!orbit.length){
                    $.timer.remove(timer);
                    return;
                }
                if(key){
                    key = false;
                    return;
                }else{
                    key = true;
                }
                el.style.backgroundColor = orbit.pop();
            });
        },

        scrollTo: function(target,spec){
            if(!Lilac(target).isNode()){
                throw 'isNode need element as the first parameter';
            }

            var conf = Lilac.extend({
                'box' : document.documentElement,
                'top' : 0,
                'step' : 2,
                'onMoveStop' : null
            },spec);
            conf.step = Math.max(2,Math.min(10,conf.step));
            var orbit = [];
            var targetPos = Lilac(target).getPos();
            var boxPos;
            if(conf['box'] == document.documentElement){
                boxPos = {'t':0};
            }else{
                boxPos = Lilac(conf['box']).getPos();
            }

            var pos = Math.max(0, (targetPos ? targetPos['t'] : 0) - (boxPos ? boxPos['t'] : 0) - conf.top);
            var cur = conf.box === document.documentElement ? (conf.box.scrollTop || document.body.scrollTop || window.pageYOffset) : conf.box.scrollTop;
            while(Math.abs(cur - pos) > conf.step && cur !== 0){
                orbit.push(Math.round(cur + (pos - cur)*conf.step/10));
                cur = orbit[orbit.length - 1];
            }
            if(!orbit.length){
                orbit.push(pos);
            }
            var tm = Lilac.timer.add(function(){
                if(orbit.length){
                    if(conf.box === document.documentElement){
                        window.scrollTo(0,orbit.shift());
                    }else{
                        conf.box.scrollTop = orbit.shift();
                    }

                }else{
                    if(conf.box === document.documentElement){
                        window.scrollTo(0,pos);
                    }else{
                        conf.box.scrollTop = pos;
                    }
                    Lilac.timer.remove(tm);
                    if(typeof conf.onMoveStop === 'function'){
                        conf.onMoveStop();
                    }
                }
            });
        },

        cookie: (function() {
            var that = {
                set: function(sKey, sValue, oOpts){
                    var arr = [];
                    var d, t;
                    var cfg = Lilac.extend({
                        'expire': null,
                        'path': '/',
                        'domain': null,
                        'secure': null,
                        'encode': true
                    }, oOpts);

                    if (cfg.encode == true) {
                        sValue = escape(sValue);
                    }
                    arr.push(sKey + '=' + sValue);

                    if (cfg.path != null) {
                        arr.push('path=' + cfg.path);
                    }
                    if (cfg.domain != null) {
                        arr.push('domain=' + cfg.domain);
                    }
                    if (cfg.secure != null) {
                        arr.push(cfg.secure);
                    }
                    if (cfg.expire != null) {
                        d = new Date();
                        t = d.getTime() + cfg.expire * 3600000;
                        d.setTime(t);
                        arr.push('expires=' + d.toGMTString());
                    }
                    document.cookie = arr.join(';');
                },
                get: function(sKey){
                    sKey = sKey.replace(/([\.\[\]\$])/g, '\\\$1');
                    var rep = new RegExp(sKey + '=([^;]*)?;', 'i');
                    var co = document.cookie + ';';
                    var res = co.match(rep);
                    if (res) {
                        return res[1] || "";
                    }
                    else {
                        return '';
                    }
                },
                remove: function(sKey, oOpts){
                    oOpts = oOpts || {};
                    oOpts.expire = -10;
                    that.set(sKey, '', oOpts);
                }
            };
            return that;
        })()

    });


    //-----------------------------------------------------------------------------------------------//
    //--------------------------------------     Array操作    ---------------------------------------//
    //-----------------------------------------------------------------------------------------------//
    Lilac.arr = {};
    Lilac.extend(Lilac.arr, {
        findout: function(o, value){
            if (!Lilac.arr.isArray(o)) {
                throw 'the findout function needs an array as first parameter';
            }
            var k = [];
            for (var i = 0, len = o.length; i < len; i += 1) {
                if (o[i] === value) {
                    k.push(i);
                }
            }
            return k;
        },

        foreach:function (o, insp) {
            var arrForeach = function (o, insp) {
                var r = [];
                for (var i = 0, len = o.length; i < len; i += 1) {
                    var x = insp(o[i], i);
                    if (x === false) {
                        break;
                    } else if (x !== null) {
                        r[i] = x;
                    }
                }
                return r;
            };

            var objForeach = function (o, insp) {
                var r = {};
                for (var k in o) {
                    var x = insp(o[k], k);
                    if (x === false) {
                        break;
                    } else if (x !== null) {
                        r[k] = x;
                    }
                }
                return r;
            };
            if (Lilac.arr.isArray(o) || (o.length && o[0] !== undefined)) {
                return arrForeach(o, insp);
            } else if (typeof o === 'object') {
                return objForeach(o, insp);
            }
            return null;
        },

        isArray:function (o) {
            return Object.prototype.toString.call(o) === '[object Array]';
        },

        toArray:function (o) {
            if (Lilac.arr.isArray(o)) {
                return o;
            }
            var arr;
            try {
                arr = slice.call(o);
            } catch (e) {
                arr = [];
                var i = o.length;
                if( i == null || o.split || o.setInterval || o.call ){
                    arr[0] = o;
                }else{
                    while (i) {
                        arr[--i] = o[i];
                    }
                }
            }
            return arr;
        },

        removeArrByIndex:function (index, arr) {
            for (var i = 0, n = 0; i < arr.length; i++) {
                if (arr[i] != arr[index]) {
                    arr[n++] = arr[i];
                }
            }
            arr.length -= 1;
            return arr;
        },

        indexOf:function (elem, arr) {
            if (arr.indexOf) {
                return arr.indexOf(elem);
            }
            for (var i = 0, len = arr.length; i < len; i++) {
                if (arr[i] === elem) {
                    return i;
                }
            }
            return -1;
        },

        inArray: function(oElement, aSource){
            return Lilac.arr.indexOf(oElement, aSource) > -1;
        }
    });

    //-----------------------------------------------------------------------------------------------//
    //----------------------------------------     ani动画    ---------------------------------------//
    //-----------------------------------------------------------------------------------------------//
    Lilac.ani = {};
    Lilac.extend(Lilac.ani, {
        algorithm: (function(){
            var algorithm = {
                'linear':function (t, b, c, d, s) {
                    return c * t / d + b;
                },

                'easeincubic':function (t, b, c, d, s) {
                    return c * (t /= d) * t * t + b;
                },

                'easeoutcubic':function (t, b, c, d, s) {
                    if ((t /= d / 2) < 1) {
                        return c / 2 * t * t * t + b;
                    }
                    return c / 2 * ((t -= 2) * t * t + 2) + b;
                },

                'easeinoutcubic':function (t, b, c, d, s) {
                    if (s == undefined) {
                        s = 1.70158;
                    }
                    return c * (t /= d) * t * ((s + 1) * t - s) + b;
                },

                'easeinback':function (t, b, c, d, s) {
                    if (s == undefined) {
                        s = 1.70158;
                    }
                    return c * (t /= d) * t * ((s + 1) * t - s) + b;
                },

                'easeoutback':function (t, b, c, d, s) {
                    if (s == undefined) {
                        s = 1.70158;
                    }
                    return c * ((t = t / d - 1) * t * ((s + 1) * t + s) + 1) + b;
                },

                'easeinoutback':function (t, b, c, d, s) {
                    if (s == undefined) {
                        s = 1.70158;
                    }
                    if ((t /= d / 2) < 1) {
                        return c / 2 * (t * t * (((s *= (1.525)) + 1) * t - s)) + b;
                    }
                    return c / 2 * ((t -= 2) * t * (((s *= (1.525)) + 1) * t + s) + 2) + b;
                }
            };
            return {
                /**
                 * 添加算法函数
                 * @method addAlgorithm
                 * @param {String} name
                 算法名
                 * @param {Function} fn
                 算法函数(开始状态，开始位置，当前时间，当前位置，偏移值，额外用户定义参数)
                 * @return {void}
                 * @example
                 $.core.ani.algorithm.addAlgorithm('test',function(t, b, c, d, s){
            				return c * t / d + b;
            			});
                 */
                'addAlgorithm':function (name, fn) {
                    if (algorithm[name]) {
                        throw '[core.ani.tweenValue] this algorithm :' + name + 'already exist';
                    }
                    algorithm[name] = fn;
                },

                /**
                 * 计算算法结果
                 * @method compute
                 * @param {String}    type
                 动画类型[linear|easeincubic|easeoutcubic|easeinoutcubic|easeinback|easeoutbackeaseinoutback|<自定义>]
                 * @param {Number}    propStart
                 开始位置
                 * @param {Number}    proDest
                 总移动距离
                 * @param {Number}    timeNow
                 当前时间（动画开始后）
                 * @param {Number}    timeDest
                 每帧间隔时间
                 * @param {Number}    extra
                 偏移值
                 * @param {Number}    params
                 额外用户定义参数
                 * @return {Number}
                 * @example
                 var res = $.core.ani.algorithm.compute('linear', 0, 100, 50, 500, 5, {});
                 */
                'compute':function (type, propStart, proDest, timeNow, timeDest, extra, params) {
                    if (typeof algorithm[type] !== 'function') {
                        throw '[core.ani.tweenValue] this algorithm :' + type + 'do not exist';
                    }
                    return algorithm[type](timeNow, propStart, proDest, timeDest, extra, params);
                }
            };
        })(),

        tweenArche: function(tween, spec){
            var conf, that, currTime, startTime, currValue, timer, pauseTime, status;
            that = {};
            conf = Lilac.extend({
                'animationType':'linear',
                'distance':1,
                'duration':500,
                'callback': function(){},
                'algorithmParams':{},
                'extra':5,
                'delay':25
            }, spec);

            var onTween = function () {
                currTime = (+new Date() - startTime);
                if (currTime < conf['duration']) {
                    currValue = Lilac.ani.algorithm.compute(
                        conf['animationType'],
                        0,
                        conf['distance'],
                        currTime,
                        conf['duration'],
                        conf['extra'],
                        conf['algorithmParams']
                    );
                    tween(currValue);

                    timer = setTimeout(onTween, conf['delay']);
                } else {
                    status = 'stop';
                    conf['callback']();
                }
            };

            status = 'stop';
            /**
             * Describe 获取当点状态
             * @method getStatus
             * @return {String}[stop|play|pause]
             * @example
             */
            that.getStatus = function () {
                return status;
            };
            /**
             * Describe 播放动画
             * @method play
             * @example
             */
            that.play = function () {
                startTime = +new Date();
                currValue = null;
                onTween();
                status = 'play';
                return that;
            };
            /**
             * Describe 停止动画
             * @method stop
             * @example
             */
            that.stop = function () {
                clearTimeout(timer);
                status = 'stop';
                return that;
            };
            /**
             * Describe 继续播放
             * @method resume
             * @example
             */
            that.resume = function () {
                if (pauseTime) {
                    startTime += (+new Date() - pauseTime);
                    onTween();
                }
                return that;
            };
            /**
             * Describe 暂停动画
             * @method pause
             * @example
             */
            that.pause = function () {
                clearTimeout(timer);
                pauseTime = +new Date();
                status = 'pause';
                return that;
            };
            /**
             * Describe 销毁对象
             * @method destroy
             * @example
             */
            that.destroy = function () {
                clearTimeout(timer);
                pauseTime = 0;
                status = 'stop';
            };
            return that;
        },

        tween: function(node, spec){
            var getSuffix = function (sValue) {
                var charCase = /(-?\d\.?\d*)([a-z%]*)/i.exec(sValue);
                var ret = [0, 'px'];
                if (charCase) {
                    if (charCase[1]) {
                        ret[0] = charCase[1] - 0;
                    }
                    if (charCase[2]) {
                        ret[1] = charCase[2];
                    }
                }
                return ret;
            };

            var styleToCssText = function (s) {
                for (var i = 0, len = s.length; i < len; i += 1) {
                    var l = s.charCodeAt(i);
                    if (l > 64 && l < 90) {
                        var sf = s.substr(0, i);
                        var sm = s.substr(i, 1);
                        var se = s.slice(i + 1);
                        return sf + '-' + sm.toLowerCase() + se;
                    }
                }
                return s;
            };

            var formatProperty = function (node, value, key) {
                //for node property
                var property = $(node).getStyle(key);

                if (typeof (property) === 'undefined' || property === 'auto') {
                    if (key === 'height') {
                        property = node.offsetHeight;
                    }
                    if (key === 'width') {
                        property = node.offsetWidth;
                    }
                }

                var ret = {
                    'start':property,
                    'end':value,
                    'unit':'',
                    'key':key,
                    'defaultColor':false
                };

                //about number
                if (typeof (value) === 'number') {
                    var style = [0, 'px'];
                    if (typeof (property) === 'number') {
                        style[0] = property;
                    } else {
                        style = getSuffix(property);
                    }
                    ret['start'] = style[0];
                    ret['unit'] = style[1];
                }

                //about color
                if (typeof(value) === 'string') {
                    var tarColObj, curColObj;
                    tarColObj = Lilac.color(value);
                    if (tarColObj) {
                        curColObj = Lilac.color(property);
                        if (!curColObj) {
                            curColObj = Lilac.color('#fff');
                        }
                        ret['start'] = curColObj;
                        ret['end'] = tarColObj;
                        ret['defaultColor'] = true;
                    }
                }
                node = null;
                return ret;
            };

            var propertyFns = {
                'opacity' : function(rate, start, end, unit){
                    var value = (rate*(end - start) + start);
                    return {
                        'filter' : 'alpha(opacity=' + value*100 + ')',
                        'opacity' : Math.max(Math.min(1,value),0),
                        'zoom' : '1'
                    };
                },
                'defaultColor' : function(rate, start, end, unit, key){
                    var r =  Math.max(0,Math.min(255, Math.ceil((rate*(end.getR() - start.getR()) + start.getR()))));
                    var g =  Math.max(0,Math.min(255, Math.ceil((rate*(end.getG() - start.getG()) + start.getG()))));
                    var b =  Math.max(0,Math.min(255, Math.ceil((rate*(end.getB() - start.getB()) + start.getB()))));
                    var ret = {};
                    ret[styleToCssText(key)] = '#' +
                        (r < 16 ? '0' : '') + r.toString(16) +
                        (g < 16 ? '0' : '') + g.toString(16) +
                        (b < 16 ? '0' : '') + b.toString(16);
                    return ret;
                },
                'default' : function(rate, start, end, unit, key){
                    var value = (rate*(end - start) + start);
                    var ret = {};
                    ret[styleToCssText(key)] = value + unit;
                    return ret;
                }
            };

            var that, conf, propertys, ontween, propertyValues, staticStyle, onend, sup, queue, arche;

            spec = spec || {};

            conf = Lilac.extend({
                'animationType' : 'linear',
                'duration' : 500,
                'algorithmParams' : {},
                'extra' : 5,
                'delay' : 25
            }, spec);

            conf['distance'] = 1;
            var tween;
            var end;
            conf['callback'] = (function(){
                end = spec['end'] || function(){};
                tween = spec['tween'] || function(){};
                return function(){
                    ontween(1);
                    onend();
                    end(node);
                };
            })();

            propertys = Lilac.merge(propertyFns, spec['propertys'] || {});

            staticStyle = null;

            propertyValues = {};

            queue = [];

            ontween = function(rate){
                var list = [];
                var opts = Lilac.arr.foreach(propertyValues, function(value, key){
                    var fn;
                    if(propertys[key]){
                        fn = propertys[key];

                    }else if(value['defaultColor']){
                        fn = propertys['defaultColor'];

                    }else{
                        fn = propertys['default'];

                    }
                    var res = fn(
                        rate,
                        value['start'],
                        value['end'],
                        value['unit'],
                        value['key']
                    );
                    for(var k in res){
                        staticStyle.push(k, res[k]);
                    }
                    try{
                        tween(rate);
                    }catch(exp){

                    }
                });
                node.style.cssText = staticStyle.getCss();
            };


            onend = function(){
                var item;
                while(item = queue.shift()){
                    try{
                        item.fn();
                        if(item['type'] === 'play'){
                            break;
                        }
                        if(item['type'] === 'destroy'){
                            break;
                        }
                    }catch(exp){

                    }
                }
            };

            arche = Lilac.ani.tweenArche(ontween, conf);

            var setNode = function(el){
                if(arche.getStatus() !== 'play'){
                    node = el;
                }else{
                    queue.push({'fn' : setNode, 'type':'setNode'});
                }
            };

            var play = function(target){
                if(arche.getStatus() !== 'play'){
                    propertyValues = Lilac.arr.foreach(target, function(value, key){
                        return formatProperty(node, value, key);
                    });
                    staticStyle = Lilac.cssText(node.style.cssText + (spec['staticStyle'] || ''));
                    arche.play();
                }else{
                    queue.push({'fn':function(){play(target);},'type':'play'});
                }
            };

            var destroy = function(){
                if(arche.getStatus() !== 'play'){
                    arche.destroy();
                    node = null;
                    that = null;
                    conf = null;
                    propertys = null;
                    ontween = null;
                    propertyValues = null;
                    staticStyle = null;
                    onend = null;
                    sup = null;
                    queue = null;
                }else{
                    queue.push({'fn':destroy,'type':'destroy'});
                }
            };

            that = {};
            /**
             * Describe 播放动画
             * @method play
             * @param {Object} target
                见例子
             * @example
             */
            that.play = function(target){
                play(target);
                return that;
            };
            /**
             * Describe 停止动画
             * @method stop
             * @example
             */
            that.stop = function(){
                arche.stop();
                return that;
            };
            /**
             * Describe 暂停动画
             * @method pause
             * @example
             */
            that.pause = function(){
                arche.pause();
                return that;
            };
            /**
             * Describe 继续播放
             * @method resume
             * @example
             */
            that.resume = function(){
                arche.resume();
                return that;
            };
            /**
             * Describe 播放并在完成的时候销毁动画对象
             * @method finish
             * @param {Object} target
                见例子
             * @example
             */
            that.finish = function(target){
                play(target);
                destroy();
                return that;
            };
            /**
             * Describe 替换动画节点
             * @method setNode
             * @param {Element} el
             * @example
             */
            that.setNode = function(el){
                setNode(el);
                return that;
            };
            /**
             * Describe 销毁对象
             * @method destroy
             * @example
             */
            that.destroy = function(){
                destroy();
                return that;
            };
            return that;
        }
    });

    //-----------------------------------------------------------------------------------------------//
    //-----------------------------------------     ajax    -----------------------------------------//
    //-----------------------------------------------------------------------------------------------//
    Lilac.io = {};
    Lilac.extend(Lilac.io, {
        getXHR: function(){
            var _XHR = false;
            try {
                _XHR = new XMLHttpRequest();
            }
            catch (try_MS) {
                try {
                    _XHR = new ActiveXObject("Msxml2.XMLHTTP");
                }
                catch (other_MS) {
                    try {
                        _XHR = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    catch (failed) {
                        _XHR = false;
                    }
                }
            }
            return _XHR;
        },

        ajax: function(oOpts){
            var opts = Lilac.extend({
                'url': '',
                'charset': 'UTF-8',
                'timeout': 30 * 1000,
                'args': {},
                'onComplete': null,
                'onTimeout': function(){},
                'uniqueID': null,

                'onFail': function(){},
                'method': 'get', // post or get
                'asynchronous': true,
                'header' : {},
                'isEncode' : false,
                'responseType': 'json'// xml or text or json
            }, oOpts);

            if (opts.url == '') {
                throw 'ajax need url in parameters object';
            }

            var tm;

            var trans = Lilac.io.getXHR();

            var cback = function(){
                if (trans.readyState == 4) {
                    clearTimeout(tm);
                    var data = '';
                    if (opts['responseType'] === 'xml') {
                            data = trans.responseXML;
                    }else if(opts['responseType'] === 'text'){
                            data = trans.responseText;
                    }else {
                        try{
                            if(trans.responseText && typeof trans.responseText === 'string'){
                             // data = $.core.json.strToJson(trans.responseText);
                                data = eval('(' + trans.responseText + ')');
                            }else{
                                data = {};
                            }
                        }catch(exp){
                            data = opts['url'] + 'return error : data error';
                            // throw opts['url'] + 'return error : syntax error';
                        }

                    }
                    if (trans.status == 200) {
                        if (opts['onComplete'] != null) {
                            opts['onComplete'](data);
                        }
                    }else if(trans.status == 0){
                        //for abort;
                    } else {
                        if (opts['onFail'] != null) {
                            opts['onFail'](data, trans);
                        }
                    }
                }
                else {
                    if (opts['onTraning'] != null) {
                        opts['onTraning'](trans);
                    }
                }
            };
            trans.onreadystatechange = cback;

            if(!opts['header']['Content-Type']){
                opts['header']['Content-Type'] = 'application/x-www-form-urlencoded';
            }
            if(!opts['header']['X-Requested-With']){
                opts['header']['X-Requested-With'] = 'XMLHttpRequest';
            }

            if (opts['method'].toLocaleLowerCase() == 'get') {
                var url = Lilac.URL(opts['url'],{
                    'isEncodeQuery' : opts['isEncode']
                });
                url.setParams(opts['args']);
                url.setParam('__rnd', new Date().valueOf());
                trans.open(opts['method'], url.toString(), opts['asynchronous']);
                try{
                    for(var k in opts['header']){
                        trans.setRequestHeader(k, opts['header'][k]);
                    }
                }catch(exp){

                }
                trans.send('');

            }
            else {
                trans.open(opts['method'], opts['url'], opts['asynchronous']);
                try{
                    for(var k in opts['header']){
                        trans.setRequestHeader(k, opts['header'][k]);
                    }
                }catch(exp){

                }
                trans.send(Lilac.jsonToQuery(opts['args'],opts['isEncode']));
            }
            if(opts['timeout']){
                tm = setTimeout(function(){
                    try{
                        trans.abort();
                        opts['onTimeout']({}, trans);
                        opts['onFail']({}, trans);
                    }catch(exp){

                    }
                }, opts['timeout']);
            }
            return trans;
        },

        scriptLoader: function(oOpts){
            var entityList = {};
            var default_opts = {
                'url': '',
                'charset': 'UTF-8',
                'timeout': 30 * 1000,
                'args': {},
                'onComplete': function(){},
                'onTimeout': null,
                'isEncode' : false,
                'uniqueID': null
            };

            var js, requestTimeout;
            var opts = Lilac.extend(default_opts, oOpts);

            if (opts.url == '') {
                throw 'scriptLoader: url is null';
            }

            var uniqueID = opts.uniqueID || Lilac.getUniqueKey();


            js = entityList[uniqueID];
            if (js != null && Lilac.browser.IE != true) {
                $(js).removeNode();
                js = null;
            }
            if (js == null) {
                js = entityList[uniqueID] = $.C('script');
            }

            js.charset = opts.charset;
            js.id = 'scriptRequest_script_' + uniqueID;
            js.type = 'text/javascript';
            if (opts.onComplete != null) {
                if (Lilac.browser.IE) {
                    js['onreadystatechange'] = function(){
                        if (js.readyState.toLowerCase() == 'loaded' || js.readyState.toLowerCase() == 'complete') {
                            try{
                                clearTimeout(requestTimeout);
                                document.getElementsByTagName("head")[0].removeChild(js);
                            }catch(exp){

                            }
                            opts.onComplete();
                        }
                    };
                }
                else {
                    js['onload'] = function(){
                        try{
                            clearTimeout(requestTimeout);
                            $(js).removeNode();
                        }catch(exp){}
                        opts.onComplete();
                    };

                }

            }

            js.src = Lilac.URL(opts.url,{
                'isEncodeQuery' : opts['isEncode']
            }).setParams(opts.args);

            document.getElementsByTagName("head")[0].appendChild(js);

            if (opts.timeout > 0 && opts.onTimeout != null) {
                requestTimeout = setTimeout(function(){
                    try{
                        document.getElementsByTagName("head")[0].removeChild(js);
                    }catch(exp){

                    }
                    opts.onTimeout();
                }, opts.timeout);
            }
            return js;
        }

    });

    //-----------------------------------------------------------------------------------------------//
    //-------------------------------------     SIZZLE选择器    --------------------------------------//
    //-----------------------------------------------------------------------------------------------//
    (function (window, undefined) {
        var chunker = /((?:\((?:\([^()]+\)|[^()]+)+\)|\[(?:\[[^\[\]]*\]|['"][^'"]*['"]|[^\[\]'"]+)+\]|\\.|[^ >+~,(\[\\]+)+|[>+~])(\s*,\s*)?((?:.|\r|\n)*)/g,
            done = 0,
            toString = Object.prototype.toString,
            hasDuplicate = false,
            baseHasDuplicate = true;
        // Here we check if the JavaScript engine is using some sort of
        // optimization where it does not always call our comparision
        // function. If that is the case, discard the hasDuplicate value.
        //   Thus far that includes Google Chrome.
        [0, 0].sort(function () {
            baseHasDuplicate = false;
            return 0;
        });

        var Sizzle = function (selector, context, results, seed) {
            results = results || [];
            context = context || document;

            var origContext = context;

            if (context.nodeType !== 1 && context.nodeType !== 9) {
                return [];
            }

            if (!selector || typeof selector !== "string") {
                return results;
            }

            var parts = [],
                m,
                set,
                checkSet,
                extra,
                prune = true,
                contextXML = Sizzle.isXML(context),
                soFar = selector,
                ret,
                cur,
                pop,
                i;

            // Reset the position of the chunker regexp (start from head)
            do {
                chunker.exec("");
                m = chunker.exec(soFar);

                if (m) {
                    soFar = m[3];

                    parts.push(m[1]);

                    if (m[2]) {
                        extra = m[3];
                        break;
                    }
                }
            } while (m);

            if (parts.length > 1 && origPOS.exec(selector)) {
                if (parts.length === 2 && Expr.relative[parts[0]]) {
                    set = posProcess(parts[0] + parts[1], context);
                } else {
                    set = Expr.relative[parts[0]] ? [context] : Sizzle(parts.shift(), context);
                    while (parts.length) {
                        selector = parts.shift();

                        if (Expr.relative[selector]) {
                            selector += parts.shift();
                        }

                        set = posProcess(selector, set);
                    }
                }
            } else {
                // Take a shortcut and set the context if the root selector is an ID
                // (but not if it'll be faster if the inner selector is an ID)
                if (!seed && parts.length > 1 && context.nodeType === 9 && !contextXML &&
                    Expr.match.ID.test(parts[0]) && !Expr.match.ID.test(parts[parts.length - 1])) {
                    ret = Sizzle.find(parts.shift(), context, contextXML);
                    context = ret.expr ? Sizzle.filter(ret.expr, ret.set)[0] : ret.set[0];
                }

                if (context) {
                    ret = seed ? {
                        expr:parts.pop(),
                        set:makeArray(seed)
                    }
                        : Sizzle.find(parts.pop(), parts.length === 1 && (parts[0] === "~" || parts[0] === "+") && context.parentNode ? context.parentNode : context, contextXML);
                    set = ret.expr ? Sizzle.filter(ret.expr, ret.set) : ret.set;

                    if (parts.length > 0) {
                        checkSet = makeArray(set);
                    } else {
                        prune = false;
                    }
                    while (parts.length) {
                        cur = parts.pop();
                        pop = cur;

                        if (!Expr.relative[cur]) {
                            cur = "";
                        } else {
                            pop = parts.pop();
                        }

                        if (pop == null) {
                            pop = context;
                        }

                        Expr.relative[cur](checkSet, pop, contextXML);
                    }
                } else {
                    checkSet = parts = [];
                }
            }

            if (!checkSet) {
                checkSet = set;
            }

            if (!checkSet) {
                Sizzle.error(cur || selector);
            }

            if (toString.call(checkSet) === "[object Array]") {
                if (!prune) {
                    results.push.apply(results, checkSet);
                } else if (context && context.nodeType === 1) {
                    for (i = 0; checkSet[i] != null; i++) {
                        if (checkSet[i] && (checkSet[i] === true || checkSet[i].nodeType === 1 && Sizzle.contains(context, checkSet[i]))) {
                            results.push(set[i]);
                        }
                    }
                } else {
                    for (i = 0; checkSet[i] != null; i++) {
                        if (checkSet[i] && checkSet[i].nodeType === 1) {
                            results.push(set[i]);
                        }
                    }
                }
            } else {
                makeArray(checkSet, results);
            }

            if (extra) {
                Sizzle(extra, origContext, results, seed);
                Sizzle.uniqueSort(results);
            }

            return results;
        };

        Sizzle.uniqueSort = function (results) {
            if (sortOrder) {
                hasDuplicate = baseHasDuplicate;
                results.sort(sortOrder);

                if (hasDuplicate) {
                    for (var i = 1; i < results.length; i++) {
                        if (results[i] === results[i - 1]) {
                            results.splice(i--, 1);
                        }
                    }
                }
            }

            return results;
        };

        Sizzle.matches = function (expr, set) {
            return Sizzle(expr, null, null, set);
        };

        Sizzle.find = function (expr, context, isXML) {
            var set;

            if (!expr) {
                return [];
            }

            for (var i = 0, l = Expr.order.length; i < l; i++) {
                var type = Expr.order[i],
                    match;

                if ((match = Expr.leftMatch[type].exec(expr))) {
                    var left = match[1];
                    match.splice(1, 1);

                    if (left.substr(left.length - 1) !== "\\") {
                        match[1] = (match[1] || "").replace(/\\/g, "");
                        set = Expr.find[type](match, context, isXML);
                        if (set != null) {
                            expr = expr.replace(Expr.match[type], "");
                            break;
                        }
                    }
                }
            }

            if (!set) {
                set = context.getElementsByTagName("*");
            }

            return {
                set:set,
                expr:expr
            };
        };

        Sizzle.filter = function (expr, set, inplace, not) {
            var old = expr,
                result = [],
                curLoop = set,
                match,
                anyFound,
                isXMLFilter = set && set[0] && Sizzle.isXML(set[0]);
            while (expr && set.length) {
                for (var type in Expr.filter) {
                    if ((match = Expr.leftMatch[type].exec(expr)) != null && match[2]) {
                        var filter = Expr.filter[type],
                            found,
                            item,
                            left = match[1];
                        anyFound = false;

                        match.splice(1, 1);

                        if (left.substr(left.length - 1) === "\\") {
                            continue;
                        }

                        if (curLoop === result) {
                            result = [];
                        }

                        if (Expr.preFilter[type]) {
                            match = Expr.preFilter[type](match, curLoop, inplace, result, not, isXMLFilter);

                            if (!match) {
                                anyFound = found = true;
                            } else if (match === true) {
                                continue;
                            }
                        }

                        if (match) {
                            for (var i = 0; (item = curLoop[i]) != null; i++) {
                                if (item) {
                                    found = filter(item, match, i, curLoop);
                                    var pass = not ^ !!found;

                                    if (inplace && found != null) {
                                        if (pass) {
                                            anyFound = true;
                                        } else {
                                            curLoop[i] = false;
                                        }
                                    } else if (pass) {
                                        result.push(item);
                                        anyFound = true;
                                    }
                                }
                            }
                        }

                        if (found !== undefined) {
                            if (!inplace) {
                                curLoop = result;
                            }

                            expr = expr.replace(Expr.match[type], "");

                            if (!anyFound) {
                                return [];
                            }

                            break;
                        }
                    }
                }

                // Improper expression
                if (expr === old) {
                    if (anyFound == null) {
                        Sizzle.error(expr);
                    } else {
                        break;
                    }
                }

                old = expr;
            }

            return curLoop;
        };

        Sizzle.error = function (msg) {
            throw "Syntax error, unrecognized expression: " + msg;
        };

        var Expr = {
            order:["ID", "NAME", "TAG"],
            match:{
                ID:/#((?:[\w\u00c0-\uFFFF\-]|\\.)+)/,
                CLASS:/\.((?:[\w\u00c0-\uFFFF\-]|\\.)+)/,
                NAME:/\[name=['"]*((?:[\w\u00c0-\uFFFF\-]|\\.)+)['"]*\]/,
                ATTR:/\[\s*((?:[\w\u00c0-\uFFFF\-]|\\.)+)\s*(?:(\S?=)\s*(['"]*)(.*?)\3|)\s*\]/,
                TAG:/^((?:[\w\u00c0-\uFFFF\*\-]|\\.)+)/,
                CHILD:/:(only|nth|last|first)-child(?:\((even|odd|[\dn+\-]*)\))?/,
                POS:/:(nth|eq|gt|lt|first|last|even|odd)(?:\((\d*)\))?(?=[^\-]|$)/,
                PSEUDO:/:((?:[\w\u00c0-\uFFFF\-]|\\.)+)(?:\((['"]?)((?:\([^\)]+\)|[^\(\)]*)+)\2\))?/
            },
            leftMatch:{},
            attrMap:{
                "class":"className",
                "for":"htmlFor"
            },
            attrHandle:{
                href:function (elem) {
                    return elem.getAttribute("href");
                }
            },
            relative:{
                "+":function (checkSet, part) {
                    var isPartStr = typeof part === "string",
                        isTag = isPartStr && !/\W/.test(part),
                        isPartStrNotTag = isPartStr && !isTag;

                    if (isTag) {
                        part = part.toLowerCase();
                    }

                    for (var i = 0, l = checkSet.length, elem; i < l; i++) {
                        if ((elem = checkSet[i])) {
                            while ((elem = elem.previousSibling) && elem.nodeType !== 1) {
                            }

                            checkSet[i] = isPartStrNotTag || elem && elem.nodeName.toLowerCase() === part ? elem || false : elem === part;
                        }
                    }

                    if (isPartStrNotTag) {
                        Sizzle.filter(part, checkSet, true);
                    }
                },
                ">":function (checkSet, part) {
                    var isPartStr = typeof part === "string",
                        elem,
                        i = 0,
                        l = checkSet.length;

                    if (isPartStr && !/\W/.test(part)) {
                        part = part.toLowerCase();

                        for (; i < l; i++) {
                            elem = checkSet[i];
                            if (elem) {
                                var parent = elem.parentNode;
                                checkSet[i] = parent.nodeName.toLowerCase() === part ? parent : false;
                            }
                        }
                    } else {
                        for (; i < l; i++) {
                            elem = checkSet[i];
                            if (elem) {
                                checkSet[i] = isPartStr ? elem.parentNode : elem.parentNode === part;
                            }
                        }

                        if (isPartStr) {
                            Sizzle.filter(part, checkSet, true);
                        }
                    }
                },
                "":function (checkSet, part, isXML) {
                    var doneName = done++,
                        checkFn = dirCheck,
                        nodeCheck;

                    if (typeof part === "string" && !/\W/.test(part)) {
                        part = part.toLowerCase();
                        nodeCheck = part;
                        checkFn = dirNodeCheck;
                    }

                    checkFn("parentNode", part, doneName, checkSet, nodeCheck, isXML);
                },
                "~":function (checkSet, part, isXML) {
                    var doneName = done++,
                        checkFn = dirCheck,
                        nodeCheck;

                    if (typeof part === "string" && !/\W/.test(part)) {
                        part = part.toLowerCase();
                        nodeCheck = part;
                        checkFn = dirNodeCheck;
                    }

                    checkFn("previousSibling", part, doneName, checkSet, nodeCheck, isXML);
                }
            },
            find:{
                ID:function (match, context, isXML) {
                    if (typeof context.getElementById !== "undefined" && !isXML) {
                        var m = context.getElementById(match[1]);
                        return m ? [m] : [];
                    }
                },
                NAME:function (match, context) {
                    if (typeof context.getElementsByName !== "undefined") {
                        var ret = [],
                            results = context.getElementsByName(match[1]);

                        for (var i = 0, l = results.length; i < l; i++) {
                            if (results[i].getAttribute("name") === match[1]) {
                                ret.push(results[i]);
                            }
                        }

                        return ret.length === 0 ? null : ret;
                    }
                },
                TAG:function (match, context) {
                    return context.getElementsByTagName(match[1]);
                }
            },
            preFilter:{
                CLASS:function (match, curLoop, inplace, result, not, isXML) {
                    match = " " + match[1].replace(/\\/g, "") + " ";

                    if (isXML) {
                        return match;
                    }

                    for (var i = 0, elem; (elem = curLoop[i]) != null; i++) {
                        if (elem) {
                            if (not ^ (elem.className && (" " + elem.className + " ").replace(/[\t\n]/g, " ").indexOf(match) >= 0)) {
                                if (!inplace) {
                                    result.push(elem);
                                }
                            } else if (inplace) {
                                curLoop[i] = false;
                            }
                        }
                    }

                    return false;
                },
                ID:function (match) {
                    return match[1].replace(/\\/g, "");
                },
                TAG:function (match, curLoop) {
                    return match[1].toLowerCase();
                },
                CHILD:function (match) {
                    if (match[1] === "nth") {
                        // parse equations like 'even', 'odd', '5', '2n', '3n+2', '4n-1', '-n+6'
                        var test = /(-?)(\d*)n((?:\+|-)?\d*)/.exec(match[2] === "even" && "2n" || match[2] === "odd" && "2n+1" ||
                            !/\D/.test(match[2]) && "0n+" + match[2] ||
                            match[2]);

                        // calculate the numbers (first)n+(last) including if they are negative
                        match[2] = (test[1] + (test[2] || 1)) - 0;
                        match[3] = test[3] - 0;
                    }

                    // TODO: Move to normal caching system
                    match[0] = done++;

                    return match;
                },
                ATTR:function (match, curLoop, inplace, result, not, isXML) {
                    var name = match[1].replace(/\\/g, "");

                    if (!isXML && Expr.attrMap[name]) {
                        match[1] = Expr.attrMap[name];
                    }

                    if (match[2] === "~=") {
                        match[4] = " " + match[4] + " ";
                    }

                    return match;
                },
                PSEUDO:function (match, curLoop, inplace, result, not) {
                    if (match[1] === "not") {
                        // If we're dealing with a complex expression, or a simple one
                        if ((chunker.exec(match[3]) || "").length > 1 || /^\w/.test(match[3])) {
                            match[3] = Sizzle(match[3], null, null, curLoop);
                        } else {
                            var ret = Sizzle.filter(match[3], curLoop, inplace, true ^ not);
                            if (!inplace) {
                                result.push.apply(result, ret);
                            }
                            return false;
                        }
                    } else if (Expr.match.POS.test(match[0]) || Expr.match.CHILD.test(match[0])) {
                        return true;
                    }

                    return match;
                },
                POS:function (match) {
                    match.unshift(true);
                    return match;
                }
            },
            filters:{
                enabled:function (elem) {
                    return elem.disabled === false && elem.type !== "hidden";
                },
                disabled:function (elem) {
                    return elem.disabled === true;
                },
                checked:function (elem) {
                    return elem.checked === true;
                },
                selected:function (elem) {
                    // Accessing this property makes selected-by-default
                    // options in Safari work properly
                    elem.parentNode.selectedIndex;
                    return elem.selected === true;
                },
                parent:function (elem) {
                    return !!elem.firstChild;
                },
                empty:function (elem) {
                    return !elem.firstChild;
                },
                has:function (elem, i, match) {
                    return !!Sizzle(match[3], elem).length;
                },
                header:function (elem) {
                    return (/h\d/i).test(elem.nodeName);
                },
                text:function (elem) {
                    return "text" === elem.type;
                },
                radio:function (elem) {
                    return "radio" === elem.type;
                },
                checkbox:function (elem) {
                    return "checkbox" === elem.type;
                },
                file:function (elem) {
                    return "file" === elem.type;
                },
                password:function (elem) {
                    return "password" === elem.type;
                },
                submit:function (elem) {
                    return "submit" === elem.type;
                },
                image:function (elem) {
                    return "image" === elem.type;
                },
                reset:function (elem) {
                    return "reset" === elem.type;
                },
                button:function (elem) {
                    return "button" === elem.type || elem.nodeName.toLowerCase() === "button";
                },
                input:function (elem) {
                    return (/input|select|textarea|button/i).test(elem.nodeName);
                }
            },
            setFilters:{
                first:function (elem, i) {
                    return i === 0;
                },
                last:function (elem, i, match, array) {
                    return i === array.length - 1;
                },
                even:function (elem, i) {
                    return i % 2 === 0;
                },
                odd:function (elem, i) {
                    return i % 2 === 1;
                },
                lt:function (elem, i, match) {
                    return i < match[3] - 0;
                },
                gt:function (elem, i, match) {
                    return i > match[3] - 0;
                },
                nth:function (elem, i, match) {
                    return match[3] - 0 === i;
                },
                eq:function (elem, i, match) {
                    return match[3] - 0 === i;
                }
            },
            filter:{
                PSEUDO:function (elem, match, i, array) {
                    var name = match[1],
                        filter = Expr.filters[name];

                    if (filter) {
                        return filter(elem, i, match, array);
                    } else if (name === "contains") {
                        return (elem.textContent || elem.innerText || Sizzle.getText([elem]) || "").indexOf(match[3]) >= 0;
                    } else if (name === "not") {
                        var not = match[3];

                        for (var j = 0, l = not.length; j < l; j++) {
                            if (not[j] === elem) {
                                return false;
                            }
                        }

                        return true;
                    } else {
                        Sizzle.error("Syntax error, unrecognized expression: " + name);
                    }
                },
                CHILD:function (elem, match) {
                    var type = match[1],
                        node = elem;
                    switch (type) {
                        case 'only':
                        case 'first':
                            while ((node = node.previousSibling)) {
                                if (node.nodeType === 1) {
                                    return false;
                                }
                            }
                            if (type === "first") {
                                return true;
                            }
                            node = elem;
                        case 'last':
                            while ((node = node.nextSibling)) {
                                if (node.nodeType === 1) {
                                    return false;
                                }
                            }
                            return true;
                        case 'nth':
                            var first = match[2],
                                last = match[3];

                            if (first === 1 && last === 0) {
                                return true;
                            }

                            var doneName = match[0],
                                parent = elem.parentNode;

                            if (parent && (parent.sizcache !== doneName || !elem.nodeIndex)) {
                                var count = 0;
                                for (node = parent.firstChild; node; node = node.nextSibling) {
                                    if (node.nodeType === 1) {
                                        node.nodeIndex = ++count;
                                    }
                                }
                                parent.sizcache = doneName;
                            }

                            var diff = elem.nodeIndex - last;
                            if (first === 0) {
                                return diff === 0;
                            } else {
                                return (diff % first === 0 && diff / first >= 0);
                            }
                    }
                },
                ID:function (elem, match) {
                    return elem.nodeType === 1 && elem.getAttribute("id") === match;
                },
                TAG:function (elem, match) {
                    return (match === "*" && elem.nodeType === 1) || elem.nodeName.toLowerCase() === match;
                },
                CLASS:function (elem, match) {
                    return (" " + (elem.className || elem.getAttribute("class")) + " ").indexOf(match) > -1;
                },
                ATTR:function (elem, match) {
                    var name = match[1],
                        result = Expr.attrHandle[name] ? Expr.attrHandle[name](elem) : elem[name] != null ? elem[name] : elem.getAttribute(name),
                        value = result + "",
                        type = match[2],
                        check = match[4];

                    return result == null ? type === "!=" : type === "=" ? value === check : type === "*=" ? value.indexOf(check) >= 0 : type === "~=" ? (" " + value + " ").indexOf(check) >= 0 : !check ? value && result !== false : type === "!=" ? value !== check : type === "^=" ? value.indexOf(check) === 0 : type === "$=" ? value.substr(value.length - check.length) === check : type === "|=" ? value === check || value.substr(0, check.length + 1) === check + "-" : false;
                },
                POS:function (elem, match, i, array) {
                    var name = match[2],
                        filter = Expr.setFilters[name];

                    if (filter) {
                        return filter(elem, i, match, array);
                    }
                }
            }
        };
        Sizzle.selectors = Expr;

        var origPOS = Expr.match.POS,
            fescape = function (all, num) {
                return "\\" + (num - 0 + 1);
            };

        for (var type in Expr.match) {
            Expr.match[type] = new RegExp(Expr.match[type].source + (/(?![^\[]*\])(?![^\(]*\))/.source));
            Expr.leftMatch[type] = new RegExp(/(^(?:.|\r|\n)*?)/.source + Expr.match[type].source.replace(/\\(\d+)/g, fescape));
        }

        var makeArray = function (array, results) {
            array = Array.prototype.slice.call(array, 0);

            if (results) {
                results.push.apply(results, array);
                return results;
            }

            return array;
        };

        // Perform a simple check to determine if the browser is capable of
        // converting a NodeList to an array using builtin methods.
        // Also verifies that the returned array holds DOM nodes
        // (which is not the case in the Blackberry browser)
        try {
            Array.prototype.slice.call(document.documentElement.childNodes, 0)[0].nodeType;

            // Provide a fallback method if it does not work
        } catch (e) {
            makeArray = function (array, results) {
                var ret = results || [],
                    i = 0;

                if (toString.call(array) === "[object Array]") {
                    Array.prototype.push.apply(ret, array);
                } else {
                    if (typeof array.length === "number") {
                        for (var l = array.length; i < l; i++) {
                            ret.push(array[i]);
                        }
                    } else {
                        for (; array[i]; i++) {
                            ret.push(array[i]);
                        }
                    }
                }

                return ret;
            };
        }

        var sortOrder;

        if (document.documentElement.compareDocumentPosition) {
            sortOrder = function (a, b) {
                if (!a.compareDocumentPosition || !b.compareDocumentPosition) {
                    if (a == b) {
                        hasDuplicate = true;
                    }
                    return a.compareDocumentPosition ? -1 : 1;
                }

                var ret = a.compareDocumentPosition(b) & 4 ? -1 : a === b ? 0 : 1;
                if (ret === 0) {
                    hasDuplicate = true;
                }
                return ret;
            };
        } else if ("sourceIndex" in document.documentElement) {
            sortOrder = function (a, b) {
                if (!a.sourceIndex || !b.sourceIndex) {
                    if (a == b) {
                        hasDuplicate = true;
                    }
                    return a.sourceIndex ? -1 : 1;
                }

                var ret = a.sourceIndex - b.sourceIndex;
                if (ret === 0) {
                    hasDuplicate = true;
                }
                return ret;
            };
        } else if (document.createRange) {
            sortOrder = function (a, b) {
                if (!a.ownerDocument || !b.ownerDocument) {
                    if (a == b) {
                        hasDuplicate = true;
                    }
                    return a.ownerDocument ? -1 : 1;
                }

                var aRange = a.ownerDocument.createRange(),
                    bRange = b.ownerDocument.createRange();
                aRange.setStart(a, 0);
                aRange.setEnd(a, 0);
                bRange.setStart(b, 0);
                bRange.setEnd(b, 0);
                var ret = aRange.compareBoundaryPoints(Range.START_TO_END, bRange);
                if (ret === 0) {
                    hasDuplicate = true;
                }
                return ret;
            };
        }

        // Utility function for retreiving the text value of an array of DOM nodes
        Sizzle.getText = function (elems) {
            var ret = "",
                elem;

            for (var i = 0; elems[i]; i++) {
                elem = elems[i];

                // Get the text from text nodes and CDATA nodes
                if (elem.nodeType === 3 || elem.nodeType === 4) {
                    ret += elem.nodeValue;

                    // Traverse everything else, except comment nodes
                } else if (elem.nodeType !== 8) {
                    ret += Sizzle.getText(elem.childNodes);
                }
            }

            return ret;
        };

        // Check to see if the browser returns elements by name when
        // querying by getElementById (and provide a workaround)
        (function () {
            // We're going to inject a fake input element with a specified name
            var form = document.createElement("div"),
                id = "script" + (new Date()).getTime();
            form.innerHTML = "<a name='" + id + "'/>";

            // Inject it into the root element, check its status, and remove it quickly
            var root = document.documentElement;
            root.insertBefore(form, root.firstChild);

            // The workaround has to do additional checks after a getElementById
            // Which slows things down for other browsers (hence the branching)
            if (document.getElementById(id)) {
                Expr.find.ID = function (match, context, isXML) {
                    if (typeof context.getElementById !== "undefined" && !isXML) {
                        var m = context.getElementById(match[1]);
                        return m ? m.id === match[1] || typeof m.getAttributeNode !== "undefined" && m.getAttributeNode("id").nodeValue === match[1] ? [m] : undefined : [];
                    }
                };

                Expr.filter.ID = function (elem, match) {
                    var node = typeof elem.getAttributeNode !== "undefined" && elem.getAttributeNode("id");
                    return elem.nodeType === 1 && node && node.nodeValue === match;
                };
            }

            root.removeChild(form);
            root = form = null; // release memory in IE
        })();

        (function () {
            // Check to see if the browser returns only elements
            // when doing getElementsByTagName("*")

            // Create a fake element
            var div = document.createElement("div");
            div.appendChild(document.createComment(""));

            // Make sure no comments are found
            if (div.getElementsByTagName("*").length > 0) {
                Expr.find.TAG = function (match, context) {
                    var results = context.getElementsByTagName(match[1]);

                    // Filter out possible comments
                    if (match[1] === "*") {
                        var tmp = [];

                        for (var i = 0; results[i]; i++) {
                            if (results[i].nodeType === 1) {
                                tmp.push(results[i]);
                            }
                        }

                        results = tmp;
                    }

                    return results;
                };
            }

            // Check to see if an attribute returns normalized href attributes
            div.innerHTML = "<a href='#'></a>";
            if (div.firstChild && typeof div.firstChild.getAttribute !== "undefined" &&
                div.firstChild.getAttribute("href") !== "#") {
                Expr.attrHandle.href = function (elem) {
                    return elem.getAttribute("href", 2);
                };
            }

            div = null; // release memory in IE
        })();

        if (document.querySelectorAll) {
            (function () {
                var oldSizzle = Sizzle,
                    div = document.createElement("div");
                div.innerHTML = "<p class='TEST'></p>";

                // Safari can't handle uppercase or unicode characters when
                // in quirks mode.
                if (div.querySelectorAll && div.querySelectorAll(".TEST").length === 0) {
                    return;
                }
                Sizzle = function (query, context, extra, seed) {
                    context = context || document;

                    // Only use querySelectorAll on non-XML documents
                    // (ID selectors don't work in non-HTML documents)
                    if (!seed && context.nodeType === 9 && !Sizzle.isXML(context)) {
                        try {
                            return makeArray(context.querySelectorAll(query), extra);
                        } catch (e) {
                        }
                    }

                    return oldSizzle(query, context, extra, seed);
                };

                for (var prop in oldSizzle) {
                    Sizzle[prop] = oldSizzle[prop];
                }

                div = null; // release memory in IE
            })();
        }

        (function () {
            var div = document.createElement("div");

            div.innerHTML = "<div class='test e'></div><div class='test'></div>";

            // Opera can't find a second classname (in 9.6)
            // Also, make sure that getElementsByClassName actually exists
            if (!div.getElementsByClassName || div.getElementsByClassName("e").length === 0) {
                return;
            }

            // Safari caches class attributes, doesn't catch changes (in 3.2)
            div.lastChild.className = "e";

            if (div.getElementsByClassName("e").length === 1) {
                return;
            }

            Expr.order.splice(1, 0, "CLASS");
            Expr.find.CLASS = function (match, context, isXML) {
                if (typeof context.getElementsByClassName !== "undefined" && !isXML) {
                    return context.getElementsByClassName(match[1]);
                }
            };

            div = null; // release memory in IE
        })();

        function dirNodeCheck(dir, cur, doneName, checkSet, nodeCheck, isXML) {
            for (var i = 0, l = checkSet.length; i < l; i++) {
                var elem = checkSet[i];
                if (elem) {
                    elem = elem[dir];
                    var match = false;
                    while (elem) {
                        if (elem.sizcache === doneName) {
                            match = checkSet[elem.sizset];
                            break;
                        }

                        if (elem.nodeType === 1 && !isXML) {
                            elem.sizcache = doneName;
                            elem.sizset = i;
                        }

                        if (elem.nodeName.toLowerCase() === cur) {
                            match = elem;
                            break;
                        }

                        elem = elem[dir];
                    }

                    checkSet[i] = match;
                }
            }
        }

        function dirCheck(dir, cur, doneName, checkSet, nodeCheck, isXML) {
            for (var i = 0, l = checkSet.length; i < l; i++) {
                var elem = checkSet[i];
                if (elem) {
                    elem = elem[dir];
                    var match = false;
                    while (elem) {
                        if (elem.sizcache === doneName) {
                            match = checkSet[elem.sizset];
                            break;
                        }

                        if (elem.nodeType === 1) {
                            if (!isXML) {
                                elem.sizcache = doneName;
                                elem.sizset = i;
                            }
                            if (typeof cur !== "string") {
                                if (elem === cur) {
                                    match = true;
                                    break;
                                }

                            } else if (Sizzle.filter(cur, [elem]).length > 0) {
                                match = elem;
                                break;
                            }
                        }

                        elem = elem[dir];
                    }

                    checkSet[i] = match;
                }
            }
        }

        Sizzle.contains = document.compareDocumentPosition ? function (a, b) {
            return !!(a.compareDocumentPosition(b) & 16);
        }
            : function (a, b) {
            return a !== b && (a.contains ? a.contains(b) : true);
        };

        Sizzle.isXML = function (elem) {
            // documentElement is verified for cases where it doesn't yet exist
            // (such as loading iframes in IE - #4833)
            var documentElement = (elem ? elem.ownerDocument || elem : 0).documentElement;
            return documentElement ? documentElement.nodeName !== "HTML" : false;
        };

        var posProcess = function (selector, context) {
            var tmpSet = [],
                later = "",
                match,
                root = context.nodeType ? [context] : context;

            // Position selectors must be done after the filter
            // And so must :not(positional) so we move all PSEUDOs to the end
            while ((match = Expr.match.PSEUDO.exec(selector))) {
                later += match[0];
                selector = selector.replace(Expr.match.PSEUDO, "");
            }

            selector = Expr.relative[selector] ? selector + "*" : selector;

            for (var i = 0, l = root.length; i < l; i++) {
                Sizzle(selector, root[i], tmpSet);
            }

            return Sizzle.filter(later, tmpSet);
        };

        Lilac.sizzle = Sizzle;
    })(window);

    window.Lilac = window.$ = Lilac;

})(window);
