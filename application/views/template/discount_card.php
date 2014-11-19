<?php if(isset($discount_infos) && $discount_infos):?>
	<?php foreach($discount_infos as $item):?>
	<div class="discount_info clearfix">

		<?php if($item['brand_id'] && isset($brand_infos[$item['brand_id']]) && $brand_infos[$item['brand_id']]):?>
		<a href="<?php echo view_tool::echo_isset($domain);?>/discount/<?php echo $item['id'];?>/" class="shop_avatar fl"><img rel="nofollow" src="<?php echo $brand_infos[$item['brand_id']]['big_pic'];?>" width="170" height="130"/></a>
		<?php else:?>
		<a href="<?php echo view_tool::echo_isset($domain);?>/discount/<?php echo $item['id'];?>/" class="shop_avatar fl"><img rel="nofollow" src="/images/sales.jpg" width="170" height="130"/></a>
		<?php endif;?>
		<div class="right_detail">
			<div class="title"><?php if(isset($item['title']) && $item['title']) echo $item['title']." ";?> <?php if( isset($item['shop_info']) && $item['shop_info']):?>—— <?php echo $item['shop_info']['name'];?><?php if($item['shop_info']['name'] != $item['shop_info']['english_name']):?>(<?php echo $item['shop_info']['english_name'];?>)<?php endif;?><?php endif;?>  </div>
			<div class="content"><a href="<?php echo view_tool::echo_isset($domain);?>/discount/<?php echo $item['id'];?>/" target＝"_blank" class=""><?php if(isset($item['clean_body']) && $item['clean_body'])  echo $item['clean_body'];?></a></div>
			<?php if(isset($item['pics_list']) && $item['pics_list']):?>
			<div class="pic_wrap">
				<?php foreach($item['pics_list'] as $k => $v):?>
				<?php if($k >= 7) break;?>
				<a target="_blank" href="<?php echo view_tool::echo_isset($domain);?>/discount/<?php echo $item['id'];?>/" target="_blank"><img rel="nofollow" alt="出国购物"  src="<?php echo $v;?>" width="80" height="80"></a>
				<?php endforeach;?>
			</div>
			<?php endif;?>
			<div class="site_info"><a href="<?php echo view_tool::echo_isset($domain);?>/discount/<?php echo $item['id'];?>/" target＝"_blank" class="fr">详细信息&nbsp;&nbsp;▶</a></div>
		</div>
	</div>
	<?endforeach;?>
	<?php if($page_cnt > 1):?>
	<div class="turn_page bottom_page" id="page_container">
		<a class="" node-type="page" action-type="changePageAdapter" href="javascript:void(0);" action-data="city=<?php echo $city_id;?>&shop_id=<?php echo $shop_id;?>&action=page&page=1">首页</a>
		<a class="" node-type="prev" action-type="changePageAdapter" href="javascript:void(0);" action-data="city=<?php echo $city_id;?>&shop_id=<?php echo $shop_id;?>&action=prev">上一页</a>
		<em><i node-type="show"><?php echo $page;?></i>/<i node-type="all"><?php echo $page_cnt;?></i></em>
		<a class="" node-type="next" action-type="changePageAdapter" href="javascript:void(0);" action-data="city=<?php echo $city_id;?>&shop_id=<?php echo $shop_id;?>&action=next">下一页</a>
		<a class="" node-type="page" action-type="changePageAdapter" href="javascript:void(0);" action-data="city=<?php echo $city_id;?>&shop_id=<?php echo $shop_id;?>&action=page&page=<?php echo $page_cnt;?>">末页</a>
	</div>
	<?php endif;?>
<?php endif;?>