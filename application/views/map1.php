<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    
    <meta charset="utf-8">
    <style>
      html, body, #map-canvas {
        margin: 0;
        padding: 0;
        height: 100%;
      }
    </style>
    <script src="http://maps.google.com/maps/api/js?v=3.8&sensor=false&key=&libraries=geometry&language=zh_cn&hl=&region="></script>
    <script>
        function initialize() {
          var myLatlng = new google.maps.LatLng(40.762321,-73.974849);
          var myLatlng1 = new google.maps.LatLng(40.7697349,-73.9667835);
          var mapOptions = {
            zoom: 4,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
          }
          var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
          contentString ="<div style='width:300px'><h2>"+
            "NameNameNameNameNameNameNameNameNameNameNameNameNameNameNameNameNameNameNameName"+
            "</h2><br/><div>"+
            "Desc"+
            "</div><br/><p>地址:"+
            "AddressNameNameNameNameNameNameNameNameNameNameNameNameNameNameNameNameNameNameNameName"+
            "</p></div>"
          var infowindow = new google.maps.InfoWindow({
                content: contentString
          });
          var marker = new google.maps.Marker({
              position: myLatlng,
              map: map,
          });
          var marker1 = new google.maps.Marker({
              position: myLatlng1,
              map: map,
          });
          (function(m){
                google.maps.event.addListener(m, 'click', function() {
                  infowindow.open(map,m);
                });
              })(marker);
        }

        google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
    <div id="map-canvas"></div>
  </body>
</html>