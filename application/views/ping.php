<!-- 面包屑引导 -->
<div class="ZB_bread_nav">
	<a href="<?php echo view_tool::echo_isset($domain);?>/"><?php echo $head_name;?></a><span class="">&gt;&gt;</span><a href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $city_lower_name;?>/"><?php echo $city_name;?>购物</a><span class="">&gt;&gt;</span><?php echo $shop_name;?>
</div>
<!-- /面包屑引导 -->

<div class="ZB_shop_content clearfix">

	<div class="shop_wrap fl">
		<!-- 评价详情 -->
		<div class="comment_wrap" id="comment_list">
			<!-- 晒单详情 -->
			<div class="comment clearfix" >
				<div class="comment_info">
					<div class="title"><a href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $city_lower_name;?>/<?php echo $shop['id'];?>/"><b><?php echo $shop['name'];?></b></a></div>
					<div class="rating_wrap"><span class="rating_title">综合评分</span><div class="rating_wrap_small"><span title="<?php echo $dianping['score'];?>星商户" class="star star<?php echo $dianping['score'];?>0" ></span></div><?php echo $dianping['score'];?>分</div>
<!-- 					<p class="slideup"></p>							 -->
					<br><div class="post_content">
					<?php 
					$tmp_content = $this->tool->clean_file_version($dianping['body'],'!pingbody');
					$tmp_content = str_replace("<img", "<img rel='nofollow' action-type='show_big_img'", $tmp_content);
					echo $tmp_content;
					?>
					</div><br>
				</div>
				<!-- 发帖信息 -->
				<div class="post_time textb">
					<span><?php //echo date('Y-m-d H:i:s',$dianping['ctime']);?></span>
				</div>

				<!-- /发帖信息-->
			</div>
			<!-- /晒单详情 -->

			<!-- 用户评论 -->
			<div class="comment_title textb" >
				<?php if(isset($this->session->userdata['user_info']['uid']) && $this->session->userdata['user_info']['uid'] == $dianping['uid']) {?>
					<a href="javascript:void(0);" action-type="modifyDianping" id="modifyDianping" action-data="id=<?php echo $dianping['id']?>" >编辑</a>|
					<a href="javascript:void(0);" action-type="delDianping" id="delDianping" action-data="id=<?php echo $dianping['id']?>" >删除</a>|
				<?php }?> 
		    	
				<a href="javascript: void(0);" id="reply">回复楼主</a>
			</div>
			<div id="comment_content"></div>


			<textarea class="send_textarea" id="ping_content"></textarea>
			<div class="btn_wrap"><a href="javascript: void(0);" id="send_ping" node-data="dianping_id=<?php echo $dianping['id'];?>&shop_id=<?php echo $dianping['shop_id'];?>&uid=<?php $user_info=$this->session->userdata('user_info');echo $user_info['uid'];?>" class="post_btn">发送</a></div>

			<!-- 翻页 -->
			<!--
			<div class="tab clearfix" id="tab_container">
				<?php if($page_cnt > 1):?>
				<div class="fr turn_page" id="page_container">
					<a class="turn_left" node-type="prev" action-type="changePage" href="javascript:void(0);" action-data="dianping_id=<?php echo $dianping['id'];?>&shop_id=<?php echo $dianping['shop_id'];?>&action=prev"></a>
					<em><i node-type="show"><?php echo $page;?></i>/<i node-type="all"><?php echo $page_cnt?$page_cnt:1;?></i></em>
					<a class="turn_right" node-type="next" action-type="changePage" href="javascript:void(0);" action-data="dianping_id=<?php echo $dianping['id'];?>&shop_id=<?php echo $dianping['shop_id'];?>&action=next"></a>
				</div>
				<?php endif;?>
			</div>
			-->
			<!-- /翻页 -->

			<!-- 评论列表 -->

			<div class="comment_lists" id="ping_comment_list">
			<?php echo $comment_list_html; ?>
			</div>
			<!-- /评论列表 -->
			<!-- /用户评论-->

			<div class="picMarquee-left">
			<div class="bd">
			<div class="tempWrap" style="overflow:hidden; position:relative; width:600px; margin-left:30px;">
			其它晒单:
			<ul class="picList" id="recommend_shop_list" style="width: 1420px; position: relative; overflow: hidden; padding: 0px; margin: 0px;">
			<?php if($all_pics):?>
			<?php $i=0;?>
			<?php foreach($all_pics as $k => $v):?>
			<?php foreach($v as $item):?>
			<li class="clone" style="float: left; width: 130px;" <?php if($i>3):?>style="display: none;"<?php endif;?>>
			<div class="pic"><a href="<?php echo view_tool::echo_isset($domain);?>/ping/<?php echo $k;?>/" target="_blank"><img width="130" height="96" src="<?php echo $item.'!shopviewlist';?>"></a></div>
			</li>
			<?php $i++;?>
			<?php endforeach;?>
			<?php endforeach;?>
			<?php endif;?>
			</ul></div>
			</div>
			</div>

			<div class="operate_box">




			<!--
			<div class="pre_next_article">
			<?php if($pre_next['pre']):?>
			<span>上一篇<a class="a_underline" target="_blank" href="<?php echo view_tool::echo_isset($domain);?>/ping/<?php echo $pre_next['pre']['id'];?>/">
				<?php 
				if(trim($pre_next['pre']['clean_body'])){
					echo tool::substr_cn2(trim($pre_next['pre']['clean_body']), 50);
				}else{
					echo "图片列表";
				}
				?>
			</a></span>
			<?php endif;?>
			<?php if($pre_next['next']):?>
			<span>下一篇<a class="a_underline" target="_blank" href="<?php echo view_tool::echo_isset($domain);?>/ping/<?php echo $pre_next['next']['id'];?>/">
				<?php 
				if(trim($pre_next['next']['clean_body'])){
					echo tool::substr_cn2(trim($pre_next['next']['clean_body']), 50);
				}else{
					echo "图片列表";
				}
				?>

			</a></span>	
			<?php endif;?>	
			</div>-->
			</div>


		</div>
