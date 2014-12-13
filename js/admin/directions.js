
function delete_type(id){
    $.io.ajax({
        'method': 'post',
        'url': '/aj/directions/delete_type',
        'args': {'id':id},
        'onComplete': function(data){
            if(data.code == '200'){
                $.litePrompt('关闭成功！', {
                    'timeout': 1500
                });
            }else{
                $.litePrompt(data.msg, {
                    'timeout': 1500
                });
            }
        }
    });
}

function recover_type(id){
    $.io.ajax({
        'method': 'post',
        'url': '/aj/directions/recover_type',
        'args': {'id':id},
        'onComplete': function(data){
            if(data.code == '200'){
                $.litePrompt('开启成功！', {
                    'timeout': 1500
                });
            }else{
                $.litePrompt(data.msg, {
                    'timeout': 1500
                });
            }
        }
    });
}


function add_type1(){
    var id = $('#id')[0].value;
    var shop_id = $('#shop_id')[0].value;
    var description = $('#description')[0].value;
    var description_url = $('#description_url')[0].value;
    var description_simple = $('#description_simple')[0].value;
    var description_url_simple = $('#description_url_simple')[0].value;
    var type = $('#type')[0].value;
    var level = $("#level")[0].value;

    $.ajax({
        url: "/aj/directions/add_type",
        type: 'POST',
        data: {id:id,shop_id:shop_id,description:description,description_url:description_url,description_simple:description_simple,description_url_simple:description_url_simple,level:level,type:type},
        cache: false,
        complete: function(result){
            var results = $.parseJSON(result.responseText);
            if(results.code==200){     
                alert('编辑成功');
                location.href = '/admin/directions/d_list/?shop_id='+shop_id;
                //location.reload();
            }else{
                alert(results.msg);
            }
        }
    });
}



function add_line(){
    var lines = $("[name='line']");
    var clone_line = $(lines[0]).clone();
    items = clone_line.find("textarea");
    span = clone_line.find("span");
    clone_line.find("input").val(1000);
    span.text("新增线路");
    for(j=0, ll=items.length; j<ll; j++){
        $(items[j]).attr("item-data", "");
        $(items[j]).attr("value", "");
    }
    $("#content").append(clone_line);
    
    //console.log(clone_line);
}




function add_type(){

    var id = $('#id').val();
    var shop_id = $('#shop_id').val();
    var description = $('#description').val();
    var description_url = $('#description_url').val();
    var type = $('#type').val();
    var lines = $("[name='line']");
    line_children=[];
    level_list=[];
    for(var i=0,l=lines.length; i<l; i++){
        level = $(lines[i]).attr("level");
        items = $(lines[i]).find("textarea");
        true_level = $(lines[i]).find("input").val();
        level_list.push(true_level);
        children = [];
        for(j=0, ll=items.length; j<ll; j++){
            item_type = $(items[j]).attr("item-type");
            item_name = $(items[j]).attr("name");
            item_data = $(items[j]).attr("item-data");

            item_value = $(items[j]).val();
            child={'type':item_type,'name':item_name,'data':item_data,'value':item_value};
            children.push(child);
        }
        line_children.push({level:true_level,children:children});
    }
    level_length = level_list.length;
    jQuery.unique( level_list );
    new_level_length = level_list.length;
    if(level_length != new_level_length){
        alert("存在相同level的线路，他们会相互覆盖。无法提交。");
        return  false;
    }


    $.ajax({
        url: "/aj/directions/add_type",
        type: 'POST',
        data: {id:id,shop_id:shop_id,description:description,description_url:description_url,type:type,line_children:line_children},
        cache: false,
        success: function(result){
            if(result){     
                alert('成功');
                location.href = '/admin/directions/d_list/?shop_id='+shop_id;
                //location.reload();
            }else{
                alert('失败');
            }
        }
    });
}


function delete_line(id){
    $.ajax({
        url: "/aj/directions/delete_line",
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

function recover_line(id){
    $.ajax({
        url: "/aj/directions/recover_line",
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

