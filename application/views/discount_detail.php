<!-- 面包屑引导 -->
<div class="ZB_bread_nav">
	<a href="<?php echo view_tool::echo_isset($domain);?>/"><?php echo $head_name;?></a><span class="">&gt;&gt;</span>
	<?php if($city_name):?>
	<a href="<?php echo view_tool::echo_isset($domain);?>/city/<?php echo $city_id;?>"><?php echo $city_name;?></a><span class="">&gt;&gt;</span>
	<?php endif;?>
	<?php if($shop_name):?>
	<a href="<?php echo view_tool::echo_isset($domain);?>/shop/<?php echo $shop_id;?>"><?php echo $shop_name;?></a><span class="">&gt;&gt;</span>
	<?php endif;?>
	折扣详情
</div>
<!-- /面包屑引导 -->

<div class="ZB_shop_content clearfix">

	<div class="shop_wrap fl">

		<!-- 评价详情 -->
		<div class="comment_wrap">
			<!-- 晒单详情 -->
			<div class="comment clearfix">
				<div class="comment_info">
					<?php if(isset($discount_info['title']) && $discount_info['title']):?>
					<div class="title"><b><?php echo $discount_info['title'];?></b><?php if($discount_info['etime'] && $discount_info['etime'] < time()):?>(已过期)<?php endif;?></div>
					<?php endif;?>
					<div class="rating_wrap"></div>

<!-- 					<p class="slideup"></p>-->
					<br><div class="post_content"><?php echo $this->tool->clean_file_version($discount_info['body'],'!pingbody');?></div><br>
				</div>
				<!-- 发帖信息 -->
				<!--
				<div class="post_time textb">
					<span><?php echo date('Y-m-d H:i:s',$discount_info['ctime']);?></span>
				</div>
				-->
				<!-- /发帖信息-->
			</div>
			<!-- /晒单详情 -->

		</div>



		<!-- /评价详情 -->
	</div>

	<div class="side_bar fr">
		<?php if(isset($new_york_kits_html) && $new_york_kits_html) echo $new_york_kits_html;?>
		<?php if(isset($city_right_discount_html) && $city_right_discount_html) echo $city_right_discount_html;?>
		<?php if (isset($shop_right_discount_html) && $shop_right_discount_html) echo $shop_right_discount_html;?>
		<?php if(isset($macys_html) && $macys_html) echo $macys_html;?>
		<?php if (isset($nearby_shop_html) && $nearby_shop_html) echo $nearby_shop_html;?>
		<?php if(isset($ios_contact_html) && $ios_contact_html) echo $ios_contact_html;?>
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




