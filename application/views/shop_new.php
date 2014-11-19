
<div class="ZB_shop_content clearfix">
	<!-- 面包屑引导 -->
	<div class="ZB_bread_nav">
		<a href="<?php echo view_tool::echo_isset($domain);?>/">赞佰</a><span class="">&gt;&gt;</span><a href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $city_lower_name;?>/"><?php echo $city_name;?>购物</a><span class="">&gt;&gt;</span><?php echo $shop['name'];?>
	</div>
	<!-- /面包屑引导 -->
	<div class="shop_wrap fl">
		<!-- 商店详情 -->
		<div class="store">
			<!-- 商店信息 -->
			<div class="store_info clearfix" id="shop_info">
				<!-- 商店大图 -->
				<div class="fl store_pic" >
					<div id="showImgPop" node-data="shop_id=<?php echo $shop['id'];?>">
					<a href="javascript:void(0);" target="_blank" class="zb_image_wrap"><img rel="nofollow" alt="<?php echo $city_name;?>-<?php echo $shop['name'];?>" src="<?php echo $this->tool->clean_file_version($shop['pic'],'!shoppic');?>" width="270" height="270" ></a>
					<a href="javascript:void(0);" class="more_img">更多图片</a>
					</div>
					<?php if( $shop['pdf_file'] ):?>
						<a rel="nofollow" title="下载PDF版<?php echo $shop['name'];?>" href="<?php echo view_tool::echo_isset($domain);?>/shop/download/?shop_id=<?php echo $shop['id'];?>" class="print_icon"></a>
					<?php endif;?>
				</div>


				<!-- /商店大图 -->
				<!-- 商店介绍 -->
				<div class="store_intro">
					<!-- 顶部评分栏 -->
					<div class="header_rating clearfix">
						<div class="fr rating_wrap"><div class="rating_wrap_small"><span title="<?php echo $shop['score'];?>星商户" class="star star<?php echo $shop['score'];?>0"></span></div>
						</div>
					</div>
					<!-- /顶部评分栏 -->
					<!-- 详细介绍 -->
					<div class="title"><span class="store_title" id="shop-name"><?php echo $shop['name'];?></span><?php if($shop['reserve_2']):?><a target="_blank" href="<?php echo $shop['reserve_2'];?>" class="official_website" title="<?php if(isset($country_name)) echo $country_name;?><?php echo $city_name.$shop['name'];?>官网">官网</a><?php endif;?></div>
					<?php if($shop['name'] != $shop['english_name']):?>
					<div class="title"><span style="font-size:13px;" id="shop-name"><?php echo $shop['english_name'];?></span></div>
					<?php endif;?>

					<div class="content textb" id="shop_intro">
						<?php
						$desc = $shop['desc'];
						$content_bl2br = nl2br($shop['desc']);
						$tmp_desc = explode("<br />", $content_bl2br);
						foreach($tmp_desc as $v){
							$v = trim($v," ");
							if($v){
								echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$v."<br />";
							}
						}
						?>
					</div>

					<p class="seemore" id="see_more" style="display:none;"><a href="javascript:void(0);" class="more">更多<span class="moredown"></span></a></p>

					<?php if($shop_tag):?>
					<div class="tag_wrap">
						<span class="fl">标签:&nbsp;</span><em class="left_border">
						<?php foreach($shop_tag as $tag_item):?>
						<span class="tag_icon"><?php echo $tag_list[$tag_item]['name'];?></span>
						<?php endforeach;?>
						</em>
					</div>
					<?php endif;?>

					<div class="shop_info">
						<p><span class="fl textb">地址：</span><span class="left_border"><?php echo $shop['address'];?></span></p>
						<?php if($shop['property'] != 1):?>
						<p><span class="fl textb">营业时间：</span><span class="left_border"><?php echo $shop['business_hour'];?></span></p>
						<?php endif;?>
						<?php if($shop['have_directions'] || $shop['reserve_3']):?>
						<?php if($shop['reserve_3']):?>
						<p class="margin_top"><a href="javascript:;" action-type="direction_more"><span class="toggle-text">怎样到达</span><span class="arrow_down"></span></a></p>
						<div class="desc_list" style="display:none;">
						<ul>
						<li>
							<em class="tit">地铁：</em><span><?php echo $shop['reserve_3'];?></span>
						</li>
						<ul>
						</div>
						<?php else:?>
						<p class="margin_top"><a href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $shop['lower_name'];?>/directions/"><span class="toggle-text">怎样到达</span><span class="arrow_right"></span></a></p>
						<?php endif;?>
						<?php endif;?>
					</div>

					<div class="post_wrap">
						<?php if($shop['is_fav']):?>
						<a href="" class="disable_btn" action-type="unfav" action-data="id=<?php echo $shop['id'];?>&type=0">已收藏</a>
						<?php else:?>
						<a href="" class="favor_btn" action-type="fav" action-data="id=<?php echo $shop['id'];?>&type=0">收藏</a>
						<?php endif;?>
						<a href="javascript: void(0);" id="showList" class="post_btn fr" node-data="shop_id=<?php echo $shop['id'];?>" sl-processed="1">点评/晒单</a>
					</div>
				</div>
				<!-- /商店介绍 -->
			</div>
			<!-- 商店信息 -->
			<?php if( 0 && $shop['pdf_file']):?>
			<div class="other_info">
				<?php if( $shop['pdf_file'] ):?>
				<p class="service_info clearfix"><a rel="nofollow" title="下载PDF版<?php echo $shop['name'];?>" href="<?php echo view_tool::echo_isset($domain);?>/shop/download/?shop_id=<?php echo $shop['id'];?>" class="print_icon fr"></a>
				<?php endif;?>
					<!--<span class="textb">服务:</span>
					<em class="service_warp">
						<span class="icon_services icon_dollar"></span>
						<span class="icon_services icon_wifi"></span>
						<span class="icon_services icon_power"></span>
						<span class="icon_services icon_exchange"></span>
						<span class="icon_services icon_disabled"></span>
						<span class="icon_services icon_help"></span>
					</em>
					<span class="textb">分享:</span>
					<em class="share_warp">
						<span class="icon_share icon_weibo"></span>
						<span class="icon_share icon_Qzone"></span>
						<span class="icon_share icon_renren"></span>
					</em>-->
				<!--</p>-->
			</div>
			<?php endif;?>
			<!-- 点评 -->
			<?php if($show_brands_infos):?>
			<div class="post clearfix">
				<div class="brand_wall">
					<div class="hidden_margin">
						<div class="brand_list">
							<?php foreach($show_brands_infos as $brand):?>
							<a href="<?php echo view_tool::echo_isset($domain);?>/brandstreet/<?php echo $shop['id'];?>" title="<?php echo $shop['name'];?>品牌墙"><img rel="nofollow" src="<?php echo $brand['big_pic'];?>" alt="" width="98" height="50"/></a>
							<?php endforeach;?>
						</div>
					</div>
					<p class="more_brand"><a href="<?php echo view_tool::echo_isset($domain);?>/brandstreet/<?php echo $shop['id'];?>" title="<?php echo $shop['name'];?>品牌墙" >更多品牌列表</a></p>
				</div>
			</div>
			<?php endif;?>
			
			<!-- /点评 -->					
		</div>
		<!-- /商店详情 -->
		<?php if(isset($coupon_discount_html) && $coupon_discount_html) echo $coupon_discount_html;?>

		<!--/折扣信息入口 -->
		<?php if($page_cnt > 1):?>
		<!--排序 -->
		<div class="order clearfix">

			<div class="fr turn_page" id="page_container">
				<a class="" node-type="page" action-type="changePage" href="javascript:void(0);" action-data="shop_id=<?php echo $shop['id'];?>&action=page&page=1">首页</a>
				<a class="" node-type="prev" action-type="changePage" href="javascript:void(0);" action-data="shop_id=<?php echo $shop['id'];?>&action=prev">上一页</a>
				<em><i node-type="show"><?php echo $page;?></i>/<i node-type="all"><?php echo $page_cnt?$page_cnt:1;?></i></em>
				<a class="" node-type="next" action-type="changePage" href="javascript:void(0);" action-data="shop_id=<?php echo $shop['id'];?>&action=next">下一页</a>
				<a class="" node-type="page" action-type="changePage" href="javascript:void(0);" action-data="shop_id=<?php echo $shop['id'];?>&action=page&page=<?php echo $page_cnt;?>">末页</a>
			</div>
