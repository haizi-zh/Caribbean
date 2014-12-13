//提交图片
$(document).ready(function(){
	var topic1 = function(form, input, fn, cbn) {
        cbn = cbn || ("ZB_" + (+(new Date())));
	    $(input).change(function() {
	        form.submit();
	    });
	    form.action = "http://v0.api.upyun.com/zanbai/";
	    fn && (window[cbn] = fn);
	}
	
	topic1($('#brand_form')[0], $('#upload_file')[0], (function(){
        return function(o) {
        	console.log(o);
        	$('#brand_pic').attr('src', o.fullurl+'!300');
        }
    })(), 'ZB_ADMIN_BRAND');
});

//添加城市
function addcity(){

	name = $("#name").val();
	desc = $("#desc").val();
	timeCostDesc = $("#timeCostDesc").val();
	travelMonth = $("#travelMonth").val();
	culture = $("#culture").val();
	activityIntro = $("#activityIntro").val();
	lightspot = $("#lightspot").val();
	tips = $("#tips").val();
	localTraffic_titles = $.find(".localTraffic_title");
    localTraffic_contents = $.find(".localTraffic_content");
    remoteTraffic_titles = $.find(".remoteTraffic_title");
    remoteTraffic_contents = $.find(".remoteTraffic_content");
 	//img = $("#city_pic").attr("src");

    separator = ',';
    var localTraffic = [];
    for(var i=0; i<localTraffic_titles.length; i++){
    	localTraffic.push($(localTraffic_titles[i]).val() + separator + $(localTraffic_contents[i]).val());
    }
    var remoteTraffic = [];
	for(var i=0; i<remoteTraffic_titles.length; i++){
        remoteTraffic.push($(remoteTraffic_titles[i]).val() + separator + $(remoteTraffic_contents[i]).val());
	}
 

    var ajaxData = {
    	name: name,
    	desc: desc,
    	timeCostDesc: timeCostDesc,
    	travelMonth: travelMonth,
    	culture: culture,
    	activityIntro: activityIntro,
    	lightspot: lightspot,
    	tips: tips,
    	localTraffic: JSON.stringify(localTraffic),
    	remoteTraffic: JSON.stringify(remoteTraffic)
    }
    

	$.ajax({
		url: "/aj/operation/addcity",
		type: 'POST',
		data: ajaxData,
		cache: false,
		success: function(result){

		  if(result) {		
			  alert('添加城市成功');
		  }else{
			  alert('添加城市失败');
		  }
		  location.reload();
        }
	});
}


function addlocal(){

    var htmlTemplate = '<span style="line-height:30px;border:3px solid #000;height:50px;color:black;font-weight:bold">New Title</span>' +
                  ' <textarea rows="1" class="localTraffic_title" style="line-height:30px;width:425px" value=""></textarea><br><br>' +
                  '<textarea rows="10" class="localTraffic_content" style="width:500px;" value=""></textarea><br><br>';

    $("#localTraffic").append(htmlTemplate);

}

function addremote(){

    var htmlTemplate = '<span style="line-height:30px;border:3px solid #000;height:50px;color:black;font-weight:bold">New Title</span>' +
                  ' <textarea rows="1" class="remoteTraffic_title" style="line-height:30px;width:425px" value=""></textarea><br><br>' +
                  '<textarea rows="10" class="remoteTraffic_content" style="width:500px;" value=""></textarea><br><br>';

    $("#remoteTraffic").append(htmlTemplate);

}