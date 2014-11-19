<?php if($right_list):?>
<div class="right_block">
	<div class="title"><?php echo $city_name;?>购物攻略</div>
	<ul class="suggest_list">
			<?php foreach($right_list as $item){?>
			<li>
				  <a href="<?php echo view_tool::echo_isset($domain);?>/shoptipsinfo/<?php echo $item['id'];?>/" title="<?php echo $item['title'];?>">
						·<?php echo $item['title'];?>
				   </a>
			</li>
			<?php }?>
	</ul>
	<p class="clearfix"><a href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $city_lower_name;?>-shoppingtips/" id="" class="more" >更多攻略</a></p>
</div>
<?php endif;?>