//编辑运营内容
function edit_article(){
	var id = $("#article_id").html();
	var title = $("#title").val();
	var source = $("#source").val();
	var authorName = $("#authorName").val();
	var desc = $("#desc").val();
	var image = $("#image").val();
	var publishTime = $("#publishTime").val();
    var content = ueContent.getContent();

    var ajaxData = {
        id: id,
        title: title,
        source: source,
        authorName: authorName,
        desc: desc,
        image: image,
        publishTime: publishTime,
        content: content
    }

    $.ajax({
    	url: "/aj/article/edit_article",
		type: 'POST',
		data: ajaxData,
		cache: false,
		success: function(result){
			if(result){
				alert('编辑内容成功');
                console.log(result);
				// location.href = '/admin/articlelist';
			}else{
				alert('编辑内容失败');
			}
		}

    });
	
}

(function($){
    var goToTopTime;
    $.fn.goToTop = function(options){
        var opts = $.extend({}, $.fn.goToTop.def, options);
        var $window = $(window);
        $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body'); // opera fix
        //$(this).hide();
        var $this = $(this);
        clearTimeout(goToTopTime);
        goToTopTime = setTimeout(function(){
            var controlLeft;
            if ($window.width() > opts.pageHeightJg * 2 + opts.pageWidth) {
                controlLeft = ($window.width() - opts.pageWidth) / 2 + opts.pageWidth + opts.pageWidthJg;
            }else{
                controlLeft = $window.width()- opts.pageWidthJg - $this.width();
            }

            var controlTop = $window.height() - $this.height() - opts.pageHeightJg;

            var shouldvisible = ( $window.scrollTop() >= opts.startline )? true : false;

            if (shouldvisible){
                $this.stop().show();
            }else{
                $this.stop().hide();
            }

            $this.css({
                position:  'fixed',
                top: controlTop,
                // left: controlLeft
            });
        }, 30);

        $(this).click(function(event){
            $body.stop().animate( { scrollTop: $(opts.targetObg).offset().top}, opts.duration);
            $(this).blur();
            event.preventDefault();
            event.stopPropagation();
        });
    };

    $.fn.goToTop.def = {
        pageWidth: 1000,//页面宽度
        pageWidthJg: 22,//按钮和页面的间隔距离
        pageHeightJg: 130,//按钮和页面底部的间隔距离
        startline: 130,//出现回到顶部按钮的滚动条scrollTop距离
        duration: 3000,//回到顶部的速度时间
        targetObg: "body"//目标位置
    };

    $('<a href="javascript:;" class="backToTop" title="返回顶部"></a>').appendTo("body");
    $(".backToTop").goToTop();
    $(window).bind('scroll resize',function(){
        $(".backToTop").goToTop({
            pageWidth: 960,
            duration: 400
        });
    });
})(jQuery);