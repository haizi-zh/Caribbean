//编辑商家
function add_photo(){
	shop_id = $("#shop_id").val(); 
	desc = $("#desc").val(); 
	photo = $("#city_pic").attr("src");
	$.ajax({
		url: "/aj/shop/add_shop_photo",
		type: 'POST',
		data: {shop_id:shop_id,photo:photo,desc:desc},
		cache: false,
		success: function(result){
			if(result){		
				alert('编辑成功');
				location.reload();
			}else{
				alert('编辑失败');
			}
		}
	});
}

function modify_photo_desc(){
	id = $("#id").val(); 
	desc = $("#desc").val(); 
	$.ajax({
		url: "/aj/shop/modify_photo_desc",
		type: 'POST',
		data: {id:id,desc:desc},
		cache: false,
		success: function(result){
			if(result){		
				alert('编辑成功');
				location.reload();
			}else{
				alert('编辑失败');
			}
		}
	});
}



function delete_shop_photo(id){
	$.ajax({
		url: "/aj/shop/delete_photo",
		type: 'POST',
		data: {id:id},
		cache: false,
		success: function(result){
			if(result){		
				alert('成功');
				location.reload();
			}else{
				alert('失败');
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
        	$('#city_pic').attr('src', o.fullurl+'!300');
        }
    })(), 'ZB_ADMIN_SHOP');

});
