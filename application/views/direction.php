<div class="ZB_shop_content clearfix">
	<!-- 面包屑引导 -->
	<div class="ZB_bread_nav">
		<!--<a href="">首页</a><span class="">&gt;&gt;</span><a href="">纽约</a><span class="">&gt;&gt;</span><a href="">Macy's Department Store</a><span class="">&gt;&gt;</span>如何到达</br>-->
		<a href="<?php echo view_tool::echo_isset($domain);?>/">赞佰</a><span class="">&gt;&gt;</span><a href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $city_lower_name;?>/"><?php echo $city_name;?>购物</a><span class="">&gt;&gt;</span><a href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $city_lower_name;?>/<?php echo $shop['id'];?>"><?php echo $shop['name'];?></a><span class="">&gt;&gt;</span>怎样到达
	</div>
	<!-- /面包屑引导 -->
	<div class="trans_wrap fl">
		<h2 class="title">怎样到达 <?php echo $shop_name;?></h2>
			<?php if($direction_list):?>
			<?php foreach($direction_list as $direction):?>
			<?php 
			$direction_type = $direction['type'];
			$direction_lines = $direction['lines'];
			?>
			<div class="trans_mode clearfix">
				<span class="trans_icon <?php if(isset($icons[$direction_type])) echo $icons[$direction_type];?> fl"></span>
				<div class="trans_info fl">
					<p class="mode_title"><?php if(isset($type_lists[$direction_type])) echo $type_lists[$direction_type];?></p>
					<p class="station"><?php echo $direction['description'];?></p>
					<p class="location_detail"></p>
					<?php foreach($direction_lines as $line_key=> $line):?>
						路线<?php echo $line_key+1;?>
						<?php foreach($line as $item):?>
							<?php if($item['item_type'] == 1):?>
								<?php if($item['title']):?>
								<p class="station"><?php echo $item['title'];?></p>
								<?php endif;?>
								<?php if($item['description']):?>
								<p class="location_detail"><?php echo $item['description'];?></p>
								<?php endif;?>
							<?php else:?>
								<?php if($item['title'] || $item['description']):?>
								<p class="location_detail">
									<?php if($item['title']):?>[<?php echo $item['title'];?>]:<?php endif;?>
									<?php if($item['description']):?><?php echo $item['description'];?><?php endif;?>
								</p>
								<?php endif;?>
							<?php endif;?>

						<?php endforeach;?>
					<?php endforeach;?>
				</div>
			</div>
			<?php endforeach;?>
			<?php endif;?>
	</div>
	<div class="side_bar fr">
		<?php if (isset($shoptips_html) && $shoptips_html) echo $shoptips_html;?>
		<?php if(isset($macys_html) && $macys_html) echo $macys_html;?>
		<?php if(isset($city_right_discount_html) && $city_right_discount_html) echo $city_right_discount_html;?>
		<?php if(isset($recommend_shop_html) && $recommend_shop_html) echo $recommend_shop_html;?>
		<?php if(isset($ios_contact_html) && $ios_contact_html) echo $ios_contact_html;?>
		
	</div>
</div>