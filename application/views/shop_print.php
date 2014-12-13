<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  xmlns:wb="http://open.weibo.com/wb">
<head>
<?php
$js_version = context::get('js_version', '');
$js_domain = context::get('js_domain', '');
$css_domain = context::get('css_domain', '');
$use_fe = context::get('use_fe', '');
?>
<?php
$uri = $_SERVER['REQUEST_URI'];
$source_url = $uri;
$source_url = urlencode($source_url);
$cookie_city_id = $this->input->cookie("city_id", true , 0);
$city_lower_name = "";
if (!isset($city_id) || !$city_id) {
	$head_city_id = $cookie_city_id;
	$head_city_name = context::get("cookie_city_name", "");
    $city_lower_name = context::get("cookie_city_lower_name", "");
}else{
	$head_city_name = $city_name;
	$head_city_id = $city_id;
    $city_lower_name = $city_info['lower_name'];
}
?>
<title><?php if(isset($page_title) && $page_title) echo $page_title;?><?php if($this->config->item($pageid,'page_title') !== FALSE) echo $this->config->item($pageid,'page_title'); else echo $this->config->item('default','page_title');?></title>
<?php if(isset($seo_keywords) && $seo_keywords):?>
<meta name="keywords" content="<?php echo $seo_keywords;?>"/>
<meta name="description" content="<?php echo $seo_description;?>"/>
<?php elseif(isset($head_city_name) && $head_city_name):?>
<meta name="keywords" content="<?php echo $head_city_name;?>购物-出境购物-出国购物-赞佰网"/>
<meta name="description" content="赞佰网( zanbai.com)为您提供<?php echo $head_city_name;?>购物攻略和<?php echo $head_city_name;?>购物中心的信息"/>
<?php else:?>
<meta name="description" content="购物街区、百货公司、奥特莱斯，一网打尽，赞佰网为您提供海外购物场所最全名录，经验分享，折扣优惠，购物攻略，带您畅购海外，一站搞定" />
<meta name="keywords" content="出境购物，出国购物，赞佰网"/>
<?php endif;?>
<meta http-equiv="content-type" content="text/html;charset=utf-8">
<meta property="wb:webmaster" content="aa9494be029a7677" />
<meta property="qc:admins" content="5447241216211631611006375" />

<link href="/favicon.ico" rel="icon" type="image/gif">
<meta name="baidu-site-verification" content="AGYtanqceJ" />
<meta name="google-site-verification" content="M6lXsWQuu4XEeubo6P8wIr9ELw3CfVgSy-9HzgTLhqc" />
<link rel="stylesheet" type="text/css" href="<?php echo $css_domain;?>/css/common.css"/>
<?php if(isset($page_css) && $page_css):?>
<link rel="stylesheet" type="text/css" href="<?php echo $css_domain;?>/css/<?php echo $page_css?>"/>
<?php else:?>
<link rel="stylesheet" type="text/css" href="<?php echo $css_domain;?>/css/ZB_<?php echo $pageid?>.css"/>
<?php endif;?>




</head>

<body class="ZB_<?php if(isset($body_class)) echo $body_class; else echo $pageid;?>">
<div class="ZB_wrap">
    <div class="ZB_header clearfix" style="padding-top:0px;height:35px;">
		<a href="<?php echo view_tool::echo_isset($domain);?>/"><img src="<?php echo $css_domain;?>/images/common/logo.png?id=20131021140000" height="33" ></a>
		<a  href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $city_lower_name;?>/"><span class="cur_city" style="font-size:40px;"><em><?php echo $head_city_name;?></em></span></a>
	</div>






		
