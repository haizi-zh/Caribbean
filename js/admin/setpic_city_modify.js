
//编辑商家
function city_modify(){
	id = $("#id").html(); 
	img = $("#city_pic").attr("src");
	name = $("#name").val(); 
	english_name = $("#english_name").val(); 
	$.ajax({
		url: "/aj/city/city_modify",
		type: 'POST',
		data: {id:id,img:img,name:name,english_name:english_name},
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


