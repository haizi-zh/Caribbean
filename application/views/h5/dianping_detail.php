
    <header class="topbar">
      <div class="left"><a class="icon icon_back" href="<?php echo view_tool::echo_isset($domain);?>/shop/index_h5_dianping/?shop_id=<?php echo $dianping_info['shop_info']['id'];?>"></a></div>
      <div class="top_title"><?php echo $dianping_info['user_info']['uname'];?>的晒单</div>
      <div class="right"><a class="icon icon_global" href="<?php echo view_tool::echo_isset($domain);?>/"></a></div>
    </header>

   <div class="list_wrap clearfix">
      <div class="detail_wrap clearfix">
        <section class="one_wrap">
            <div class="comment_wrap">
              <a href="" class="avatar_wrap"><img src="<?php echo $dianping_info['user_info']['image'];?>" alt="" class="avatar_pic"></a>
              <a href="" class="comment_info">
                <p><span class="nickname"><?php echo $dianping_info['user_info']['uname'];?></span></p>
                <!-- php 截字-->
                <p class="info_content">
                <?php echo $dianping_info['body'];?>
                </p>
              </a>
            </div>
        </section>
      </div>
   </div>