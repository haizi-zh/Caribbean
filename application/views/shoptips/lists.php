<div class="ZB_shop_content clearfix">
	<div class="favor_page fl">	
		<div class="favor_wrap">
			<?php if(!$list):?>
			<div class="favor_city clearfix">
			还没有攻略！
			</div>
			<?php else:?>
			<div class="favor_city clearfix">
				<div class="city_info">
					<div class="favor_title"><?php echo $city_name;?>购物攻略</div>
				</div>
				<div class="discount_favor" id="coupon_all">
					<?php if(isset($shoptips_list_html) && $shoptips_list_html) echo $shoptips_list_html;?>
				</div>
			</div>
			<?php endif;?>
		</div>
	</div>
	<div class="side_bar fr">
	</div>
</div>