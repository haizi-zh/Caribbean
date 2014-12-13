
   <header class="topbar">
      <div class="left tl"></div>
      <div class="top_title"><?php echo $city_info['name'];?></div>
      <div class="right tr"><a class="icon icon_global" href="<?php echo view_tool::echo_isset($domain);?>/"></a></div>
   </header>

   <div class="list_wrap clearfix">
      <div class="city_bg">
        <img src="<?php echo $city_info['reserve_3'];?>" alt=""/>
        <span class="city_name"><?php echo $city_info['name'];?>·<?php echo $city_info['english_name'];?></span>
        <a href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $city_info['lower_name'];?>-shoppingtips/"><span class="shoptips_name">查看购物攻略</span></a>
      </div>
      <div class="list_tab">
        <a href="<?php echo view_tool::echo_isset($domain);?>/city/index_h5/?city=<?php echo $city_info['id'];?>&property=1" <?php if($property==1):?>class="cur"<?php endif;?> >名店街区</a>
        <a href="<?php echo view_tool::echo_isset($domain);?>/city/index_h5/?city=<?php echo $city_info['id'];?>&property=2" <?php if($property==2):?>class="cur"<?php endif;?> >购物中心</a>
        <a href="<?php echo view_tool::echo_isset($domain);?>/city/index_h5/?city=<?php echo $city_info['id'];?>&property=3" <?php if($property==3):?>class="cur"<?php endif;?> >奥特莱斯</a>
      </div>
      <div class="shop_list_wrap clearfix">

        <?php if($shop_infos):?>
        <?php foreach($shop_infos as $shop):?>
        <div class="one_shop">
          <a href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $city_lower_name;?>/<?php echo $shop['id']?>/" class="link_wrap">
            <img src="<?php echo $shop['pic'];?>" alt="" width="121" height="90" class="shop_avatar">
            <div class="shop_info">
              <div class="title"><em>
                <?php echo $shop['name'];?>
                <?php if($shop['name'] != $shop['english_name']):?>
                ——<?php echo $shop['english_name'];?>
                <?php endif;?>
              </em><span class="rank rank_<?php echo $score_list[$shop['score']];?>"></span></div>
              <p class="tags">
                <?php if($shop['tags']):?>
                <?php foreach($shop['tags'] as $tag_id):?>
                <span><?php echo $tag_list[$tag_id]['name'];?></span>
                <?php endforeach;?>
                <?php endif;?>
              </p>

              <div class="discount">
          <?php if(isset($shop['exist_coupon']) && $shop['exist_coupon']):?><a title="<?php echo $shop['exist_coupon_info']['title'];?>" href="<?php echo view_tool::echo_isset($domain);?>/coupon_info/<?php echo $shop['exist_coupon'];?>/<?php echo $shop['id'];?>/"> <span class="youhui">优惠券</span></a><?php endif;?>
          <!-- 
          <?php if($shop['exist_discount']):?><a href="<?php echo view_tool::echo_isset($domain);?>/discount/<?php echo $shop['exist_discount'];?>">  <span class="zhe">折扣</span></a><?php endif;?>
          -->
              </div>
            </div>
          </a>
        </div>
        <?php endforeach;?>
        <?php endif;?>

      </div>
   </div>

