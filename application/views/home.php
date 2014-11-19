<div class="ZB_content ">
	<!-- 城市列表 -->
	<div class="ZB_index_title">
		<b>请选择你感兴趣的城市</b>
	</div>
	<div class="ZB_cities_wrap">

		<?php foreach($cities as $country=>$country_cities){?>
			<div class="ZB_cities clearfix">
				<div class="state_name <?php echo $country_code[$country];?>"></div>
				<div class="hidden_margin">
					<ul class="clearfix">
						<?php foreach($country_cities as $city){?>
						<li>
							<a href="<?php echo view_tool::echo_isset($domain);?>/city/<?php echo $city['id'];?>" target='_blank'><?php echo $city['name'];?></a>
						</li>
						<?php }?>
					</ul>
				</div>
			</div>
		<?php }?>
	</div>
	<!-- /城市列表 -->

	<!-- banner 此处node-type等属性与微公益线上模块保持一致 请王磊看看是否要保留-->
<!--	
	<div class="ZB_index_title">
		<b>活动信息</b>
	</div>
	<div class="ZB_banner clearfix" id="pl_index_banner">
		<ul class="banner_pic clearfix" node-type="slider" style="left: 0px; position: relative;">
			<?php for($i=0;$i<4;$i++){$each=isset($pics[$i])?$pics[$i]:array();$img=isset($each['img'])?$each['img']:'';$link=isset($each['link'])?$each['link']:'';?>
				<li action-type="pause" action-data="<?php echo $i;?>"><a href="<?php echo $link;?>" target="_blank"><img src="<?php echo $img;?>" width="940" title=""></a></li>
			<?php }?>
		</ul>
		<div class="banner_num clearfix">
			<ul class="fr clearfix" node-type="sliderDot">
				<li class=" cur"><a action-type="slideDot" action-data="page=0" class="dot" href="javascript:void(0);">•</a></li>
				<li class=" "><a action-type="slideDot" action-data="page=1" class="dot" href="javascript:void(0);">•</a></li>
				<li class=" "><a action-type="slideDot" action-data="page=2" class="dot" href="javascript:void(0);">•</a></li>
				<li class=" "><a action-type="slideDot" action-data="page=3" class="dot" href="javascript:void(0);">•</a></li>
			</ul>
		</div>
	</div>
-->	
	<!-- /banner -->

	<!-- bottom_suggest -->
	<div class="ZB_index_title">
		<br><b>最新点评/晒单</b>
	</div>
	<div class="ZB_bottom_suggest">
		<div class="hidden_margin clearfix">
			<?php foreach($hot_dianpings as $dianping){?>
			<div class="suggest_item">
				<?php if($dianping['has_pic']){?>
					<a href="<?php echo view_tool::echo_isset($domain);?>/ping/<?php echo $dianping['id'];?>" target="_blank" class="item_pic"><img rel="nofollow" src="<?php echo $this->tool->get_img($dianping['pic'],'homefeed');?>" height="252"/></a>
				<?php }?>
<!--				<div class="item_intro"><?php echo $this->tool->substr_cn2($dianping['clean_body'],30);?></div> -->
				<!-- 此处需要看需求是否保留 -->
<!--				<div class="response_wrap" style="display:none"> -->
<!-- 					<div class="response clearfix"> -->
<!-- 						<a href="" target="_blank" class="fl"><img src="../images/cities/newyork.jpg" width="30" height="30"/></a> -->
<!-- 						<a href="">用户</a><span>jfoejfioejfiowefjoifjio</span> -->
<!-- 					</div> -->
<!-- 					<div class="response clearfix"> -->
<!-- 						<a href="" target="_blank" class="fl"><img src="../images/cities/newyork.jpg" width="30" height="30"/></a> -->
<!-- 						<a href="">用户</a><span>jfoejfioejfiowefjoifjio积分基佛阿胶覅哦</span> -->
<!-- 					</div> -->
<!-- 				</div> -->
			</div>
			<?php }?>
		</div>
	</div>
	<!-- /bottom_suggest -->
</div>