<div class="ZB_shop_content clearfix">
	<!-- 面包屑引导 -->

	<!-- /面包屑引导 -->
	<div class="shop_wrap fl" style="width:100%;">
		<!-- 商店详情 -->
		<div class="store">
			<!-- 商店信息 -->
			<div class="store_info clearfix" style="margin-bottom:5px;">
				<!-- 商店大图 -->
				<div class="fl store_pic" id="showImgPop" node-data="shop_id=<?php echo $shop['id'];?>" style="">
					<a  href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $city_lower_name;?>/<?php echo $shop['id'];?>/">
					<img alt="<?php echo $city_name;?>-<?php echo $shop['name'];?>" src="<?php echo $this->tool->clean_file_version($shop['pic'],'!shoppic');?>" width="245" height="245" >
					</a>
				</div>
				<!-- /商店大图 -->
				<!-- 商店介绍 -->
				<div class="store_intro" style="">
					<!-- 顶部评分栏 -->

					<!-- /顶部评分栏 -->
					<!-- 详细介绍 -->
					<div class="title">
						<a  href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $city_lower_name;?>/<?php echo $shop['id'];?>/">
						<span class="store_title" id="shop-name"><?php echo $shop['name'];?></span>
						</a>

						<?php if($shop['reserve_2']):?><a target="_blank" href="<?php echo $shop['reserve_2'];?>" class="official_website" style="background-color:#ededed;color:#000;">官网</a><?php endif;?></div>
					
					
					<div class="content textb" id="shop_intro" style="width:auto;">
						<?php
						$desc = $shop['desc'];
						$content_bl2br = nl2br($shop['desc']);
						$tmp_desc = explode("<br>", $content_bl2br);
						
						foreach($tmp_desc as $v){
							$v = trim($v," ");
							if($v){
								//$v = strip_tags($v);
								//$v = str_replace(" (", "(", $v);
								//$v = str_replace("）", ")", $v);
								echo "<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$v."</div>";
								//echo "<p style='font-family: GB'>".$v."</p>";
							}
						}
						?>
					</div>

					<?php if($shop_tag):?>
					<div class="tag_wrap" style="margin-top:5px;">
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

				</div>
				<!-- /商店介绍 -->
			</div>
			<!-- 商店信息 -->
			<?php if(isset($shop['reserve_3']) && $shop['reserve_3']):?>
			<div class="other_info" style="padding-bottom:2px;">
				
				<p class="traffic_info"><span class="fl textb">地铁：</span><span class="left_border"><?php echo $shop['reserve_3'];?></span></p>

			</div>
			<?php endif;?>
			<!-- 点评 -->
			<?php if( 0 && $show_brands_infos):?>
			<div class="post clearfix">
				<div class="brand_wall">
					<div class="hidden_margin">
						<div class="brand_list">
							<?php foreach($show_brands_infos as $brand):?>
							<img src="<?php echo $brand['big_pic'];?>" alt="" width="98" height="50"/>
							<?php endforeach;?>
						</div>
					</div>
					<p class="more_brand">更多品牌列表</p>
				</div>
			</div>
			<?php endif;?>
			
			<div class="map_block">
			<img alt="<?php echo $shop['name'];?>购物地图" width="640" height="640" style="-webkit-user-select: none;display:block;margin:0 auto 20px;" src="<?php echo $shop['reserve_5'];?>">
			</div>

			<!-- /点评 -->
			<div class="map_block" style="width:100%;height:120px;display:block;margin:0 auto 20px;">
				<div width="40%" style="float:left;">
				<div class="app_logo">
					<a href="https://itunes.apple.com/cn/app/zan-bai-wang-chu-jing-gou/id774874759?mt=8#">
					<img alt="扫描二维码,关注zanbai-赞佰网 IOS客户端" src="<?php echo $css_domain;?>/images/qrcode.png" alt="" width="120" height="120">
					</a>
				</div>
				<div class="app_link_text">
					<div class="app_name"><a href="https://itunes.apple.com/cn/app/zan-bai-wang-chu-jing-gou/id774874759?mt=8#">安装iOS客户端-出境购物尽在掌握</a></div>
					<div class="app_guide"></div>
				</div>
				</div>
				<div width="40%" style="float:left;margin-left:30px;">
				<div class="app_logo">
					<img alt="扫描二维码,关注zanbai-赞佰网 微信订阅号" src="<?php echo $css_domain;?>/images/weixindingyue.jpg" alt="" width="120" height="120"/>
				</div>
		        <div class="app_link_text">
		            <div class="app_name">关注微信订阅号-最新攻略一扫而尽</div>
		            <div class="app_guide"></div>
		        </div>
		   		</div>

			</div>	



		</div>
		<!-- /商店详情 -->
		








	</div>

</div>





	<!--
	<div class="ZB_footer">
		<div class="footer">
			<div class="footer_icon fl">
				<span>关注赞佰：
					<a target="_blank" href="http://www.weibo.com/zanbaiwb/" class="icon_list icon_weibo"></a>
					<a target="_blank" href="http://t.qq.com/zanbaiqianhua" class="icon_list icon_qweibo"></a>
					<a target="_blank" href="http://www.douban.com/people/70076907/" class="icon_list icon_dou"></a>
				</span>
				<p>
					<a href="<?php echo view_tool::echo_isset($domain);?>/help?tab=1" class="about_us">关于赞佰 |</a>
					<a href="<?php echo view_tool::echo_isset($domain);?>/help?tab=2" class="about_us">联系我们 |</a>
					<a href="<?php echo view_tool::echo_isset($domain);?>/links" class="about_us">友情链接 |</a>
					<a href="<?php echo view_tool::echo_isset($domain);?>/help?tab=3" class="about_us">使用条款</a>
				</p>
			</div>
			<div class="right_wrap fr">
				<p>北京赞佰千华网络科技有限公司  京ICP备13005904号 京公网安备11010802010914</p>
				<p>Copyright © 2013-ZANBAI</p>
			</div>
		</div>
	</div>
	-->

	<?php if(!isset($area_cities) || !$area_cities):?>
	<?php
	$area_cities = context::get("area_cities", array());
	$country_code = context::get("country_code", array());
	?>
	<?php endif;?>
	<!-- 城市选择弹层-->
	<!--
	<div class="ZB_cities_layer" style="display:none" id="zb-city-layer">
		<?php if(isset($area_cities) && $area_cities):?>
		<div class="ZB_cities_wrap">
			<?php foreach($area_cities as $country=>$country_cities){?>
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
	-->
</div>





</html>



