<?php $white_user = context::get("white_user", false);?>
<?php if($shop_infos):?>
  <!-- city页的商家shop_card -->
  <?php foreach($shop_infos as $shop) { ?>
  <div class="comment_wrap">
      <div class="comment clearfix">
      <div class="avatar fl">
        <div class="avatar_pic">
          <a title="<?php echo $shop['name'];?><?php if($shop['name'] != $shop['english_name']) echo "|".$shop['english_name'];?>" href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $city_lower_name;?>/<?php echo $shop['id']?>/" target="_blank"><img rel="nofollow" alt="<?php echo $shop['name'];?><?php if($shop['name'] != $shop['english_name']) echo "|".$shop['english_name'];?>"  src="<?php echo $shop['pic']?>" width="170" height="128" /></a>
        </div>
      </div>

      <div class="comment_info">
        <div class="title">
          <div class="rating_wrap_small fr">
            <span title="<?php echo $shop['score'] ?>星商户" class="star star<?php echo $shop['score']?>0"></span>
          </div>
          <a href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $city_lower_name;?>/<?php echo $shop['id']?>/" title="<?php echo $shop['name'];?><?php if($shop['name'] != $shop['english_name']) echo "|".$shop['english_name'];?>" ><?php echo $shop['name']?><?php if($shop['name'] != $shop['english_name']):?><span class="fs14"> —— <?php echo $shop['english_name'];?></span><?php endif;?></a>
          <?php if(isset($shop['exist_coupon']) && $shop['exist_coupon']):?><a title="<?php echo $shop['exist_coupon_info']['title'];?>" href="<?php echo view_tool::echo_isset($domain);?>/coupon_info/<?php echo $shop['exist_coupon'];?>/<?php echo $shop['id'];?>/"> <span class="card_icon">优惠券</span></a><?php endif;?>
          <?php if($shop['exist_discount']):?><a href="<?php echo view_tool::echo_isset($domain);?>/discountshop/<?php echo $shop['id'];?>/">  <span class="card_icon_black">折扣</span></a><?php endif;?>

        </div>

        <div>
        <?php if($shop['ext']['dianping_cnt']):?>
        <div class="avatar_comment fr">
        <a href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $city_lower_name;?>/<?php echo $shop['id']?>/" class="linkb"><?php echo $shop['ext']['dianping_cnt'];?>条</a>点评
        </div>
        <?php endif?>
        <p><span class="textb">地址： </span><?php echo $shop['address'] ?></p>
        </div>
        <?php if($shop['tags']):?>
        <div class="tag">
          <?php if($shop['is_fav']):?>
          <a class="disable_btn fr" href="javascript:;" title="取消收藏" action-type="unfav" action-data="id=<?php echo $shop['id'];?>&type=0">已收藏</a>
          <?php else:?>
          <a class="favor_btn fr" href="javascript:;" title="收藏" action-type="fav" action-data="id=<?php echo $shop['id'];?>&type=0">收藏</a>
          <?php endif;?>
          <span class="fl textb">标签:</span>
          <em class="left_border">
          <?php foreach($shop['tags'] as $tag_id):?>
          <a href="javascript:;" style="color:black;cursor:default;"><?php echo $tag_list[$tag_id]['name'];?></a>
          <?php endforeach;?>
          </em>
        </div>
        <?php endif;?>
        <!--
        <div class="bottom_comment">
        <?php foreach($shop['comments'] as $comment) { ?>
        <div class="one_comment"><em>"<a target="_blank" href="/ping/<?php echo $comment['id'];?>"><?php echo $comment['clean_short_body']?></a>"</em><span class="user"><?php echo $comment['user_info']['uname']?>点评</span></div>
        <?php } ?>
        </div>
        -->
        <div class="bottom_comment">
          <div class="comment_icon">
            <a rel="nofollow" href="<?php echo view_tool::echo_isset($domain);?>/shop/download/?shop_id=<?php echo $shop['id'];?>" class="icon print_icon" title="下载PDF"><span></span></a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
  <?php if($page_cnt > 1):?>
  <div class="turn_page bottom_page" id="page_container_adapter">
    <a class="turn_first" node-type="page" action-type="changePageAdapter" href="javascript:void(0);" action-data="city=<?php echo $city_id;?>&action=page&page=1">返回第一页</a>
    <a class="turn_forward" node-type="prev" action-type="changePageAdapter" href="javascript:void(0);" action-data="city=<?php echo $city_id;?>&action=prev">上一页</a>
    <em><i node-type="show"><?php echo $page;?></i>/<i node-type="all"><?php echo $page_cnt;?></i></em>
    <a class="turn_next" node-type="next" action-type="changePageAdapter" href="javascript:void(0);" action-data="city=<?php echo $city_id;?>&action=next">下一页</a>
  </div>
  <?php endif;?>

<?php elseif(isset($content) && $content):?>
  <div class="info_blank">
  <p><?php echo $content;?></p>
  <p>如果您发现了新的商家并通知我们，您将是赞佰网第一个发现它的人！ 欢迎致信 <a href="mailto:feedback@zanbai.com ">feedback@zanbai.com </a></p>
  </div>

<?php else:?>
  
  <div class="info_blank"><p>没有搜索到商家。请选择其他条件.</p></div>
  
<?php endif;?>
