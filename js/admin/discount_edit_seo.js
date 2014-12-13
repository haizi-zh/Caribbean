
$.ready(function () {
        $('#edit_discount').addEvent('click', function(){

        var id = $('#id')[0].value;
        var seo_title = $('#seo_title')[0].value;
        var seo_keywords = $('#seo_keywords')[0].value;
        var seo_description = $('#seo_description')[0].value;
       
        $.io.ajax({
            'method': 'post',
            'url': '/aj/discount/edit_discount_seo',
            'args': {
                'id':id,
                'seo_title':seo_title,
                'seo_keywords':seo_keywords,
                'seo_description':seo_description
            },
            'onComplete': function(data){
                if(data.code == '200'){
                    $.litePrompt('添加成功！', {
                        'timeout': 1500
                    });
                }else{
                    $.litePrompt(data.msg, {
                        'timeout': 1500
                    });
                }
            }
        });
    });
});



function add(){
    var id = $("#id").val();
    var seo_title = $("#seo_title").val();
    var seo_keywords = $("#seo_keywords").val();
    var seo_description = $("#seo_description").val();
    
    $.ajax({
        url: "/aj/discount/edit_discount_seo",
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
