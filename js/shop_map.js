google.maps.visualRefresh = false;
var LatLng=[];
var markers = [];
var infowindow = [];
var infowindowshow = false;
var contentString = [];
var mapbounds = {} ;
var markerarray = [] ;
$(function (){
    var lat = $("#lat").val() ;
    var lng = $("#lng").val() ;
    if (typeof map == "undefined") {
        var myLatlng = new google.maps.LatLng(lat , lng) ;
        var mapOptions = {
            zoom : 10 ,
            center:myLatlng ,
            mapTypeControl: true, 
            mapTypeControlOptions:{
                position:google.maps.ControlPosition.TOP_RIGHT
            },
            zoomControlOptions:{
                position:google.maps.ControlPosition.LEFT_TOP
            },
            scaleControl:true,
            ScaleControlOptions:{
                position:google.maps.ControlPosition.LEFT_TOP,
                style:google.maps.ScaleControlStyle.DEFAULT
            }
        } ;
        map = new google.maps.Map(document.getElementById("map-canvas") , mapOptions) ;
        clearinfowindow();
        clearmarker();
        mapinit();
    }
}) ;

function datainit(page){
    var city_id      = $("#city_id").val() ;
    var maxlat ,maxlng ,minlat,minlng ;
    if(typeof mapbounds.maxlat != 'undefined'){
        maxlat = mapbounds.maxlat ;
        minlat = mapbounds.minlat ;
        maxlng = mapbounds.maxlng ;
        minlng = mapbounds.minlng ;
    } else {
        window.setTimeout(function() {
            maxlat = map.getBounds().getNorthEast().lat();
            minlat = map.getBounds().getSouthWest().lat();
            maxlng = map.getBounds().getNorthEast().lng();
            minlng = map.getBounds().getSouthWest().lng();
            if(typeof maxlat != "undefined"){
                $.get('/shopping/shops',{'maxlat':maxlat,'maxlng':maxlng,'minlat':minlat,'minlng':minlng,'city_id':city_id ,'page':page} ,function (result){
                    $("#ul_shop").empty() ;
                    $("#shop_cnt").html(result.cnt) ;
                    $("#ul_shop").html(result.html) ;
                    clearmarker() ;
                    markerarray = result.marker ;
                    bounds=new google.maps.LatLngBounds();
                    $.each(markerarray,function(k,v){
                        LatLng[k] = setmaplatlng(v.lat, v.lng);
                        bounds.extend(LatLng[k]);
                        markers[k] = setmapmarker(LatLng[k],seticon(k,"small"),v);
                        setmarkerevent(markers[k],k);
                    });
                    
                    //设置左侧列表事件
                    $("#ul_shop li").each(function(k,v){
                        $(v).on("mouseover",function(){
                            markers[k].setIcon(seticon(k,"big"));
                            setmarkermaxzindex(k);
                        });
                        $(v).on("mouseout",function(){
                            if(k !== infowindowshow){
                                markers[k].setIcon(seticon(k,"small"));
                            }
                        });
                        $(v).on("click",function(){
                            clearinfowindow();
                            setinfowindow(k);
                            setmarkersmallicon();
                            setmarkermaxzindex(k);
                        })
                    }) ; 
                } ,'json') ;
            }
        } , 1000) ; 
        return ;   
    }
    if(typeof maxlat == 'undefined') return ;
    $.get('/shopping/shops',{'maxlat':maxlat,'maxlng':maxlng,'minlat':minlat,'minlng':minlng,'city_id':city_id ,'page':page} ,function (result){
        $("#shop_cnt").html(result.cnt) ;
        $("#ul_shop").html(result.html) ;
        clearmarker() ;
        markerarray = result.marker ;
        bounds=new google.maps.LatLngBounds();
        $.each(markerarray,function(k,v){
            LatLng[k] = setmaplatlng(v.lat, v.lng);
            bounds.extend(LatLng[k]);
            markers[k] = setmapmarker(LatLng[k],seticon(k,"small"),v);
            setmarkerevent(markers[k],k);
        });
        if(typeof nowbounds == "undefined"){
            map.fitBounds(bounds);
        }else{
            if (is_drag != true) {
                setmapzoom(nowzoom);
                map.setCenter(nowcenter);
            }
        }
        //设置左侧列表事件
        $("#ul_shop li").each(function(k,v){
            $(v).on("mouseover",function(){
                markers[k].setIcon(seticon(k,"big"));
                setmarkermaxzindex(k);
            });
            $(v).on("mouseout",function(){
                if(k !== infowindowshow){
                    markers[k].setIcon(seticon(k,"small"));
                }
            });
            $(v).on("click",function(){
                clearinfowindow();
                setinfowindow(k);
                setmarkersmallicon();
                setmarkermaxzindex(k);
            })
        }) ; 
    } ,'json') ;
}

