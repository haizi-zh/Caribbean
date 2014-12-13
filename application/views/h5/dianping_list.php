
    <!-- 顶导 -->
    <header class="topbar">
      <div class="left"><a class="icon icon_back" href="<?php echo $shop_info['ext']['shop_url'];?>"></a></div>
      <div class="top_title">评论列表</div>
      <div class="right"></div>
    </header>
    <!-- 列表 -->
    <div class="list_wrap clearfix">
        <!-- 评论列表 -->
        <?php if($dianping_list):?>
        <?php foreach($dianping_list as $item):?>
        <?php //var_dump($item);die;?>
        <section class="one_wrap">
            <div class="comment_wrap">
              <a href="" class="avatar_wrap"><img src="<?php echo $item['user_info']['image'];?>" alt="" class="avatar_pic"></a>
              <a href="<?php echo view_tool::echo_isset($domain);?>/ping/<?php echo $item['id'];?>" class="comment_info">
                <p><span class="nickname"><?php echo $item['user_info']['uname'];?></span></p>
                <!-- php 截字-->
                <p class="info_content">
                <?php echo trim($item['clean_short_body']);?>
                </p>
                <?php if($item['pic']):?>
                  <img src="<?php echo $item['pic'];?>" alt="" class="user_commentpic">
                <?php endif;?>

                <?php if($item['pics_list']):?>
                <?php foreach($item['pics_list'] as $pic):?> 
                
                <?php endforeach;?>
                <?php endif;?>
                <p class="tr"><span class="more">全文</span></p>
              </a>
            </div>
        </section>

        <?php endforeach;?>
        <?php endif;?>

      
    </div>
