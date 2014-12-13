<!-- 面包屑引导 -->
<div class="ZB_bread_nav">
	<a href="<?php echo view_tool::echo_isset($domain);?>/"><?php echo $head_name;?></a><span class="">&gt;&gt;</span><a href="<?php echo view_tool::echo_isset($domain);?>/city/<?php echo $city_id;?>"><?php echo $city_name;?>购物</a><span class="">&gt;&gt;</span><a href="<?php echo view_tool::echo_isset($domain);?>/shop/<?php echo $shop_id;?>"><?php echo $shop_name;?></a>
</div>
<!-- /面包屑引导 -->
<?php if(isset($have_shop) && $have_shop){?>
<div class="ZB_content ">
	<div class="shop_pic">
		<p class="shop_title">主力百货公司</p>
		<div class="shop_wrap">
			<ul class="list_detail clearfix" id="anchor_store_list">
				<?php foreach ($have_shop as $key => $value) {?>
				<?php 
				$alt_title = $value['name'];
				if($alt_title != $value['english_name']){
					$alt_title .= " ".$value['english_name'];
				}
				?>
					<li>
						<div class="shop_pic" action-type="show_anchor_store" action-data="brand_id=<?php echo $value['id'];?>"><a title=" 主力百货公司 <?php echo $alt_title;?>" href="javascript:;"><img rel="nofollow" alt="<?php echo $alt_title;?>" src="<?php echo $value['big_pic'];?>"></a></div>
						<div class="shop_name_E"><a href="javascript:;" title="<?php echo $alt_title;?>"><?php echo $value['name'];?></a></div>
						<?php if($value['name'] != $value['english_name']):?>
						<div class="shop_name_C"><a href="javascript:;" class="W_texta" title="<?php echo $alt_title;?>"><?php echo $value['english_name'];?></a></div>
						<?php endif;?>
						<?php if($value['eb_url']):?>
						<div class="shop_name_C">
						<a href="<?php echo $value['eb_url'];?>">直达商城</a>
						</div>
						<?php endif;?>
						
						
					</li>
				<?php  }?>
			</ul>
		</div>
	</div>
</div>
<div id="show_anchor" style="display:none;"></div>
<?php }?>
<?php
	$this->config->load('env',TRUE);
	$brand_domain = $this->config->item('brand_domain','env');
?>
<div class="ZB_content ">
	<div class="">
		<p class="brand_title">精品专卖店</p>
		<div class="brand_list" id="brand_list">
			<?php foreach($brands as $key=>$value) { ?>
				<?php if($key):?>
				<a href="javascript:void(0);" action-type="change_brand" action-data="letter=<?php echo $key;?>" target="_blank"><?php echo $key;?></a>
				<?php endif;?>
			<?php }?>
		</div>
		<div class="brand_wrap">
			<?php foreach($this->tool->get_first_chars() as $char){?>
			<?php if(isset($brands[$char])){?>

			<div class="brand_letter" name="<?php echo $char;?>"><?php echo $char;?></div>
			<ul class="list_detail clearfix">
				<?php foreach($brands[$char] as $brand){?>
				<?php $alt_title = $brand['name'];
				if($alt_title != $brand['english_name']){
					$alt_title .= " ".$brand['english_name'];
				}
				?>
				<li class="clearfix"><div class="brand_pic fl">
					<?php if($brand['big_pic']):?>
					<img rel="nofollow" alt="<?php echo $alt_title;?>" src="<?php echo $brand['big_pic'];?>">
					<?php else:?>

					<img rel="nofollow" alt="<?php echo $alt_title;?>" src="<?php echo $brand_domain.'brand_'.$brand['id'];?>.jpg">
					<?php endif;?>
					</div>
					<div class="list_name_E"><a title="<?php echo $alt_title;?>" href="javascript:;" class="W_texta"><?php echo $brand['name'];?></a></div>
					<?php if($brand['name'] != $brand['english_name']):?>
					<div class="list_name_C"><a title="<?php echo $alt_title;?>" href="javascript:;" class="W_texta"><?php echo $brand['english_name'];?></a></div>
					<?php endif;?>
				</li>
				<?php }?>
			</ul>
			<?php }}?>
		</div>
	</div>
</div>