<!--
		<div class="ZB_nav ">
		<ul class="clearfix">
		<li><a href="" target="_blank">更多攻略</a></li>
		<li><a href="" target="_blank">其他城市【纽约 首尔 洛杉矶】</a></li>
		<li><a href="" target="_blank">更多商家</a></li>
		</ul>
		</div>
	-->

		<!-- /评价详情 -->
	</div>

	<div class="side_bar fr">
		<!--  这里放地图-->
		
		<?php if(isset($right_user_html) && $right_user_html) echo $right_user_html;?>
		<?php if(isset($macys_html) && $macys_html) echo $macys_html;?>
		<!--  /这里放地图-->
		<?php if(isset($city_right_discount_html) && $city_right_discount_html) echo $city_right_discount_html;?>
		<?php if(isset($right_discount_html) && $right_discount_html) echo $right_discount_html;?>
		
		
		<?php if(isset($right_tips_html) && $right_tips_html) echo $right_tips_html;?>
		<?php if(isset($right_pinglist_html) && $right_pinglist_html) echo $right_pinglist_html;?>

		

		<?php if(isset($nearby_shop_html) && $nearby_shop_html) echo $nearby_shop_html;?>

		<?php if(isset($ios_contact_html) && $ios_contact_html) echo $ios_contact_html;?>
		
		<!-- /相关榜单 -->
	</div>



		
	<p class="nav-blog">
		<?php if($pre_next['pre']):?>
		<?php 
		if(trim($pre_next['pre']['clean_body'])){
			$pre_body = tool::substr_cn2(trim($pre_next['pre']['clean_body']), 50);
		}else{
			$pre_body = "图片列表";
		}
		?>
		<span class="prev-blog">
			<a href="<?php echo view_tool::echo_isset($domain);?>/ping/<?php echo $pre_next['pre']['id'];?>/" rel="prev" title="<?php echo $pre_body;?>">
				<?php echo $pre_body;?>
			</a>
		</span>
		<?php endif;?>
		<?php if($pre_next['next']):?>
		<?php 
		if(trim($pre_next['next']['clean_body'])){
			$next_body = tool::substr_cn2(trim($pre_next['next']['clean_body']), 50);
		}else{
			$next_body = "图片列表";
		}
		?>
		<span class="next-blog">
			<a href="<?php echo view_tool::echo_isset($domain);?>/ping/<?php echo $pre_next['next']['id'];?>/" rel="next" title="<?php echo $next_body;?>">
				<?php echo $next_body;?>
			</a>
		</span>
		<?php endif;?>
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


