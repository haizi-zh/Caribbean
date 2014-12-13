(function ($) {
    $.imgClip = {};

    $.imgClip.init = function(img, options) {
        var $area = $($.C('div')),
            $border1 = $($.C('div')),
            $border2 = $($.C('div')),
            $outLeft = $($.C('div')),
            $outTop = $($.C('div')),
            $outRight = $($.C('div')),
            $outBottom = $($.C('div')),
            left,
            top,
            imgOfs,
            imgWidth,
            imgHeight,
            parent,
            parOfs,
            parScroll,
            adjusted,
            zIndex = 0,
            fixed,
            $p,
            startX,
            startY,
            moveX,
            moveY,
            resizeMargin = 10,
            resize = [],
            V = 0,
            H = 1,
            keyDown,
            d,
            aspectRatio,
            x1,
            x2,
            y1,
            y2,
            x,
            y,
            selection = {
                x1: 0,
                y1: 0,
                x2: 0,
                y2: 0,
                width: 0,
                height: 0
            };

            $area[0].setAttribute('id', 'area');
            $border1[0].setAttribute('id', 'border1');
            $border2[0].setAttribute('id', 'border2');
            $outLeft[0].setAttribute('id', 'outLeft');
            $outTop[0].setAttribute('id', 'outTop');
            $outRight[0].setAttribute('id', 'outRight');
            $outBottom[0].setAttribute('id', 'outBottom');
        function viewX(x) {
            // if (!imgOfs || !parScroll || !parOfs) {
            //     return 0;
            // }
            return parseInt(x + imgOfs.l + parScroll.l - parOfs.l, 10);
        }
        function viewY(y) {
            // if (!imgOfs || !parScroll || !parOfs) {
            //     return 0;
            // }
            return parseInt(y + imgOfs.t + parScroll.t - parOfs.t, 10);
        }
        function selX(x) {
            // if (!imgOfs || !parScroll || !parOfs) {
            //     return 0;
            // }
            return parseInt(x - imgOfs.l - parScroll.l + parOfs.l, 10);
        }
        function selY(y) {
            // if (!imgOfs || !parScroll || !parOfs) {
            //     return 0;
            // }
            return parseInt(y - imgOfs.t - parScroll.t + parOfs.t, 10);
        }
        function evX(event) {
            // if (!parScroll || !parOfs) {
            //     return 0;
            // }
            return parseInt(event.pageX + parScroll.l - parOfs.l, 10);
        }
        function evY(event) {
            // if (!parScroll || !parOfs) {
            //     return 0;
            // }
            return parseInt(event.pageY + parScroll.t - parOfs.t, 10);
        }

        function adjust() {
            imgOfs = $(img).getPos();
            // console.log($(img)[0],$(img)[0].id);
            // console.log($(img).getPos());
            imgWidth = parseInt($(img).getStyle('width'), 10);
            imgHeight = parseInt($(img).getStyle('height'), 10);

            if($(parent)[0].tagName.toLowerCase() == 'body'){
                parOfs = parScroll = {
                    l: 0,
                    t: 0
                };
            }else{
                parOfs = $(parent).getPos();
                parScroll = {
                    l: parent.scrollLeft,
                    t: parent.scrollTop
                }
            }
            l = viewX(0);
            t = viewY(0);
        }


        function update() {
            try{
                $area.setStyle('left', viewX(selection.x1) + 'px');
                $area.setStyle('top', viewY(selection.y1) + 'px');
                $area.setStyle('width', Math.max(selection.width - options.borderWidth * 2, 0) + 'px');
                $area.setStyle('height', Math.max(selection.height - options.borderWidth * 2, 0) + 'px');

                $border1.setStyle('left', viewX(selection.x1) + 'px');
                $border1.setStyle('top', viewY(selection.y1) + 'px');
                $border1.setStyle('width', Math.max(selection.width - options.borderWidth * 2, 0) + 'px');
                $border1.setStyle('height', Math.max(selection.height - options.borderWidth * 2, 0) + 'px');

                $border2.setStyle('left', viewX(selection.x1) + 'px');
                $border2.setStyle('top', viewY(selection.y1) + 'px');
                $border2.setStyle('width', Math.max(selection.width - options.borderWidth * 2, 0) + 'px');
                $border2.setStyle('height', Math.max(selection.height - options.borderWidth * 2, 0) + 'px');


                $outLeft.setStyle('left', l + 'px');
                $outLeft.setStyle('top', t + 'px');
                $outLeft.setStyle('width', selection.x1 + 'px');
                $outLeft.setStyle('height', imgHeight + 'px');

                $outTop.setStyle('left', l + selection.x1 + 'px');
                $outTop.setStyle('top', t + 'px');
                $outTop.setStyle('width', selection.width + 'px');
                $outTop.setStyle('height', selection.y1 + 'px');

                $outRight.setStyle('left', l + selection.x2 + 'px');
                $outRight.setStyle('top', t + 'px');
                $outRight.setStyle('width', imgWidth - selection.x2 + 'px');
                $outRight.setStyle('height', imgHeight + 'px');

                $outBottom.setStyle('left', l + selection.x1 + 'px');
                $outBottom.setStyle('top', t + selection.y2 + 'px');
                $outBottom.setStyle('width', selection.width + 'px');
                $outBottom.setStyle('height', imgHeight - selection.y2 + 'px');
            }catch(e){
            }
        }


        function areaMouseMove(event) {
            if (!adjusted) {
                adjust();
                adjusted = true;
                var t1 = function() {
                    adjusted = false;
                    $area.addEvent('mouseout', t1);
                }
                var t2 = function() {
                    adjusted = false;
                    $border1.addEvent('mouseout', t2);
                }
                var t3= function() {
                    adjusted = false;
                    $border2.addEvent('mouseout', t2);
                }

                $area.addEvent('mouseout', t1);
                $border1.addEvent('mouseout', t2);
                $border2.addEvent('mouseout', t3);
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
            $border2.setStyle('cursor', resize.length ? resize.join('') + '-resize': options.movable ? 'move': '')

        }

        function areaMouseDown(event) {
            if (event.which != 1) return false;
            adjust();
            if (options.resizable && resize.length > 0) {
                $('body').setStyle('cursor', resize.join('') + '-resize');
                x1 = viewX(resize[H] == 'w' ? selection.x2: selection.x1);
                y1 = viewY(resize[V] == 'n' ? selection.y2: selection.y1);
                $(document).addEvent('mousemove', selectingMouseMove);
                $border2.removeEvent('mousemove', areaMouseMove);

                var func = function() {
                    resize = [];
                    $('body').setStyle('cursor', '');
                    if (options.autoHide) {
                        $area.setStyle('display', 'none');
                        $border1.setStyle('display', 'none');
                        $border2.setStyle('display', 'none');

                        $outLeft.setStyle('display', 'none');
                        $outTop.setStyle('display', 'none');
                        $outRight.setStyle('display', 'none');
                        $outBottom.setStyle('display', 'none');

                    }
                    options.onSelectEnd(img, selection);
                    $(document).removeEvent('mousemove', selectingMouseMove);
                    $border2.addEvent('mousemove', areaMouseMove);
                    $(document).removeEvent('mouseup', func);
                };
                $(document).addEvent('mouseup', func);
            } else if (options.movable) {
                moveX = selection.x1 + l;
                moveY = selection.y1 + t;
                startX = evX(event);
                startY = evY(event);

                $(document).addEvent('mousemove', movingMouseMove);
                var func = function() {
                    options.onSelectEnd(img, selection);
                    $(document).removeEvent('mousemove', movingMouseMove);
                    $(document).removeEvent('mouseup', func);
                };

                $(document).addEvent('mouseup', func);

            }
            return false;

        }

        function aspectRatioXY() {
            x2 = Math.max(l, Math.min(l + imgWidth, x1 + Math.abs(y2 - y1) * aspectRatio * (x2 >= x1 ? 1 : -1)));
            y2 = Math.round(Math.max(t, Math.min(t + imgHeight, y1 + Math.abs(x2 - x1) / aspectRatio * (y2 >= y1 ? 1 : -1))));
            x2 = Math.round(x2);
        }

        function aspectRatioYX() {
            y2 = Math.max(t, Math.min(t + imgHeight, y1 + Math.abs(x2 - x1) / aspectRatio * (y2 >= y1 ? 1 : -1)));
            x2 = Math.round(Math.max(l, Math.min(l + imgWidth, x1 + Math.abs(y2 - y1) * aspectRatio * (x2 >= x1 ? 1 : -1))));
            y2 = Math.round(y2)
        }

        function doResize(newX2, newY2) {
            x2 = newX2;
            y2 = newY2;
            if (options.minWidth && Math.abs(x2 - x1) < options.minWidth) {
                x2 = x1 - options.minWidth * (x2 < x1 ? 1 : -1);
                if (x2 < l) {
                    x1 = l + options.minWidth;
                } else if (x2 > l + imgWidth) {
                    x1 = l + imgWidth - options.minWidth;
                }
            }

            if (options.minHeight && Math.abs(y2 - y1) < options.minHeight) {
                y2 = y1 - options.minHeight * (y2 < y1 ? 1 : -1);
                if (y2 < t) {
                    y1 = t + options.minHeight;
                }
                else if (y2 > t + imgHeight) {
                    y1 = t + imgHeight - options.minHeight;
                }
            }

            x2 = Math.max(l, Math.min(x2, l + imgWidth));
            y2 = Math.max(t, Math.min(y2, t + imgHeight));
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
            var newX1 = Math.max(l, Math.min(moveX + evX(event) - startX, l + imgWidth - selection.width));
            var newY1 = Math.max(t, Math.min(moveY + evY(event) - startY, t + imgHeight - selection.height));
            doMove(newX1, newY1);
            event.preventDefault();
            return false
        }

        function startSelection(event) {
            adjust();
            selection.x1 = selection.x2 = selX(startX = x1 = x2 = evX(event));
            selection.y1 = selection.y2 = selY(startY = y1 = y2 = evY(event));
            selection.width = 0;
            selection.height = 0;
            resize = [];
            update();
            $area.setStyle('display', '');
            $border1.setStyle('display', '');
            $border2.setStyle('display', '');

            $outLeft.setStyle('display', '');
            $outTop.setStyle('display', '');
            $outRight.setStyle('display', '');
            $outBottom.setStyle('display', '');



            $(document).removeEvent('mouseup', cancelSelection);

            $(document).addEvent('mousemove', selectingMouseMove);
            $border2.removeEvent('mousemove', areaMouseMove);
            options.onSelectStart(img, selection);
            var func = function() {
                if (options.autoHide || (selection.width * selection.height == 0)) {
                    $area.setStyle('display', 'none');
                    $border1.setStyle('display', 'none');
                    $border2.setStyle('display', 'none');

                    $outLeft.setStyle('display', 'none');
                    $outTop.setStyle('display', 'none');
                    $outRight.setStyle('display', 'none');
                    $outBottom.setStyle('display', 'none');
                }
                options.onSelectEnd(img, selection);
                $(document).removeEvent('mousemove', selectingMouseMove);
                $border2.addEvent('mousemove', areaMouseMove);

                $(document).removeEvent('mouseup', func);
            };

            $(document).addEvent('mouseup', func);
        }

        function cancelSelection() {
            $(document).removeEvent('mousemove', startSelection);
            $area.setStyle('display', 'none');
            $border1.setStyle('display', 'none');
            $border2.setStyle('display', 'none');

            $outLeft.setStyle('display', 'none');
            $outTop.setStyle('display', 'none');
            $outRight.setStyle('display', 'none');
            $outBottom.setStyle('display', 'none');
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
                $area.setStyle('display', '');
                $border1.setStyle('display', '');
                $border2.setStyle('display', '');

                $outLeft.setStyle('display', '');
                $outTop.setStyle('display', '');
                $outRight.setStyle('display', '');
                $outBottom.setStyle('display', '');

                $(document).removeEvent('mouseup', cancelSelectionSub);
                $(document).addEvent('mousemove', selectingMouseMove);
                $border2.removeEvent('mousemove', areaMouseMove);
                options.onSelectStart(img, selection);
                var func = function() {
                    if (options.autoHide || (selection.width * selection.height == 0)) {
                        $area.setStyle('display', 'none');
                        $border1.setStyle('display', 'none');
                        $border2.setStyle('display', 'none');

                        $outLeft.setStyle('display', 'none');
                        $outTop.setStyle('display', 'none');
                        $outRight.setStyle('display', 'none');
                        $outBottom.setStyle('display', 'none');
                    }
                    options.onSelectEnd(img, selection);
                    $(document).removeEvent('mousemove', selectingMouseMove);
                    $border2.addEvent('mousemove', areaMouseMove);

                    $(document).removeEvent('mouseup', func);
                };
                $(document).addEvent('mouseup', func);

                $(document).removeEvent('mousemove', startSelectionSub);
            };

            $(document).addEvent('mousemove', startSelectionSub);

            function cancelSelectionSub(){
                $(document).removeEvent('mousemove', startSelectionSub);
                $area.setStyle('display', 'none');
                $border1.setStyle('display', 'none');
                $border2.setStyle('display', 'none');

                $outLeft.setStyle('display', 'none');
                $outTop.setStyle('display', 'none');
                $outRight.setStyle('display', 'none');
                $outBottom.setStyle('display', 'none');

                $(document).removeEvent('mouseup', cancelSelectionSub);
            };


            $(document).addEvent('mouseup', cancelSelectionSub);
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

        this.setOptions = function(newOptions) {
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
                if (!isNaN($p.getStyle('z-index')) && $p.getStyle('z-index') > zIndex) {
                    zIndex = $p.getStyle('z-index');
                }

                if ($p.getStyle('position') == 'fixed') {
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
                $area.setStyle('display', 'none');
                $border1.setStyle('display', 'none');
                $border2.setStyle('display', 'none');

                $outLeft.setStyle('display', 'none');
                $outTop.setStyle('display', 'none');
                $outRight.setStyle('display', 'none');
                $outBottom.setStyle('display', 'none');

            }
            else if (newOptions.show) {
                $area.setStyle('display', '');
                $border1.setStyle('display', '');
                $border2.setStyle('display', '');

                $outLeft.setStyle('display', '');
                $outTop.setStyle('display', '');
                $outRight.setStyle('display', '');
                $outBottom.setStyle('display', '');
            }

            $outLeft.addClassName(options.classPrefix + '-outer');
            $outTop.addClassName(options.classPrefix + '-outer');
            $outRight.addClassName(options.classPrefix + '-outer');
            $outBottom.addClassName(options.classPrefix + '-outer');


            $area.addClassName(options.classPrefix + '-selection');
            $border1.addClassName(options.classPrefix + '-border1');
            $border2.addClassName(options.classPrefix + '-border2');


            $area.setStyle('borderWidth', options.borderWidth + 'px');
            $border1.setStyle('borderWidth', options.borderWidth + 'px');
            $border2.setStyle('borderWidth', options.borderWidth + 'px');


            $area.setStyle('backgroundColor', options.selectionColor);
            $area.setStyle('opacity', options.selectionOpacity);

            $border1.setStyle('borderStyle','solid');
            $border1.setStyle('borderColor', options.borderColor1);

            $border1.setStyle('borderStyle','dashed');
            $border1.setStyle('borderColor', options.borderColor2);

            $outLeft.setStyle('opacity',options.outerOpacity);
            $outLeft.setStyle('backgroundColor', options.outerColor);

            $outTop.setStyle('opacity',options.outerOpacity);
            $outTop.setStyle('backgroundColor', options.outerColor);

            $outRight.setStyle('opacity',options.outerOpacity);
            $outRight.setStyle('backgroundColor', options.outerColor);

            $outBottom.setStyle('opacity',options.outerOpacity);
            $outBottom.setStyle('backgroundColor', options.outerColor);


            aspectRatio = options.aspectRatio && (d = options.aspectRatio.split(/:/)) ? d[0] / d[1] : null;
            if (options.disable || options.enable === false) {
                $area.removeEvent('mousemove', areaMouseMove);
                $area.removeEvent('mousedown', areaMouseDown);


                $border1.removeEvent('mousemove', areaMouseMove);
                $border1.removeEvent('mousedown', areaMouseDown);
                $border2.removeEvent('mousemove', areaMouseMove);
                $border2.removeEvent('mousedown', areaMouseDown);

                $(img).removeEvent('mousedown', imgMouseDown);

                $outLeft.removeEvent('mousedown', imgMouseDown);
                $outTop.removeEvent('mousedown', imgMouseDown);
                $outRight.removeEvent('mousedown', imgMouseDown);
                $outBottom.removeEvent('mousedown', imgMouseDown);

                $(window).removeEvent('resize', windowResize)
            } else if (options.enable || options.disable === false) {
                if (options.resizable || options.movable) {
                    $area.addEvent('mousemove', areaMouseMove);
                    $area.addEvent('mousedown', areaMouseDown);
                    $border1.addEvent('mousemove', areaMouseMove);
                    $border1.addEvent('mousedown', areaMouseDown);
                    $border2.addEvent('mousemove', areaMouseMove);
                    $border2.addEvent('mousedown', areaMouseDown);
                }
                if (!options.persistent) {
                    $(img).addEvent('mousedown', imgMouseDown);
                    $outLeft.addEvent('mousedown', imgMouseDown);
                    $outTop.addEvent('mousedown', imgMouseDown);
                    $outRight.addEvent('mousedown', imgMouseDown);
                    $outBottom.addEvent('mousedown', imgMouseDown);
                }
                $(window).addEvent('resize', windowResize);
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


        if ($.browser.IE) {
            img.setAttribute('unselectable', 'on');
        }

        $area.setStyle('display', 'none');
        $area.setStyle('position', fixed ? 'fixed': 'absolute');
        $area.setStyle('overflow', 'hidden');
        $area.setStyle('zIndex', zIndex > 0 ? zIndex: '0');

        $border1.setStyle('display', 'none');
        $border1.setStyle('position', fixed ? 'fixed': 'absolute');
        $border1.setStyle('overflow', 'hidden');
        $border1.setStyle('zIndex', zIndex > 0 ? zIndex: '0');

        $border2.setStyle('display', 'none');
        $border2.setStyle('position', fixed ? 'fixed': 'absolute');
        $border2.setStyle('overflow', 'hidden');
        $border2.setStyle('zIndex', zIndex > 0 ? zIndex: '0');

        $outLeft.setStyle('display', 'none');
        $outLeft.setStyle('position', fixed ? 'fixed': 'absolute');
        $outLeft.setStyle('overflow', 'hidden');
        $outLeft.setStyle('zIndex', zIndex > 0 ? zIndex: '0');

        $outTop.setStyle('display', 'none');
        $outTop.setStyle('position', fixed ? 'fixed': 'absolute');
        $outTop.setStyle('overflow', 'hidden');
        $outTop.setStyle('zIndex', zIndex > 0 ? zIndex: '0');


        $outRight.setStyle('display', 'none');
        $outRight.setStyle('position', fixed ? 'fixed': 'absolute');
        $outRight.setStyle('overflow', 'hidden');
        $outRight.setStyle('zIndex', zIndex > 0 ? zIndex: '0');

        $outBottom.setStyle('display', 'none');
        $outBottom.setStyle('position', fixed ? 'fixed': 'absolute');
        $outBottom.setStyle('overflow', 'hidden');
        $outBottom.setStyle('zIndex', zIndex > 0 ? zIndex: '0');


        $area.setStyle('borderStyle', 'solid');

        initOptions = {
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
        this.setOptions(options);
    };

    $.lo.imgClip = function(options) {
        // debugger
        options = options || {};
        options.enable = true;
        new $.imgClip.init(this[0], options);
        return this;
    };

})(Lilac);
