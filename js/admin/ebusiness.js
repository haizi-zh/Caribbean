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
  
  topic1($('#ebusiness_form')[0], $('#upload_file')[0], (function(){
        return function(o) {
          $('#ebusiness_pic').attr('src', o.fullurl+'!300');
        }
    })(), 'ZB_ADMIN_SHOP');
});


function add_ebusiness(){
    var id = $('#id')[0].value;
    var name = $('#name')[0].value;
    var description = $('#description')[0].value;
    var web_site = $('#web_site')[0].value;
    var country = $('#country')[0].value;
    var tags = $('#tags')[0].value;
    var pay_type = $('#pay_type')[0].value;
    var type = $('#type')[0].value;
    var logo = $("#ebusiness_pic").attr("src");
    
    $.ajax({
        url: "/aj/ebusiness/add",
        type: 'POST',
        data: {id:id,name:name,description:description,web_site:web_site,country:country,tags:tags,pay_type:pay_type,type:type,logo:logo},
        cache: false,
        success: function(result){
            if(result){     
                alert('编辑成功');
                location.href = '/admin/ebusiness/elist';
                //location.reload();
            }else{
                alert('编辑失败');
            }
        }
    });
}

function delete_ebusiness(id){
    $.ajax({
        url: "/aj/ebusiness/delete_ebusiness",
        type: 'POST',
        data: {id:id},
        cache: false,
        success: function(result){
          if(result) {      
              alert('成功');
              //location.reload();
          }else{
              alert('失败');
          }
        }
    });
}

function recover_ebusiness(id){
    $.ajax({
        url: "/aj/ebusiness/recover_ebusiness",
        type: 'POST',
        data: {id:id},
        cache: false,
        success: function(result){
          if(result) {      
              alert('成功');
              //location.reload();
          }else{
              alert('失败');
          }
        }
    });
}
