//添加商家
function add_user(){
	id=$("#id").val(); 
	username = $("#username").val(); 
	password = $("#password").val(); 
	nikename = $("#nikename").val(); 
	power = $("#power").val();
	if(!username || !password || !nikename){
		alert('请添加全');
		return;
	}

	$.ajax({
		url: "/aj/adminuser/add_user",
		type: 'POST',
		data: {id:id,username:username,password:password,nikename:nikename,power:power},
		cache: false,
		'complete': function(result,textStatus){
		  var results = $.parseJSON(result.responseText);
		  
		  if(results.code == 200) {		
			  alert('添加成功');
		  }else{
			  alert(results.msg);
		  }
        }
	});
}