$.ready(function(){

    var ids = [
        'info',
        'contact',
        'duty'
    ];

    var helpContentList = $('#help_content')[0].children;

    var helpContainer = $('#help_nav')[0];
    var helpDevt = $.delegatedEvent(helpContainer);
    helpDevt.add('changeTab', 'click', function(e){
        for(var i = 0, len = ids.length; i < len; i++){
            var el = $.sizzle('[node-type='+ids[i]+']');
            if(e.data.target == ids[i]){
                $('#' + ids[i]).addClassName('cur');
                $(el).setStyle('display', '');
            }else{
                $('#' + ids[i]).removeClassName('cur');
                $(el).setStyle('display', 'none');
            }
        }
    });
});
