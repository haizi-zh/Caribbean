$.ready(function () {

	
    var RICHEDITORHTML = '' +
        '<div class="shop-name">'+
        '</div>' +
        '<div class="detail">' +
            '<div class="clearfix">' +
                '<div id="RE_container" style="border: 1px solid #CCC; /*width: 495px;width: 615px;*/">' +
                    // '<input type="hidden" value="" id="pids" node-type="pids">' +
                    '<div id="RE_toolbar">' +
                        // '<a class="button html" action-type="toolbar_act" title="查看源码" command="html" unselectable="on"></a>' +
                        // '<a class="button fontname" action-type="toolbar_act" title="字体" command="fontname" unselectable="on"></a>' +
                        // '<a class="button fontsize" action-type="toolbar_act" title="字号" command="fontsize" unselectable="on"></a>' +
                        '<a style="margin-left: 1px;" class="button removeformat" action-type="toolbar_act" title="删除格式" command="removeformat" unselectable="on"></a>' +
                        '<a class="button bold" action-type="toolbar_act" title="粗体" command="bold" unselectable="on"></a>' +
                        '<a class="button italic" action-type="toolbar_act" title="斜体" command="italic" unselectable="on"></a>' +
                        '<a class="button underline" action-type="toolbar_act" title="下划线" command="underline" unselectable="on"></a>' +
                        '<a class="button strikethrough" action-type="toolbar_act" title="删除线" command="strikethrough" unselectable="on"></a>' +
                        '<a class="button justifyleft" action-type="toolbar_act" title="左对齐" command="justifyleft" unselectable="on"></a>' +
                        '<a class="button justifycenter" action-type="toolbar_act" title="居中" command="justifycenter" unselectable="on"></a>' +
                        '<a class="button justifyright" action-type="toolbar_act" title="右对齐" command="justifyright" unselectable="on"></a>' +
                        '<a class="button justifyfull" action-type="toolbar_act" title="两端对齐" command="justifyfull" unselectable="on"></a>' +
                        '<a class="button indent" action-type="toolbar_act" title="增加缩进" command="indent" unselectable="on"></a>' +
                        '<a class="button outdent" action-type="toolbar_act" title="减少缩进" command="outdent" unselectable="on"></a>' +
                        // '<a class="button forecolor" action-type="toolbar_act" title="前景色" command="forecolor" unselectable="on"></a>' +
                        // '<a class="button backcolor" action-type="toolbar_act" title="背景色" command="backcolor" unselectable="on"></a>' +
                        '<a class="button createlink" action-type="toolbar_act" title="超级连接" command="createlink" unselectable="on"></a>' +
                        '<a class="button insertorderedlist" action-type="toolbar_act" title="有序列表" command="insertorderedlist" unselectable="on"></a>' +
                        '<a class="button insertunorderedlist" action-type="toolbar_act" title="无序列表" command="insertunorderedlist" unselectable="on"></a>' +
                        '<a style="width: 43px;" class="button insertimage" action-type="toolbar_act" title="插入图片" command="insertimage" unselectable="on"></a>' +
                        // '<a class="button table" action-type="toolbar_act" title="表格" command="table" unselectable="on"></a>' +
                        // '<a class="button emoticons" action-type="toolbar_act" title="表情" command="emoticons" unselectable="on"></a>' +
                    '</div>' +
                    // visibility: hidden; outline: none; position: absolute; top: 135px; right: 380px; margin: 0; border: solid transparent; border-width: 40px 20px 30px 90px; opacity: 0; filter: alpha(opacity=0); -moz-transform: translate(-300px, 0) scale(4); direction: ltr; cursor: pointer; background: #000;
                    '<form style="" action="http://v0.api.upyun.com/zanbai/" target="ifmUpload" method="post" id="upload_form" name="upload_form" enctype="multipart/form-data">'+
                        '<input type="hidden" name="policy" id="policy">'+
                        '<input type="hidden" name="signature" id="signature">'+
                        '<input type="file" id="upload_file" name="file" style="-ms-filter:\'progid:DXImageTransform.Microsoft.Alpha(Opacity=0)\';filter:alpha(opacity=0);opacity:0; position: absolute;top: 28px;left: 278px;width: 40px;height: 32px;*height: 34px;">' +
                    '</form>'+
                    '<iframe id="RE_iframe" frameborder="no" scrolling="auto" style="width: 100%; height: 100%;"></iframe>' +
                    '<div id="RE_mask_div" style="display: none;color: #fff;width: 100%; height: 550px;background-color: rgb(0, 0, 0); filter:alpha(opacity=30);opacity: 0.3; top: 30px; left: 0px;position: absolute;">' +
                        '<span style="vertical-align:top;position: absolute;left: 320px;top: 100px;"><img src="'+window.$CONFIG.css_domain+'/images/common/loading.gif" style="margin-right: 10px;">正在上传图片</span>' +
                    '</div>' +
                    '<textarea id="RE_textarea" wrap="on" style="display: none; ">' +
                    '</textarea>' +
                    '<iframe src="about:blank" name="ifmUpload" id="ifmUpload" style="display:none;"></iframe>' +
                '</div>' +
            '</div>' +
        '</div>';

        		var a = $('#my_content');
        		a[0].innerHTML=RICHEDITORHTML;
		        var content_html = $('#content_html')[0].value;
		        //console.log( content_html );

        		

                var rEditor = $('#RE_textarea').richEditor({
                    id : 'editor',
                    textareaId : 'textarea',
                    b : 2,
                    a : 4,
                    content: content_html
                });



                 $('#edit_discount').addEvent('click', function(){
            // if (window.uploadImgFlag) {
            //     return;
            // }
            var id = $('#id')[0].value;
            var title = $('#title')[0].value;
            var title_mobile = $('#title_mobile')[0].value;
            var stime = $('#stime')[0].value;
            var etime = $('#etime')[0].value;
            var shop_type = $('#shop_type')[0].value;
            var level = "";
            var share_content = $('#share_content')[0].value;

            if($('#level')){
                level = $('#level')[0].value;
            }

            var pids = '';
            var srcReg = /src=[\'\"]?([^\'\"]*)[\'\"]?/i;
            var arr = rEditor.getContent().match(/<img.*?(?:>|\/>)/gi);
            if(arr){
                for (var i = 0; i < arr.length; i++) {
                    var src = arr[i].match(srcReg);
                    if(src[1]){
                        pids += src[1].replace(/!popup$/, '') + ',';
                        // console.warn('已匹配的图片地址'+(i+1)+'：'+src[1]);
                    }
                    // 也可以替换src属性
                    // if (src[0]) {
                    //     var t = src[0].replace(/src/i, "href");
                    // }
                }
            }
            $.io.ajax({
                'method': 'post',
                'url': '/aj/discount/edit_discount',
                'args': {
                    'body': encodeURIComponent(rEditor.getContent()),
                    // 'pics': nodes.pids.value,
                    'pics': pids.replace(/,$/, ''),
                    'level':level,
                    'id':id,
                    'title':title,
                    'title_mobile':title_mobile,
                    'stime':stime,
                    'etime':etime,
                    'shop_type':shop_type,
                    'share_content':share_content
                },
                'onComplete': function(data){
                    if(data.code == '200'){
                        //a.destroy();
                        $.litePrompt('添加成功！', {
                            'timeout': 1500
                        });
                    }else{
                        //a.destroy();
                        $.litePrompt(data.msg, {
                            'timeout': 1500
                        });
                    }
                }
            });
        });


});