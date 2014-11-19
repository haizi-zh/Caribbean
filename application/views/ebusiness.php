<!-- 面包屑引导 -->
<div class="ZB_bread_nav">
	<a href="<?php echo view_tool::echo_isset($domain);?>/"><?php echo $head_name;?></a><span class="">&gt;&gt;</span>推荐电商
</div>
<!-- /面包屑引导 -->
<?php if(isset($list) && $list):?>
<div class="ZB_content ">
	<div class="shop_pic">
		<div class="shop_wrap">
			<ul class="list_detail clearfix" id="anchor_store_list">
				<?php foreach ($list as $key => $value) :?>
					<li>
						<div class="shop_pic" action-type="show_anchor_store" action-data="id=<?php echo $value['id'];?>"><a title="电商<?php echo $value['name'];?>;?>" href="javascript:;"><img rel="nofollow" width="132" height="102" alt="电商<?php echo $value['name'];?>" src="<?php echo $value['logo'];?>"></a></div>
						<div class="shop_name_E"><a href="javascript:;"><?php echo $value['name'];?></a></div>
					</li>
				<?php  endforeach;?>
			</ul>
		</div>
	</div>
</div>
<div id="show_anchor" style="display:none;"></div>
<?php endif;?>