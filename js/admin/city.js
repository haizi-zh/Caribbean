
//隐藏城市
function city_hidden(id){
	$.ajax({
		url: "/aj/city/city_hidden_foradmin",
		type: 'POST',
		data: {id:id},
		cache: false,
		success: function(result){
		  if(result) {		
			  alert('成功');
			  location.reload();
		  }else{
			  alert('失败');
		  }
        }
	});
}
//显示城市
function city_show(id){
	$.ajax({
		url: "/aj/city/city_show_foradmin",
		type: 'POST',
		data: {id:id},
		cache: false,
		success: function(result){
		  if(result) {		
			  alert('成功');
			  location.reload();
		  }else{
			  alert('失败');
		  }
        }
	});
}

function set_city_level(id){
	var level =  $('#level_' + id)[0].value;

	$.ajax({
		url: "/aj/city/set_city_level",
		type: 'POST',
		data: {id:id,level:level},
		cache: false,
		success: function(result){
		  if(result) {		
			  alert('成功');
			  location.reload();
		  }else{
			  alert('失败');
		  }
        }
	});
}

function set_city_level_top(id){
	var level_top =  $('#level_top_' + id)[0].value;

	$.ajax({
		url: "/aj/city/set_city_level_top",
		type: 'POST',
		data: {id:id,level_top:level_top},
		cache: false,
		success: function(result){
		  if(result) {		
			  alert('成功');
			  location.reload();
		  }else{
			  alert('失败');
		  }
        }
	});
}
