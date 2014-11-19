<div class="right_block">
	<div class="erweima_area">
		<?php if($more):?>
		
		<a href="<?php echo view_tool::echo_isset($domain);?>/guide/<?php echo $info['id'];?>/">
		
	    <img style="display:block;margin:0 auto 5px;"  src="<?php echo upimage::format_brand_up_image($img,'!shoppic');?>" height="280" width="200">
		</a>
		<div style="display:block;">
		<span style="display:inline-block;width:140px;"><?php echo $info['title'];?></span><span style="text-align:right;">  <a rel="nofollow" class="card_icon" style="line-height:20px;" href="<?php echo view_tool::echo_isset($domain);?>/coupon/download_coupon/?id=<?php echo $id;?>">下载pdf</a></span>
		</div>
		<?php else:?>
	    <img style="display:block;margin:0 auto 5px;"  src="<?php echo upimage::format_brand_up_image($img,'!shoppic');?>" height="280" width="200">
		<?php endif;?>
		<!--<div class="gui_jnlist_item_text">2014-8-4更新</div>-->
	</div>
</div>

