<?php if(isset($list) && $list):?>
	<?php foreach($list as $item):?>
		<?php 
			$pic = "";
			if($item['pics']){
				$pics = $item['pics'];
				$pics_decode = json_decode($pics, true);
				$pic = $pics_decode[0];
			}
		?>
		<div class="discount_single fl clearfix" style="width:305px;padding-right:3px;">
			<div class="img_wrap fl" style="margin-right:3px;">
				<a target="_blank" href="<?php echo view_tool::echo_isset($domain);?>/shoptipsinfo/<?php echo $item['id'];?>/">
					<img src="<?php if($pic) echo $pic.'!settingimage';?>" alt="" width="130" height="85">
				</a>
			</div>
			<div class="info_wrap fr" style="width:165px;">
				<p class="title" style="font-size:16px;"><a target="_blank" href="<?php echo view_tool::echo_isset($domain);?>/shoptipsinfo/<?php echo $item['id'];?>/"><?php echo $item['title'];?></a></p>
			</div>
		</div>
	<?php endforeach;?>

<?php endif;?>
