//提交图片
$(document).ready(function(){
	var topic = function(form, input, fn, cbn) {
        cbn = cbn || ("ZB_" + (+(new Date())));
	    $(input).change(function() {
	        form.submit();
	    });
	    form.action = "http://v0.api.upyun.com/zanbai/";
	    fn && (window[cbn] = fn);
	}

	topic($('#topic_01')[0], $('#upload_file1')[0], (function(){
        return function(o) {
        	$('#topic_pic01').attr('src', o.fullurl+'!300');
        }
    })(), 'ZB_ADMIN_TOPIC1');


	topic($('#topic_02')[0], $('#upload_file2')[0], (function(){
        return function(o) {
        	$('#topic_pic02').attr('src', o.fullurl+'!300');
        }
    })(), 'ZB_ADMIN_TOPIC2');

    topic($('#topic_03')[0], $('#upload_file3')[0], (function(){
        return function(o) {
        	$('#topic_pic03').attr('src', o.fullurl+'!300');
        }
    })(), 'ZB_ADMIN_TOPIC3');

    topic($('#topic_04')[0], $('#upload_file4')[0], (function(){
        return function(o) {
        	$('#topic_pic04').attr('src', o.fullurl+'!300');
        }
    })(), 'ZB_ADMIN_TOPIC4');
});

//提交运营数据
function setpic(){
	img1 = $("#topic_pic01").attr("src");
	link1 = $("#link1").val();
	img2 = $("#topic_pic02").attr("src");
	link2 = $("#link2").val();
	img3 = $("#topic_pic03").attr("src");
	link3 = $("#link3").val();
	img4 = $("#topic_pic04").attr("src");
	link4 = $("#link4").val();

	$.ajax({
		url: "/aj/operation/update_home_pics",
		type: 'POST',
		data: {img1:img1,link1:link1,img2:img2,link2:link2,img3:img3,link3:link3,img4:img4,link4:link4},
		cache: false,
		success: function(result){
		  if(result) {
			  alert('轮播图片设置成功');
		  }else{
			  alert('轮播图片设置失败');
		  }
		  location.reload();
        }
	});
}



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



