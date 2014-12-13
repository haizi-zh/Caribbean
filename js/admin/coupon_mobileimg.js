//提交图片
$(document).ready(function(){
    
    var uploadFormConfig = function(form, input, fn, cbn) {
        cbn = cbn || ("ZB_" + (+(new Date())));
        $(input).change(function() {
            form.submit();
        });
        form.action = "http://v0.api.upyun.com/zanbai/";
        fn && (window[cbn] = fn);
    }

    if(uploadFormConfig){
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


function add_coupon_mobile_image(){
            var id = $('#id')[0].value;
            var photo = $("[name='city_pic']");
            var photo_str = "";
            $.each(photo, function(i,item){
                console.log(i, item, $(item).attr('src'));
                photo_str += $(item).attr('src')+",";
            });
       
            $.ajax({
                url: "/aj/coupon/add_coupon_mobile_image",
                type: 'POST',
                data: {id:id,mobile_pics:photo_str},
                cache: false,
                success: function(result){
                    if(result){     
                        alert('编辑成功');
                        location.href = '/admin/coupon/lists';
                        //location.reload();
                    }else{
                        alert('编辑失败');
                    }
                }
            });


}