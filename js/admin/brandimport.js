//编辑品牌
//function editbrand(){
//	id = $("#brand_id").html();
//	name = $("#name").val();
//	ename = $("#englist_name").val();
//	desc = $("#desc").val();
//	small_img = $("#small_pic").attr("src");
//	big_img = $("#big_pic").attr("src");
//	
//	$.ajax({
//		url: "/aj/operation/editbrand",
//		type: 'POST',
//		data: {id:id,name:name,ename:ename,desc:desc,small_img:small_img,big_img:big_img},
//		cache: false,
//		success: function(result){
//		  if(result) {		
//			  alert('编辑品牌成功');
//		  }else{
//			  alert('编辑品牌失败');
//		  }
//		  location.reload();
//        }
//	});
//}

//跳转
function confirm(){
	id = $("#target_shop_id").val();
	self.location='/admin/brandimport?shop_id='+id;
}