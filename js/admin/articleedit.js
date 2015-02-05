//编辑运营内容
function edit_article(){
	var id = $("#article_id").html();
	var title = $("#title").val();
	var source = $("#source").val();
	var authorName = $("#authorName").val();
	var desc = $("#desc").val();
	var image = $("#image").val();
	var publishTime = $("#publishTime").val();
    var content = ueContent.getContent();

    var ajaxData = {
        id: id,
        title: title,
        source: source,
        authorName: authorName,
        desc: desc,
        image: image,
        publishTime: publishTime,
        content: content
    }

    $.ajax({
    	url: "/aj/article/edit_article",
		type: 'POST',
		data: ajaxData,
		cache: false,
		success: function(result){
			if(result){
				alert('编辑内容成功');
				location.href = '/admin/articlelist';
			}else{
				alert('编辑内容失败');
			}
		}

    });
	
}