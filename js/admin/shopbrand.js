//跳转
function confirm(){
	id = $("#target_shop_id").val(); 
	self.location='/admin/shopbrand?nocache=1&shop_id='+id;
}

//品牌下拉选择框
$("#brand_box").change(function(){
	brand_id = $("#brand_box").val();
	$("#target_brand_id").val(brand_id);
})

//选中品牌
function select_brand(id, name){
	$("#target_brand_id").val(id);
	$("#suggestion_brand").val(name);
	$("#suggestion_result").empty();
	$("#suggestion_result").css("display","none");
}

//品牌联想功能
function suggestion(piece){
	$.ajax({
	    url: "http://zanbai.com:8090/?piece=" + piece,
	    async: false,
	    dataType: "jsonp",
	    jsonp: "callback",
	    success: function( json ){
	        data = eval('(' + json + ')');
			brand = data['brand'];
			var html = '';
			if(brand && brand.length){
			    for(var i=0;i<brand.length;i++){                     	
			       word = brand[i]['word']
			       word_id = brand[i]['word_id']
			       html += '<a href="javascript:;" style="text-decoration:none;color:#000;" onclick="select_brand(' + word_id + ',\''+ word+'\')">' + brand[i]['word'] + '</a><br>';
			    }
			}else{
				html += '很遗憾，没有为您找到对应的品牌，请尝试重新输入~<br>';
			}
			$("#target_brand_id").val('');
			$("#suggestion_result").css("display","block"); 
		    $("#suggestion_result").empty();
		    $("#suggestion_result").append(html); 
	    }
	});
}

//为商家添加品牌
function add_shop_brand(){
	brand_id = $("#target_brand_id").val();
	shop_id = $("#shop_id").html();
	city_id = $("#city_id").html();
	
	$.ajax({
		url: "/aj/shopbrand/add_shop_brand",
		data: {brand_id:brand_id,city_id:city_id,shop_id:shop_id},
		cache: false,
		type: 'POST',
		success: function(result){
		  if(result == 1) {
			  	alert('添加品牌成功');
			  	location.reload();
		  }else{
              	alert('添加品牌失败，请检查是否为商家选择城市是否选择.');
		  }
        }
	});
}

function delete_shop_brand(shop_id, brand_id){
	$.ajax({
		url: "/aj/shopbrand/delete_shop_brand",
		data: {brand_id:brand_id,shop_id:shop_id},
		cache: false,
		type: 'POST',
		success: function(result){
		  if(result == 1) {
			  	alert('删除品牌成功');
			  	location.reload();
		  }else{
              	alert('删除品牌失败');
		  }
        }
	})
}
function select_demo(id){
	//console.log(id);
	$("#target_brand_id").val(id);
}

function demo_suggest(){
	var brand_name = $("#brand_name").val();
	$.ajax({
		url: "/aj/shopbrand/demo_suggest",
		data: {brand_name:brand_name},
		cache: false,
		type: 'GET',
		success: function(result){
			    var obj = eval('(' + result + ')');
			   // console.log(obj.data);

			    //清空城市
			    // <ul style="max-height: 180px; overflow: auto;"><li class="ac_even"><strong>Sa</strong>bina</li><li class="ac_odd ac_over"><strong>Sa</strong>int Clairsville</li><li class="ac_even"><strong>Sa</strong>int Henry</li><li class="ac_odd"><strong>Sa</strong>int Johns</li><li class="ac_even"><strong>Sa</strong>int Louisville</li><li class="ac_odd"><strong>Sa</strong>int Marys</li><li class="ac_even"><strong>Sa</strong>int Paris</li><li class="ac_odd"><strong>Sa</strong>lem</li><li class="ac_even"><strong>Sa</strong>lesville</li><li class="ac_odd"><strong>Sa</strong>lineville</li><li class="ac_even"><strong>Sa</strong>ndusky</li><li class="ac_odd"><strong>Sa</strong>ndyville</li><li class="ac_even"><strong>Sa</strong>rahsville</li><li class="ac_odd"><strong>Sa</strong>rdinia</li><li class="ac_even"><strong>Sa</strong>rdis</li><li class="ac_odd"><strong>Sa</strong>vannah</li></ul>
			   	$("#name_list").empty();
			    content = '<ul style="max-height: 180px; overflow: auto;">';
			    //添加国家
			    
			  	for (var i in obj.data) {
			  		content += '<li onclick="select_demo('+obj.data[i]['id']+');">' + obj.data[i]['name'] + '   id=>' + obj.data[i]['id'] + '</li>';
			  		//$("#name_list").append("<option value='"+obj.data[i]['id']+"'>"+obj.data[i]['name']+"</option>");
			  	}
			  	content+= '</ul>';
			  	$("#name_list").html(content);
		  		//console.log(content);
        }
	})

}
