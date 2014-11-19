$(function(){

$("[action-type='delete_tag']").click(function(){
	var id = $(this).attr("action-data");
	console.log(id);
	$.ajax({
		url:"/aj/brandtag/delete_brandtag_foradmin",
		type:"POST",
		data:{id:id},
		cache:false,
		success:function(result){
		  if(result) {		
			  //alert('成功');
			  //location.reload();
		  }else{
			  alert('失败');
		  }
		}
	});
});


});