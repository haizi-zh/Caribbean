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

function table_html(index, mid, name, rank_score) {
	var strHtml = '<tr><th>'
					+ index + '</th><th>'
					+ mid + '</th><th>'
					+ name + '</br></th><th>' + rank_score + '</th><th><a class="btn btn-link btn-danger " href="/admin/editviewspot?viewspot_id='
					+ mid + '&nocache=1" target="_blank"  >编辑景点</a></th><th><a class="btn btn-link btn-primary" href="http://pic.lvxingpai.cn/viewspot/cms?name=' + name + '" target="_blank" >景点照片</a></th></tr>';

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

			  	//获取数据id		  	 
			    var obj = eval('(' + result + ')');

                $("#J_viewspot_table").empty();
                $("#pages").empty();

			  	for (var i in obj) {
			  		 viewspotlist = table_html(i, obj[i]._id.$id.toString(), obj[i].zhname, obj[i].hotness);
			  		 $("#J_viewspot_table").append(viewspotlist);
			  	}

                alert('ok');
			  	 
		  }else{
              	alert('fail');
		  }
        }
	});


		
}


