//编辑城市
function editcity(){
	id = $("#city_id").html();
	name = $("#name").val();
	desc = $("#desc").val();
	timeCostDesc = $("#timeCostDesc").val();
	travelMonth = $("#travelMonth").val();
	// small_img = $("#small_pic").attr("src");

	geoHistory_titles = $.find(".geoHistory_title");
	geoHistory_desc = $.find(".geoHistory_desc");

	activities_titles = $.find(".activities_title");
	activities_desc = $.find(".activities_desc");
     
    specials_titles = $.find(".specials_title");
	specials_desc = $.find(".specials_desc");

	tips_titles = $.find(".tips_title");
	tips_desc = $.find(".tips_desc");

	localTraffic_titles = $.find(".localTraffic_title");
	localTraffic_desc = $.find(".localTraffic_desc");
	remoteTraffic_titles = $.find(".remoteTraffic_title");
	remoteTraffic_desc = $.find(".remoteTraffic_desc");

	separator = ',';
	var geoHistory = [];
	for(var i=0; i<geoHistory_titles.length; i++){
		geoHistory.push($(geoHistory_titles[i]).val() + separator + $(geoHistory_desc[i]).val());
	}

	var activities = [];
	for(var i=0; i<activities_titles.length; i++){
		activities.push($(activities_titles[i]).val() + separator + $(activities_desc[i]).val());
	}

	var specials = [];
	for(var i=0; i<specials_titles.length; i++){
		specials.push($(specials_titles[i]).val() + separator + $(specials_desc[i]).val());
	}

	var tips = [];
	for(var i=0; i<tips_titles.length; i++){
        tips.push($(tips_titles[i]).val() + separator + $(tips_desc[i]).val());
	}

	var localTraffic = [];
	for(var i=0; i<localTraffic_titles.length; i++){
		localTraffic.push($(localTraffic_titles[i]).val() + separator + $(localTraffic_desc[i]).val());
	}
	var remoteTraffic = [];
	for(var i=0; i<remoteTraffic_titles.length; i++){
        remoteTraffic.push($(remoteTraffic_titles[i]).val() + separator + $(remoteTraffic_desc[i]).val());
	}

	var ajaxData = {
		// data
		id: id,
		name: name,
		desc: desc,
		timeCostDesc: timeCostDesc,
		travelMonth: travelMonth,
		geoHistory: JSON.stringify(geoHistory),
		activities:JSON.stringify(activities),
		specials: JSON.stringify(specials),
		tips: JSON.stringify(tips),
		localTraffic: JSON.stringify(localTraffic),
		remoteTraffic: JSON.stringify(remoteTraffic)
	}

	// console.log(specials);
	// console.log(JSON.stringify(specials));

	$.ajax({
		url: "/aj/operation/editcity",
		type: 'POST',
		data: ajaxData,
		cache: false,
		success: function(result){

		  if(result) {		
			  alert('编辑城市成功');
		  }else{
			  alert('编辑城市失败');
		  }
		  location.reload();
        }
	});
}


$(document).ready(function(){
	return;
	var pic = function(form, input, fn, cbn) {
        cbn = cbn || ("ZB_" + (+(new Date())));
	    $(input).change(function() {
	        form.submit();
	    });
	    form.action = "http://v0.api.upyun.com/zanbai/";
	    fn && (window[cbn] = fn);
	}
	
	//pic($('#small_pic_form')[0], $('#upload_small_file')[0], (function(){
    //    return function(o) {
    //    	$('#small_pic').attr('src', o.fullurl+'!300');
    //    }
    //})(), 'ZB_ADMIN_EDIT_BRAND_SMALL');
	
	pic($('#big_pic_form')[0], $('#upload_big_file')[0], (function(){
        return function(o) {
        	$('#big_pic').attr('src', o.fullurl+'!300');
        }
    })(), 'ZB_ADMIN_EDIT_BRAND_BIG');
});

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