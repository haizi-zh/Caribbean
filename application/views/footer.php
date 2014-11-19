	<!-- 底导 -->
	<div class="footer">
		<div class="foot_con">

			<div class="f_list">
				<h4>关于我们</h4>	
				<ul>
					<li><a href="<?php echo view_tool::echo_isset($domain);?>/help/1/" target="_blank">关于赞佰</a></li>
					<li><a href="<?php echo view_tool::echo_isset($domain);?>/help/2/" target="_blank">联系我们</a></li>
					<li><a href="<?php echo view_tool::echo_isset($domain);?>/help/3/" target="_blank">服务条款</a></li>

				</ul>
			</div>
			<div class="f_list">
				<h4>用户帮助</h4>			
				<ul>
					<li><a href="<?php echo view_tool::echo_isset($domain);?>/sitemap/" target="_blank">网站地图</a></li>
					<li><a href="<?php echo view_tool::echo_isset($domain);?>/feedback/" target="_blank">意见反馈</a></li>
					<li><a href="<?php echo view_tool::echo_isset($domain);?>/links/" target="_blank">友情链接</a></li>
				</ul>
			</div>
			
			<div class="f_list">
				<h4>关注我们</h4>
				<ul>
				<li class="sina_attention">
				<a href="http://www.weibo.com/zanbaiwb/" target="_blank"><span class="icon_list icon_weibo">&nbsp;</span>新浪微博</a>			
				</li>
				<li><a href="http://t.qq.com/zanbaiqianhua" target="_blank"><span class="icon_list icon_qweibo">&nbsp;</span>腾讯微博</a></li>
				<li><a href="http://www.douban.com/people/70076907/" target="_blank"><span class="icon_list icon_dou">&nbsp;</span>豆瓣</a></li>	
				</ul>
			</div>
			<div class="f_list qr-code">
				<h4>赞佰订阅号</h4>
				<img src="http://img3.zanbai.com/2014/07/2c1363e39a4eaaf8.jpg!300n" alt="赞佰订阅号二维码">
			</div>
			<div class="f_list ios-code">
				<h4>苹果APP</h4>
				<a href="https://itunes.apple.com/cn/app/zan-bai-wang-chu-jing-gou/id774874759?mt=8#" title="赞佰苹果APP" target="_blank">
				<img src="http://zanbai.b0.upaiyun.com/2014/09/89b27a6ff6087a67.png!300n" alt="赞佰苹果APP">
				</a>
			</div>


			<!--
			<div class="f_list weixin_code">
				<h4>赞佰客户端下载</h4>
				<a class="client_pic" href="https://itunes.apple.com/cn/app/zan-bai-wang-chu-jing-gou/id774874759?mt=8#" target="_blank"></a>
			</div>-->
			<div class="clear_f"></div>
			
			<div class="record">北京赞佰千华网络科技有限公司 京ICP备13005904号 京公网安备11010802010914 Copyright © 2014-ZANBAI</div>
		</div>

	</div>


	<!-- /底导 -->
	<?php if(!isset($top_area_cities) || !$top_area_cities):?>
	<?php
	$top_area_cities = context::get("area_cities", array());
	$country_code = context::get("country_code", array());
	?>
	<?php endif;?>
	<!-- 城市选择弹层-->
	<div class="ZB_cities_layer" style="display:none" id="zb-city-layer">
		<?php if(isset($top_area_cities) && $top_area_cities):?>
		<div class="ZB_cities_wrap">
			<?php foreach($top_area_cities as $country=>$country_cities){?>
				<div class="ZB_cities clearfix">
					<div class="state_name <?php echo $country_code[$country];?>"></div>
					<div class="hidden_margin">
						<ul class="clearfix">
							<?php foreach($country_cities as $city){?>
							<li>
								<a href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $city['lower_name'];?>/"><?php echo $city['name'];?></a>
							</li>
							<?php }?>
						</ul>
					</div>
				</div>
			<?php }?>
		</div>
		<?php endif;?>

	</div>
	<!-- /城市选择弹层-->


