
<?php if($coupon_list):?>
<div class="discount_list">
	<?php foreach($coupon_list as $k=>$v):?>
	<div class="discount_label">
		<div class="discount_info">
			
			<div class="num_count fr">
				<span class="download_num">
					<a rel="nofollow" class="favor_btn" href="<?php echo view_tool::echo_isset($domain);?>/coupon/download_coupon/?id=<?php echo $v['id'];?>&shop_id=<?php echo $shop_id;?>">
					下载(<?php echo $v['download_count'];?>)
					</a>
					<!--<em>120人</em>-->
				</span><em class="v_line"></em>
				<span class="download_num">
					<?php if($v['is_fav']):?>
					<a href="javascript:;" class="favor_btn" action-type="unfav" action-data="id=<?php echo $v['id'];?>&type=1&noclass=1">已收藏</a>
					<?php else:?>
					<a href="javascript:;" class="favor_btn" action-type="fav" action-data="id=<?php echo $v['id'];?>&type=1&noclass=1">收藏</a>
					<?php endif;?>

				<!--<em>120人</em>-->
				</span>
			</div>

			<a href="<?php echo view_tool::echo_isset($domain);?>/coupon_info/<?php echo $v['id'];?>/<?php echo $shop_id;?>/">
			<p class="coupon_feed"><span class="icon_coupon">优惠券</span><?php echo $v['title'];?></p>
			</a>
		</div>
	</div>
	<?php endforeach;?>
	<!--
	<div class="discount_label">
		<div class="discount_info">
			<div class="num_count fr"><span class="download_num"><a href="">下载</a><em>120人</em></span><em class="v_line"></em><span class="download_num"><a href="">收藏</a><em>120人</em></span>
			</div>
			<p class="coupon_feed"><span class="icon_discount">折扣</span>购物中心三年活动优惠券购物中心三年活动优惠券购物中心三年活动优惠券购物中心三年活动优惠券</p>
		</div>
	</div>
	-->
	<!--
	<p class="more_discount tar"><a href="">更多折扣</a></p>
	-->
</div>
<?php endif;?>

<!--
<?php if( 0 && $coupon_list && $discount_list):?>
<div class="discount_wrap">
	<?php if($coupon_list):?>
	<?php $i=0;?>
	<?php foreach($coupon_list as $k=>$v):?>
	<p>
	<span class="card_icon">优惠券</span><a href="<?php echo view_tool::echo_isset($domain);?>/coupon_info/<?php echo $v['id'];?>/<?php echo $shop_id;?>"><?php echo $v['title'];?></a>
	</p>
	<?php $i++;?>
	<?php endforeach;?>
	<?php endif;?>


	<?php if($discount_list):?>
	<?php $i=0;?>
	<?php foreach($discount_list as $k=>$v):?>
	<p>
	<span class="card_icon">折扣</span><a href="<?php echo view_tool::echo_isset($domain);?>/discount/<?php echo $v['id'];?>"><?php echo $v['title'];?></a>
	</p>
	<?php $i++;?>
	<?php endforeach;?>
	
	<?php endif;?>
</div>
<?php endif;?>



<?php if($coupon_list || $discount_list):?>
<?php 
$show_coupon_count = 2;
if($discount_list){
	$show_coupon_count = 1;
}
$i=0;
?>
<div class="discount_wrapV2 clearfix">
	<?php if($coupon_list):?>
	<?php foreach($coupon_list as $k=>$v):?>
	<?php $i++;?>
	<div class="discount_single fl clearfix" <?php if($i > 2):?>style="display:none;"<?php endif;?> >
		<div class="img_wrap fl">
			<?php

			$pic = "";
			if($v['pics']){
				$pics = $v['pics'];
				$pics_json = json_decode($pics);
				$pic = $pics_json[0];
			}
			?>
			<a href="<?php echo view_tool::echo_isset($domain);?>/coupon_info/<?php echo $v['id'];?>/<?php echo $shop_id;?>"><img src="<?php if($pic) echo $pic;?>" alt="" width="130" height="145"></a>
		</div>
		<div class="info_wrap fr">
			<a href="<?php echo view_tool::echo_isset($domain);?>/coupon_info/<?php echo $v['id'];?>/<?php echo $shop_id;?>"><p class="title"><?php echo $v['title'];?></p></a>
			<p class="during_time"></p>
			<div><a rel="nofollow" class="discount_btn" href="<?php echo view_tool::echo_isset($domain);?>/coupon/download_coupon/?id=<?php echo $v['id'];?>&shop_id=<?php echo $shop_id;?>">下载优惠券</a></div>
			
			<?php if($v['is_fav']):?>
			<div><a class="disable_btn" href="javascript:;" action-type="unfav" action-data="id=<?php echo $v['id'];?>&type=1">已收藏</a></div>
			<?php else:?>
			<div><a class="favor_btn" href="javascript:;" action-type="fav" action-data="id=<?php echo $v['id'];?>&type=1">收藏</a></div>
			<?php endif;?>
			
		</div>
	</div>
	<?php endforeach;?>
	<?php endif;?>

	<?php if($discount_list):?>
	<?php foreach($discount_list as $k=>$v):?>
	<?php $i++;?>
	<div class="discount_single fl clearfix" <?php if($i > 2):?>style="display:none;"<?php endif;?> >
		<div class="img_wrap fl">
			<a href="<?php echo view_tool::echo_isset($domain);?>/discount/<?php echo $v['id'];?>/">
			<img src="/images/discount.jpeg" alt="" width="130" height="145">
			</a>
		</div>
		<div class="info_wrap fr">
			<a href="<?php echo view_tool::echo_isset($domain);?>/discount/<?php echo $v['id'];?>/">
			<p class="title"><?php echo $v['title'];?></p>
			</a>
			<p class="during_time"><?php echo $v['time_format'];?></p>
		</div>
	</div>
	<?php endforeach;?>
	<?php endif;?>
</div>

<?php if($i > 2):?>
<p class="more_brand" ><a href="javascript:;" title="更多<?php echo $shop_name;?>优惠券/折扣" action-type="show_more_coupon_discount">更多优惠券/折扣</a></p>
<?php endif;?>

<?php endif;?>
-->
