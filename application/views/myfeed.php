<div class="ZB_shop_content clearfix">
			<div class="shop_wrap fl">

				<!-- tab -->
				<!--<div class="tab">
					<div class="fr turn_page">
						<a class="turn_left" href=""></a>
						<em>1/<?php echo $cnt?$cnt:1;?></em>
						<a class="turn_right" href=""></a>
					</div>
					<p class="title"><b>用户的全部点评/晒单</b></p>
				</div>-->

				<div class="tab" id="tab_container">
					<div class="fr turn_page" id="page_container">
						<a class="turn_left" node-type="prev" action-type="changePage" href="javascript:void(0);" action-data="uid=<?php echo $user_info['uid'];?>&action=prev&type=myfeed"></a>
						<em><i node-type="show"><?php echo $page;?></i>/<i node-type="all"><?php echo $page_cnt;?></i></em>
						<a class="turn_right" node-type="next" action-type="changePage" href="javascript:void(0);" action-data="uid=<?php echo $user_info['uid'];?>&action=next&type=myfeed"></a>
					</div>
					<p class="title"><b>关注人的最新晒单</b></p>
				</div>

				<!-- /tab -->

				<!-- 评价详情 -->
				<div class="comment_wrap" id="comment_list">
					<?php echo $dianping_html;?>
				</div>
				<!-- /评价详情 -->
			</div>

			<div class="side_bar fr">
				<!--  用户信息-->
				<?php if(isset($right_user_html) && $right_user_html) echo $right_user_html;?>
				<!--  /用户信息-->
				<?php if(isset($macys_html) && $macys_html) echo $macys_html;?>
				<!-- 相关榜单 -->
				<!-- <div class="right_block">
					<div class="title">看过这家店的人还看过</div>
					<ul class="other_list">
<!-- 							<li> -->
<!-- 								  <a href="" title="猫总的北京火锅之选"> -->
<!-- 										·猫总的北京火锅之选 -->
<!-- 								   </a> -->
<!-- 								   <div class="rating_wrap"><div class="rating_wrap_small"><span title="5星商户" class="star star50" ></span></div><a href="" class="linkb">1231条</a>评论</div> -->
<!-- 							</li>	 -->
					<!-- </ul>
				</div>
				<!-- /相关榜单 -->

				<!-- 相关榜单 -->
				<!-- <div class="right_block">
					<div class="title">相关榜单</div>
					<ul class="suggest_list">
<!-- 							<li> -->
<!-- 								  <a href="" title="猫总的北京火锅之选"> -->
<!-- 										·猫总的北京火锅之选 -->
<!-- 								   </a> -->
<!-- 							</li> -->
					<!-- </ul>
				</div>
				<!-- /相关榜单 -->
			</div>
		</div>
