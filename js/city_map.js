var map;
var last_marker_arr = {};
var current_marker_arr = {};
var infowindow;

function initialize() {
    var lat = $("#lat").html();
    var lng = $("#lng").html();
    var myLatlng = new google.maps.LatLng(lat, lng);
    var mapOptions = {
        zoom: 10,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
    google.maps.event.addListener(map, 'bounds_changed', function() {
        refresh_markers();
    });
}

function refresh_markers() {
    var bounds = map.getBounds();
    b = bounds.toString();
    var reg = '/[^0-9,\.]*/'; 
    b = b.replace(/\(/g, "");  
    b = b.replace(/\)/g,"")
    b = b.replace(/\s/g,"")
    b = b.replace(reg,'');

    $.get("/aj/city_map/get_shops?bounds="+b, function(result){
        var obj = jQuery.parseJSON(result);
        $("#ul_shop").empty();
        $("#shop_cnt").html(obj['cnt']);
        var cnt = 0;
        //遍历商家数组
        $.each(obj['shops'], function(i, val) {
            var location = val.location;

            //更新左侧商家列表结果
            cnt++;
            str = '<li><a class="search_result result-block" href="#" location="'+val.location+'"><i class="icon_spot spot_blue">'+cnt+'</i><div class="shop_info"> <p class="name">'+val.name+'</p> <p class="addr">地址：'+val.address+'</p> </div></a></li>';
            $("#ul_shop").append(str);

            if (location in last_marker_arr) {
              //如果当前位置在上一次结果中包括,更新计数label
              marker = last_marker_arr[location];
              update_marker_cnt(marker, cnt);
              last_marker_arr[location] = marker;
            } else{
              //如果是新的label，则创建新的marker
              marker = create_new_marker(val, cnt);
            }
            current_marker_arr[location] = marker;
        });
        update_marker_arr();
        combine_result_listener();
    });
}

function update_marker_cnt(marker, cnt){
    marker.styleIcon.set('text', cnt+'');
}

function update_marker_arr(){
    //1.去除在last_marker_arr而不在current_marker_arr中的marker
    //2.将current_marker_arr赋值给last_marker_arr
    //3.清除current_marker_arr
    var markers = []
    for (var location in last_marker_arr) {
        if (!current_marker_arr[location]) {
            markers.push(last_marker_arr[location]);
        }
    }
    clearMarkers(markers);
    last_marker_arr = current_marker_arr;
    current_marker_arr = {};
}

function create_new_marker(item, cnt){
    var pos = item.location.split(",");
    var color = get_marker_color(item.property);
    var marker = new StyledMarker({
        styleIcon:new StyledIcon(StyledIconTypes.MARKER,{color:color,text:cnt+''}),
        position:new google.maps.LatLng(pos[0], pos[1]),
        map:map});

    (function(marker){
        google.maps.event.addListener(marker, 'click', function() {
            if (infowindow) {infowindow.close();}
            // contentString ="<div style='overflow:hidden;width:300px;'><h2><a href='/shop?shop_id="+item.id+"' target='_blank'>"+item.name+"</a></h2><a href='/shop?shop_id="+item.id+"' target='_blank' style='float:left;font-size:12px'>进入>></a><br/><br/><div>"+item.desc+"...</div><br/><p>地址:"+item.address+"</p><br/><p>品牌:"+item.brand_list+"<a href='/brandstreet?shop_id="+item.id+"' target='_blank'><br/>更多>></a></p></div>"
            contentString ="<div style='overflow:hidden;width:300px;'><h2><a href='/shop?shop_id="+item.id+"' target='_blank'>"+item.name+"</a></h2><br/><div>"+item.desc+"...</div><br/><p>地址:"+item.address+"</p><br/></div>"
            infowindow = new google.maps.InfoWindow({content: contentString});
            infowindow.open(map, marker);
        });
    })(marker);
    return marker;
}

function combine_result_listener() {
    $(".result-block").click(function() {
        var location = $(this).attr("location")
        var pos = location.split(","); 
        var viewport = $(this).attr("viewport");
        if(viewport){
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

// 获取marker颜色
function get_marker_color(property){
    color = 'ccffcc';
    if(property == 1){
        color = 'ccffcc';
    }else if(property == 2){
        color = 'ff9999';
    }else if(property == 3){
        color = 'ccccff';
    }
    return color;
}

// 将传入的markers清除
function clearMarkers(markers) {
  setAllMap(markers, null);
}

// 将传入的marker绑定到传入的地图上，辅助函数
function setAllMap(markers, map) {
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(map);
  }
}

google.maps.event.addDomListener(window, 'load', initialize);


var cityName = $('.search_city', $('#search-wrap'));
$('#search-wrap').click(function(e){
    var display = $('#zb-city-layer').css('display');
    if (display != 'none') {
        cityName.html(
            cityName.html().substring(0, cityName.html().length - 1) + '▶'
        );
        $('#zb-city-layer').css('display', 'none');
    }
    else {
        cityName.html(
            cityName.html().substring(0, cityName.html().length - 1) + '▼'
        );
        $('#zb-city-layer').css('display', '');
    }
});

function contains(parent, node) {
    if (parent === node) {
        return false;
    } else if (parent.compareDocumentPosition) {
        return ((parent.compareDocumentPosition(node) & 16) === 16);

    } else if (parent.contains && node.nodeType === 1) {
        return   parent.contains(node);

    } else {
        while (node = node.parentNode) {
            if (parent === node) {
                return true;
            }
        }
    }
    return false;
}

$(document).click(function(e){
    var el = e.srcElement || e.target;
    var cityLayer = $('#zb-city-layer');
    if (cityLayer[0]) {
        if (
            !contains(cityLayer[0], el)
            &&
            $(el).attr('id') != 'search-wrap'
            &&
            $($(el).parent()[0]).attr('id') != 'search-wrap'
        ) {
            cityName.html(
                cityName.html().substring(0, cityName.html().length - 1) + '▶'
            );
            cityLayer.css('display', 'none');
        }
    }
});


