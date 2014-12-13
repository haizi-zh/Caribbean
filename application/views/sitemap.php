<div class="ZB_content ">
	<div class="link_content">
		<h3 class="link_tit">网站地图</h3>
		<?php foreach ($link_list as $name => $list) :?>
		<div class="link_title"><?php echo $name;?></div>
		<ul class="link_list">
			<?php foreach($list as $url => $item):?>
			<li style="width:251px;"><a href="<?php echo $url;?>" target="_blank"><?php echo $item;?> </a></li>
			<?php endforeach;?>
		</ul>
		<?php endforeach;?>
	</div>
</div>