function mapinit(){
    LatLng=[];
    markers = [];
    infowindow = [];
    infowindowshow = false;
    contentString = [];
    datainit(1);
    if(markerarray.length>0){
        if(markerarray.length==1){
            if(typeof nowbounds == "undefined"){
                setmapcenter(markerarray[0].lat,markerarray[0].lng);
                setmapzoom(10) ;
            }else{
                if (is_drag != true) {
                    setmapzoom(nowzoom);
                    map.setCenter(nowcenter);
                }
            }
            LatLng[0] = setmaplatlng(markerarray[0].lat,markerarray[0].lng);
            markers[0] = setmapmarker(LatLng[0],seticon(0,"small"),markerarray[0]);
            setmarkerevent(markers[0],0);
        }else{
            bounds=new google.maps.LatLngBounds();
            $.each(markerarray,function(k,v){
                LatLng[k] = setmaplatlng(v.lat, v.lng);
                bounds.extend(LatLng[k]);
                markers[k] = setmapmarker(LatLng[k],seticon(k,"small"),v);
                setmarkerevent(markers[k],k);
            });
            if(typeof nowbounds == "undefined"){
                map.fitBounds(bounds);  
            }else{
                if (is_drag != true) {
                    setmapzoom(nowzoom);
                    map.setCenter(nowcenter);
                }
            }
        }
        
        if(poiid && pagestart == 0 && keyword==''){
            clearinfowindow();
            markers[0].setIcon(seticon(0,"big"));
            setmarkermaxzindex(0);
            setinfowindow(0);
            setmarkersmallicon();
            setmarkermaxzindex(0);
        }
    }
    
    google.maps.event.addListener(map, 'dragend', function() {
        window.setTimeout(function() {
            var tbounds = map.getBounds() ;
            mapbounds.maxlat = tbounds.getNorthEast().lat();
            mapbounds.minlat = tbounds.getSouthWest().lat();
            mapbounds.maxlng = tbounds.getNorthEast().lng();
            mapbounds.minlng = tbounds.getSouthWest().lng();

            nowbounds = map.getBounds();
            nowzoom = map.getZoom();
            nowcenter = map.getCenter();
            is_drag = true;
            datainit(1);
        }, 300); 
    });
}
//设置弹层
function setinfowindow(k){
    infowindowshow = k;
    contentString[k] = "<div style='overflow:hidden;width:300px;'><h2><a href='/shop?shop_id="+markerarray[k].id+"' target='_blank'>"+markerarray[k].name+"</a></h2><br/><div>"+markerarray[k].desc+"...</div><br/><p>地址:"+markerarray[k].address+"</p><br/></div>";
    infowindow[k] = new google.maps.InfoWindow({
        content: contentString[k],
        disableAutoPan: false
    });
    infowindow[k].open(map,markers[k]);
    google.maps.event.addListener(infowindow[k], 'closeclick', function() {
        infowindowshow = false;
        markers[k].setIcon(seticon(k,"small"));
    });
}
//清除弹层
function clearinfowindow(){
    infowindowshow = false;
    $.each(infowindow,function(infok,infov){
        if(typeof infov != "undefined"){
            infov.setMap(null);
        }
    })
    infowindow.length = 0;
    contentString.length = 0;
}
//清除所有marker
function clearmarker(){
    $.each(markers,function(k,v){
        v.setMap(null);
    })
    markers.length = 0;
}

function setmarkermaxzindex(k){
    markers[k].setZIndex(google.maps.Marker.MAX_ZINDEX );
}
//设置marker事件
function setmarkerevent(marker,k){
    //鼠标移入坐标点事件
    google.maps.event.addListener(marker, 'mouseover', function() {
        marker.setIcon(seticon(k,"big"));
        setmarkermaxzindex(k)
    });
    //鼠标移出坐标点事件
    google.maps.event.addListener(marker, 'mouseout', function() {
        setmarkersmallicon();
    });
    //鼠标点击事件
    google.maps.event.addListener(marker, 'click', function() {
        clearinfowindow();
        setinfowindow(k);
        setmarkersmallicon();
        setmarkermaxzindex(k);
    });
}
//设置marker全为小图标
function setmarkersmallicon(){
    $.each(markers,function(k,v){
        if (k !== infowindowshow){
            v.setIcon(seticon(k,"small"));
        }
    })
}
//设置地图缩放级别
function setmapzoom(zoom){
    map.setZoom(zoom);
}
//设置地图中心点
function setmapcenter(lat,lng){
    map.setCenter(setmaplatlng(lat,lng));
}

//得到坐标类
function setmaplatlng(lat,lng){
    return new google.maps.LatLng(lat, lng);
}
//得到marker类
function setmapmarker(latlng,icon,info){
    return new google.maps.Marker({
        position: latlng,
        map: map,
        icon:icon,
        title:info.name
    });
}
//得到icon类
function seticon(k,size){
    if(isNaN(parseInt(k))){
        k = 0;
    }
    var height = (parseInt(k)+1)*50;
    if(size=="small"){
        icon=new google.maps.MarkerImage("/images/pin.png",new google.maps.Size(27,31),new google.maps.Point(50,height));
    }else{
        icon=new google.maps.MarkerImage("/images/pin.png",new google.maps.Size(37,43),new google.maps.Point(0,height));
    }            
    return icon;
}

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