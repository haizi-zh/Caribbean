<div class="right_block">
	<div class="title"><?php if($city_info) echo $city_info['name'];?>购物攻略</div>
	<ul class="suggest_list">
			<?php foreach($list as $id=>$value):?>
			<li>
				  <a href="<?php echo view_tool::echo_isset($domain);?>/shoptipsinfo/<?php echo $value['id'];?>/" title="<?php echo $value['title'];?>">
						·<?php echo $value['title'];?>
				   </a>
			</li>
			<?php endforeach;?>
	</ul>
	<?php if($tips_count > 5):?><p class="clearfix"><a href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $city_info['lower_name'];?>-shoppingtips/" class="more">更多攻略</a></p><?php endif;?>

</div>