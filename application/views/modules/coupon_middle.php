<div class="coupon_tip">
<?php foreach($list as $v):?>
	<div class="content">
	<a href="<?php echo view_tool::echo_isset($domain);?>/coupon_info/<?php echo $v['id'];?>/<?php echo $shop_id;?>/"><span class="coupon_tag"></span><span><?php echo $v['title'];?></span></a>
	</div>
<?php endforeach;?>
</div>