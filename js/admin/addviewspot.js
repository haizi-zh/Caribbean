ueVisitGuide.ready(function(){
	//ueVisitGuide.setContent("请在此处编辑游玩攻略");
	//ueAntiPit.setContent("请在此处编辑防坑指南");
});


//根据国家获取省市列表
$('#countrys').change(function(){ 
	countrys = $("#countrys").val(); 
	
	$.ajax({
		url: "/aj/addviewspot/get_provinces_by_countrys",
		data: {countrys:countrys},
		cache: false,
		success: function(result){

		  if(result) {		

			  	//获取数据
			    var obj = eval('(' + result + ')');
			    
			    //清空省份和城市
			    $("#provinces").empty();
			    $("#citys").empty();
			    
			    //添加省份
			    $("#provinces").append("<option></option>");
			  	for (var i in obj) {
			  		$("#provinces").append("<option value='"+obj[i]+"'>"+obj[i]+"</option>");
			  	}
		  }else{
              	alert('fail');
		  }
        }
	});
})

//根据国家、省市获取城市列表
$('#provinces').change(function(){ 
	countrys = $("#countrys").val(); 
	provinces = $("#provinces").val(); 

	$.ajax({
		url: "/aj/addviewspot/get_cities_by_provinces",
		data: {countrys:countrys, provinces:provinces},
		cache: false,
		success: function(result){
		  if(result) {		
			  	//获取数据
			    var obj = eval('(' + result + ')');

			    //清空城市
			    $("#citys").empty();
			    
			    //添加国家
			    $("#citys").append("<option></option>");
			  	for (var i in obj) {
			  		$("#citys").append("<option value='"+obj[i]+"'>"+obj[i]+"</option>");
			  	}
		  }else{
              	alert('fail');
		  }
        }
	});
})


//添加景点
function add_viewspot(){ 
	country = $("#countrys").val(); 
	province = $("#provinces").val(); 
	city = $("#citys").val(); 
	name = $("#name").val();
	description = $("#description").val();
	address = $("#address").val();
	openTime = $("#openTime").val();
	openHour = $("#openHour").val();
	closeHour = $("#closeHour").val();
	priceDesc = $("#priceDesc").val();
	phone = $("#phone").val();
	ratingsScore = $("#ratingsScore").val();
	travelGuide = $("#travelGuide").val();   

	var visitGuide = ueVisitGuide.getContent();
	var antiPit = ueAntiPit.getContent();

    var ajaxData = {
    	country: country,
    	province: province,
    	city: city,
    	name: name,
    	description: description,
    	address: address,
    	openTime: openTime,
    	openHour: openHour,
    	closeHour: closeHour,
    	priceDesc: priceDesc,
    	phone: phone,
    	ratingsScore: ratingsScore,
    	visitGuide: visitGuide,
    	antiPit: antiPit,
    	travelGuide: travelGuide
    }

	$.ajax({
		url: "/aj/addviewspot/add_viewspot",
		type: 'POST',
		data: ajaxData,
		cache: false,
		success: function(result){
		  if(result) {		
			  alert('景点添加成功');
			  // location.reload();//保存成功不跳转
		  }else{
			  alert('景点添加失败');
		  }
        }
	});
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