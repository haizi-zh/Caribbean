/**
 * imgclip
 */
define(function(require){
    var $ = require('jquery');

    function ImgClip (img, options) {
        var $area = $('<div/>');
        var $border1 = $('<div/>');
        var $border2 = $('<div/>');
        var $outLeft = $('<div/>');
        var $outTop = $('<div/>');
        var $outRight = $('<div/>');
        var $outBottom = $('<div/>');
        var imgOfs;
        var imgWidth;
        var imgHeight;
        var parent;
        var parOfs;
        var parScroll;
        var adjusted;
        var zIndex = 0;
        var fixed;
        var $p;
        var startX;
        var startY;
        var moveX;
        var moveY;
        var resizeMargin = 10;
        var resize = [];
        var V = 0;
        var H = 1;
        var keyDown;
        var d;
        var aspectRatio;
        var x1;
        var x2;
        var y1;
        var y2;
        var x;
        var y;
        var left;
        var top;
        var selection = {
            x1: 0,
            y1: 0,
            x2: 0,
            y2: 0,
            width: 0,
            height: 0
        };

        $area.attr('id', 'area');
        $border1.attr('id', 'border1');
        $border2.attr('id', 'border2');
        $outLeft.attr('id', 'outLeft');
        $outTop.attr('id', 'outTop');
        $outRight.attr('id', 'outRight');
        $outBottom.attr('id', 'outBottom');


        function viewX(x) {
            return parseInt(x + imgOfs.left + parScroll.left - parOfs.left, 10);
        }
        function viewY(y) {
            return parseInt(y + imgOfs.top+ parScroll.top - parOfs.top, 10);
        }
        function selX(x) {
            return parseInt(x - imgOfs.left - parScroll.left + parOfs.left, 10);
        }
        function selY(y) {
            return parseInt(y - imgOfs.top- parScroll.top + parOfs.top, 10);
        }
        function evX(event) {
            return parseInt(event.pageX + parScroll.left - parOfs.left, 10);
        }
        function evY(event) {
            return parseInt(event.pageY + parScroll.top - parOfs.top, 10);
        }

        function adjust() {
            imgOfs = $(img).position();
            imgWidth = parseInt($(img).css('width'), 10);
            imgHeight = parseInt($(img).css('height'), 10);

            if ($(parent)[0].tagName.toLowerCase() == 'body') {
                parOfs = parScroll = {
                    left: 0,
                    top: 0
                };
            }
            else {
                parOfs = $(parent).position();
                parScroll = {
                    left: parent.scrollLeft,
                    top: parent.scrollTop
                }
            }
            left = viewX(0);
            top = viewY(0);
        }

        function update() {
            try{
                $area.css('left', viewX(selection.x1) + 'px');
                $area.css('top', viewY(selection.y1) + 'px');
                $area.css('width', Math.max(selection.width - options.borderWidth * 2, 0) + 'px');
                $area.css('height', Math.max(selection.height - options.borderWidth * 2, 0) + 'px');

                $border1.css('left', viewX(selection.x1) + 'px');
                $border1.css('top', viewY(selection.y1) + 'px');
                $border1.css('width', Math.max(selection.width - options.borderWidth * 2, 0) + 'px');
                $border1.css('height', Math.max(selection.height - options.borderWidth * 2, 0) + 'px');

                $border2.css('left', viewX(selection.x1) + 'px');
                $border2.css('top', viewY(selection.y1) + 'px');
                $border2.css('width', Math.max(selection.width - options.borderWidth * 2, 0) + 'px');
                $border2.css('height', Math.max(selection.height - options.borderWidth * 2, 0) + 'px');


                $outLeft.css('left', left + 'px');
                $outLeft.css('top', top + 'px');
                $outLeft.css('width', selection.x1 + 'px');
                $outLeft.css('height', imgHeight + 'px');

                $outTop.css('left', left + selection.x1 + 'px');
                $outTop.css('top', top + 'px');
                $outTop.css('width', selection.width + 'px');
                $outTop.css('height', selection.y1 + 'px');

                $outRight.css('left', left + selection.x2 + 'px');
                $outRight.css('top', top + 'px');
                $outRight.css('width', imgWidth - selection.x2 + 'px');
                $outRight.css('height', imgHeight + 'px');

                $outBottom.css('left', left + selection.x1 + 'px');
                $outBottom.css('top', top + selection.y2 + 'px');
                $outBottom.css('width', selection.width + 'px');
                $outBottom.css('height', imgHeight - selection.y2 + 'px');
            }catch(e){
            }
        }

        function areaMouseMove(event) {
            if (!adjusted) {
                adjust();
                adjusted = true;
                var t1 = function() {
                    adjusted = false;
                    $area.on('mouseout', t1);
                }
                var t2 = function() {
                    adjusted = false;
                    $border1.on('mouseout', t2);
                }
                var t3= function() {
                    adjusted = false;
                    $border2.on('mouseout', t2);
                }

                $area.on('mouseout', t1);
                $border1.on('mouseout', t2);
                $border2.on('mouseout', t3);
            }
            x = selX(evX(event)) - selection.x1;
            y = selY(evY(event)) - selection.y1;
            resize = [];
            if (options.resizable) {
                if (y <= resizeMargin) resize[V] = 'n';
                else if (y >= selection.height - resizeMargin) resize[V] = 's';
                if (x <= resizeMargin) resize[H] = 'w';
                else if (x >= selection.width - resizeMargin) resize[H] = 'e'
            }
            $border2.css('cursor', resize.length ? resize.join('') + '-resize': options.movable ? 'move': '');
        }

        function areaMouseDown(event) {
            if (event.which != 1) return false;
            adjust();
            if (options.resizable && resize.length > 0) {
                $('body').css('cursor', resize.join('') + '-resize');
                x1 = viewX(resize[H] == 'w' ? selection.x2: selection.x1);
                y1 = viewY(resize[V] == 'n' ? selection.y2: selection.y1);
                $(document).on('mousemove', selectingMouseMove);
                $border2.off('mousemove', areaMouseMove);
                var func = function() {
                    resize = [];
                    $('body').css('cursor', '');
                    if (options.autoHide) {
                        $area.css('display', 'none');
                        $border1.css('display', 'none');
                        $border2.css('display', 'none');

                        $outLeft.css('display', 'none');
                        $outTop.css('display', 'none');
                        $outRight.css('display', 'none');
                        $outBottom.css('display', 'none');

                    }
                    options.onSelectEnd(img, selection);
                    $(document).off('mousemove', selectingMouseMove);
                    $border2.on('mousemove', areaMouseMove);
                    $(document).off('mouseup', func);
                };
                $(document).on('mouseup', func);
            } else if (options.movable) {
                moveX = selection.x1 + left;
                moveY = selection.y1 + top;
                startX = evX(event);
                startY = evY(event);

                $(document).on('mousemove', movingMouseMove);
                var func = function() {
                    options.onSelectEnd(img, selection);
                    $(document).off('mousemove', movingMouseMove);
                    $(document).off('mouseup', func);
                };

                $(document).on('mouseup', func);

            }
            return false;
        }

        function aspectRatioXY() {
            x2 = Math.max(left, Math.min(left + imgWidth, x1 + Math.abs(y2 - y1) * aspectRatio * (x2 >= x1 ? 1 : -1)));
            y2 = Math.round(Math.max(top, Math.min(top + imgHeight, y1 + Math.abs(x2 - x1) / aspectRatio * (y2 >= y1 ? 1 : -1))));
            x2 = Math.round(x2);
        }

        function aspectRatioYX() {
            y2 = Math.max(top, Math.min(top + imgHeight, y1 + Math.abs(x2 - x1) / aspectRatio * (y2 >= y1 ? 1 : -1)));
            x2 = Math.round(Math.max(left, Math.min(left + imgWidth, x1 + Math.abs(y2 - y1) * aspectRatio * (x2 >= x1 ? 1 : -1))));
            y2 = Math.round(y2)
        }

        function doResize(newX2, newY2) {
            x2 = newX2;
            y2 = newY2;
            if (options.minWidth && Math.abs(x2 - x1) < options.minWidth) {
                x2 = x1 - options.minWidth * (x2 < x1 ? 1 : -1);
                if (x2 < left) {
                    x1 = left + options.minWidth;
                } else if (x2 > left + imgWidth) {
                    x1 = left + imgWidth - options.minWidth;
                }
            }

            if (options.minHeight && Math.abs(y2 - y1) < options.minHeight) {
                y2 = y1 - options.minHeight * (y2 < y1 ? 1 : -1);
                if (y2 < top) {
                    y1 = top + options.minHeight;
                }
                else if (y2 > top + imgHeight) {
                    y1 = top + imgHeight - options.minHeight;
                }
            }

            x2 = Math.max(left, Math.min(x2, left + imgWidth));
            y2 = Math.max(top, Math.min(y2, top + imgHeight));
            if (aspectRatio) if (Math.abs(x2 - x1) / aspectRatio > Math.abs(y2 - y1)) aspectRatioYX();
            else aspectRatioXY();
            if (options.maxWidth && Math.abs(x2 - x1) > options.maxWidth) {
                x2 = x1 - options.maxWidth * (x2 < x1 ? 1 : -1);
                if (aspectRatio) aspectRatioYX()
            }
            if (options.maxHeight && Math.abs(y2 - y1) > options.maxHeight) {
                y2 = y1 - options.maxHeight * (y2 < y1 ? 1 : -1);
                if (aspectRatio) aspectRatioXY()
            }
            selection.x1 = selX(Math.min(x1, x2));
            selection.x2 = selX(Math.max(x1, x2));
            selection.y1 = selY(Math.min(y1, y2));
            selection.y2 = selY(Math.max(y1, y2));
            selection.width = Math.abs(x2 - x1);
            selection.height = Math.abs(y2 - y1);
            update();
            options.onSelectChange(img, selection);
        }

        function selectingMouseMove(event) {
            x2 = !resize.length || resize[H] || aspectRatio ? evX(event) : viewX(selection.x2);
            y2 = !resize.length || resize[V] || aspectRatio ? evY(event) : viewY(selection.y2);
            doResize(x2, y2);
            return false;
        }

        function doMove(newX1, newY1) {
            x2 = (x1 = newX1) + selection.width;
            y2 = (y1 = newY1) + selection.height;
            selection.x1 = selX(x1);
            selection.y1 = selY(y1);
            selection.x2 = selX(x2);
            selection.y2 = selY(y2);
            update();
            options.onSelectChange(img, selection);
        }

        function movingMouseMove(event) {
            var newX1 = Math.max(left, Math.min(moveX + evX(event) - startX, left + imgWidth - selection.width));
            var newY1 = Math.max(top, Math.min(moveY + evY(event) - startY, top + imgHeight - selection.height));
            doMove(newX1, newY1);
            event.preventDefault();
            return false;
        }

        function startSelection(event) {
            adjust();
            selection.x1 = selection.x2 = selX(startX = x1 = x2 = evX(event));
            selection.y1 = selection.y2 = selY(startY = y1 = y2 = evY(event));
            selection.width = 0;
            selection.height = 0;
            resize = [];
            update();
            $area.css('display', '');
            $border1.css('display', '');
            $border2.css('display', '');

            $outLeft.css('display', '');
            $outTop.css('display', '');
            $outRight.css('display', '');
            $outBottom.css('display', '');

            $(document).off('mouseup', cancelSelection);

            $(document).on('mousemove', selectingMouseMove);
            $border2.off('mousemove', areaMouseMove);
            options.onSelectStart(img, selection);
            var func = function() {
                if (options.autoHide || (selection.width * selection.height == 0)) {
                    $area.css('display', 'none');
                    $border1.css('display', 'none');
                    $border2.css('display', 'none');

                    $outLeft.css('display', 'none');
                    $outTop.css('display', 'none');
                    $outRight.css('display', 'none');
                    $outBottom.css('display', 'none');
                }
                options.onSelectEnd(img, selection);
                $(document).off('mousemove', selectingMouseMove);
                $border2.on('mousemove', areaMouseMove);

                $(document).off('mouseup', func);
            };

            $(document).on('mouseup', func);
        }

        function cancelSelection() {
            $(document).off('mousemove', startSelection);
            $area.css('display', 'none');
            $border1.css('display', 'none');
            $border2.css('display', 'none');

            $outLeft.css('display', 'none');
            $outTop.css('display', 'none');
            $outRight.css('display', 'none');
            $outBottom.css('display', 'none');
        }

        function imgMouseDown(event) {
            if (event.which != 1) return false;

            function startSelectionSub(evt){
                adjust();
                selection.x1 = selection.x2 = selX(startX = x1 = x2 = evX(evt));
                selection.y1 = selection.y2 = selY(startY = y1 = y2 = evY(evt));
                selection.width = 0;
                selection.height = 0;
                resize = [];
                update();
                $area.css('display', '');
                $border1.css('display', '');
                $border2.css('display', '');

                $outLeft.css('display', '');
                $outTop.css('display', '');
                $outRight.css('display', '');
                $outBottom.css('display', '');

                $(document).off('mouseup', cancelSelectionSub);
                $(document).on('mousemove', selectingMouseMove);
                $border2.off('mousemove', areaMouseMove);
                options.onSelectStart(img, selection);
                var func = function() {
                    if (options.autoHide || (selection.width * selection.height == 0)) {
                        $area.css('display', 'none');
                        $border1.css('display', 'none');
                        $border2.css('display', 'none');

                        $outLeft.css('display', 'none');
                        $outTop.css('display', 'none');
                        $outRight.css('display', 'none');
                        $outBottom.css('display', 'none');
                    }
                    options.onSelectEnd(img, selection);
                    $(document).off('mousemove', selectingMouseMove);
                    $border2.on('mousemove', areaMouseMove);

                    $(document).off('mouseup', func);
                };
                $(document).on('mouseup', func);

                $(document).off('mousemove', startSelectionSub);
            };

            $(document).on('mousemove', startSelectionSub);

            function cancelSelectionSub(){
                $(document).off('mousemove', startSelectionSub);
                $area.css('display', 'none');
                $border1.css('display', 'none');
                $border2.css('display', 'none');

                $outLeft.css('display', 'none');
                $outTop.css('display', 'none');
                $outRight.css('display', 'none');
                $outBottom.css('display', 'none');

                $(document).off('mouseup', cancelSelectionSub);
            };


            $(document).on('mouseup', cancelSelectionSub);
            return false;
        }

        function windowResize() {
            adjust();
            update(false);
            x1 = viewX(selection.x1);
            y1 = viewY(selection.y1);
            x2 = viewX(selection.x2);
            y2 = viewY(selection.y2);
        }


        function setOptions (newOptions) {
            options = $.extend(options, newOptions);
            if (newOptions.x1 != null) {
                selection.x1 = newOptions.x1;
                selection.y1 = newOptions.y1;
                selection.x2 = newOptions.x2;
                selection.y2 = newOptions.y2;
                newOptions.show = true
            }

            if (newOptions.keys){
                options.keys = $.extend({
                    shift: 1,
                    ctrl: 'resize'
                },newOptions.keys === true ? {}: newOptions.keys);
            }

            parent = $(options.parent)[0];

            adjust();
            $p = $(img);

            while ($p.length && ($p[0].tagName.toLowerCase() != 'body')) {
                if (!isNaN($p.css('z-index')) && $p.css('z-index') > zIndex) {
                    zIndex = $p.css('z-index');
                }

                if ($p.css('position') == 'fixed') {
                    fixed = true;
                }
                $p = $($p[0].parentNode);
            }

            x1 = viewX(selection.x1);
            y1 = viewY(selection.y1);
            x2 = viewX(selection.x2);
            y2 = viewY(selection.y2);
            selection.width = x2 - x1;
            selection.height = y2 - y1;
            update();
            if (newOptions.hide) {
                $area.css('display', 'none');
                $border1.css('display', 'none');
                $border2.css('display', 'none');

                $outLeft.css('display', 'none');
                $outTop.css('display', 'none');
                $outRight.css('display', 'none');
                $outBottom.css('display', 'none');

            }
            else if (newOptions.show) {
                $area.css('display', '');
                $border1.css('display', '');
                $border2.css('display', '');

                $outLeft.css('display', '');
                $outTop.css('display', '');
                $outRight.css('display', '');
                $outBottom.css('display', '');
            }

            $outLeft.addClass(options.classPrefix + '-outer');
            $outTop.addClass(options.classPrefix + '-outer');
            $outRight.addClass(options.classPrefix + '-outer');
            $outBottom.addClass(options.classPrefix + '-outer');


            $area.addClass(options.classPrefix + '-selection');
            $border1.addClass(options.classPrefix + '-border1');
            $border2.addClass(options.classPrefix + '-border2');


            $area.css('borderWidth', options.borderWidth + 'px');
            $border1.css('borderWidth', options.borderWidth + 'px');
            $border2.css('borderWidth', options.borderWidth + 'px');


            $area.css('backgroundColor', options.selectionColor);
            $area.css('opacity', options.selectionOpacity);

            $border1.css('borderStyle','solid');
            $border1.css('borderColor', options.borderColor1);

            $border1.css('borderStyle','dashed');
            $border1.css('borderColor', options.borderColor2);

            $outLeft.css('opacity',options.outerOpacity);
            $outLeft.css('backgroundColor', options.outerColor);

            $outTop.css('opacity',options.outerOpacity);
            $outTop.css('backgroundColor', options.outerColor);

            $outRight.css('opacity',options.outerOpacity);
            $outRight.css('backgroundColor', options.outerColor);

            $outBottom.css('opacity',options.outerOpacity);
            $outBottom.css('backgroundColor', options.outerColor);


            aspectRatio = options.aspectRatio && (d = options.aspectRatio.split(/:/)) ? d[0] / d[1] : null;
            if (options.disable || options.enable === false) {
                $area.off('mousemove', areaMouseMove);
                $area.off('mousedown', areaMouseDown);


                $border1.off('mousemove', areaMouseMove);
                $border1.off('mousedown', areaMouseDown);
                $border2.off('mousemove', areaMouseMove);
                $border2.off('mousedown', areaMouseDown);

                $(img).off('mousedown', imgMouseDown);

                $outLeft.off('mousedown', imgMouseDown);
                $outTop.off('mousedown', imgMouseDown);
                $outRight.off('mousedown', imgMouseDown);
                $outBottom.off('mousedown', imgMouseDown);

                $(window).off('resize', windowResize)
            } else if (options.enable || options.disable === false) {
                if (options.resizable || options.movable) {
                    $area.on('mousemove', areaMouseMove);
                    $area.on('mousedown', areaMouseDown);
                    $border1.on('mousemove', areaMouseMove);
                    $border1.on('mousedown', areaMouseDown);
                    $border2.on('mousemove', areaMouseMove);
                    $border2.on('mousedown', areaMouseDown);
                }
                if (!options.persistent) {
                    $(img).on('mousedown', imgMouseDown);
                    $outLeft.on('mousedown', imgMouseDown);
                    $outTop.on('mousedown', imgMouseDown);
                    $outRight.on('mousedown', imgMouseDown);
                    $outBottom.on('mousedown', imgMouseDown);
                }
                $(window).on('resize', windowResize);
            }
            $(options.parent)[0].appendChild($outLeft[0]);
            $(options.parent)[0].appendChild($outTop[0]);
            $(options.parent)[0].appendChild($outRight[0]);
            $(options.parent)[0].appendChild($outBottom[0]);
            $(options.parent)[0].appendChild($outLeft[0]);

            $(options.parent)[0].appendChild($area[0]);
            $(options.parent)[0].appendChild($border1[0]);
            $(options.parent)[0].appendChild($border2[0]);

            options.enable = options.disable = undefined;
        };

        if ($.browser.msie) {
            img.attr('unselectable', 'on');
        }

        $area.css('display', 'none');
        $area.css('position', fixed ? 'fixed': 'absolute');
        $area.css('overflow', 'hidden');
        $area.css('zIndex', zIndex > 0 ? zIndex: '0');

        $border1.css('display', 'none');
        $border1.css('position', fixed ? 'fixed': 'absolute');
        $border1.css('overflow', 'hidden');
        $border1.css('zIndex', zIndex > 0 ? zIndex: '0');

        $border2.css('display', 'none');
        $border2.css('position', fixed ? 'fixed': 'absolute');
        $border2.css('overflow', 'hidden');
        $border2.css('zIndex', zIndex > 0 ? zIndex: '0');

        $outLeft.css('display', 'none');
        $outLeft.css('position', fixed ? 'fixed': 'absolute');
        $outLeft.css('overflow', 'hidden');
        $outLeft.css('zIndex', zIndex > 0 ? zIndex: '0');

        $outTop.css('display', 'none');
        $outTop.css('position', fixed ? 'fixed': 'absolute');
        $outTop.css('overflow', 'hidden');
        $outTop.css('zIndex', zIndex > 0 ? zIndex: '0');


        $outRight.css('display', 'none');
        $outRight.css('position', fixed ? 'fixed': 'absolute');
        $outRight.css('overflow', 'hidden');
        $outRight.css('zIndex', zIndex > 0 ? zIndex: '0');

        $outBottom.css('display', 'none');
        $outBottom.css('position', fixed ? 'fixed': 'absolute');
        $outBottom.css('overflow', 'hidden');
        $outBottom.css('zIndex', zIndex > 0 ? zIndex: '0');


        $area.css('borderStyle', 'solid');

        var initOptions = {
            borderColor1: '#000',
            borderColor2: '#fff',
            borderWidth: 1,
            classPrefix: 'imgClip',
            movable: true,
            resizable: true,
            selectionColor: '#fff',
            selectionOpacity: 0.2,
            outerColor: '#000',
            outerOpacity: 0.2,
            parent: 'body',
            onSelectStart: function() {},
            onSelectChange: function() {},
            onSelectEnd: function() {}
        };

        options = $.extend(initOptions, options);
        setOptions(options);
    }

    return {
        init: function (imgDom, options) {
            options = options || {};
            options.enable = true;
            new ImgClip(imgDom, options);
        }
    }

});