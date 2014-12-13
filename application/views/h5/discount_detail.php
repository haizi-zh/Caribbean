   <header class="topbar">
      <div class="left tl"><?php if($city_info):?><a class="icon icon_back" href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $city_info['lower_name'];?>/"></a><?php endif;?></div>
      <div class="top_title"><?php echo $discount_info['title'];?></div>
      <div class="right tr"><a class="icon icon_global" href="<?php echo view_tool::echo_isset($domain);?>/"></a></div>
   </header>

   <div class="list_wrap clearfix">
      <div class="city_bg">
        <span class="shop_name"><?php echo $discount_info['title'];?></span>
      </div>
      <div class="detail_wrap clearfix">
        <section>
          <?php echo $discount_info['body'];?>
        </section>
      </div>
   </div>

   