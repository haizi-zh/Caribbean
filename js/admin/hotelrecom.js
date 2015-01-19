//推荐酒店
function recom(){
	var editpick = new Array();
	$.each($("input[name='editpick[]']:checked"), function() { editpick.push($(this).val()); });
    
    separator = ',';
    var recomdata = [];
    for(var i=0; i<editpick.length; i++){
    	recomdata.push(editpick[i] + separator);
    }


	var ajaxData = {
		recomdata: JSON.stringify(recomdata),
	}

	$.ajax({
		url: "/aj/hotel/hotelrecom",
		type: 'POST',
		data: ajaxData,
		cache: false,
		success: function(result){
            console.log(result);
			if(result){		
				alert('推荐酒店成功');

			}else{
				alert('推荐酒店失败');
			}
		}
	});

}