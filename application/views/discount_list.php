<div class="ZB_shop_content clearfix">
	<div class="ZB_bread_nav">
		<a href="<?php echo view_tool::echo_isset($domain);?>/"><?php echo $head_name;?></a><span class="">&gt;&gt;</span><a href="<?php echo view_tool::echo_isset($domain);?>/city/<?php echo $city_id;?>"><?php echo $city_name;?></a><span class="">&gt;&gt;</span><?php if($shop_info):?><a href="<?php echo view_tool::echo_isset($domain);?>/shop/<?php echo $shop_id;?>"><?php echo $shop_info['name'];?></a><span class="">&gt;&gt;</span><?php endif;?>折扣列表
	</div>
	<div class="shop_wrap fl">
		<?php if($page_cnt > 1):?>
		<div class="order clearfix">
			<div class="fr turn_page" id="page_container">
				<a class="" node-type="page" action-type="changePage" href="javascript:void(0);" action-data="city=<?php echo $city_id;?>&shop_id=<?php echo $shop_id;?>&action=page&page=1">首页</a>
				<a class="" node-type="prev" action-type="changePage" href="javascript:void(0);" action-data="city=<?php echo $city_id;?>&shop_id=<?php echo $shop_id;?>&action=prev">上一页</a>
				<em><i node-type="show"><?php echo $page;?></i>/<i node-type="all"><?php echo $page_cnt;?></i></em>
				<a class="" node-type="next" action-type="changePage" href="javascript:void(0);" action-data="city=<?php echo $city_id;?>&shop_id=<?php echo $shop_id;?>&action=next">下一页</a>
				<a class="" node-type="page" action-type="changePage" href="javascript:void(0);" action-data="city=<?php echo $city_id;?>&shop_id=<?php echo $shop_id;?>&action=page&page=<?php echo $page_cnt;?>">末页</a>
			</div>
		</div>
		<?php endif;?>

		<div class="discount_list" id="comment_list">
			<?php if(isset($discount_list_html) && $discount_list_html):?>
			<?php echo $discount_list_html;?>
			<?php elseif($shop_info):?>
			<?php if($city_name):?><a href="<?php echo view_tool::echo_isset($domain);?>/city/<?php echo $city_id;?>"><?php  echo $city_name;?></a><?php endif;?>- <?php if($shop_info):?><a href="/shop/<?php echo $shop_id;?>"><?php echo $shop_info['name'];?></a><?php endif;?>的折扣信息还没有录入，请联系我们添加。
			<?php elseif($city_name):?>
			<?php if($city_name):?><a href="<?php echo view_tool::echo_isset($domain);?>/city/<?php echo $city_id;?>"><?php  echo $city_name;?></a><?php endif;?>的折扣信息还没有录入，请联系我们添加。
			<?php endif;?>
		</div>
	</div>
	<div class="side_bar fr">
	<?php if(isset($macys_html) && $macys_html) echo $macys_html;?>
	<?php if(isset($recommend_shop_html) && $recommend_shop_html) echo $recommend_shop_html;?>
	<?php if(isset($ios_contact_html) && $ios_contact_html) echo $ios_contact_html;?>
	</div>
</div>
