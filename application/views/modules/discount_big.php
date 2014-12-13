<?php if($infos):?>
<div class="discount">
	<span class="tag">折扣/新品</span>
	<?php foreach($infos as $v):?>
	<p class="content"><a title="<?php echo $v['title'];?>" href="<?php echo view_tool::echo_isset($domain);?>/discount/<?php echo $v['id'];?>/" target="_blank"><?if(isset($v['title']) && $v['title']) echo $v['title'].":";?><?if(isset($v['clean_body']) && $v['clean_body']) echo $v['clean_body'];?></a></p>
	<?php endforeach;?>

	<p class="more_detail"><a title="<?php echo $shop_info['name'].'折扣列表';?>" href="<?php echo view_tool::echo_isset($domain);?>/discountshop/<?php echo $shop_id;?>/">更多&nbsp;&nbsp;▶</a></p>
</div>
<?php endif;?>