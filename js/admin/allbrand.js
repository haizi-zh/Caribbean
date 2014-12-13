//获取品牌html
function getbrandhtml(char){
	
	$.ajax({
		url: "/aj/operation/getbrandhtml",
		type: 'POST',
		data: {char:char},
		cache: false,
		success: function(result){
			 $("#brands_html").html(result);
			 $("#char_label").html('当前字母:'+char);
        }
	});
}

function set_brand(brand_id, brand_name){
	$("#brand_id").html(brand_id); 
	$("#brand_name").html(brand_name); 
}

function delete_brand(){
	brand_id = $("#brand_id").html();	
	$.ajax({
		url: "/aj/operation/delete_brand",
		type: 'POST',
		data: {brand_id:brand_id},
		cache: false,
		success: function(result){
			if(result) {		
			  	alert('删除品牌成功');
			  	location.reload();
			}else{
	            alert('删除品牌失败');
			  	location.reload();
			}
        }
	});
}