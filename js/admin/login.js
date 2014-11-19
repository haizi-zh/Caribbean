//添加商家
function login(){
	uname = $("#uname").val(); 
	passwd = $("#passwd").val(); 
	
	$.ajax({
		url: "/aj/login/log",
		type: 'POST',
		data: {uname:uname,passwd:passwd},
		success: function(result){
			if(result == 1){
				alert('登录成功');
				window.location.href="/admin"; 
			}else{
				alert('登录失败');
			}
        }
	});
}