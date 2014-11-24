//添加景点
function add_viewspot(){ 
	name = $("#name").val();
	english_name = $("#english_name").val();
	desc = $("#desc").val();

	$.ajax({
		url: "/aj/addviewspot/add_viewspot",
		type: 'POST',
		data: {name:name,english_name:english_name,desc:desc},
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