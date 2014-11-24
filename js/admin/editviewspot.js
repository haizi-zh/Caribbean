//跳转
function edit(){
   id = $("#target_shop_id").val();
   self.location='/admin/editviewspot?shop_id='+id;
}

//编辑景点
function edit_viewspot(){
	//id = $("#shop_id").html();
	//！！！调试用：跳过页面中shop_id，直接更新
	id = '1';
	name = $("#name").val();
	english_name = $("#english_name").val();
	desc = $("#desc").val();

	$.ajax({
		url: "/aj/addviewspot/edit_viewspot",
		type: 'POST',
		data: {id:id,name:name,english_name:english_name,desc:desc},
		cache: false,
		success: function(result){
			if(result){		
				alert('编辑景点成功');
				location.reload();
			}else{
				alert('编辑景点失败');
			}
		}
	});
}