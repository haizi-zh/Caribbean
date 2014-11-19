<?php if(isset($list) && $list):?>
	<div class="right_block">
		<div class="title">
			<?php echo $city_name;?>商场优惠券
		</div>
		<ul class="suggest_list">
			<?php foreach($list as $coupon_id=>$item){?>
			<li>
				  <a href="<?php echo view_tool::echo_isset($domain);?>/coupon_info/<?php echo $coupon_id;?>/<?php echo $item['shop_id'];?>/" alt="<?php echo $item['title'];?>">
						·<?php echo tool::substr_cn2($item['title'], 50);?>
				   </a>
			</li>
			<?php }?>
		</ul>
	</div>
<?php endif;?>

