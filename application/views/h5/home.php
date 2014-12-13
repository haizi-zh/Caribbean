<header class="topbar">
  <div class="left tl"><a class="icon icon_back" href=""></a></div>
  <div class="top_title">选择城市</div>
  <div class="right tr"></div>
</header>
<div class="main">
  <?php if($country_names):?>
  <?php foreach($country_names as $country=>$c_name):?>
  <?php $country_citys = $cities[$country];?>
  <address ><?php echo $c_name;?></address>
  <div class="name_list" name="<?php echo $country_code[$country];?>" id="<?php echo $country_code[$country];?>">
    <?php foreach($country_citys as $city_info):?>
    <a href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $city_info['lower_name'];?>"><?php echo $city_info['name'];?></a>
    <?php endforeach;?>
  </div>
  <?php endforeach;?>
  <?php endif;?>
</div>