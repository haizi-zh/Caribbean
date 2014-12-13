//提交图片
$(document).ready(function(){
	var topic1 = function(form, input, fn, cbn) {
        cbn = cbn || ("ZB_" + (+(new Date())));
	    $(input).change(function() {
	        form.submit();
	    });
	    form.action = "http://v0.api.upyun.com/zanbai/";
	    fn && (window[cbn] = fn);
	}
	
	topic1($('#brand_form')[0], $('#upload_file')[0], (function(){
        return function(o) {
        	console.log(o);
        	$('#brand_pic').attr('src', o.fullurl+'!300');
        }
    })(), 'ZB_ADMIN_BRAND');
});

//添加品牌
function setbrand(){
	name = $("#name").val();
	ename = $("#englist_name").val();
	desc = $("#desc").val();
	property = $("#property").val();
	img = $("#brand_pic").attr("src");
	ebusiness_id = $("#ebusiness_id").val();
	eb_name = $("#eb_name").val();
	eb_url = $("#eb_url").val();

	$.ajax({
		url: "/aj/operation/addbrand",
		type: 'POST',
		data: {name:name,ename:ename,desc:desc,property:property,img:img,ebusiness_id:ebusiness_id,eb_name:eb_name,eb_url:eb_url},
		cache: false,
		success: function(result){
		  if(result) {		
			  alert('添加品牌成功');
		  }else{
			  alert('添加品牌失败');
		  }
		  location.reload();
        }
	});
}
