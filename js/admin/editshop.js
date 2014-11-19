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

//编辑商家
function edit_shop(){
	id = $("#shop_id").html(); 
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
	mylocation = $("#location").val();
	reserve_1 = $("#shop_cnt").val();
	reserve_2 = $("#link").val();
	seo_keywords = $("#seo_keywords").val();

	reserve_3 = $("#how_come").val();
	discount_type = $("#discount_type").val();
	$.ajax({
		url: "/aj/addshop/edit_shop",
		type: 'POST',
		data: {id:id,area:area,country:country,city:city,name:name,english_name:english_name,desc:desc,address:address,phone:phone,business_hour:business_hour,property:property,img:img,rank_score:rank_score,reserve_1:reserve_1,reserve_2:reserve_2,reserve_3:reserve_3,location:mylocation,seo_keywords:seo_keywords,discount_type:discount_type},
		cache: false,
		success: function(result){
			if(result){		
				alert('编辑商家成功');
				location.reload();
			}else{
				alert('编辑商家失败');
			}
		}
	});
}

//跳转
function edit(){
	id = $("#target_shop_id").val(); 
	self.location='/admin/editshop?shop_id='+id;
}

//提交图片
$(document).ready(function(){
	
	 function initialize() {
	    var lon = $("#lon").html();
	    var lat = $("#lat").html();
	    var shop_name = $("#name").val();
	    var zoom = 0;
	    if(lon) zoom=13;
	    
		var mapOptions = {
				center: new google.maps.LatLng(lon, lat),
				zoom: zoom,
				mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		
		var map = new google.maps.Map(document.getElementById("map-canvas"),
		        mapOptions);
		
		var marker = new google.maps.Marker({
		    position: map.getCenter(),
		    map: map,
		    title: shop_name,
		  });
		
		map.panTo(marker.getPosition());
		google.maps.event.addListener(map, 'click', function(e) {
			var location = new String(e.latLng);
			location = location.replace("(","");
			location = location.replace(")","");
			$('#location').val(location)
		});
	}
	var has_map = $("#has_map").html();
	console.log(has_map);
	
	if(has_map){
		google.maps.event.addDomListener(window, 'load', initialize);	
	}
	
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