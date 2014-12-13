function delete_discount(id){
	$.ajax({
		url: "/aj/discount/delete_discount_foradmin",
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
function recover_discount(id){
	$.ajax({
		url: "/aj/discount/recover_discount_foradmin",
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



function publish_discount(id){
	$.ajax({
		url: "/aj/discount/recover_discount_foradmin",
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




function show(id){
	var body=$('#body_'+id);
	var clean_body = $('#clean_body_'+id);
	clean_body[0].style.display = 'none';
	body[0].style.display= '';
}

function hidden(id){
	var body=$('#body_'+id);
	var clean_body = $('#clean_body_'+id);
	clean_body[0].style.display = '';
	body[0].style.display= 'none';
}