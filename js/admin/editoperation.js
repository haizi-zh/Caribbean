//编辑运营内容
function edit_operation(){
	id = $("#operation_id").html();
	title = $("#title").val();
	cover = $("#cover").val();
	link = $("#link").val();

    var ajaxData = {
        id: id,
        title: title,
        cover: cover,
        link: link
	   
    }


    $.ajax({
    	url: "/aj/addoperation/edit_operation",
		type: 'POST',
		data: ajaxData,
		cache: false,
		success: function(result){ 
			if(result){
				alert('编辑内容成功');
				location.reload();
			}else{
				alert('编辑内容失败');
			}
		}

    });
	
}