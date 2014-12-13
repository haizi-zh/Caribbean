$(document).ready(function(){


    $('#adv_add').click(function(){
        id = $("#id").val();
        name = $("#name").val();
        url = $("#url").val();
        country = $("#country").val();
        city = $("#city").val();
        shop_id = $("#shop_id").val();
        type = $("#type").val();
        pic = $("#pic").val();
        level = $("#level").val();

        n_city = $("#n_city").val();
        n_shop_id = $("#n_shop_id").val();
        n_coupon_id = $("#n_coupon_id").val();
        $.ajax({
            url: "/aj/adv/add",
            type: 'POST',
            data: {id:id,name:name,url:url,country:country,city:city,shop_id:shop_id,type:type,pic:pic,level:level,n_city:n_city,n_shop_id:n_shop_id,n_coupon_id:n_coupon_id},
            cache: false,
            success: function(result){
              if(result) {      
                  layer.msg("操作成功", 2, -1, function (){ location.href="/admin/adv/"});
              }else{
                  layer.msg("操作失败", 2, -1);
              }
              
            }
        });

    });



    $('[action-type="delete_adv"]').click(function(){
        id = $(this).attr("id");
        $.ajax({
            url: "/aj/adv/delete",
            type: 'POST',
            data: {id:id},
            cache: false,
            success: function(result){
              if(result) {      
                  layer.msg("操作成功", 2, -1, function (){ location.href="/admin/adv/"});
              }else{
                  layer.msg("操作失败", 2, -1);
              }
              
            }
        });

    });

    $('[action-type="recover_adv"]').click(function(){
        id = $(this).attr("id");
        $.ajax({
            url: "/aj/adv/recover",
            type: 'POST',
            data: {id:id},
            cache: false,
            success: function(result){
              if(result) {      
                  layer.msg("操作成功", 2, -1, function (){ location.href="/admin/adv/"});
              }else{
                  layer.msg("操作失败", 2, -1);
              }
              
            }
        });

    });

    var uploadFormConfig = function(form, input, fn, cbn) {
        cbn = cbn || ("ZB_" + (+(new Date())));
        $(input).change(function() {
            form.submit();
        });
        form.action = "http://v0.api.upyun.com/zanbai/";
        fn && (window[cbn] = fn);
    }
    if($('#upload_form')[0] && uploadFormConfig){

        uploadFormConfig($('#upload_form')[0], $('#upload_file')[0], (function(){
            return function(o) {
                pic_url = o.fullurl+'!300';
                source_url = o.source_url;
                $('#pic_src').attr('src', pic_url);
                $('#pic').val(source_url);
            }
        })(), 'ZB_ADMIN_SHOP');


    }



});



