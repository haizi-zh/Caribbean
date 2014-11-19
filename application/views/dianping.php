  <div class="comment clearfix">
   <!-- 头像信息 -->
   <div class="avatar fl">
    <div class="avatar_pic">
     <a href="<?php echo view_tool::echo_isset($domain);?>/myprofile?uid=<?php echo $uid ?>" target="_blank"><img rel="nofollow" alt="出国购物" src="<?php echo $image ?>" width="77" height="72" /></a>
    </div>
    <div class="nick_name">
     <?php echo $uname ?>
    </div>
    <div class="avatar_comment">
     <a href="<?php echo view_tool::echo_isset($domain);?>/ping/<?php echo $dianping_id ?>" target="_blank" class="linkb"><?php echo $cmt_cnt ?></a>回复
    </div>
   </div>
   <!-- /头像信息 -->
   <!-- 评论信息 -->
   <div class="comment_info">
    	 <div class="rating_wrap">
		   <span class="rating_title">综合评分</span>
		   <div class="rating_wrap_small">
		    <span title="<?php echo $score?>星商户" class="star star<?php echo $big_score?>"></span>
		   </div><?php echo $score?>
	  </div>
	  <p class="slideup"> <a href="<?php echo view_tool::echo_isset($domain);?>/ping/<?php echo $dianping_id ?>"> <?php echo $body ?></a></p> <a href="<?php echo view_tool::echo_isset($domain);?>/ping/<?php echo $dianping_id ?>"><?php echo $pic_html ?></a>
   </div>
   <!-- 回复举报 -->

  <div class="comment_title textb">
   <?php if($del_icon == true) {?>
      <a href="javascript:void(0);" action-type="delDianping" action-data="id=<?php echo $dianping_id?>" >删除</a>|
    <?php }?> 
     <?php if($need_comment == true) {?>
   <a href="javascript:void(0);" action-type="reply" action-data="dianping_id={$dianping_id}&amp;shop_id={$shop_id}">回复楼主</a>
    <?php } ?> 
  </div>
 
  <!-- /回复举报 -->
   
  </div>
  <!-- /评论信息 -->
  
