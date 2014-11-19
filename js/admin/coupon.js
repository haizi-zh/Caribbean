
function add_coupon(){
            var id = $('#id')[0].value;

            var shop_ids = $("[name='shop_id']");
            var shop_ids_str = "";
            $.each(shop_ids, function(i,item){
                shop_ids_str += $(item).val()+",";
            });
            brand_item = $("[name='brand_item']");
            var brand_infos = {};
            $.each(brand_item, function(i,item){
                brand_id = $(item).find('#brand_id')[0].value;
                var str="";

                var list = $(item).find("[name='country_ids']");

                var len = list.length;
                for (var i = 0; i < len; i++) {
                    if (list[i].checked) {
                        str+=list[i].value+","; 
                    };
                }
                brand_infos[brand_id] = str;
            });

            var brand_id = $('#brand_id')[0].value;
            var title = $('#title')[0].value;
            var level = $('#level')[0].value;
            var share_content = $('#share_content')[0].value;
            if($("#body")[0]){
                var body = $('#body')[0].value;
            }else{
                var body = '';
            }
            
            var img_size = $('#img_size')[0].value;
            var template_order = $("#template_order")[0].value

            var photo = $("[name='city_pic']");
            var photo_str = "";
            $.each(photo, function(i,item){
                photo_str += $(item).attr('src')+",";
            });


            
            $.ajax({
                url: "/aj/coupon/add",
                type: 'POST',
                data: {id:id,brand_infos:brand_infos,title:title,body:body,pics:photo_str,shop_ids_str:shop_ids_str,level:level,body:body,share_content:share_content,img_size:img_size,template_order:template_order},
                cache: false,
                success: function(result){
                    if(result){     
                        alert('编辑成功');
                        //location.href = '/admin/coupon/lists';
                        //location.reload();
                    }else{
                        alert('编辑失败');
                    }
                }
            });


}


$("[action-type='show_more']").click(function(){
    id = $(this).attr("action-data");
    more_id = "more_"+id;
    $("#"+more_id).toggle();
});


$("[action-type='add_shop']").click(function(){
    var lines = $("[name='shop_id']");
    var clone_line = $(lines[0]).clone();
    clone_line.val('');
    $("#shop_ids").append(clone_line);
});
//<div id="tong" class="hide" ><img src="images/tong.jpg" /></div>

$("[action-type='show_img']").mouseover(function(){
    pic = $(this).attr("action-data");
    console.log('in');

});

$("[action-type='show_img']").mouseout(function(){
    console.log('out');
});


$("[action-type='add_brand']").click(function(){
    var lines = $("[name='brand_item']");
    var clone_line = $(lines[0]).clone(true,true);
    clone_line.val('');
    $("#brand_ids").append(clone_line);
});

function delete_coupon(id){
    $.ajax({
        url: "/aj/coupon/delete_coupon",
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

function recover_coupon(id){
    $.ajax({
        url: "/aj/coupon/recover_coupon",
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


function add_seo(){
    var id = $("#id").val();
    var seo_title = $("#seo_title").val();
    var seo_keywords = $("#seo_keywords").val();
    var seo_description = $("#seo_description").val();
    
    $.ajax({
        url: "/aj/coupon/edit_coupon_seo",
        type: 'POST',
        data: {seo_title:seo_title,seo_keywords:seo_keywords,seo_description:seo_description,id:id},
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




//提交图片
$(document).ready(function(){

    $("[action-type='brand_id']").bind('change', function(){
        var brand_id = $(this).val();
        var country_list = $(this).parent().parent().parent().find("#country_list");
        console.log(country_list);
        $.ajax({
            url: "/aj/coupon/get_brand_countrys",
            data: {brand_id:brand_id},
            cache: false,
            success: function(result){
              if(result) {      
                    //获取数据
                    var obj = eval('(' + result + ')');
                    //清空城市
                    country_list.empty();
                    country_list.append("品牌分布的国家:");
                    //添加国家
                    for (var i in obj) {
                        country_list.append("<input type='checkbox' name='country_ids' id='country_ids_"+i+"' value='"+i+"'/>"+obj[i]);
                    }
                   country_list.append("(若不选择国家，则默认此品牌所有的商家都添加优惠券。若选择则只有选中国家的商家才显示。)");
              }else{
                    //alert('fail');
              }
            }
        });
    });



//根据国家获取城市列表
/*
$('[action-type="brand_id"]').change(function(){ 
    var brand_id = $(this).val();
    console.log(23);
    $.ajax({
        url: "/aj/coupon/get_brand_countrys",
        data: {brand_id:brand_id},
        cache: false,
        success: function(result){
          if(result) {      
                //获取数据
                var obj = eval('(' + result + ')');
                //清空城市
                $("#country_list").empty();
                $("#country_list").append("品牌分布的国家:");
                //添加国家
                for (var i in obj) {
                    $("#country_list").append("<input type='checkbox' name='country_ids' id='country_ids_"+i+"' value='"+i+"'/>"+obj[i]);
                }
                $("#country_list").append("(若不选择国家，则默认此品牌所有的商家都添加优惠券。若选择则只有选中国家的商家才显示。)");
          }else{
                //alert('fail');
          }
        }
    });
})*/


    var uploadFormConfig = function(form, input, fn, cbn) {
        cbn = cbn || ("ZB_" + (+(new Date())));
        $(input).change(function() {
            form.submit();
        });
        form.action = "http://v0.api.upyun.com/zanbai/";
        fn && (window[cbn] = fn);
    }
    var upload_form = $('#upload_form');
    
    if(uploadFormConfig && upload_form[0]){
        uploadFormConfig($('#upload_form')[0], $('#upload_file')[0], (function(){
            return function(o) {
                pic_url = o.fullurl+'!300';
                var img_str = "<li style='padding:5px;'><img width='80' height='80' name='city_pic' src="+pic_url+"></img></li>";
                //$('#city_pic').attr('src', );
                $("#my_list").append(img_str);
            }
        })(), 'ZB_ADMIN_SHOP');

    }
});


$(function() {
    $( "#my_list" ).sortable({
      revert: true
    });

  });


