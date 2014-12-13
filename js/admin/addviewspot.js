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
    	country:country,
    	province:province,
    	city:city,
    	name:name,
    	description:description,
    	address:address,
    	openTime:openTime,
    	openHour:openHour,
    	closeHour:closeHour,
    	priceDesc:priceDesc,
    	phone:phone,
    	ratingsScore:ratingsScore,
    	visitGuide:visitGuide,
    	antiPit:antiPit,
    	travelGuide:travelGuide
    }

	$.ajax({
		url: "/aj/addviewspot/add_viewspot",
		type: 'POST',
		data: ajaxData,
		cache: false,
		success: function(result){
		  if(result) {		
			  alert('景点添加成功');
			  location.reload();
		  }else{
			  alert('景点添加失败');
		  }
        }
	});
}