<!DOCTYPE html>
<html>
<head>
    <style>
        html, body, #map-canvas {
        height: 100%;
        margin: 0;
        padding: 0;
        }
        #pagination-digg{float: right;margin-top:5px;}
        #pagination-digg li { border:0; margin:0; padding:0; font-size:11px; list-style:none; float:left; }
        #pagination-digg a { border:solid 1px #9aafe5; margin-right:2px; }
        #pagination-digg .previous-off,#pagination-digg .next-off  { border:solid 1px #DEDEDE; color:#888888; display:block; float:left; font-weight:bold; margin-right:2px; padding:3px 4px; }
        #pagination-digg .next a,#pagination-digg .previous a { font-weight:bold; } 
        #pagination-digg .active { background:#2e6ab1; color:#FFFFFF; font-weight:bold; display:block; float:left; padding:4px 6px; /* savers */ margin-right:2px; }
        #pagination-digg a:link,#pagination-digg a:visited { color:#0e509e; display:block; float:left; padding:3px 6px; text-decoration:none; }
        #pagination-digg a:hover { border:solid 1px #0e509e; }
    </style>
    <link rel="stylesheet" type="text/css" href="<?php echo $css_domain;?>/css/common.css?v=<?php echo $js_version;?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $css_domain;?>/css/ZB_city_map.css?v=<?php echo $js_version;?>"/>
</head>
<body>
    <input type="hidden" name="lat" id="lat" value="<?php echo $lat ;?>" /><input type="hidden" name="lng" id="lng" value="<?php echo $lng ;?>" />
    <input type="hidden" id="city_id" value="<?php echo $city_info['id'] ;?>" />
    <!-- HTML 正文部分开始 -->
    <div class="map_layer" id="map_layer"> 
        <!-- 城市选择弹层-->
            <div class="ZB_cities_layer" style="display:none" id="zb-city-layer">
                <?php if(isset($area_cities) && $area_cities):?>
                <div class="ZB_cities_wrap">
                    <?php foreach($area_cities as $country=>$country_cities){?>
                        <div class="ZB_cities clearfix">
                            <div class="state_name <?php echo $country_code[$country];?>"></div>
                            <div class="hidden_margin">
                                <ul class="clearfix">
                                    <?php foreach($country_cities as $city){?>
                                    <li>
                                        <a href="<?php echo view_tool::echo_isset($domain);?>/city_map?city=<?php echo $city['id'];?>" target='_blank'><?php echo $city['name'];?></a>
                                    </li>
                                    <?php }?>
                                </ul>
                            </div>
                        </div>
                    <?php }?>
                </div>
                <?php endif;?>
            </div>
            <!-- /城市选择弹层-->
        <div class="header clearfix">
            <a href="#" class="user_addr"></a>
            
            <a href="/" class="back_btn common_btn1">返回首页</a>
            <a href="javascript:history.go(-1)" class="back_btn common_btn1">返回上一页</a>

            <div class="back"><a href="" class="back_icon"></a></div>
            <div class="search_wrap" id="search-wrap">
                <span class="search_city"><?php echo $city_info['name']. "  " ;?>▶</span>
            </div>
        </div>

        <div class="fluid_height" id="fluid_height">
            <div class="aside" id="aside">
                <div class="hide">
                    <p class="result-total">共找到<span class="result_total" id="shop_cnt">0</span>个商家</p>

                    <div class="fix-height">
                        <ul class="result-list" id="ul_shop"></ul>
                    </div>

                    <div id="em_resultNone" class="no-result hide" style="display: none;">
                        <h4>建议：</h4>
                        <p>1. 请确保所有字词拼写正确。</p>
                        <p>2. 尝试不同的关键字。</p>
                    </div>
                </div>
            </div>
            <div class="map_wrap" id="map-canvas"></div>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo $js_domain;?>/js/jquery/1.7.2/jquery.min.js?v=<?php echo $js_version;?>"></script>
    <!--
    https://maps.googleapis.com/maps/api/js?key=AIzaSyDB0HwGrpYeSsDY1rHJs9bLRiUlQweA-S4
    http://maps.google.cn/maps/api/js?sensor=false&key=AIzaSyDB0HwGrpYeSsDY1rHJs9bLRiUlQweA-S4
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDB0HwGrpYeSsDY1rHJs9bLRiUlQweA-S4"></script>
    
-->
    <script type="text/javascript" src="http://maps.google.cn/maps/api/js?sensor=false&key=AIzaSyDB0HwGrpYeSsDY1rHJs9bLRiUlQweA-S4"></script>

    <script type="text/javascript" src="<?php echo $js_domain;?>/js/shop_map.js?v=<?php echo $js_version;?>"></script>
</body>
</html>