</div>
<?php 
$close_app_pop = context::get("close_app_pop", 0);
?>
<div id="popfloating_float_level" style="display: block;<?php if($close_app_pop==1):?>display:none;<?php endif;?>">
	<div class="app_wrap_pop">
		<div class="app_wrap_pop_box">
			<a href="javascript:;" id="floating_app_close" class="app_wrap_pop_close" title="关闭">×</a>
			<a href="https://itunes.apple.com/cn/app/zan-bai-wang-chu-jing-gou/id774874759?mt=8#" target="_blank" title="赞佰苹果APP">
			<img src="http://zanbai.b0.upaiyun.com/2014/09/89b27a6ff6087a67.png!300n" width="180" height="200" alt="赞佰苹果APP" />		
			</a>
			<div class="app_wrap_pop_text">
				<p class="app_wrap_pop_t">微信号<strong>zanbai</strong></p>
				<p class="app_wrap_pop_c">关注<span>即有机会参加抽奖活动</span></p>
			</div>
			<div class="app_wrap_pop_cont">
				<div class="app_wrap_pop_code">
					<img alt="关注微信抽奖" id="popfloating_float_img" src="http://zanbai.b0.upaiyun.com/2014/09/57dc614c8825d199.jpg!300n">
				</div>
			</div>
		</div>
		<div class="app_wrap_pop_collect">收藏zanbai.com，以便下次快速访问<a href="javascript:;" id="favorites" class="app_wrap_pop_s_btn">点击收藏</a></div>
	</div>
</div>



<?php
$js_version = context::get('js_version', '');
$js_domain = context::get('js_domain', '');
$css_domain = context::get('css_domain', '');
$tj_domain = context::get('tj_domain', '');
$use_fe = context::get('use_fe', '');
$tj = context::get('tj', '');
?>
<?php if($use_fe):?>

<script type="text/javascript">
    require('<?php echo $pageid?>/main');
</script>

<?php else:?>

<script src="<?php echo $js_domain;?>/js/Lilac.js?version=<?php echo $js_version;?>" type="text/javascript"></script>
<?php if(isset($jsplugin_list) && !empty($jsplugin_list)){ foreach($jsplugin_list as $each){?>
	<script src="<?php echo $js_domain;?>/js/plugins/Lilac.<?php echo $each?>.js?version=<?php echo $js_version;?>" type="text/javascript"></script>
<?php }}?>
<script src="<?php echo $js_domain;?>/js/common.js?version=<?php  echo $js_version;?>" type="text/javascript"></script>

<?php if(isset($page_js)):?>
<script src="<?php echo $js_domain;?>/js/<?php  echo $page_js?>.js?version=<?php  echo $js_version;?>" type="text/javascript"></script>
<?php else:?>
<script src="<?php echo $js_domain;?>/js/<?php  echo $pageid?>.js?version=<?php  echo $js_version;?>" type="text/javascript"></script>
<?php endif;?>

<script src="<?php echo $js_domain;?>/js/plugins/Lilac.popup.js?version=<?php  echo $js_version;?>" type="text/javascript"></script>
<script src="<?php echo $js_domain;?>/js/plugins/Lilac.drag.js?version=<?php  echo $js_version;?>" type="text/javascript"></script>

<?php endif;?>


<?php if($pageid == 'shop_detail'):?>
<script type="text/javascript" src="http://maps.google.cn/maps/api/js?sensor=false&key=AIzaSyDB0HwGrpYeSsDY1rHJs9bLRiUlQweA-S4"></script>



<?php endif;?>


<?php
$no_cache = 0;
if($_GET && isset($_GET['no_cache']) && $_GET['no_cache']==1){
	$no_cache = 1;
}
if($_SERVER && isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']=="nocache=1"){
	$no_cache = 1;
}
?>
<div style="display:none">
<?php if($_SERVER['SERVER_NAME']!='zan.com' && $no_cache==0):?>
<script type="text/javascript">

var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");

document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fff68fee1a56f64563d79ce07806ff504' type='text/javascript'%3E%3C/script%3E"));

</script>
<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1000199935'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s22.cnzz.com/z_stat.php%3Fid%3D1000199935%26show%3Dpic1' type='text/javascript'%3E%3C/script%3E"));</script>

<?php endif;?>
</div>


<?php if($pageid == "links" || $pageid == "brand"):?>
<script type="text/javascript" src="//s.skimresources.com/js/63422X1435865.skimlinks.js"></script>
<?php endif;?>

<?php if(0 && isset($tj_id) && $tj_id && isset($tj[$tj_id])):?>
<img style="display:none;" src="<?php echo $tj_domain;?>/images/gif/<?php echo $tj[$tj_id];?>?rt=<?php echo mt_rand(1,10000);?>"/>
<?php endif;?>


</body>


</html>
