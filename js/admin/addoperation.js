//添加景点
function add_operation(){ 
	title = $("#title").val(); 
	cover = $("#cover").val(); 
	link = $("#link").val();   

    var ajaxData = {
    	title: title,
    	cover: cover,
    	link: link
    	
    }

	$.ajax({
		url: "/aj/addoperation/add_operation",
		type: 'POST',
		data: ajaxData,
		cache: false,
		success: function(result){

		  if(result) {		
			  alert('内容添加成功');
			  location.reload();
		  }else{
			  alert('内容添加失败');
		  }
        }
	});
}