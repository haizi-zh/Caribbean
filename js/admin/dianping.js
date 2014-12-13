function dianping_ping_modify_uid(id){
	var uid=$('#uid')[0].value;
	if(!uid){
		return false;
	}
	$.ajax({
		url: "/aj/ping/dianping_ping_modify_uid",
		type: 'POST',
		data: {id:id,uid:uid},
		cache: false,
		success: function(result){
		  if(result) {		
			  alert('成功');
			  //location.reload();
		  }else{
			  alert('失败');
		  }
        }
	});
}
//dianping_ping_ctime
function dianping_ping_ctime(id){
	var ctime=$('#ctime')[0].value;
	if(!ctime){
		return false;
	}
	$.ajax({
		url: "/aj/ping/dianping_ping_ctime",
		type: 'POST',
		data: {id:id,ctime:ctime},
		cache: false,
		success: function(result){
		  if(result) {		
			  alert('成功');
			  //location.reload();
		  }else{
			  alert('失败');
		  }
        }
	});
}

//删除评论
function delete_dianping_comment(id){
	$.ajax({
		url: "/aj/ping/delete_dianping_comment_foradmin",
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

function recover_dianping_comment(id){
	$.ajax({
		url: "/aj/ping/recover_dianping_comment_foradmin",
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

//删除dianping
function delete_dianping(id){
	var now=new Date(); 
	var number = now.getSeconds(); 
	$.ajax({
		url: "/aj/ping/delete_dianping_foradmin?v="+number,
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

function recover_dianping(ping_id){
	var now=new Date(); 
	var number = now.getSeconds(); 
	$.ajax({
		url: "/aj/ping/recover_dianping_foradmin?v="+number,
		type: 'POST',
		data: {ping_id:ping_id},
		//cache: false,
		//async:false,
		complete: function(result){
			console.log(result);
		  if(result) {		
			  alert('成功');
			  location.reload();
		  }else{
			  alert('失败');
		  }
        }
	});
}


//删除dianping
function top_dianping(id,status){
	if(status!=0){
		alert("此晒单已被删除,请先取消删除后,再做置顶操作");
		return;
	}
	var now=new Date(); 
	var number = now.getSeconds(); 
	$.ajax({
		url: "/aj/ping/top_dianping?v="+number,
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

function untop_dianping(id){
	var now=new Date(); 
	var number = now.getSeconds(); 
	$.ajax({
		url: "/aj/ping/untop_dianping?v="+number,
		type: 'POST',
		data: {id:id},
		//cache: false,
		//async:false,
		complete: function(result){

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

