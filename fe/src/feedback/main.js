define(function(require){
    var $ = require('jquery');
    var config = require('feedback/config');
    function isLoaded(id) {
        var ret = false;
        var scripts = document.getElementsByTagName('script');
        for (var i = 0, len = scripts.length; i < len; i++) {
            if (scripts[i].getAttribute('id') === id) {
                ret = true;
                break;
            }
        }
        return ret;
    }

    /**
     * 加载 jquery 插件资源
     *
     * @param  {string}   id       script id
     * @param  {string}   url      script url
     * @param  {Function} callback 加载完后的回调
     */
    function load(id, url, callback) {
        if (!isLoaded(id)) {
            var head = document.getElementsByTagName('head')[0]
                        || document.body;
            var script = document.createElement('script');
            script.setAttribute('type', 'text/javascript');
            script.setAttribute('src', url);
            script.setAttribute('id', id);

            if (callback != null) {
                script.onload = script.onreadystatechange = function () {
                    if (script.ready) {
                        return false;
                    }
                    if (!script.readyState
                        || script.readyState == 'loaded'
                        || script.readyState == 'complete'
                    ) {
                        script.ready = true;
                        callback();
                    }
                };
            }
            head.appendChild(script);
        }
    }

    load('layer' , window.$CONFIG.normalUrl + '/js/layer/layer.min.js',function (){
        layer.use(window.$CONFIG.normalUrl+'/js/layer/extend/layer.ext.js');
    });
    var mail_tips = '请填写邮件地址便于与我们互动，建议您注册并登录后晒单' ;
    var link_tips = "http://www.zanbai.com/" ;
    if($("input[name=item_bug_type]:selected").val() == "sug_con") {
        $("#item_link").val($link_tips) ;
        $("#link").show() ;
    }

    $("input[name=item_bug_type]").click(function (){
        $("#suggest_content").html( $("#"+$(this).val()).text() );
        if($(this).val() == 'sug_con') {
            $("#link").show() ;
        } else {
            $("#link").hide() ;
        }
    });

    $("#item_email").focus(function (){
        if($(this).val() == mail_tips){
            $(this).val('') ;
        }
    }).blur(function (){
        if($(this).val() == ''){
            $(this).val(mail_tips) ;
        }
    }) ;

    $("#sub_feedback").click(function (){
        //获取内容
        var content = $.trim($("#item_content").val()) ;
        var data = [] ;
        if(!content.length){
            layer.msg('总得说点什么吧？');
            $("#item_content").focus() ;
            return ;
        }
        data = 'item_content=' + encodeURIComponent(content) ;
        //获取提交类型
        var sug_type = $("input[name=item_bug_type]:checked").val();
        if(sug_type == 'sug_con') {
            //获取链接
            var linkreg = /^http:\/\/www\.zanbai\.com(\/|\?)(([a-z0-9])+(\/)?)*$/ ;
            var link = $("#item_link").val() ;
            if(!linkreg.test(link)){
                layer.msg('地址好像不对哦，再检查一下吧？');
                return ;
            }
            data = data+ "&item_link=" + encodeURIComponent(link) ;
        }
        data = data + "&item_bug_type="+sug_type ;
        //获取邮箱
        var mail = $("#item_email").val() ;
        if(mail == mail_tips) {
            layer.msg('邮箱还没填呢？留个联系方式吧');
            return ;
        }else{
            var mailreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
            if(!mailreg.test(mail)){
                layer.msg('邮箱格式不对吧？再瞧瞧');
                return ;
            }
        }
        data = data + "&item_email=" + encodeURIComponent(mail) ; 
        $.ajax({
            url:config.AJAX.ADD_FEEDBACK,
            type:'POST' ,
            dataType:'JSON',
            data:data,
            success:function (data){
                if(data.code == 200){
                    $("#feedback_form")[0].reset() ;
                    layer.msg(data.msg , 1 ,1, function(){location.href="/" ;}) ;
                    
                } else {
                    layer.msg(data.msg) ;
                }
            }
        });

    })
});