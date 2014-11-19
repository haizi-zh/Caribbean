	<div class="ZB_bread_nav">
		<a href="<?php echo view_tool::echo_isset($domain);?>/"><?php echo $head_name;?></a><span class="">&gt;&gt;</span><a href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $city_info['lower_name'];?>/"><?php echo $city_name;?>购物</a><span class="">&gt;&gt;</span> <?php if($shop_id):?><a href="<?php echo view_tool::echo_isset($domain);?>/shop/<?php echo $shop_id;?>"><?php echo $shop_info['name'];?></a><span class="">&gt;&gt;</span><?php else:?><?php echo $city_name;?><?php endif;?>购物攻略
	</div>
<div class="ZB_content clearfix">

	<div class="shop_discount_wrap">
		<!-- 面包屑引导 -->

		<!-- /面包屑引导 -->
		<!-- 翻页信息 -->
<!-- 		<div class="order clearfix">
			<div class="fr turn_page" id="page_container">
				<a class="turn_left" node-type="prev" action-type="changePage" href="javascript:void(0);" action-data="city=<?php //echo $city;?>&shop_id=<?php //echo $shop_id;?>&action=prev"></a>
				<em><i node-type="show"><?php //echo $page;?></i>/<i node-type="all"><?php //echo $page_cnt;?></i></em>
				<a class="turn_right" node-type="next" action-type="changePage" href="javascript:void(0);" action-data="city=<?php //echo $city;?>&shop_id=<?php //echo $shop_id;?>&action=next"></a>
			</div>
		</div> -->
		<!-- /翻页信息 -->
		<!-- 打折列表信息 -->
		<div class="strategy_list" id="comment_list">
			<?php if(isset($shoptips_list_html) && $shoptips_list_html):?>
			<?php echo $shoptips_list_html;?>
			<?php endif;?>
		</div>
		<!-- /打折列表信息 -->
	</div>

</div>
