<div class="ZB_shop_content clearfix">
	<!-- 面包屑引导 -->
	<div class="ZB_bread_nav">
		<a href="<?php echo view_tool::echo_isset($domain);?>/"><?php echo $head_name;?></a><span class="">&gt;&gt;</span><a href="<?php echo view_tool::echo_isset($domain);?>/city/<?php echo $city_id;?>"><?php echo $city_name;?></a><span class="">&gt;&gt;</span><a href="javascript:;"><?php echo $shop['name'];?>购物</a>
	</div>
	<!-- /面包屑引导 -->

	<div class="shop_wrap fl">
		<!-- 商店详情 -->
		<div class="store">

			<!-- 商店信息 -->
			<div class="store_info clearfix">
				<div class="title"><span class="store_title" id="shop-name"><?php echo $shop['name'];?></span>
<!-- 					<a href="" class="linkb">其他分店<span class="moredown"></span></a> -->
				</div>
				<div class="fl store_pic" id="showImgPop" node-data="shop_id=<?php echo $shop['id'];?>">
					<a href="javascript:void(0);" target="_blank" class="zb_image_wrap"><img rel="nofollow" title="<?php echo $city_name;?>-<?php echo $shop['name'];?>" alt="<?php echo $city_name;?>-<?php echo $shop['name'];?>" src="<?php echo $this->tool->clean_file_version($shop['pic'],'!shoppic');?>" height="270" ></a>
				</div>
				<!-- 商店介绍 -->
				<div class="store_intro">
					<div class="title"><span class="store_title"><?php echo $shop['name'];?> 简介：</span></div>
					<div id="shop_intro" class="content textb">
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
					<p id="see_more" class="seemore"><a href="javascript:void(0);" class="linkb">展开更多</a></p>
					<?php if($have_brand){?>
					<div class="btn_wrap"><a href="<?php echo view_tool::echo_isset($domain);?>/brandstreet/<?php echo $shop['id'];?>" class="common_btn1">品牌列表</a></div>
					<?php }?>
				</div>
				<!-- /商店介绍 -->
			</div>
			<!-- 商店信息 -->
	  <?php $white_user = context::get("white_user", false);?>
      <?php if($white_user):?>
      <a target="_blank" href="<?php echo view_tool::echo_isset($domain);?>/shop/<?php echo $shop['id'];?>&print=1">打印</a>
      <?php endif;?>

			<!-- 点评 -->
			<div class="post clearfix">
				<div class="post_wrap fr">
					<a href="javascript: void(0);" id="showList" class="post_btn" node-data="shop_id=<?php echo $shop['id'];?>">点评/晒单</a>
					<?php if(0 && $have_brand){?>
					<a title="<?php echo $city_name;?>-<?php echo $shop['name'];?>-品牌列表" href="<?php echo view_tool::echo_isset($domain);?>/brandstreet/<?php echo $shop['id'];?>" class="post_btn">品牌列表</a>
					<?php }?>
				</div>
				<div class="rating_wrap"><div class="rating_wrap_big"><span title="<?php echo $shop['score'];?>星商户" class="star star<?php echo $shop['score'];?>0" ></span></div><span><a href="" class="linkb"><?php echo $total;?>条</a>点评</span></div>
				
				<?php if($shop['reserve_2']) { ?>
					<p><span class="textb">官网：</span><a title="<?php echo $city_name;?>-<?php echo $shop['name'];?>" target="_blank" href="<?php echo $shop['reserve_2'];?>">直达链接 > <span class="site_icon"></span></a></p>
				<?php }?>

				<?php if(isset($shop['reserve_3']) && $shop['reserve_3']):?><p><span class="textb">怎样到达：</span><?php echo $shop['reserve_3'];?></p><?php endif;?>
				<p><span class="textb">地址：</span><?php echo $shop['address'];?></p>
				<?php if($shop['property'] != 1)  {?>
					<p><span class="textb">营业时间：</span><?php echo $shop['business_hour'];?></p>
					<p><span class="textb">电话：</span><?php echo $shop['phone'];?></p>
				<?php }?>




			</div>
			<!-- /点评 -->


		</div>
		<?php if(isset($coupon_html) && $coupon_html):?>
			<?php echo $coupon_html;?>
		<?php endif;?>
		
		<!-- /商店详情 -->
		<!--折扣信息入口 -->

		<?php if(isset($discount_detail_html) && $discount_detail_html):?>
			<?php echo $discount_detail_html;?>
		<?php endif;?>

		<!--/折扣信息入口 -->
		<?php if($page_cnt):?>
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
		<!-- /评价详情 -->
	</div>

	<div class="side_bar fr">
		<!--  这里放地图-->
		<div class="right_block" id="show-detailmap" style="cursor:pointer">
			<div id="lat" style="display:none"><?php echo $lat?></div>
			<div id="lon" style="display:none"><?php echo $lon?></div>
			<div id="shop_name" style="display:none"><?php echo $shop['name'];?></div>
			<div id="shop_desc" style="display:none"><?php echo $shop['short_desc'];?></div>
			<div id="shop_address" style="display:none"><?php echo $shop['address'];?></div>
			<div id="map-canvas" style="height: 200px">
				<?php if(isset($shop['reserve_4']) && $shop['reserve_4']):?>
					<img rel="nofollow" alt="<?php echo $shop['name'];?>购物地图"  style="-webkit-user-select: none" src="<?php echo $shop['reserve_4'];?>">
				<?php else:?>
					<img rel="nofollow" alt="<?php echo $shop['name'];?>购物地图"  style="-webkit-user-select: none" src="http://ditu.google.cn/maps/api/staticmap?center=<?php echo $lon?>,<?php echo $lat?>&amp;zoom=13&amp;size=220x200&amp;maptype=roadmap&amp;markers=color:blue%7Clabel:o%7C<?php echo $lon?>,<?php echo $lat?>&amp;sensor=false">
				<?php endif;?>
			</div><br>
			<a href="javascript:void(0);">查看大图</a>
		</div>
		<!--  /这里放地图-->
		
		<?php if (isset($nearby_shop_html) && $nearby_shop_html) echo $nearby_shop_html;?>

		<?php if (isset($shoptips_html) && $shoptips_html) {
			echo $shoptips_html;
		}?>
		
		<!-- 折扣信息 -->
		<?php if(isset($discount_right_list_html) && $discount_right_list_html):?>
			<?php echo $discount_right_list_html;?>
		<?php endif;?>
		<!-- /折扣信息 -->

		<!-- 相关榜单 -->
		<div class="right_block">
			<div class="title">同区域内的热门商家</div>
			<ul class="suggest_list">
					<?php foreach($hot_shops as $id=>$shop){?>
					<li>
						  <a href="<?php echo view_tool::echo_isset($domain);?>/shop/<?php echo $id;?>" title="<?php echo $shop['name'];?>">
								·<?php echo $shop['name'];?>
						   </a>
					</li>
					<?php }?>
			</ul>
		</div>

		<?php if(isset($ios_contact_html) && $ios_contact_html) echo $ios_contact_html;?>
		
		<!-- /相关榜单 -->
	</div>
</div>



