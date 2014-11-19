<?php if($dianpings):?>
<!-- shop页的晒单card-->
<?php foreach($dianpings as $dianping){?>
<?php if(isset($dianping['shop_info']['name'])) $shop_title = $dianping['shop_info']['name'];else $shop_title = '出国购物';?>
<?php 
if(isset($dianping['user_info']['uname'])){
	$uname = $dianping['user_info']['uname'];
}else{
	$uname = "";
}
?>
<div class="comment clearfix">
	<!-- 头像信息 -->
	<div class="avatar fl">
		<div class="avatar_pic"><a title="<?php echo $uname?>" href="<?php echo view_tool::echo_isset($domain);?>/myprofile?uid=<?php echo isset($dianping['user_info']['uid'])?$dianping['user_info']['uid']:0;?>" target="_blank"><img rel="nofollow" alt="<?php echo $uname;?>"  src="<?php echo isset($dianping['user_info']['image'])?$dianping['user_info']['image']:'';?>" width="77" height="72"/></a></div>
		<div class="nick_name"><?php echo $uname;?></div>
		<div class="avatar_comment"><a title="<?php echo $shop_title;?>" href="<?php echo view_tool::echo_isset($domain);?>/ping/<?php echo $dianping['id'];?>" target="_blank" class="linkb"><?php echo isset($dianping['cmt_cnt'])?$dianping['cmt_cnt']:0;?>条</a>回复</div>
	</div>
	<!-- /头像信息 -->
	<!-- 评论信息 -->
	<div class="comment_info">

		<?php if(isset($show_shop_title) && $show_shop_title == 1 ):?>
		<h3><a title="<?php echo $shop_title;?>" href="<?php echo view_tool::echo_isset($domain);?>/shop/<?php echo $dianping['shop_info']['id'];?>"><?php echo $shop_title;?></a></h3>
		<?php endif;?>

		<div class="rating_wrap"><span class="rating_title">综合评分</span><div class="rating_wrap_small"><span title="<?php echo $dianping['score'];?>星商户" class="star star<?php if(!$dianping['score']) echo '00';else echo $dianping['score']*10;?>" ></span></div><?php echo $dianping['score'];?></div>
		<br><a href="<?php echo view_tool::echo_isset($domain);?>/ping/<?php echo $dianping['id'];?>" title="<?php echo $shop_title;?>" >
		<p class="slideup"><?php echo $dianping['clean_body'];?></p>
		<?php if($dianping['has_pic']){?>
			<a title="更多" href="<?php echo view_tool::echo_isset($domain);?>/ping/<?php echo $dianping['id'];?>" class="linkb">更多<span class="moredown"></span></a>
			<div class="pic_wrap">
				<?php if($dianping['has_pic']){?>
					<?php $picarray = json_decode($dianping['pics'], true);foreach($picarray as $pic){?>
					<a title="<?php echo $shop_title;?>" href="<?php echo view_tool::echo_isset($domain);?>/ping/<?php echo $dianping['id'];?>"><img alt="<?php echo $shop_title;?>"  src="<?php echo upimage::format_brand_up_image($pic).'!pingpreview';?>"/></a>
				<?php }}?>
			</div>
		<?php }?>
		</a>
	</div>
	<!-- /评论信息 -->
	<!-- 回复举报 -->
	<?php if(!isset($simple)){?>
		<div class="comment_title textb">
			<!--<a href="javascript:;" ><span class="like_icon"></span></a>|-->
			<?php if($login_uid && $login_uid == $dianping['uid']) :?>
		      	<a href="javascript:void(0);" action-type="modifyDianping" action-data="id=<?php echo $dianping['id']?>" >编辑</a>|
		      	<a href="javascript:void(0);" action-type="delDianping" action-data="id=<?php echo $dianping['id']?>" >删除</a>|
		    <?php endif;?> 
			<a href="javascript:void(0);" action-type="reply" action-data="dianping_id=<?php echo $dianping['id'];?>&shop_id=<?php echo $dianping['shop_id'];?>">回复楼主</a>
		</div>
	<?php } ?>
	<!-- /回复举报 -->
</div>
<?php }?>

<?php 
if(!isset($shop_id)){
	$shop_id = 0;
}
?>

<?php if(!isset($have_no_page)):?>
<div class="turn_page bottom_page" id="page_container_adapter">
<a class="" node-type="page" action-type="changePageAdapter" href="javascript:void(0);" action-data="uid=<?php if(isset($user_info) && $user_info) echo $user_info['uid'];?>&type=<?php if(isset($type) && $type)echo $type;?>&shop_id=<?php echo $shop_id;?>&action=page&page=1">首页</a>
<a class="" node-type="prev" action-type="changePageAdapter" href="javascript:void(0);" action-data="uid=<?php if(isset($user_info) && $user_info) echo $user_info['uid'];?>&type=<?php if(isset($type) && $type)echo $type;?>&shop_id=<?php echo $shop_id;?>&action=prev">上一页</a>
<em><i node-type="show"><?php echo $page;?></i>/<i node-type="all"><?php echo $page_cnt;?></i></em>
<a class="" node-type="next" action-type="changePageAdapter" href="javascript:void(0);" action-data="uid=<?php if(isset($user_info) && $user_info) echo $user_info['uid'];?>&type=<?php if(isset($type) && $type)echo $type;?>&shop_id=<?php echo $shop_id;?>&action=next">下一页</a>
<a class="" node-type="page" action-type="changePageAdapter" href="javascript:void(0);" action-data="uid=<?php if(isset($user_info) && $user_info) echo $user_info['uid'];?>&type=<?php if(isset($type) && $type)echo $type;?>&shop_id=<?php echo $shop_id;?>&action=page&page=<?php echo $page_cnt;?>">末页</a>
</div>
<?php endif;?>


<?php else:?>
  <div class="info_blank"><p>
  	<?php if(isset($shop_id) && $shop_id):?>
  	这个商店暂时还没有点评哟，快来发布一个点评／晒单吧！
	<?php else:?>
	还没有关注的人啊，发现并关注你感兴趣的人吧。
	<?php endif;?>
	</p>
  </div>
<?php endif;?>
