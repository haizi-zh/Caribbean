
<?php if(isset($list) && $list):?>
<ul class="clearfix">
<?php foreach($list as $item):?>

	<li><a href="<?php echo view_tool::echo_isset($domain);?>/shoptipsinfo/<?php echo $item['id'];?>/" title="<?php echo $item['title'];?>">
		<span class="title"><?php echo $item['title'];?></span>
			<img rel="nofollow" src="<?php if(isset($item['pics_list']) && $item['pics_list']) echo upimage::format_brand_up_image($item['pics_list'][0])."!300";?>" alt="<?php echo $item['title'];?>" width="280" height="280"/>
		</a>
	</li>

<?endforeach;?>
</ul>
<?php endif;?>
