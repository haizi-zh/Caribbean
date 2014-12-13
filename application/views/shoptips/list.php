<div class="ZB_shop_content clearfix">
	<div class="favor_page fl" style="width:100%;">
		<div class="ZB_bread_nav">
			<a href="<?php echo view_tool::echo_isset($domain);?>/"><?php echo $head_name;?></a><span class="">&gt;&gt;</span><a href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $city_info['lower_name'];?>/"><?php echo $city_name;?>购物</a><span class="">&gt;&gt;</span> <?php if($shop_id):?><a href="<?php echo view_tool::echo_isset($domain);?>/shop/<?php echo $shop_id;?>"><?php echo $shop_info['name'];?></a><span class="">&gt;&gt;</span><?php else:?><?php echo $city_name;?><?php endif;?>购物攻略
		</div>

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
				<?php if(isset($shoptips_list_html) && $shoptips_list_html) echo $shoptips_list_html;?>
			</div>
			<?php endif;?>
		</div>
	</div>

</div>