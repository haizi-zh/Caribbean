//根据id删除评论
function delete_ping(){
	ping_id = $("#ping_id").val();
	
	$.ajax({
		url: "/aj/delete/delete_ping",
		type: 'POST',
		data: {ping_id:ping_id},
		cache: false,
		success: function(result){
		  if(result) {		
			  alert('删除点评成功');
			  location.reload();
		  }else{
			  alert('删除点评失败');
		  }
        }
	});
}