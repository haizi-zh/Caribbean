<?php if($list):?>
<div class="right_block">
	<div class="title"><a href="<?php echo view_tool::echo_isset($domain);?>/shop/<?php echo $shop_id;?>" class="more">更多</a>相关晒单</div>
	<ul class="discont_list">
		<?php foreach($list as $v):?>
		<li>
			<a href="<?php echo view_tool::echo_isset($domain);?>/ping/<?php echo $v['id'];?>" title="猫总的北京火锅之选">
				<img src="<?php if($v['pic']) echo $v['pic'];?>" width="160" class="shop_avatar"/>
			</a>
		</li>
		<?php endforeach;?>
	</ul>
</div>
<?php endif;?>