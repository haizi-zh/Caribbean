
   <header class="topbar">
      <div class="left tl"><a class="icon icon_back" href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $city_info['lower_name'];?>/"></a></div>
      <div class="top_title"><?php echo $shop['name'];?></div>
      <div class="right tr"></div>
   </header>
   
   <div class="list_wrap clearfix">
      <div class="city_bg">
        <img src="<?php echo $shop['pic'];?>" alt=""/>
        <span class="shop_name"><?php echo $shop['name'];?></span>
      </div>

      <div class="detail_wrap clearfix">
        <section>
        <a href="<?php echo view_tool::echo_isset($domain);?>/shop/index_h5_more/?shop_id=<?php echo $shop_id;?>">
          <?php echo $shop['short_desc'];?>
        </a>
        </section>

      <!-- format_discount_coupon_data -->
      <?php if($coupon_list):?>

      <?php foreach($coupon_list as $coupon_info):?>
        <section class="pl24">
          <span class="flag"><em class="coner"></em>优惠</span>
          <a href="<?php echo view_tool::echo_isset($domain);?>/coupon_info/<?php echo $coupon_info['id'];?>/<?php echo $shop_id;?>/">
            <p class="warn">
                <?php echo $coupon_info['title'];?>
              </p>
          </a>
        </section>
      <?php endforeach;?>

      <?php endif;?>


      <?php if($shop['reserve_3']):?>
        <section>
          地铁：<?php echo $shop['reserve_3'];?>
        </section>
      <?php endif;?>

        <div class="detail_btns">
          <a href="<?php echo view_tool::echo_isset($domain);?>/shop/index_h5_dianping/?shop_id=<?php echo $shop_id;?>" class="btn2">查看晒单</a>
          <!--
          <a href="" class="btn2">品牌列表</a>
          <a href="" class="btn2">附近商家</a>
          -->
        </div>

   </div>
</div>
