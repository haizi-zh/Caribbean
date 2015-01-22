//提交图片
$(document).ready(function(){
	var topic1 = function(form, input, fn, cbn) {
        cbn = cbn || ("ZB_" + (+(new Date())));
	    $(input).change(function() {
	        form.submit();
	    });
	    form.action = "http://v0.api.upyun.com/zanbai/";
	    fn && (window[cbn] = fn);
	}
	
	topic1($('#brand_form')[0], $('#upload_file')[0], (function(){
        return function(o) {
        	console.log(o);
        	$('#brand_pic').attr('src', o.fullurl+'!300');
        }
    })(), 'ZB_ADMIN_BRAND');
});

//添加城市
function addcity(){

	name = $("#name").val();
	desc = $("#desc").val();
	timeCostDesc = $("#timeCostDesc").val();
	travelMonth = $("#travelMonth").val();
	culture = $("#culture").val();
	activityIntro = $("#activityIntro").val();
	lightspot = $("#lightspot").val();
	tips = $("#tips").val();
	localTraffic_titles = $.find(".localTraffic_title");
    localTraffic_contents = $.find(".localTraffic_content");
    remoteTraffic_titles = $.find(".remoteTraffic_title");
    remoteTraffic_contents = $.find(".remoteTraffic_content");
 	//img = $("#city_pic").attr("src");

    separator = ',';
    var localTraffic = [];
    for(var i=0; i<localTraffic_titles.length; i++){
    	localTraffic.push($(localTraffic_titles[i]).val() + separator + $(localTraffic_contents[i]).val());
    }
    var remoteTraffic = [];
	for(var i=0; i<remoteTraffic_titles.length; i++){
        remoteTraffic.push($(remoteTraffic_titles[i]).val() + separator + $(remoteTraffic_contents[i]).val());
	}
 

    var ajaxData = {
    	name: name,
    	desc: desc,
    	timeCostDesc: timeCostDesc,
    	travelMonth: travelMonth,
    	culture: culture,
    	activityIntro: activityIntro,
    	lightspot: lightspot,
    	tips: tips,
    	localTraffic: JSON.stringify(localTraffic),
    	remoteTraffic: JSON.stringify(remoteTraffic)
    }
    

	$.ajax({
		url: "/aj/operation/addcity",
		type: 'POST',
		data: ajaxData,
		cache: false,
		success: function(result){

		  if(result) {		
			  alert('添加城市成功');
		  }else{
			  alert('添加城市失败');
		  }
		  location.reload();
        }
	});
}


function addlocal(){

    var htmlTemplate = '<span style="line-height:30px;border:3px solid #000;height:50px;color:black;font-weight:bold">New Title</span>' +
                  ' <textarea rows="1" class="localTraffic_title" style="line-height:30px;width:425px" value=""></textarea><br><br>' +
                  '<textarea rows="10" class="localTraffic_content" style="width:500px;" value=""></textarea><br><br>';

    $("#localTraffic").append(htmlTemplate);

}

function addremote(){

    var htmlTemplate = '<span style="line-height:30px;border:3px solid #000;height:50px;color:black;font-weight:bold">New Title</span>' +
                  ' <textarea rows="1" class="remoteTraffic_title" style="line-height:30px;width:425px" value=""></textarea><br><br>' +
                  '<textarea rows="10" class="remoteTraffic_content" style="width:500px;" value=""></textarea><br><br>';

    $("#remoteTraffic").append(htmlTemplate);

}

(function($){
    var goToTopTime;
    $.fn.goToTop=function(options){
        var opts = $.extend({},$.fn.goToTop.def,options);
        var $window=$(window);
        $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body'); // opera fix
        //$(this).hide();
        var $this=$(this);
        clearTimeout(goToTopTime);
        goToTopTime=setTimeout(function(){
            var controlLeft;
            if ($window.width() > opts.pageHeightJg * 2 + opts.pageWidth) {
                controlLeft = ($window.width() - opts.pageWidth) / 2 + opts.pageWidth + opts.pageWidthJg;
            }else{
                controlLeft = $window.width()- opts.pageWidthJg-$this.width();
            }

            var controlTop=$window.height() - $this.height()-opts.pageHeightJg;

            var shouldvisible=( $window.scrollTop() >= opts.startline )? true : false;

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
        },30);

        $(this).click(function(event){
            $body.stop().animate( { scrollTop: $(opts.targetObg).offset().top}, opts.duration);
            $(this).blur();
            event.preventDefault();
            event.stopPropagation();
        });
    };

    $.fn.goToTop.def={
        pageWidth:1000,//页面宽度
        pageWidthJg:22,//按钮和页面的间隔距离
        pageHeightJg:130,//按钮和页面底部的间隔距离
        startline:130,//出现回到顶部按钮的滚动条scrollTop距离
        duration:3000,//回到顶部的速度时间
        targetObg:"body"//目标位置
    };

    $('<a href="javascript:;" class="backToTop" title="返回顶部"></a>').appendTo("body");
    $(".backToTop").goToTop();
    $(window).bind('scroll resize',function(){
        $(".backToTop").goToTop({
          pageWidth:960,
          duration:400
        });
    });
})(jQuery);