<!-- 			<div class="order_list"><b>排序方式:</b><span class="input"><a class="arrowdown fr" href=""></a><em>最近点评</em></span> -->
<!--				<ul class="order_slide" style="display:none;"> -->
<!-- 					<li><a href="">最早点评</a></li> -->
<!-- 					<li><a href="">鲜花数</a></li> -->
<!-- 					<li><a href="">会员级别</a></li> -->
<!-- 				</ul> -->
<!-- 			</div> -->
		</div>
		<!-- /排序 -->
		<?php endif;?>
		<!-- 评价详情 -->
		<div class="comment_wrap" id="comment_list">
			<?php echo $shaidan_list_html; ?>
		</div>
	</div>
	<div class="side_bar fr"  id="side_bar">
		<div class="right_block np" id="show-detailmap" style="cursor:pointer">
			<div id="lat" style="display:none"><?php echo $lat?></div>
			<div id="lon" style="display:none"><?php echo $lon?></div>
			<div id="shop_name" style="display:none"><?php echo $shop['name'];?></div>
			<div id="shop_desc" style="display:none"><?php echo $shop['short_desc'];?></div>
			<div id="shop_address" style="display:none"><?php echo $shop['address'];?></div>
			<div id="map-canvas" class="map_canvas" style="height: 200px">
				<?php if(isset($shop['reserve_4']) && $shop['reserve_4']):?>
					<img rel="nofollow" alt="<?php echo $shop['name'];?>购物地图"  style="-webkit-user-select: none" src="<?php echo upimage::format_brand_up_image($shop['reserve_4']);?>">
				<?php else:?>
					<img rel="nofollow" alt="<?php echo $shop['name'];?>购物地图"  style="-webkit-user-select: none" src="http://ditu.google.cn/maps/api/staticmap?center=<?php echo $lon?>,<?php echo $lat?>&amp;zoom=13&amp;size=220x200&amp;maptype=roadmap&amp;markers=color:blue%7Clabel:o%7C<?php echo $lon?>,<?php echo $lat?>&amp;sensor=false">
				<?php endif;?>
			</div>
			<div class="map_control clearfix">
				<a href="javascript:void(0);">查看大图</a>
			</div>
		</div>
		<?php if(isset($macys_html) && $macys_html) echo $macys_html;?>
		<div id='this_top'>
		<?php if (isset($nearby_shop_html) && $nearby_shop_html) echo $nearby_shop_html;?>
		<?php if (isset($shoptips_html) && $shoptips_html) echo $shoptips_html;?>
		</div>
		<?php if (isset($discount_right_list_html) && $discount_right_list_html) echo $discount_right_list_html;?>
		<?php if(isset($ios_contact_html) && $ios_contact_html) echo $ios_contact_html;?>
		<?php if(isset($recommend_shop_html) && $recommend_shop_html) echo $recommend_shop_html;?>

		<div class="goToTop" id="goToTop" style="position: fixed;bottom: 100px;display:none;">
		    <a class="toTop" href="javascript:void(0)"></a>
		</div>
	</div>
</div>



<!-- JiaThis Button BEGIN -->
<script type="text/javascript">
var jiathis_config={
	data_track_clickback:true,
	siteNum:5,
	sm:"tsina,weixin,qzone,tqq,douban",
	title: "<?php echo $share_content;?>",
	url: "<?php echo $share_url;?>",
	pic:'<?php echo $share_img;?>',
	appkey:{
		"tsina":"3809461175"
	},
	summary:"",
	showClose:false,
	shortUrl:true,
	hideMore:true
}
</script>
<script type="text/javascript" src="http://v3.jiathis.com/code/jiathis_r.js?move=0&amp;uid=1375424008234667" charset="utf-8"></script>
<!-- JiaThis Button END -->



