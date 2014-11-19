<div class="ZB_shop_content clearfix" id="shop_content">
	<div class="ZB_bread_nav">
		<a href="<?php echo view_tool::echo_isset($domain);?>/"><?php echo $head_name;?></a><span class="">&gt;&gt;</span><?php echo $city_name;?>购物
	</div>

	<div class="side_bar fl" id="side_bar">
		<?php if(isset($new_york_kits_html) && $new_york_kits_html) echo $new_york_kits_html;?>

		<?php if(isset($left_tips_html) && $left_tips_html) echo $left_tips_html;?>

		<?php if(isset($macys_html) && $macys_html) echo $macys_html;?>
		
		<!-- 相关榜单 -->
		<div class="left_block" id="this_top">
			<div class="title">选择您要去的品牌商店</div>
			<div class="word_wrap">
				<?php foreach($first_char_array as $char){?>
				<a href="javascript: void(0);" action-type="choose_key" action-data="char=<?php echo $char;?>&city=<?php echo $city_id;?>" title="<?php echo $char;?>" <?php if($char == $current_char){?>class="cur"<?php }?>><?php echo $char;?></a>
				<?php }?>
			</div>
			<div class="toggle_list" id="toggle_list">
				<div class="all_brand" action-type="all_brand" action-data="city=<?php echo $city_id;?>&brand_id=0"><a href="javascript:;" action-type="all_brand_cur" class="">热门品牌</a></div>
				<ul class="list_detail clearfix">
					<?php echo $brand_html; ?>
				</ul>
			</div>
		</div>
		<?php if(isset($ios_contact_html) && $ios_contact_html) echo $ios_contact_html;?>

		<!-- /相关榜单 -->
	</div>

	<div class="shop_list_wrap fr">
		<!-- 面包屑引导 -->

		<!-- /面包屑引导 -->
		<div class="filter_list" id="tab_container_new">
			<ul class="select" id="cat_item">

				<li id="cat_1" class="clearfix"><span class="cate" >分类</span>
					<div class="cate_wrap">
					<a href="javascript:;" class="cur" action-type="change_tab_new" action-data="cat=1&id=0&city=<?php echo $city_id;?>">所有</a>
					<?php foreach($tags_one as $k => $v):?>
					<a href="javascript:;" action-type="change_tab_new" action-data="cat=1&id=<?php echo $v['id'];?>&city=<?php echo $city_id;?>"><?php echo $v['name'];?></a>
					<?php endforeach;?>

					<?php if(isset($tags_four) && $tags_four):?>
					<?php foreach($tags_four as $k => $v):?>
					<a href="javascript:;" action-type="change_tab_new" action-data="cat=1&id=<?php echo $k;?>&city=<?php echo $city_id;?>"><?php echo $v;?></a>
					<?php endforeach;?>
					<?php endif;?>
					</div>
				</li>

				<li  id="cat_2" class="clearfix"><span class="cate">类型</span>
					<div class="cate_wrap">
					<a href="javascript:;" class="cur" action-type="change_tab_new" action-data="cat=2&id=0&city=<?php echo $city_id;?>">所有</a>
					<?php foreach($tags_two as $v):?>
					<a href="javascript:;" action-type="change_tab_new" action-data="cat=2&id=<?php echo $v['id'];?>&city=<?php echo $city_id;?>"><?php echo $v['name'];?></a>
					<?php endforeach;?>
					</div>
				</li>

				<?php if(isset($tags_three) && $tags_three):?>
				<li id="cat_3" class="clearfix"><span class="cate">地标</span>
					<div class="cate_wrap">
					<a href="javascript:;" class="cur" action-type="change_tab_new" action-data="cat=3&id=0&city=<?php echo $city_id;?>">所有</a>
					<?php foreach($tags_three as $k => $v):?>
					<a href="javascript:;" action-type="change_tab_new" action-data="cat=3&id=<?php echo $k;?>&city=<?php echo $city_id;?>"><?php echo $v;?></a>
					<?php endforeach;?>
					</div>
				</li>
				<?php endif;?>

			</ul>
		</div>

		<?php if($page_cnt > 1):?>
		<div class="tab clearfix" id="tab_container" >
			<div class="fr turn_page" id="page_container">
				<a class="turn_first" node-type="page" action-type="changePage" href="javascript:void(0);" action-data="city=<?php echo $city_id;?>&action=page&page=1">返回第一页</a>
				<a class="turn_forward" node-type="prev" action-type="changePage" href="javascript:void(0);" action-data="city=<?php echo $city_id;?>&action=prev">上一页</a>
				<em><i node-type="show"><?php echo $page;?></i>/<i node-type="all"><?php echo $page_cnt;?></i></em>
				<a class="turn_next" node-type="next" action-type="changePage" href="javascript:void(0);" action-data="city=<?php echo $city_id;?>&action=next">下一页</a>
			</div>
			<!--
			<div class="fr turn_page" id="page_container">
				<a class="turn_left" node-type="prev" action-type="changePage" href="javascript:void(0);" action-data="city=<?php echo $city_id;?>&action=prev"></a>
				<em><i node-type="show"><?php echo $page;?></i>/<i node-type="all"><?php echo $page_cnt;?></i></em>
				<a class="turn_right" node-type="next" action-type="changePage" href="javascript:void(0);" action-data="city=<?php echo $city_id;?>&action=next"></a>
			</div>
			-->
		</div>
		<?php endif;?>

		<div class="shop_list clearfix" id="shop_list">
			<!-- 商家的信息和评论列表-->
			<?php echo $shop_list_html ?>

		</div>

		<div class="goToTop" id="goToTop" style="position: fixed;bottom: 100px;display:none;">
		    <a class="toTop" href="javascript:void(0)"></a>
		</div>
	</div>
</div>
