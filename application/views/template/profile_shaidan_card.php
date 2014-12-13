<!-- shop页的晒单card-->
<?php foreach($dianpings as $dianping){?>
<div class="comment clearfix">
	<!-- 头像信息 -->
	<div class="avatar fl">
		<div class="avatar_pic"><a href="<?php echo view_tool::echo_isset($domain);?>/shop/<?php echo isset($dianping['shop_id'])?$dianping['shop_id']:0;?>" target="_blank"><img rel="nofollow" alt="出国购物"  src="<?php echo isset($dianping['shop_info']['pic'])?$dianping['shop_info']['pic']:'';?>" width="77" height="72"/></a></div>
		<div class="nick_name"><?php echo isset($dianping['shop_info']['name'])?$dianping['shop_info']['name']:'Null';?></div>
		<div class="avatar_comment"><a href="<?php echo view_tool::echo_isset($domain);?>/ping/<?php echo $dianping['id'];?>" target="_blank" class="linkb"><?php echo isset($dianping['cmt_cnt'])?$dianping['cmt_cnt']:0;?>条</a>回复</div>
	</div>
	<!-- /头像信息 -->
	<!-- 评论信息 -->
	<div class="comment_info">
		<div class="rating_wrap"><span class="rating_title">综合评分</span><div class="rating_wrap_small"><span title="<?php echo $dianping['score'];?>星商户" class="star star<?php if(!$dianping['score']) echo '00';else echo $dianping['score']*10;?>" ></span></div><?php echo $dianping['score'];?></div>
		<a target='_blank' href="<?php echo view_tool::echo_isset($domain);?>/ping/<?php echo $dianping['id'];?>">
		<p class="slideup"><?php echo $dianping['clean_body'];?></p>
		<?php if($dianping['has_pic']){?>
			<a target='_blank' href="<?php echo view_tool::echo_isset($domain);?>/ping/<?php echo $dianping['id'];?>" class="linkb">更多<span class="moredown"></span></a>
			<div class="pic_wrap">
				<?php if($dianping['has_pic']){?>
					<?php $picarray = json_decode($dianping['pics'], true);foreach($picarray as $pic){?>
					<a target='_blank' href="<?php echo view_tool::echo_isset($domain);?>/ping/<?php echo $dianping['id'];?>"><img rel="nofollow" alt="出国购物"  src="<?php echo $pic.'!pingpreview';?>"/></a>
				<?php }}?>
			</div>
		<?php }?>
		</a>
	</div>
	<!-- /评论信息 -->
</div>
<?php }?>