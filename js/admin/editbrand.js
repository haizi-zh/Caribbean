//编辑品牌
function editbrand(){
	id = $("#brand_id").html();
	name = $("#name").val();
	ename = $("#englist_name").val();
	desc = $("#desc").val();
	property = $("#property").val();
	small_img = $("#small_pic").attr("src");
	big_img = $("#big_pic").attr("src");
	ebusiness_id = $("#ebusiness_id").val();
	eb_name = $("#eb_name").val();
	eb_url = $("#eb_url").val();
    var brandtag_ids="";
    var list = $("[name='brandtag_id']");

    var len = list.length;
    for (var i = 0; i < len; i++) {
        if (list[i].checked) {
            brandtag_ids+=list[i].value+","; 
        };
    }
	
	$.ajax({
		url: "/aj/operation/editbrand",
		type: 'POST',
		data: {id:id,name:name,ename:ename,desc:desc,property:property,small_img:small_img,big_img:big_img,ebusiness_id:ebusiness_id,eb_name:eb_name,eb_url:eb_url,brandtag_ids:brandtag_ids},
		cache: false,
		success: function(result){
		  if(result) {		
			  alert('编辑品牌成功');
		  }else{
			  alert('编辑品牌失败');
		  }
		 // location.reload();
        }
	});
}

//跳转
function edit(){
	id = $("#target_brand_id").val();
	self.location='/admin/editbrand?brand_id='+id;
}

$(document).ready(function(){
	
	var pic = function(form, input, fn, cbn) {
        cbn = cbn || ("ZB_" + (+(new Date())));
	    $(input).change(function() {
	        form.submit();
	    });
	    form.action = "http://v0.api.upyun.com/zanbai/";
	    fn && (window[cbn] = fn);
	}
	
	//pic($('#small_pic_form')[0], $('#upload_small_file')[0], (function(){
    //    return function(o) {
    //    	$('#small_pic').attr('src', o.fullurl+'!300');
    //    }
    //})(), 'ZB_ADMIN_EDIT_BRAND_SMALL');
	
	pic($('#big_pic_form')[0], $('#upload_big_file')[0], (function(){
        return function(o) {
        	$('#big_pic').attr('src', o.fullurl+'!300');
        }
    })(), 'ZB_ADMIN_EDIT_BRAND_BIG');
});