//根据地域获取省份列表
$('#area').change(function(){ 
	area = $("#area").val(); 

	$.ajax({
		url: "/aj/citylist/get_contries_by_area",
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

function table_html(index, id, name, mid) {
	var strHtml = '<tr><th>' 
	+ index + '</th><th>' 
	+ id + '</th><th>' 
	+ name + '</th><th><a class="btn btn-link btn-danger " href="/admin/editcitylist?city_id=' 
	+ mid + '&amp;nocache=1" target="_blank">编辑</a></th></tr>';

    return strHtml;
}

//跳转
function select_city(){
	area = $("#area").val(); 
	country = $("#country").val();
	var citylist;
	
	$.ajax({
		url: "/aj/citylist/get_cities_by_country",
		data: {country:country},
		cache: false,
		success: function(result){
		  if(result) {		
			  	//获取数据id		  	 
			    var obj = eval('(' + result + ')');

                $("#J_city_table").empty();
                $("#name").val('');
                $("#id").val('');
			  	for (var i in obj) {
			  		 citylist = table_html(i, obj[i].mid, obj[i].name, obj[i].mid);
			  		 $("#J_city_table").append(citylist);
			  	}

			  	 
		  }else{
              	alert('fail');
		  }
        }
	});
		
}