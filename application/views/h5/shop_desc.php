   <header class="topbar">
      <div class="left tl"><a class="icon icon_back" href="<?php echo $shop['ext']['shop_url'];?>"></a></div>
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
        <a href="<?php echo view_tool::echo_isset($domain);?>/shop/index_h5_more/?shop_id=<?php echo $shop['id'];?>">
          <?php echo $shop['desc'];?>
        </a>
        </section>
      </div>
   </div>