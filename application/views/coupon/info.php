<div class="ZB_shop_content clearfix">
	<div class="ZB_bread_nav">
	<a href="<?php echo view_tool::echo_isset($domain);?>/"><?php echo $head_name;?></a><span class="">&gt;&gt;</span><a href="<?php echo view_tool::echo_isset($domain);?>/city/<?php echo $city_id;?>"><?php echo $city_name;?></a><span class="">&gt;&gt;</span>优惠券
	<!--<span class="">&gt;&gt;</span><a href="<?php echo view_tool::echo_isset($domain);?>/shop/<?php echo $shop_info['id'];?>"><?php echo $shop_info['name'];?></a><span class="">&gt;&gt;</span><?php if($coupon_info) echo $coupon_info['title'] ;else echo "优惠券";?>
	-->
	</div>

	<div class="shop_wrap fl">				
<?php
$uri = $_SERVER['REQUEST_URI'];
$source_url = $uri;
$source_url = urlencode($source_url);
?>
		<!--排序 -->
		<div class="order_wrap">
			<!-- 评价详情 -->
			<!--
			<div class="shop_header">
				<p><a href="<?php echo view_tool::echo_isset($domain);?>/shop/<?php echo $shop_info['id'];?>"><?php if($shop_info) echo $shop_info['name'];?></a></p>
			</div>
			-->
			<?php if($coupon_info['template_order'] ==1):?>

			<div class="coupon_print">
			
				<p class="title"><?php if($coupon_info) echo $coupon_info['title'];?></p>
				<?php if($img_size==0){
					$maxwidth = "371";
				}else{
					$maxwidth = "670";
				}
				$maxwidth = "670";
				?>

				<?php if($pics):?>
					预览图
					<?php foreach($pics as $pic):?>
					<?php $pic = str_replace("!300", "", $pic);?>
					
					<div><img rel="nofollow" alt="<?php if($coupon_info) echo $shop_info['name'];?>优惠券" style="max-width:<?php echo $maxwidth;?>px;" src="<?php echo $pic;?>"/></div>
					<br/>
					<?php endforeach;?>

				<?php endif;?>
				<?php if(!$login_type):?>
				<div class="btn_wrap"><a title="查看<?php if($coupon_info) echo $shop_info['name'];?>优惠券" href="<?php echo view_tool::echo_isset($domain);?>/callback/weibo/?source_url=<?php echo $source_url;?>" class="coupon_btn">查看优惠券(请登录新浪微博)</a></div>
				<?php else:?>
				<div class="btn_wrap"><a rel="nofollow" title="下载<?php if($coupon_info) echo $shop_info['name'];?>优惠券" href="<?php echo view_tool::echo_isset($domain);?>/coupon/download_coupon/?id=<?php echo $id;?>&shop_id=<?php echo $shop_id;?>" class="coupon_btn">下载优惠券</a> 
					<!---<a href="/coupon/print_coupon/?id=<?php echo $id;?>&shop_id=<?php echo $shop_id;?>" class="coupon_btn">打印优惠券并分享微博</a>
				-->
				<?php if($coupon_info['is_fav']):?>
				<div class="btn_wrap"><a title="收藏<?php if($coupon_info) echo $shop_info['name'];?>优惠券" href="javascript:;" action-type="unfav" action-data="id=<?php echo $coupon_info['id'];?>&type=1" class="coupon_btn">已收藏</a></div>
				<?php else:?>
				<div class="btn_wrap"><a title="收藏<?php if($coupon_info) echo $shop_info['name'];?>优惠券" href="javascript:;" action-type="fav" action-data="id=<?php echo $coupon_info['id'];?>&type=1" class="coupon_btn">收藏</a></div>
				<?php endif;?>
				</div>
				<?php endif;?>
				

				<div class="post_content"><?php if($coupon_info) echo nl2br($coupon_info['body']);?></div>




			</div>

			<?php else:?>

			<div class="coupon_print">
				<p class="title"><?php if($coupon_info) echo $coupon_info['title'];?></p>
				<div class="post_content"><?php if($coupon_info) echo nl2br($coupon_info['body']);?></div>

			<?php if(!$login_type):?>
			<div class="btn_wrap"><a title="查看<?php if($coupon_info) echo $shop_info['name'];?>优惠券" href="<?php echo view_tool::echo_isset($domain);?>/callback/weibo/?source_url=<?php echo $source_url;?>" class="coupon_btn">查看优惠券(请登录新浪微博)</a></div>
			<?php else:?>
			<div class="btn_wrap"><a rel="nofollow" title="下载<?php if($coupon_info) echo $shop_info['name'];?>优惠券" href="<?php echo view_tool::echo_isset($domain);?>/coupon/download_coupon/?id=<?php echo $id;?>&shop_id=<?php echo $shop_id;?>" class="coupon_btn">下载优惠券(<?php echo $coupon_info['download_count'];?>)</a> 
				<!---<a href="/coupon/print_coupon/?id=<?php echo $id;?>&shop_id=<?php echo $shop_id;?>" class="coupon_btn">打印优惠券并分享微博</a>
			-->
			<?php if($coupon_info['is_fav']):?>
			<div class="btn_wrap"><a title="收藏<?php if($coupon_info) echo $shop_info['name'];?>优惠券" href="javascript:;" action-type="unfav" action-data="id=<?php echo $coupon_info['id'];?>&type=1" class="coupon_btn">已收藏</a></div>
			<?php else:?>
			<div class="btn_wrap"><a title="收藏<?php if($coupon_info) echo $shop_info['name'];?>优惠券" href="javascript:;" action-type="fav" action-data="id=<?php echo $coupon_info['id'];?>&type=1" class="coupon_btn">收藏</a></div>
			<?php endif;?>
			</div>
			<?php endif;?>
			<?php if($img_size==0){
				$maxwidth = "371";
			}else{
				$maxwidth = "670";
			}
			$maxwidth = "670";
			?>

			<?php if($pics):?>
				预览图
				<?php foreach($pics as $pic):?>
				<?php $pic = str_replace("!300", "", $pic);?>
				
				<div><img rel="nofollow" alt="<?php if($coupon_info) echo $shop_info['name'];?>优惠券" style="max-width:<?php echo $maxwidth;?>px;" src="<?php echo $pic."!pingbody";?>"/></div>
				<br/>
				<?php endforeach;?>

			<?php endif;?>

			</div>
			<?php endif;?>
			<!-- /dayin -->
		</div>
		<!-- /排序 -->
		<!--

		-->
	</div>
	<div class="side_bar fr" id="side_bar">
		<?php if(isset($macys_html) && $macys_html) echo $macys_html;?>
		<div id='this_top'>
		<?php echo tool::isset_echo($recommend_shop_html);?>
		<?php echo tool::isset_echo($right_tips_html);?>
		
		</div>
		<?php if(isset($right_coupon_html) && $right_coupon_html) echo $right_coupon_html;?>
		<?php if(isset($ios_contact_html) && $ios_contact_html) echo $ios_contact_html;?>
	</div>
</div>