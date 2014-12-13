
<div class="ZB_shop_content clearfix">
	<!-- 面包屑引导 -->
	<div class="ZB_bread_nav">
		<a href="<?php echo view_tool::echo_isset($domain);?>/"><?php echo $head_name;?></a><span class="">&gt;&gt;</span><a href="<?php echo view_tool::echo_isset($domain);?>/city/<?php echo $city_id;?>"><?php echo $city_name;?></a><span class="">&gt;&gt;</span><a href="javascript:;"><?php echo $shop['name'];?></a>
	</div>
	<!-- /面包屑引导 -->
	<div class="shop_wrap fl">
		<!-- 商店详情 -->
		<div class="store">
			<!-- 商店信息 -->
			<div class="store_info clearfix">
				<!-- 商店大图 -->
				<div class="fl store_pic" id="showImgPop" node-data="shop_id=<?php echo $shop['id'];?>">
					<a href="javascript:void(0);" target="_blank" class="zb_image_wrap"><img alt="<?php echo $city_name;?>-<?php echo $shop['name'];?>" src="<?php echo $this->tool->clean_file_version($shop['pic'],'!shoppic');?>" width="270" height="270" ></a>
					<a href="javascript:void(0);" class="more_img">更多图片</a>
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
					<div class="title"><span class="store_title" id="shop-name"><?php echo $shop['name'];?></span><a target="_blank" href="<?php echo $shop['reserve_2'];?>" class="official_website">官网</a></div>
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

					<p class="seemore" id="see_more"><a href="javascript:void(0);" class="more">更多<span class="moredown"></span></a></p>

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
					</div>
					<div class="post_wrap">
						<a href="javascript: void(0);" id="showList" class="post_btn fr" node-data="shop_id=<?php echo $shop['id'];?>" sl-processed="1">点评/晒单</a>
					</div>
				</div>
				<!-- /商店介绍 -->
			</div>
			<!-- 商店信息 -->
			<?php if(isset($shop['reserve_3']) && $shop['reserve_3']):?>
			<div class="other_info">
				
				<p class="traffic_info"><span class="fl textb">交通：</span><span class="left_border"><?php echo $shop['reserve_3'];?></span></p>
				
				<!--
				<p class="service_info clearfix">
					
					<a href="" class="print_icon fr"></a><span class="textb">服务:</span>
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
					</em>
					
				</p>
				-->
			</div>
			<?php endif;?>
			<!-- 点评 -->

			<?php if(isset($coupon_discount_html) && $coupon_discount_html) echo $coupon_discount_html;?>
			<div class="map_block">
			<img style="-webkit-user-select: none" src="http://ditu.google.cn/maps/api/staticmap?center=40.762321,-73.974849&amp;zoom=13&amp;size=640x640&amp;maptype=roadmap&amp;markers=color:red%7Clabel:o%7C40.762321,-73.974849&amp;sensor=false">
			</div>

			<?php if($show_brands_infos):?>
			<div class="post clearfix">
				<div class="brand_wall">
					<div class="hidden_margin">
						<div class="brand_list">
							<?php foreach($show_brands_infos as $brand):?>
							<a href=""><img src="<?php echo $brand['big_pic'];?>" alt="" width="98" height="50"/></a>
							<?php endforeach;?>
						</div>
					</div>
				</div>
			</div>
			<?php endif;?>

		</div>


	</div>
	<div class="side_bar fr">
		<?php if(isset($ios_contact_html) && $ios_contact_html) echo $ios_contact_html;?>
	</div>
</div>

