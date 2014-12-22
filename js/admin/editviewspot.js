//根据地域获取国家列表
$('#area').change(function(){ 
	area = $("#area").val(); 
	
	$.ajax({
		url: "/aj/addshop/get_contries_by_area",
		data: {area:area},
		cache: false,
		success: function(result){
		  if(result) {		
			  	//获取数据
			    var obj = eval('(' + result + ')');
			    
			    //清空城市和国家
			    $("#country").empty();
			    $("#city").empty();
			    
			    //添加国家
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

//根据国家获取城市列表
$('#country').change(function(){ 
	country = $("#country").val(); 
	
	$.ajax({
		url: "/aj/addshop/get_cities_by_country",
		data: {country:country},
		cache: false,
		success: function(result){
		  if(result) {		
			  	//获取数据
			    var obj = eval('(' + result + ')');
			    
			    //清空城市
			    $("#city").empty();
			    
			    //添加国家
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

//跳转
function edit(){
   id = $("#target_viewspot_id").val();
   self.location='/admin/editviewspot?viewspot_id='+id;
}

//编辑景点
function edit_viewspot(){
	id = $("#viewspot_id").html();
	isEdited = $("#isEdited").val();
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
	var antiPit = ueAntipit.getContent(); 

    var ajaxData = {
        id: id,
        isEdited: isEdited,
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
		url: "/aj/addviewspot/edit_viewspot",
		type: 'POST',
		data: ajaxData,
		cache: false,
		success: function(result){
            console.log(result);
			if(result){		
				alert('编辑景点成功');
				location.reload();
			}else{
				alert('编辑景点失败');
			}
		}
	});
}