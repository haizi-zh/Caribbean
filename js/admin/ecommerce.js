//提交图片
$(document).ready(function(){
    
$('[action-type="del_cat"]').bind("click", function(){
    var id = $(this).attr("action-data");
    $.ajax({
        "url":"/aj/ecommerce/del_cat",
        "type":"POST",
        "data":{id:id},
        "cache":false,
        success:function(result){
            if(result){
                alert("成功");
                location.reload();
            }else{
                alert("失败");
            }
        }
    });
});

$('[action-type="del_link"]').bind("click", function(){
    var id = $(this).attr("action-data");
    console.log(id);
    $.ajax({
        "url":"/aj/ecommerce/del_link",
        "type":"POST",
        "data":{id:id},
        "cache":false,
        success:function(result){
            if(result){
                alert("成功");
                location.reload();
            }else{
                alert("失败");
            }
        }
    });
});


});