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

//添加商家
function add_shop(){
	area = $("#area").val(); 
	country = $("#country").val(); 
	city = $("#city").val(); 
	name = $("#name").val();
	english_name = $("#english_name").val();
	desc = $("#desc").val();
	address = $("#address").val();
	phone = $("#phone").val();
	business_hour = $("#business_hour").val();
	property = $("#property").val();
	img = $("#shop_pic").attr("src");
	rank_score = $("#rank_score").val();
	reserve_1 = $("#shop_cnt").val();
	reserve_2 = $("#link").val();
	reserve_3 = $("#how_come").val();

	discount_type = $("#discount_type").val();

	$.ajax({
		url: "/aj/addshop/add_shop",
		type: 'POST',
		data: {area:area,country:country,city:city,name:name,english_name:english_name,desc:desc,address:address,phone:phone,business_hour:business_hour,property:property,img:img,rank_score:rank_score,reserve_1:reserve_1,reserve_2:reserve_2,reserve_3:reserve_3,discount_type:discount_type},
		cache: false,
		success: function(result){
		  if(result) {		
			  alert('商家添加成功');
			  location.reload();
		  }else{
			  alert('商家添加失败');
		  }
        }
	});
}

//提交图片
$(document).ready(function(){
	var uploadFormConfig = function(form, input, fn, cbn) {
            cbn = cbn || ("ZB_" + (+(new Date())));
            
	    $(input).change(function() {
	        form.submit();
	    });
	    form.action = "http://v0.api.upyun.com/zanbai/";
	    fn && (window[cbn] = fn);
	}

         uploadFormConfig($('#upload_form')[0], $('#upload_file')[0], (function(){
            return function(o) {
            	$('#shop_pic').attr('src', o.fullurl+'!300');
            }
        })(), 'ZB_ADMIN_SHOP');
});
