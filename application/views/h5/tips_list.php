   <header class="topbar">
      <div class="left tl"><a class="icon icon_back" href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $city_info['lower_name'];?>"></a></div>
      <div class="top_title"><?php echo $city_info['name'];?>购物攻略</div>
      <div class="right tr"><a class="icon icon_global" href="<?php echo view_tool::echo_isset($domain);?>/"></a></div>
   </header>

   <div class="list_wrap clearfix">
      <div class="shop_list_wrap clearfix">
        <?php if($list):?>
        <?php foreach($list as $item):?>
        <div class="one_shop">
          <a href="<?php echo view_tool::echo_isset($domain);?>/shoptipsinfo/<?php echo $item['id']?>/" class="link_wrap">
            <?php if($item['pics_list']):?>
            <img src="<?php echo $item['pics_list'][0];?>" alt="" width="121" height="90" class="shop_avatar">
            <?php endif;?>
            <div class="shop_info">
              <div class="title"><em>
                <?php echo $item['title'];?>
              </em>
              </div>
              <p class="tags">
                <?php echo $item['clean_body'];?>
              </p>
              <div class="discount">
              </div>
            </div>
          </a>
        </div>
        <?php endforeach;?>
        <?php endif;?>
      </div>
   </div>




