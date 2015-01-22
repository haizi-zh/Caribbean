//根据地域获取省份列表
$('#area').change(function(){ 
	area = $("#area").val(); 

	$.ajax({
		url: "/aj/hotel/get_contries_by_area",
		data: {area:area},
		cache: false,
		success: function(result){
		  if(result) {		
			  	//获取数据
			    var obj = eval('(' + result + ')');
			    
			    //清空城市和省份
			    $("#country").empty();
			    $("#city").empty();
			    
			    //添加省份
			    $("#country").append("<option></option>");
			  	for (var i in obj) {
			  		$("#country").append("<option value='"+i+"'>"+obj[i]+"</option>");
			  	}
		  }else{
              	alert('fail');
		  }
        }
	});
})

//根据省份获取城市列表
$('#country').change(function(){ 
	country = $("#country").val(); 

	$.ajax({
		url: "/aj/hotel/get_cities_by_country",
		data: {country:country},
		cache: false,
		success: function(result){

		  if(result) {		
			  	//获取数据
			    var obj = eval('(' + result + ')');
			    
			    //清空城市
			    $("#city").empty();
			    
			    //添加城市
			    $("#city").append("<option></option>");
			  	for (var i in obj) {
			  		 $("#city").append("<option value='"+obj[i]['id']+"'>"+obj[i]['name']+"</option>");
			  	}
		  }else{
              	alert('fail');
		  }
        }
	});
})


function table_html(editpick, mongoid, rating, index, name, desc) {
	var strHtml = '<tr><th class="btn_bed"><input type="checkbox" value="'
	    + mongoid +'" name="editpick[]" ';

	if(editpick)
		strHtml += 'checked';

	strHtml +='/></th><th>' 
	          + rating + '</th><th>'
	          + index + '</th><th>'
	          + name + '</th><th>'
	          + desc + '</th></tr>';

    return strHtml;
}



//跳转
function select_city(){
	area = $("#area").val(); 
	country = $("#country").val();
	city = $("#city").val(); 

	$.ajax({
		url: "/aj/hotel/select_city",
		data: {area:area,country:country,city:city},
		cache: false,
		success: function(result){
		  if(result) {	
		        console.log(result);	

			  	//获取数据id		  	 
			    var obj = eval('(' + result + ')');

                $("#J_hotel_table").empty();
                $("#pages").empty();
                $("#name").val('');
                $("#hotel_pagination").empty();
                
			  	for (var i in obj) {
			  		 if ( typeof(obj[i].rating) == "undefined" )   obj[i].rating='';
			  		 if ( typeof(obj[i].desc) == "undefined" )   obj[i].desc='';
			  		 hotellist = table_html(obj[i].editpick, obj[i]._id.$id.toString(), obj[i].rating, i, obj[i].zhname, obj[i].desc);
			  		 $("#J_hotel_table").append(hotellist);
			  	}

                alert('ok');
			  	 
		  }else{
              	alert('fail');
		  }
        }
	});	
}


//推荐酒店
function recom(){
	var editpick = new Array();
	$.each($("input[name='editpick[]']:checked"), function() { editpick.push($(this).val()); });
    
    separator = ',';
    var recomdata = [];
    for(var i=0; i<editpick.length; i++){
    	recomdata.push(editpick[i] + separator);
    }


	var ajaxData = {
		recomdata: JSON.stringify(recomdata),
	}

	$.ajax({
		url: "/aj/hotel/hotelrecom",
		type: 'POST',
		data: ajaxData,
		cache: false,
		success: function(result){
            console.log(result);
			if(result){		
				alert('推荐酒店成功');

			}else{
				alert('推荐酒店失败');
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