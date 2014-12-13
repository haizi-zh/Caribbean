<?php if(isset($list) && $list):?>
	<div class="right_block">
		<div class="title">
			<?php if(count($list)==5):?>
			<a href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $city_info['lower_name'];?>-shopdiscount" class="more">更多</a>
			<?php endif;?>
			最新折扣
		</div>
		<ul class="suggest_list">
			<?php foreach($list as $discount_id=>$item){?>
			<li>
				  <a href="<?php echo view_tool::echo_isset($domain);?>/discount/<?php echo $discount_id;?>" alt="<?php echo $item['title'];?>">
						·<?php echo tool::substr_cn2($item['title'], 50);?>
				   </a>
			</li>
			<?php }?>
		</ul>
	</div>
<?php endif;?>

