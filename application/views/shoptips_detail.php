<!-- 面包屑引导 -->
<div class="ZB_bread_nav">
	<a href="<?php echo view_tool::echo_isset($domain);?>/"><?php echo $head_name;?></a><span class="">&gt;&gt;</span>
	<?php if(!$discount_info['country']):?>
		<?php if($city_info):?><a href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $city_info['lower_name'];?>/"><?php echo $city_name;?>购物</a><span class="">&gt;&gt;</span><?php endif;?>
		<?php if($city_info):?>
		<a href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $city_info['lower_name'];?>-shoppingtips/"><?php echo $city_name;?>购物攻略</a><span class="">&gt;&gt;</span>
		<?php endif;?>
	<?php endif;?>
	<?php if(isset($discount_info['title']) && $discount_info['title']) echo $discount_info['title'];?>
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
					<div class="title" style="text-align:center;"><b><?php echo $discount_info['title'];?></b></div>
					<?php endif;?>
					<div class="rating_wrap"></div>
<!-- 					<p class="slideup"></p>-->
					<br><div class="post_content" onselectstart="return false"><?php echo str_replace("<div><b><br></b></div>", "", $shoptips_body); ?></div><br>
					<img src="http://zanbai.b0.upaiyun.com/2014/08/a4961ac611fe5e8a.jpg"/>
					<br>本文版权归属于赞佰网，转载请注明出处。

				</div>

				<div class="picMarquee-left">
				<div class="bd">
				<div class="tempWrap" style="overflow:hidden; position:relative; width:600px">
				<?php if($shops):?>
				相关商家:
				<ul class="picList" id="recommend_shop_list" style="width: 1420px; position: relative; overflow: hidden; padding: 0px; margin: 0px;">

				<?php $i=0;?>
				<?php foreach($shops as $v):?>
				<li class="clone" style="float: left; width: 130px;" <?php if($i>3):?>style="display: none;"<?php endif;?>>
				<div class="pic"><a href="<?php echo $v['ext']['shop_url'];?>" target="_blank"><img width="130" height="96" src="<?php echo $v['pic'];?>"></a></div>
				<div class="title"><a href="<?php echo $v['ext']['shop_url'];?>" target="_blank"><?php echo $v['name'];?></a></div>
				</li>
				<?php $i++;?>
				<?php endforeach;?>
				</ul>
				<?php endif;?>
				</div>
				</div>
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

			<!-- 用户评论 -->
			<div id="comment_content"></div>
			<div class="comment_title textb">
				<a href="javascript: void(0);" id="reply"></a>
			</div>
			<textarea class="send_textarea" id="ping_content"></textarea>
			<div class="btn_wrap">
				<a href="javascript: void(0);" id="send_ping" node-data="dianping_id=<?php echo $discount_info['id'];?>&type=1&uid=<?php $user_info=$this->session->userdata('user_info');echo $user_info['uid'];?>" class="post_btn">评论</a>
			</div>

			<!--
			<div class="tab clearfix" id="tab_container">
				<?php if($page_cnt > 1):?>
				<div class="fr turn_page" id="page_container">
					<a class="turn_left" node-type="prev" action-type="changePage" href="javascript:void(0);" action-data="dianping_id=<?php echo $discount_info['id'];?>&type=1&action=prev"></a>
					<em><i node-type="show"><?php echo $page;?></i>/<i node-type="all"><?php echo $page_cnt?$page_cnt:1;?></i></em>
					<a class="turn_right" node-type="next" action-type="changePage" href="javascript:void(0);" action-data="dianping_id=<?php echo $discount_info['id'];?>&type=1&action=next"></a>
				</div>
				<?php endif;?>

			</div>
			-->


			<!-- 评论列表 -->
			<div class="comment_lists" id="ping_comment_list">
			<?php echo $comment_list_html; ?>
			</div>

		</div>

		<div class="operate_box">
		<div class="pre_next_article">
		<?php if($pre_next['pre']):?>
		<span>上一篇<a class="a_underline" target="_blank" href="<?php echo view_tool::echo_isset($domain);?>/shoptipsinfo/<?php echo $pre_next['pre']['id'];?>/"><?php echo $pre_next['pre']['title'];?></a></span>
		<?php endif;?>
		<?php if($pre_next['next']):?>
		<span>下一篇<a class="a_underline" target="_blank" href="<?php echo view_tool::echo_isset($domain);?>/shoptipsinfo/<?php echo $pre_next['next']['id'];?>/"><?php echo $pre_next['next']['title'];?></a></span>	
		<?php endif;?>	
		</div>
		</div>




		<!-- /评价详情 -->
	</div>
	

	<div class="side_bar fr" id="side_bar">
		
		
		<?php if(isset($macys_html) && $macys_html) echo $macys_html;?>
		<div id='this_top'>
		<?php if(isset($right_tips_html) && $right_tips_html) echo $right_tips_html;?>
		<?php if(isset($recommend_shop_html) && $recommend_shop_html) echo $recommend_shop_html;?>
		<?php if(isset($right_relation_tips_html) && $right_relation_tips_html) echo $right_relation_tips_html;?>
		</div>
		<?php if(isset($ios_contact_html) && $ios_contact_html) echo $ios_contact_html;?>
		<?php if(isset($new_york_kits_html) && $new_york_kits_html) echo $new_york_kits_html;?>
	</div>

	<p class="nav-blog">
		<span class="prev-blog">
			<a href="<?php echo view_tool::echo_isset($domain);?>/shoptipsinfo/<?php echo $pre_next['pre']['id'];?>/" rel="prev" title="<?php echo $pre_next['pre']['title'];?>"><?php echo $pre_next['pre']['title'];?></a>
		</span>
		<span class="next-blog">
			<a href="<?php echo view_tool::echo_isset($domain);?>/shoptipsinfo/<?php echo $pre_next['next']['id'];?>/" rel="next" title="<?php echo $pre_next['next']['title'];?>"><?php echo $pre_next['next']['title'];?></a>
		</span>
	</p>

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



