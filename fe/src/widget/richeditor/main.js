/**
 * 富文本编辑器
 */
define(function(require){
    var richEditorBase = require('widget/richeditor/base');
    var util = require('util');
    var config = require('widget/richeditor/config');
    var popup = require('widget/popup/main');

    var showShopName =
        $('#shop-name').html()
        ?
        '<div class="shop-name">' + $('#shop-name').html() + '</div>'
        :
        '';
    var RICHEDITORHTML = ''
        + showShopName
        + '<div class="detail">'
        +   '<div class="clearfix">'
        +       '<p style="margin-bottom:5px;margin-top:10px;">星级评分</p>'
        +       '<div class="rating_wrap_big_hover" id="rating">'
        +           '<ul>'
        +               '<li>'
        +                   '<a class="star one_star " title="一般般" action-type="ratingAction" action-data="rating=0"></a>'
        +               '</li>'
        +               '<li>'
        +                   '<a class="star two_stars " title="还不错" action-type="ratingAction" action-data="rating=1"></a>'
        +               '</li>'
        +               '<li>'
        +                   '<a class="star three_stars " title="很不错" action-type="ratingAction" action-data="rating=2"></a>'
        +               '</li>'
        +               '<li>'
        +                   '<a class="star four_stars " title="非常棒" action-type="ratingAction" action-data="rating=3"></a>'
        +               '</li>'
        +               '<li>'
        +                   '<a class="star five_stars " title="超级赞" action-type="ratingAction" action-data="rating=4"></a>'
        +               '</li>'
        +           '</ul>'
        +       '</div>'
        +       '<br>'
        +       '<p style="margin-bottom:5px;margin-top:20px;">晒单内容</p>'
        +       '<div id="RE_container" style="border: 1px solid #CCC; width: 615px;">'
        +           '<div id="RE_toolbar">'
        +               '<a style="margin-left: 1px;" class="button removeformat" action-type="toolbar-action" title="删除格式" command="removeformat" unselectable="on"></a>'
        +               '<a class="button bold" action-type="toolbar-action" title="粗体" command="bold" unselectable="on"></a>'
        +               '<a class="button italic" action-type="toolbar-action" title="斜体" command="italic" unselectable="on"></a>'
        +               '<a class="button underline" action-type="toolbar-action" title="下划线" command="underline" unselectable="on"></a>'
        +               '<a class="button strikethrough" action-type="toolbar-action" title="删除线" command="strikethrough" unselectable="on"></a>'
        +               '<a class="button justifyleft" action-type="toolbar-action" title="左对齐" command="justifyleft" unselectable="on"></a>'
        +               '<a class="button justifycenter" action-type="toolbar-action" title="居中" command="justifycenter" unselectable="on"></a>'
        +               '<a class="button justifyright" action-type="toolbar-action" title="右对齐" command="justifyright" unselectable="on"></a>'
        +               '<a class="button justifyfull" action-type="toolbar-action" title="两端对齐" command="justifyfull" unselectable="on"></a>'
        +               '<a class="button indent" action-type="toolbar-action" title="增加缩进" command="indent" unselectable="on"></a>'
        +               '<a class="button outdent" action-type="toolbar-action" title="减少缩进" command="outdent" unselectable="on"></a>'
        +               '<a class="button insertorderedlist" action-type="toolbar-action" title="有序列表" command="insertorderedlist" unselectable="on"></a>'
        +               '<a class="button insertunorderedlist" action-type="toolbar-action" title="无序列表" command="insertunorderedlist" unselectable="on"></a>'
        +               '<a style="width: 43px;" class="button insertimage" action-type="toolbar-action" title="插入图片" command="insertimage" unselectable="on"></a>'
        +           '</div>'
        +           '<form style="position: absolute;top: 120px;left: 350px;" action="http://v0.api.upyun.com/zanbai/" target="ifmUpload" method="post" id="upload_form" name="upload_form" enctype="multipart/form-data">'
        +               '<input type="hidden" name="policy" id="policy">'
        +               '<input type="hidden" name="signature" id="signature">'
        +               '<input type="file" id="upload_file" name="file" style="-ms-filter:\'progid:DXImageTransform.Microsoft.Alpha(Opacity=0)\';filter:alpha(opacity=0);opacity:0; position: absolute;top: 28px;left: 278px;width: 40px;height: 32px;*height: 34px;">'
        +           '</form>'
        +           '<iframe id="RE_iframe" frameborder="no" scrolling="yes" style="width: 100%; height: 300px;"></iframe>'
        +           '<div id="RE_mask_div" style="display: none;color: #fff;width: 100%; height: 550px;background-color: rgb(0, 0, 0); filter:alpha(opacity=30);opacity: 0.3; top: 30px; left: 0px;position: absolute;">'
        +               '<span style="vertical-align:top;position: absolute;left: 320px;top: 100px;"><img src="'+window.$CONFIG.css_domain+'/images/common/loading.gif" style="margin-right: 10px;">正在上传图片</span>'
        +           '</div>'
        +           '<textarea id="RE_textarea" wrap="on" style="display: none; width: 684px; height: 300px;"></textarea>'
        +           '<iframe src="about:blank" name="ifmUpload" id="ifmUpload" style="display:none;"></iframe>'
        +       '</div>'
        +   '</div>'
        +   '<div class="btn">'
        +       '<a class="W_btn_b" href="javascript:void(0);" node-type="okBtn">'
        +           '<span>确认</span>'
        +       '</a>'
        +       '<a class="W_btn_a" href="javascript:void(0);" node-type="cancelBtn">'
        +           '<span>取消</span>'
        +       '</a>'
        +   '</div>'
        + '</div>';

    var richEditorPop;

    var defaults = {
        content: '',
        confirmFn: function () {},  // 富文本编辑点击确定回调函数
        cancalFn: function () {     // 富文本编辑点击取消回调函数
            richEditorPop && richEditorPop.destroy();
        }
    }

    var conf = {};
    var nodes;

    function show (opts) {
        conf = $.extend({}, defaults, opts);

        richEditorPop = popup.createModulePopup();
        richEditorPop.setContent(RICHEDITORHTML);
        richEditorPop.show();
        richEditorPop.setMiddle();
        richEditorBase.init({
            content: conf.content
        });

        nodes = util.dom.parseDOM(
            util.dom.builder(richEditorPop.getInner()).list
        );

        bindEvt();

    }

    function bindEvt () {
        $(nodes.okBtn).on('click', function () {
            conf.confirmFn(richEditorBase.getContent(), richEditorPop);
        });

        $(nodes.cancelBtn).on('click', function () {
            conf.cancalFn();
        });
    }

    return {
        show: show
    }
});