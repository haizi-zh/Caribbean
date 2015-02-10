//根据地域获取省份列表
$('#area').change(function(){ 
	area = $("#area").val(); 

	$.ajax({
		url: "/aj/viewspotlist/get_contries_by_area",
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
		url: "/aj/viewspotlist/get_cities_by_country",
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

//审核
$('#isEdited').click(function(){
	if( $('#isEdited').val()==0){
		$("#isEdited").removeClass().addClass("W_btn_a");
		$('#isEdited').val("1");
		$('#isEdited').text("已审核");

	}else{
        $("#isEdited").removeClass().addClass("W_btn_b");
		$('#isEdited').val("0");
		$('#isEdited').text("未审核");
	}
	
})

function table_html(index, mid, name, rank_score, isDone, address) {
	var strHtml = '<tr><th>'
					+ index + '</th><th style="height:28px;margin-left:15px;width:250px;">'
					+ address + '</th><th>'
					+ name + '</br></th><th>' + rank_score + '</th><th><a class="btn btn-link btn-danger " href="/admin/editviewspot?viewspot_id='
					+ mid + '&nocache=1" target="_blank"  >编辑景点</a></th><th><a class="btn btn-link btn-primary" href="http://pic.lvxingpai.cn/viewspot/cms?name=' 
					+ name + '" target="_blank" >景点照片</a>'
					+ isDone + '</th></tr>';

    return strHtml;
}



//跳转
function select_city(){
	area = $("#area").val(); 
	country = $("#country").val();
	city = $("#city").val(); 
	isEdited = $("#isEdited").val();


	$.ajax({
		url: "/aj/viewspotlist/select_city",
		data: {area:area,country:country,city:city,isEdited:isEdited},
		cache: false,
		success: function(result){
		  if(result) {	
		        console.log(result);	

			  	//获取数据id		  	 
			    var obj = eval('(' + result + ')');

                $("#J_viewspot_table").empty();
                $("#pages").empty();
                

			  	for (var i in obj) {

			  		 if ( typeof(obj[i].address) == "undefined" )   obj[i].address='';

			  		 var isDone = '';
                     if(obj[i].isdone){
                     	isDone = ' 图片已审核';
                     }

			  		 viewspotlist = table_html(i, obj[i]._id.$id.toString(), obj[i].zhname, obj[i].hotness, isDone, obj[i].address);
			  		 $("#J_viewspot_table").append(viewspotlist);
			  	}

                alert('ok');
			  	 
		  }else{
              	alert('fail');
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