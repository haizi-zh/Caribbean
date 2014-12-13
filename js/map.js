$(document).ready(function() {
    var map;
    var market_arr = {};

    function initialize() {
      var mapOptions = {
         center: new google.maps.LatLng(10,100),
          zoom: 2,
          mapTypeId: google.maps.MapTypeId.ROADMAP,
      };
      map = new google.maps.Map(document.getElementById("map-canvas"),
              mapOptions);

      //最好是使用移动事件和放大缩小事件来计算,现在用的是边缘变化的计算:bounds_changed,zoom_changed,mouse
      google.maps.event.addListener(map, 'zoom_changed', function() {
          var bounds = map.getBounds();
          addall();
      });

    }

    //给li重新绑定事件
    function bandle() {
       $(".shop").click(function() {
        var location = $(this).attr("location")
        var pos = location.split(","); 
        /*var marker = new google.maps.Marker({
          position: new google.maps.LatLng(pos[0], pos[1]),
          map: map,
          title: 'Click to zoom',
          zoom:16,
        map.setCenter(marker.getPosition());*/

        //返回的地点如果有一个范围,则取此bound作为比例尺子
        var viewport = $(this).attr("viewport");
        if(viewport) {
           var viewport_arr=  {}
           var arr = viewport.split(";");    
           $.each(arr, function(i, val) {
                var tmp = val.split(':');
                viewport_arr[tmp[0]] = tmp[1]
           })
           var southWest = new google.maps.LatLng(viewport_arr['southwest_lat'],viewport_arr['southwest_lng']);
           var northEast = new google.maps.LatLng(viewport_arr['northeast_lat'],viewport_arr['northeast_lng']);
           var bounds = new google.maps.LatLngBounds(southWest,northEast);
           map.fitBounds(bounds);
        }
        else {
            map.setZoom(16);
        }
        map.setCenter(new google.maps.LatLng(pos[0], pos[1]))
      });
    }


     //返回当前的bound,然后计算出在该范围内的所有商家有多少
    function addall() {
        var bounds = map.getBounds();
        b = bounds.toString();
        var reg = '/[^0-9,\.]*/'; 
        b = b.replace(/\(/g, "");  
        b = b.replace(/\)/g,"")
        b = b.replace(/\s/g,"")
        b = b.replace(reg,'');

        $.get("http://zanbai.com/aj/map/shopbyrange?range="+b, function(result){
            //部署到某个地方了
            var obj = jQuery.parseJSON(result);
            $("#ul_shop").empty()
            $.each(obj, function(i, val) {
              var name = val.name;
              var location = val.location;

              if (location in market_arr) return
              else market_arr[location]=1

              var pos = location.split(",")
              contentString ="<div style='width:300px'><h2>"+val.name+"</h2><br/><div>"+val.desc+"...</div><br/><p>地址:"+val.address+"</p></div>"
              var infowindow = new google.maps.InfoWindow({
                  content: contentString
              });
              marker = new google.maps.Marker({
                  map:map,
                  draggable:false,
                  animation: google.maps.Animation.DROP,
                  position: new google.maps.LatLng(pos[0], pos[1]),
                });

              //给商家列表添加一个新的
              str = '<li><a class="shop" href="#" location="'+val.location+'">'+val.name+'</a></li>';
              $("#ul_shop").append(str);

              (function(m){
                google.maps.event.addListener(m, 'click', function() {
                  infowindow.open(map,m);
                });
              })(marker);

            });
            bandle()
        });
    }

    google.maps.event.addDomListener(window, 'load', initialize);
    bandle();

    $("#search_btn").click(function() {
        key = $("#search_key").val()
        $("#s_result").empty();
        $.get("http://zanbai.com/aj/map/place_search?q="+key, function(result){
            //部署到某个地方了
            var obj = jQuery.parseJSON(result);
            jQuery.each(obj, function(i, val) {
                var li = '<li><a class="shop" href="#" location="'+val.location+'" viewport="'+val.viewport+'">'+val.name+'</a></li>';
                $("#s_result").append(li);
            bandle();
            });
        });
    })
 });
