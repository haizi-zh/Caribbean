<?php if(isset($fav_coupons) && $fav_coupons):?>
	<?php if($page==1):?>
		<div class="hidden_margin clearfix" id="coupon_list">
	<?php endif;?>
	<?php foreach($fav_coupons as $coupon):?>
		<?php 
			$pic = "";
			if($coupon['pics']){
				$pics = $coupon['pics'];
				$pics_decode = json_decode($pics, true);
				$pic = $pics_decode[0];
			}
			$shop_id = $coupon['shop_id'];
			if(strstr($shop_id, ",")){
				$tmp = explode(",", $shop_id);
				$shop_id = $tmp[1];
			}
		?>
		<div class="discount_single fl clearfix">
			<div class="img_wrap fl">
				<a target="_blank" href="/coupon_info/<?php echo $coupon['id'];?>/<?php echo $shop_id;?>/">
					<img src="<?php if($pic) echo $pic;?>" alt="" width="130" height="145">
				</a>
			</div>
			<div class="info_wrap fr">
				<p class="title"><a target="_blank" href="/coupon_info/<?php echo $coupon['id'];?>/<?php echo $shop_id;?>/"><?php echo $coupon['title'];?></a></p>
				<!--
				<div><a class="discount_btn" href="">下载优惠券</a></div>
			-->
				<div><a class="discount_btn" href=""></a></div>
				<div><a rel="nofollow" class="discount_btn" href="/coupon/download_coupon/?id=<?php echo $coupon['id'];?>&shop_id=<?php echo $shop_id;?>">下载优惠券</a></div>
				<div><a class="disable_btn" href="javascript:;" action-type="unfav" action-data="id=<?php echo $coupon['id'];?>&type=1&noclass=0">已收藏</a></div>

			</div>
		</div>
	<?php endforeach;?>
	<?php if($page==1):?>
		</div>
		<?php if($fav_coupons_count > 4):?>
		<p class="clearfix tar"><a href="javascript:;" class="more" id="coupon_more" action-type="coupon_more" action-data="2">更多<span class="moredown"></span></a></p>
		<?php endif;?>
	<?php endif;?>
<?php endif;?>
