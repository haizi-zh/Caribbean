<!--<div class="ZB_content ">
	<div class="link_content">
		<h3 class="link_tit">友情链接</h3>
		<?php foreach ($link_list as $name => $list) :?>
		<div class="link_title"><?php echo $name;?></div>
		<ul class="link_list">
			<?php foreach($list as $url => $item):?>
			<li><a href="<?php echo $url;?>" target="_blank"><?php echo $item;?> </a></li>
			<?php endforeach;?>
		</ul>
		<?php endforeach;?>
	</div>
</div>
-->


<div class="ZB_content ">
	<div class="link_content">
		<h3 class="link_tit">友情链接</h3>
		<?php foreach ($cat_list as $k => $v) :?>
		<div class="link_title"><?php echo $v['name'];?></div>
		<ul class="link_list">
			<?php if($v['links']):?>
			<?php foreach($v['links'] as  $item):?>
			<li><a href="<?php echo $item['url'];?>" target="_blank"><?php echo $item['name'];?> </a></li>
			<?php endforeach;?>
			<?php endif;?>
		</ul>
		<?php endforeach;?>
	</div>
</div>
