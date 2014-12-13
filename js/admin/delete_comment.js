//根据id删除评论
function delete_comment(){
	comment_id = $("#comment_id").val();
	
	$.ajax({
		url: "/aj/delete/delete_comment",
		type: 'POST',
		data: {comment_id:comment_id},
		cache: false,
		success: function(result){
		  if(result) {		
			  alert('删除评论成功');
			  location.reload();
		  }else{
			  alert('删除评论失败');
		  }
        }
	});
}