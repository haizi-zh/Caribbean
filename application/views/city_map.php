<style>
      html, body, #map-canvas {
        margin: 0;
        padding: 0;
        height: 100%;
      }
</style>
<link rel="stylesheet" type="text/css" href="<?php echo $css_domain;?>/css/common.css?v=<?php echo $js_version;?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo $css_domain;?>/css/ZB_city_map.css?v=<?php echo $js_version;?>"/>
<script src="http://maps.google.com/maps/api/js?v=3.8&sensor=false&key=&libraries=geometry&language=zh_cn&hl=&region="></script>
<script src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/styledmarker/src/StyledMarker.js"></script>
<script type="text/javascript" src="<?php echo $css_domain;?>/js/jquery/1.7.2/jquery.min.js"></script>
<div id="lat" style="display:none"><?php echo $lat?></div>
<div id="lng" style="display:none"><?php echo $lng?></div>
<div class="map_layer">
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
                
                <a href="<?php echo view_tool::echo_isset($domain);?>/" class="back_btn common_btn1">返回首页</a>
                <a href="<?php echo view_tool::echo_isset($domain);?>/city/<?php echo $city_id;?>" class="back_btn common_btn1">返回上一页</a>

                <div class="back"><a href="" class="back_icon"></a></div>
                <div class="search_wrap" id="search-wrap">
                    <span class="search_city"><?php echo $city_name;?>▶</span>
                    <!--
                    <div class="select_wrap">
                        <a href="#" class="search_btn"></a> 
                        <input type="text" value="搜索地点"/>
                        <ul class="select_down" style="display:none">
                            <li><a href="">楼主下辈子美利坚</a></li>
                            <li><a href="">楼主下辈子德意志</a></li>
                            <li><a href="">楼主下辈子法兰西</a></li>
                            <li><a href="">楼主下辈子不列颠</a></li>
                        </ul>
                    </div>
                    -->
                </div>


            </div>
            <div class="fluid_height">
                <div class="aside">
                    <div class="hide">
                          <p class="result-total">共找到<span class="result_total" id="shop_cnt">0</span>个商家</p>

                          <div class="fix-height">
                            <ul class="result-list" id="ul_shop">
                            </ul>
                            <!-- <p class="pagination" style="display: block;">
                                <span class="current">1</span>
                                <a href="#">2</a>
                                <a href="#">3</a>
                                <a href="#">4</a>
                                <a href="#" class="next">&gt;</a>
                            </p> -->
                          </div>

                          <div id="em_resultNone" class="no-result hide" style="display: none;">
                            <h4>建议：</h4>
                            <p>1. 请确保所有字词拼写正确。</p>
                            <p>2. 尝试不同的关键字。</p>
                          </div>
                        </div>

                </div>
                <div class="map_wrap" id="map-canvas">
                </div>
            </div>
        </div>  
<script src="<?php echo $js_domain;?>/js/city_map.js?v=<?php echo $js_version;?>" type="text/javascript"></script>
