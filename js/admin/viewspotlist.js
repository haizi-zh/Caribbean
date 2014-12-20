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
			  		 $("#city").append("<option value='"+obj[i]['name']+"'>"+obj[i]['name']+"</option>");
			  	}
		  }else{
              	alert('fail');
		  }
        }
	});
})

//跳转
function select_city(){
	area = $("#area").val(); 
	country = $("#country").find("option:selected").text();
	city = $("#city").val(); 
	if(!country){
		self.location='/admin/viewspotlist';	
	}else{
		self.location='/admin/viewspotlist?area='+area+'&country='+country+'&city='+city;
	}
		
}


$(document).ready(function(){
	
	$("[name='rank_score']").bind('change', function(){
		id = $(this).attr("id");
		rank_score = $(this).val();
		old_value = $(this).attr("old-value");
		if(isNaN(rank_score)){
			alert("请输入纯数字");
			$(this).val(old_value);
			return false;
		}
		$.ajax({
			'url':"/aj/shop/change_rank_score_foradmin",
			"type":"post",
			'data':{id:id,rank_score:rank_score},
	        success: function(result){
	          if(result) {      
	              alert('修改排名得分成功');
	              $(this).attr("old-value", rank_score);
	          }else{
	              alert('失败');
	          }
	        }
		});
	});


	$("[name='delete_cache']").bind('click', function(){
		id = $(this).attr("id");
		$.ajax({
			'url':"/aj/shop/delete_cache_foradmin",
			"type":"post",
			'data':{id:id},
	        success: function(result){
	          if(result) {      
	              alert('清理成功');
	          }else{
	              alert('失败');
	          }
	        }
		});
	});

	$("[name='delete_brand_cache']").bind('click', function(){
		id = $(this).attr("id");
		$.ajax({
			'url':"/aj/shop/delete_cache_brand_foradmin",
			"type":"post",
			'data':{id:id},
	        success: function(result){
	          if(result) {      
	              alert('清理成功');
	          }else{
	              alert('失败');
	          }
	        }
		});
	});
	
});

