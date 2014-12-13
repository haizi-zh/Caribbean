
<header class="topbar">
  <div class="left tl"></div>
  <div class="top_title"><?php echo $coupon_info['title'];?></div>
  <div class="right tr"><a class="icon icon_global" href="<?php echo view_tool::echo_isset($domain);?>/"></a></div>
</header>
<div class="list_wrap clearfix">

<section class="one_wrap">

    <?php if($coupon_info['mobile_pics_list']):?>
    <a href="<?php echo tool::clean_file_version($coupon_info['mobile_pics_list'][0]);?>">
    <img src="<?php echo $coupon_info['mobile_pics_list'][0];?>" alt="" class="shop_avatar" />
    </a>
  	<?php elseif($coupon_info['pics_list']):?>
    <a href="<?php echo tool::clean_file_version($coupon_info['pics_list'][0]);?>">
    <img src="<?php echo $coupon_info['pics_list'][0];?>" alt="" class="shop_avatar" />
    </a>
    <?php endif;?>


    <div class="discount_info">
      <h3><?php echo $coupon_info['title'];?></h3>
      <p>
      <?php echo $coupon_info['body'];?>
      </p>
    </div>

</section>

</div>