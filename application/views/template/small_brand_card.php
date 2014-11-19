<?php if($brands){ ?>
<?php
	$this->config->load('env',TRUE);
	$brand_domain = $this->config->item('brand_domain','env');
	
?>
	<?php foreach($brands as $brand){?>
		<li class="clearfix" action-type="brand" action-data="brand_id=<?php echo $brand['id'];?>&city=<?php echo $city_id;?>">
		<?php
			if($brand['big_pic']) {
				$pic = upimage::format_brand_up_image($brand['big_pic']);
			}else{
				$pic = $brand['big_pic'];
			}
		?>
		<div class="brand_pic fl"><a href="javascript: void(0);" title="<?php echo $brand['name'];?> | <?php echo $brand['english_name'];?>"><img rel="nofollow" alt="<?php echo $brand['name'];?> | <?php echo $brand['english_name'];?>" src="<?php echo $pic;?>" width="40" height="40"/></a></div>
		<div class="list_name_C"><a href="javascript: void(0);" class="W_texta"> <?php echo $brand['name'];?></a></div>
		<?php if($brand['name'] != $brand['english_name']):?>
		<div class="list_name_C"><a href="javascript: void(0);" class="W_texta"> <?php echo $brand['english_name'];?></a></div>
		<?php endif;?>
		</li>
	<?php }?>
<?} else { ?>
	很遗憾，该城市还没有品牌信息
<?}?>