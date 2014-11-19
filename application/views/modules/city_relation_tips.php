<?php if($city_infos):?>
<div class="right_block">
	<div class="title">推荐城市攻略</div>
	<ul class="suggest_list">
			<?php foreach($city_infos as $city => $item){?>
			<li>
				  <a href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $item['lower_name'];?>-shoppingtips/" title="<?php echo $item['name'];?>.'购物攻略';?>">
						·<?php echo trim($item['name']).'购物攻略';?>
				   </a>
			</li>
			<?php }?>
	</ul>
</div>
<?php endif;?>