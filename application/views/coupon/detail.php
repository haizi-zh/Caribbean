<div class="ZB_guide clearfix" id="shop_content">
	<div class="ZB_bread_nav">
		<a href="<?php echo view_tool::echo_isset($domain);?>/"><?php echo $head_name;?></a><span class="">&gt;&gt;</span><?php echo $coupon_info['title'];?>
	</div>

	<div class="side_bar fl" id="side_bar">
		<div class="right_block">
			<div class="erweima_area">
			    <img style="display:block;margin:0 auto 5px;"  src="<?php echo upimage::format_brand_up_image($guide_img,'!shoppic');?>" height="280" width="200">
			</div>
		</div>

		<img src="http://zanbai.b0.upaiyun.com/2014/09/255c48df18ec3c63.jpg" width="230" />
		<div class="right_block">
			<img src="http://zanbai.b0.upaiyun.com/2014/09/e3948a7db9575b07.jpg" />
		</div>
		<!-- /相关榜单 -->
	</div>

	<div class="guide_contnt fr">

		<div class="shop_list clearfix" id="shop_list">
			<!-- 商家的信息和评论列表-->
			<div class="guide_desc">
				<div><span>名称：</span><?php echo $coupon_info['title'];?></div>
				<div><span>文件大小：</span><?php echo $desc['size'];?></div>
				<div><span>页数：</span><?php echo $desc['page'];?>页</div>
				<div><span>更新日期：</span><?php echo $desc['time'];?></div>

				<div>下载次数:<?php echo $coupon_info['download_count'];?></div>
			</div>
			<div style="width:100%;margin-top:20px;padding-bottom:15px;border-bottom:1px solid #e0e0e0;">
				<a href="https://itunes.apple.com/cn/app/zan-bai-wang-chu-jing-gou/id774874759?mt=8#"><span class="btn_grey">下载IOS客户端</span></a>
				<a rel="nofollow" href="/coupon/download_coupon/?id=<?php echo $guide_id;?>"><span class="btn_grey">下载PDF版购物锦囊</span></a>
			</div>
			
			<?php if($more_guide):?>
			<div style="margin:20px;width:100%;height:250px;">
				<div>其他购物锦囊</div>
				<div>
					<?php foreach($more_guide as $guide):?>
					<a href="<?php echo view_tool::echo_isset($domain);?>/guide/<?php echo $guide['id'];?>/">
					<span style="float:left;width:48%;text-align:center;">
					<img src="<?php echo $guide['pics_list'][0];?>" width="150" height="210" />
					<h2><?php echo $guide['title'];?></h2>
					</span>
					</a>
					<?php endforeach;?>
				</div>
			</div>
			<?php endif;?>


			<div style="border-top:1px solid #e0e0e0;">

			<div class="comment_title mt30" id="comment_content" >
			<a href="javascript:void(0)" data-bn-ipg="27-1">评论</a>
			</div>

			<textarea class="send_textarea" id="ping_content"></textarea>
			<div class="btn_wrap">
				<a href="javascript: void(0);" id="send_ping" node-data="dianping_id=<?php echo $guide_id;?>&type=2&uid=<?php echo $vuid;?>" class="post_btn">评论</a>
			</div>
			<div class="comment_lists" id="ping_comment_list">
				<?php echo $comment_list_html;?>
			</div>

			</div>
		</div>



	</div>
</div>
