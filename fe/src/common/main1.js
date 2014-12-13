/**
 * common模块
 */
// define(['jquery'], function($, require){
define('common/main1', function(require){

    var util = require('util');
    var config = require('common/config');
    var login = require('common/login');

    var view = {};
    view.$suggestText = $('#suggestion-text');
    view.$suggestTarget = $('#suggestion-target');
    view.$login = $('#login-btn');

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
                                     + 'href="http://zanbai.com/shop?shop_id='
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
});

/**
 * home
 */
define('home/main', function(require){
});

/**
 * util
 * 包含一些常用的方法以及一些jquery未实现的常用方法
 */
define('util', function(require){

    var $ = require('jquery');

    var result = {};

    function _is(type, obj){
        var cls = Object.prototype.toString.call(obj).slice(8, -1);
        return obj !== undefined && obj !== null && cls === type;
    }

    result = {
        isArray: function(obj){
            return _is('Array', obj);
        },

        isObject: function(obj){
            return _is('Object', obj);
        },

        isString: function(obj){
            return _is('String', obj);
        },

        isFunction: function(obj){
            return _is('Function', obj);
        },

        getUniqueKey: (function(){
            var _loadTime = (new Date()).getTime().toString(), _i = 1;
            return function () {
                return _loadTime + (_i++);
            };
        })(),

        indexOf: function(item, arr){
            if (arr.indexOf) {
                return arr.indexOf(item);
            }
            for (var i = 0, len = arr.length; i < len; i++) {
                if (arr[i] === item) {
                    return i;
                }
            }
            return -1;
        },

        inArray: function(oElement, aSource){
            return result.indexOf(oElement, aSource) > -1;
        },

        easyTemplate: (function(){
            var easyTemplate = function(s,d){
                if(!s){
                    return '';
                }
                if (s!==easyTemplate.template) {
                    easyTemplate.template = s;
                    easyTemplate.aStatement =
                        easyTemplate.parsing(easyTemplate.separate(s));
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
                var sRet =
                    s.replace(
                        /(<(\/?)#(.*?(?:\(.*?\))*)>)|(')|([\r\n\t])|(\$\{([^\}]*?)\})/g,
                        function(a,b,c,d,e,f,g,h){
                            if (b) {
                                return '{|}'+(c?'-':'+')+d+'{|}';
                            }
                            if (e) {
                                return '\\\'';
                            }
                            if (f) {
                                return '';
                            }
                            if (g) {
                                return '\'+('+h.replace(r,'\'')+')+\'';
                            }
                        }
                    );
                return sRet;
            };
            easyTemplate.parsing = function(s){
                var mName;
                var vName;
                var sTmp;
                var aTmp;
                var sFL;
                var sEl;
                var aList;
                var aStm = ['var aRet = [];'];
                aList = s.split(/\{\|\}/);
                var r = /\s/;
                while (aList.length) {
                    sTmp = aList.shift();
                    if (!sTmp) {
                        continue;
                    }
                    sFL = sTmp.charAt(0);
                    if (sFL !== '+' && sFL !== '-') {
                        sTmp = '\''+sTmp+'\'';
                        aStm.push('aRet.push('+sTmp+');');
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

        // 字符串
        str: {
            trim: function(str){
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

            decodeHTML: function (str) {
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

            encodeHTML: function (str) {
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
            }
        },

        obj: {
            objSup: function (obj, fList) {
                var that = {};
                for (var i = 0, len = fList.length; i < len; i += 1) {
                    if (typeof obj[fList[i]] !== 'function') {
                        throw 'super need function list '
                                + ' as the second paramsters';
                    }
                    that[fList[i]] = (function (fun) {
                        return function () {
                            return fun.apply(obj, arguments);
                        };
                    })(obj[fList[i]]);
                }
                return that;
            },

            cut: function(obj, list){
                var ret = {};
                if (!result.isArray(list)) {
                    throw 'Lilac.cut need array as second parameter';
                }
                for (var k in obj) {
                    if (!result.inArray(k, list)) {
                        ret[k] = obj[k];
                    }
                }
                return ret;
            }
        },

        // json
        json: {
            jsonToQuery: function(JSON, isEncode) {
                var _fdata = function (data, isEncode) {
                    data = data == null? '': data;
                    data = result.str.trim(data.toString());
                    if (isEncode) {
                        return encodeURIComponent(data);
                    }
                    return data;

                };

                var _Qstring = [];
                if (typeof JSON == 'object') {
                    for (var k in JSON) {
                        if (k === '$nullName') {
                            _Qstring = _Qstring.concat(JSON[k]);
                            continue;
                        }
                        if (JSON[k] instanceof Array) {
                            for(var i = 0, len = JSON[k].length; i < len; i++){
                                _Qstring.push(k + '=' + _fdata(JSON[k][i],isEncode));
                            }
                        }
                        else {
                            if (typeof JSON[k] != 'function') {
                                _Qstring.push(k + '=' +_fdata(JSON[k],isEncode));
                            }
                        }
                    }
                }
                if(_Qstring.length) {
                    return _Qstring.join('&');
                }
                return '';
            },

            queryToJson: function(QS, isDecode) {
                var _Qlist = result.str.trim(QS).split('&');
                var _json = {};
                var _fData = function (data) {
                    if (isDecode) {
                        return decodeURIComponent(data);
                    }
                    else {
                        return data;
                    }
                };
                for (var i = 0, len = _Qlist.length; i < len; i++) {
                    if (_Qlist[i]) {
                        var _hsh = _Qlist[i].split('=');
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
                            if (result.isArray(_json[_key]) != true) {
                                _json[_key] = [_json[_key]];
                            }
                            _json[_key].push(_fData(_value));
                        }
                    }
                }
                return _json;
            }
        },

        dom: {
            parseDOM: function(list){
                for (var a in list) {
                    if (list[a] && (list[a].length == 1)) {
                        list[a] = list[a][0];
                    }
                }
                return list;
            },

            builder: function (sHTML, oSelector) {
                var isHTML = (typeof (sHTML) === 'string');

                // 写入HTML
                var container = sHTML;

                if (isHTML) {
                    container = document.createElement('div');
                    container.innerHTML = sHTML;
                }

                var domList = {};
                var totalList;

                if (oSelector) {
                    for (key in selectorList) {
                        domList[key] = $(oSelector[key].toString(), container);
                    }
                } else {
                    totalList = $('[node-type]', container);
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
                    domBox = document.createDocumentFragment();
                    while (container.childNodes[0]) {
                        domBox.appendChild(container.childNodes[0]);
                    }
                }

                // 返回文档碎片跟节点列表
                return {
                    'box': domBox,
                    'list': domList
                };
            },

            contains:function (parent, node) {
                if (parent === node) {
                    return false;
                } else if (parent.compareDocumentPosition) {
                    return ((parent.compareDocumentPosition(node) & 16) === 16);

                } else if (parent.contains && node.nodeType === 1) {
                    return parent.contains(node);

                } else {
                    while (node = node.parentNode) {
                        if (parent === node) {
                            return true;
                        }
                    }
                }
                return false;
            },

            isNode: function(elem) {
                return (elem != undefined)
                            && Boolean(elem.nodeName)
                            && Boolean(elem.nodeType);
            }
        },

        // 事件
        evt: {
            custEvent: (function(){
                var custEventAttribute = '__custEventKey__';
                var custEventKey = 1;
                var custEventCache = {};
                /**
                 * 从缓存中查找相关对象
                 * 当已经定义时
                 *     有type时返回缓存中的列表 没有时返回缓存中的对象
                 * 没有定义时返回false
                 * @param {Object|number} obj 对象引用或获取的key
                 * @param {String} type 自定义事件名称
                 */
                var findCache = function (obj, type) {
                    var _key =
                        (typeof obj == 'number')
                        ?
                        obj
                        :
                        obj[custEventAttribute];

                    return (_key && custEventCache[_key])
                        &&
                        {
                            obj:
                                (
                                    typeof type == 'string'
                                    ?
                                    custEventCache[_key][type]
                                    :
                                    custEventCache[_key]
                                ),
                            key:_key
                        };
                };

                //事件迁移相关
                var hookCache = {};//arr key -> {origtype-> {fn, desttype}}

                var add = function (obj, type, fn, data, once) {
                    if (obj && typeof type == 'string' && fn) {
                        var _cache = findCache(obj, type);
                        if (!_cache || !_cache.obj) {
                            throw 'custEvent (' + type + ') is undefined !';
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
                    if (obj && typeof type == 'string') {
                        var _cache = findCache(obj, type), _obj;
                        if (_cache && (_obj = _cache.obj)) {
                            args = typeof args != 'undefined'
                                        && [].concat(args) || [];
                            for (
                                var i = _obj.length - 1;
                                i > -1 && _obj[i];
                                i--
                            ) {
                                var fn = _obj[i].fn;
                                var isOnce = _obj[i].once;
                                if (fn && fn.apply) {
                                    try {
                                        fn.apply(
                                            obj,
                                            [
                                                {
                                                    obj:obj,
                                                    type:type,
                                                    data:_obj[i].data,
                                                    preventDefault:preventDefault
                                                }
                                            ].concat(args)
                                        );
                                        if (isOnce) {
                                            _obj.splice(i, 1);
                                        }
                                    } catch (e) {
                                        throw ('[error][custEvent]' + e.message,
                                                e, e.stack);
                                    }
                                }
                            }

                            if (
                                preventDefaultFlag
                                &&
                                typeof (defaultAction) === 'function'
                            ) {
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
                            var _key =
                                (typeof obj == 'number')
                                ?
                                obj
                                :
                                obj[custEventAttribute]
                                    || (obj[custEventAttribute] = custEventKey++);
                            var _cache =
                                custEventCache[_key] || (custEventCache[_key] = {});
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
                    undefine: function (obj, type) {
                        if (obj) {
                            var _key =
                                (typeof obj == 'number')
                                ?
                                obj
                                :
                                obj[custEventAttribute];
                            if (_key && custEventCache[_key]) {
                                if (type) {
                                    type = [].concat(type);
                                    for (var i = 0; i < type.length; i++) {
                                        if (type[i] in custEventCache[_key]) {
                                            delete custEventCache[_key][type[i]];
                                        }
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
                                if (result.isArray(_obj)) {
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
                     *      源事件名->目标事件名
                     * }
                     */
                    hook:function (orig, dest, typeMap) {
                        if (!orig || !dest || !typeMap) {
                            return;
                        }
                        var destTypes = [];
                        var origKey = orig[custEventAttribute];
                        var origKeyCache = origKey && custEventCache[origKey];
                        var origTypeCache;
                        var destKey =
                            dest[custEventAttribute]
                                || (dest[custEventAttribute] = custEventKey++);
                        var keyHookCache;
                        if (origKeyCache) {
                            keyHookCache =
                                hookCache[origKey + '_' + destKey]
                                   || (hookCache[origKey + '_' + destKey] = {});
                            var fn = function (event) {
                                var preventDefaultFlag = true;
                                fire(
                                    dest,
                                    keyHookCache[event.type].type,
                                    Array.prototype.slice.apply(
                                        arguments,
                                        [1, arguments.length]
                                    ),
                                    function () {
                                        preventDefaultFlag = false
                                    }
                                );
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
                             *  源事件名->目标事件名
                             * }
                     */
                    unhook:function (orig, dest, typeMap) {
                        if (!orig || !dest || !typeMap) {
                            return;
                        }
                        var origKey = orig[custEventAttribute];
                        var destKey = dest[custEventAttribute];
                        var keyHookCache = hookCache[origKey + '_' + destKey];
                        if (keyHookCache) {
                            for (var origType in typeMap) {
                                var destType = typeMap[origType];
                                if (keyHookCache[origType]) {
                                    that.remove(
                                        orig,
                                        origType,
                                        keyHookCache[origType].fn
                                    );
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
            })()
        }
    }

    return result;
});

/**
 * common模块 配置
 */
define('common/config', {

    /**
     * ajax接口管理
     */
    AJAX: {
        SEARCH_SUGGESTION: 'http://zanbai.com:8090/?business=shop&limit=10&piece='
    }
});

/**
 * login模块
 */
// define(['jquery'], function($, require){
define('common/login', function(require){

    var util = require('util');
    var config = require('common/config');
    var hogan = require('hogan');
    var popup = require('widget/popup/main');

    var LOGINTPL = ''
        + '<div id="login-layer-wraper">'
        +     '<div class="layer_login detail">'
        +         '<p class="login_title"></p>'
        +         '<div class="login_icon_wrap">'
        +             '<ul class="icon_list clearfix">'
        +                 '<li>'
        +                     '<a class="cur" href="../callback/weibo/?source_url={{sourceUrl}}">'
        +                         '<em class="icon_sns weibo_login"></em><span>weibo</span>'
        +                     '</a>'
        +                 '</li>'
        +                 '<li>'
        +                     '<a class="cur" href="../callback/qq/?source_url={{sourceUrl}}">'
        +                         '<em class="icon_sns QQ_login"></em><span>tencent</span>'
        +                     '</a>'
        +                 '</li>'
        +                 '<li>'
        +                     '<a class="cur" href="../callback/douban">'
        +                         '<em class="icon_sns douban_login"></em><span>douban</span>'
        +                     '</a>'
        +                 '</li>'
        +                 '<li>'
        +                     '<a class="cur" href="../callback/renren/?source_url={{sourceUrl}}">'
        +                         '<em class="icon_sns renren_login"></em><span>renren</span>'
        +                     '</a>'
        +                 '</li>'
        +                 '<li>'
        +                     '<a href="javascript:void(0);">'
        +                         '<em class="icon_sns facebook_login"></em><span>facebook</span>'
        +                     '</a>'
        +                 '</li>'
        +                 '<li>'
        +                     '<a href="javascript:void(0);">'
        +                         '<em class="icon_sns twitter_login"></em><span>twitter</span>'
        +                     '</a>'
        +                 '</li>'
        +             '</ul>'
        +         '</div>'
        +         '<div class="sign_wrap">'
        +             '<h3>使用Zanbai登录</h3>'
        +             '<div class="info_list clearfix">'
        +                 '<div class="tit fl"><i>*</i>账号：</div>'
        +                 '<div class="inp">'
        +                     '<input name="email" type="text" class="W_input" id="email" value="">'
        +                 '</div>'
        +             '</div>'
        +             '<div class="info_list clearfix">'
        +                 '<div class="tit fl"><i>*</i>密码：</div>'
        +                 '<div class="inp">'
        +                     '<input name="passwd" type="password" class="W_input" id="passwd" value="">'
        +                 '</div>'
        +                 '<div class="tips"></div>'
        +             '</div>'
        +         '</div>'
        +         '<div class="btn_wrap">'
        +             '<a href="javascript:void(0);" id="header-login" class="login_btn">立即登录</a>'
        +             '<a target="_blank" href="/register/?source_url={{sourceUrl}}" class="sign_btn">立即注册</a>'
        +         '</div>'
        +     '</div>'
        + '</div>';

    var LOGINHTML = hogan.compile(LOGINTPL).render({
        sourceUrl: $CONFIG.sourceUrl
    });

    function bindEvts(popup) {
        // var headerLogin = $.sizzle('#header-login', popup.getInner())[0];
        // var emailVal = $.sizzle('#email', popup.getInner())[0];
        // var passVal = $.sizzle('#passwd', popup.getInner())[0];
    }

    return {
        show: function(){
            var loginPopup = popup.createModulePopup({
                // 'isDrag': false
            });
            loginPopup.setTitle('提示');
            loginPopup.setContent(LOGINHTML);
            loginPopup.show();
            loginPopup.setMiddle();
            bindEvts(loginPopup);
        }
    }

    /*var TEMP = '' +
        '<div class="detail">' +
            '<div class="clearfix">' +
                '<div>' +
                    '<p>sadasd撒大</p>' +
                '</div>' +
                '<div class="btn">' +
                    '<a class="W_btn_a" href="javascript:void(0);" node-type="cancelBtn">' +
                        '<span>确认</span>' +
                    '</a>' +
                '</div>' +
            '</div>' +
        '</div>';

    var a = popup.createModulePopup({
        // 'isDrag': false
    });
    a.setTitle("提示");
    a.setContent(TEMP);
    a.show();
    a.setMiddle();*/

    // var nodes = util.dom.parseDOM(util.dom.builder(a.getInner()).list);
    // $(nodes.cancelBtn).on('click', function () {
    //     a.destroy();
    // });

    // popup.litePrompt('添加成功！', {
    //     'timeout': 1500
    // });

    // popup.createModuleMask.show();
    // popup.test();
});

/**
 * 浮层
 */
define('widget/popup/main', function(require){

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
                            && Lilac.browser.IE));

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

    return {
        createModulePopup: createModulePopup,
        litePrompt: litePrompt
    }
});

/**
 * 拖拽
 */
define('widget/drag/main',function(require){

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