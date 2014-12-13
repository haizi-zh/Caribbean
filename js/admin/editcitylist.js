//编辑城市
function editcity(){
	id = $("#city_id").html();
	name = $("#name").val();
	desc = $("#desc").val();
	timeCostDesc = $("#timeCostDesc").val();
	travelMonth = $("#travelMonth").val();
	// small_img = $("#small_pic").attr("src");
	culture = $("#culture").val();
	activityIntro = $("#activityIntro").val();
	lightspot = $("#lightspot").val();
	tips = $("#tips").val();
	localTraffic_titles = $.find(".localTraffic_title");
	localTraffic_contents = $.find(".localTraffic_content");
	remoteTraffic_titles = $.find(".remoteTraffic_title");
	remoteTraffic_contents = $.find(".remoteTraffic_content");

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
		// data
		id: id,
		name: name,
		desc: desc,
		timeCostDesc: timeCostDesc,
		travelMonth: travelMonth,
		culture: culture,
		activityIntro:activityIntro,
		lightspot: lightspot,
		tips: tips,
		localTraffic: JSON.stringify(localTraffic),
		remoteTraffic: JSON.stringify(remoteTraffic)
	}
	
	$.ajax({
		url: "/aj/operation/editcity",
		type: 'POST',
		data: ajaxData,
		cache: false,
		success: function(result){

		  if(result) {		
			  alert('编辑城市成功');
		  }else{
			  alert('编辑城市失败');
		  }
		  location.reload();
        }
	});
}


$(document).ready(function(){
	return;
	var pic = function(form, input, fn, cbn) {
        cbn = cbn || ("ZB_" + (+(new Date())));
	    $(input).change(function() {
	        form.submit();
	    });
	    form.action = "http://v0.api.upyun.com/zanbai/";
	    fn && (window[cbn] = fn);
	}
	
	//pic($('#small_pic_form')[0], $('#upload_small_file')[0], (function(){
    //    return function(o) {
    //    	$('#small_pic').attr('src', o.fullurl+'!300');
    //    }
    //})(), 'ZB_ADMIN_EDIT_BRAND_SMALL');
	
	pic($('#big_pic_form')[0], $('#upload_big_file')[0], (function(){
        return function(o) {
        	$('#big_pic').attr('src', o.fullurl+'!300');
        }
    })(), 'ZB_ADMIN_EDIT_BRAND_BIG');
});