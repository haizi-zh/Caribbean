$(document).ready(function(){
	
	$("[name='rank_score']").bind('change', function(){
		id = $(this).attr("id");
		rank_score = $(this).val();
		old_value = $(this).attr("old-value");
		if(isNaN(rank_score)){
			alert("请输入纯数字");
			$(this).val(old_value);
			return false;
		}
		$.ajax({
			'url':"/aj/shop/change_rank_score_foradmin",
			"type":"post",
			'data':{id:id,rank_score:rank_score},
	        success: function(result){
	          if(result) {      
	              alert('修改排名得分成功');
	              $(this).attr("old-value", rank_score);
	          }else{
	              alert('失败');
	          }
	        }
		});
	});


	$("[name='delete_cache']").bind('click', function(){
		id = $(this).attr("id");
		$.ajax({
			'url':"/aj/shop/delete_cache_foradmin",
			"type":"post",
			'data':{id:id},
	        success: function(result){
	          if(result) {      
	              alert('清理成功');
	          }else{
	              alert('失败');
	          }
	        }
		});
	});

	$("[name='delete_brand_cache']").bind('click', function(){
		id = $(this).attr("id");
		$.ajax({
			'url':"/aj/shop/delete_cache_brand_foradmin",
			"type":"post",
			'data':{id:id},
	        success: function(result){
	          if(result) {      
	              alert('清理成功');
	          }else{
	              alert('失败');
	          }
	        }
		});
	});
	
});

