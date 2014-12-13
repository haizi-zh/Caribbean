<div class="ZB_shop_content clearfix">
	<div class="favor_page fl">							
		<div class="favor_wrap">
				<?php if(!$fav_shops_count && !$fav_coupons_count):?>
				<div class="favor_city clearfix">	
				你还没有收藏任何商户/优惠券呢！当你发现有意思的、有价值的商户/优惠券时，赶紧收藏下来哦！
				</div>
				<?php else:?>
				<div class="favor_city clearfix">						
					<div class="city_info">
						<div class="favor_title">收藏商店</div>
						<div class="city_name" id="shop_city_list">
							<a href="javascript:;" class="cur" action-data="city=0&type=0" action-type="choose_shop_city" >所有</a>
							<?php if($shop_city_infos):?>
							<?php foreach($shop_city_infos as $shop_city):?>
							<a href="javascript:;" action-type="choose_shop_city" action-data="city=<?php echo $shop_city['id'];?>&type=0"><?php echo $shop_city['name'];?></a>
							<?php endforeach;?>
							<?php endif;?>
						</div>
					</div>		
					<div class="shop_favor" id="shop_all">
						<?php if(isset($shop_html) && $shop_html) echo $shop_html;?>
					</div>
				</div>
				<div class="favor_city clearfix">						
					<div class="city_info">
						<div class="favor_title">收藏优惠券</div>
						<div class="city_name" id="coupon_city_list">
							<a href="javascript:;" action-type="choose_coupon_city" action-data="city=0&type=1" class="cur">所有</a>
							<?php if($coupon_city_infos):?>
							<?php foreach($coupon_city_infos as $coupon_city):?>
							<a href="javascript:;" action-type="choose_coupon_city" action-data="city=<?php echo $coupon_city['id'];?>&type=1" ><?php echo $coupon_city['name'];?></a>
							<?php endforeach;?>
							<?php endif;?>
						</div>
					</div>		
					<div class="discount_favor" id="coupon_all">
						<?php if(isset($coupon_html) && $coupon_html) echo $coupon_html;?>
					</div>			
				</div>
				<?php endif;?>
			<!-- /折扣收藏 -->
		</div>
		<!-- /收藏模块 -->
	</div>
	<div class="side_bar fr">
		<!--  这里放地图-->
		<?php if(isset($right_user_html) && $right_user_html) echo $right_user_html;?>
		<?php if(isset($macys_html) && $macys_html) echo $macys_html;?>
		<!--  /这里放地图-->
	</div>
</div>