<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="购物街区、百货公司、奥特莱斯，一网打尽，赞佰网为您提供海外购物场所最全名录，经验分享，折扣优惠，购物攻略，带您畅购海外，一站搞定" />
<meta name="keywords" content="<?php echo $seo_keywords;?>"/>
<link href="/favicon.ico" rel="icon" type="image/gif">
<meta name="baidu-site-verification" content="AGYtanqceJ" />
<meta name="google-site-verification" content="M6lXsWQuu4XEeubo6P8wIr9ELw3CfVgSy-9HzgTLhqc" />
<meta name="360-site-verification" content="3e55271ac437d545d2b9647e4289d082" />
<meta name="sogou_site_verification" content="u2UdBqsYHG"/>

<?php
$js_version = context::get('js_version', '');
$js_domain = context::get('js_domain', '');
$css_domain = context::get('css_domain', '');
$tj_domain = context::get('tj_domain', '');
$tj = context::get('tj', '');

$use_fe = context::get('use_fe', '');
?>

<title>出国购物攻略_购物清单_折扣信息_优惠券下载【赞佰网】</title>
<link rel="stylesheet" type="text/css" href="<?php echo $css_domain;?>/css/common.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $css_domain;?>/css/ZB_index.css"/>
<style type="text/css">

</style>
<?php if($use_fe):?>
<script type="text/javascript" src="<?php echo $js_domain;?>/fe/lib/Lilac.js"></script>
<script type="text/javascript">
    require.config({
        baseUrl : '<?php echo $js_domain;?>/fe/src/',
        paths   : {
            // 'jquery' : '../dep/jquery/1.8.2/jquery.min'
            'jquery' : 'http://libs.baidu.com/jquery/1.8.2/jquery.min'
        }
    });
</script>
<?php else:?>

<?php endif;?>
</head>
<body class="ZB_index">
	<div>
		<div class="city_bg" id="city-bg"></div>
		<div class="intro">
			<div class="city_list" id="city-list">
				<div class="top_slogan">
					<i class="brand">ZANBAI</i>&nbsp;&nbsp;&nbsp;&nbsp;<span>出境购物指南&nbsp;全球百货攻略</span>
				</div>
				<!-- 请吊哥通过style控制元素的left值，每一次移动距离是-830px-->
				<div class="single_wrap clearfix">
				<?php foreach($home_citys as $v):?>
					<div class="single">
						<ul class="clearfix">
							<?php foreach($v as $city_id => $city):?>
							<li>
								<a title="<?php echo $city;?>-<?php echo $city_infos[$city_id]['english_name'];?>购物指南" action-type="change-bg" action-data="img=<?php echo $city_pics[$city_id];?>" href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $city_infos[$city_id]['lower_name'];?>/">
									<span class="city_name">
										<em class="fs30"><?php echo $city;?></em>
										<em class="fs12"><?php echo $city_infos[$city_id]['english_name'];?></em>
									</span>
									<span class="bg"></span>
								</a>
							</li>
							<?php endforeach;?>
						</ul>
					</div>
				<?php endforeach;?>
				</div>
				<div class="page_turn"><a title="全球100座城市购物指南" href="<?php echo view_tool::echo_isset($domain);?>/home/more/" class="page_up">更多城市/MORE<span class="page_icon"></span></a></div>
				<!--
				<div class="bottom_tip">ZANBAI<span>出境购物指南全球百货攻略</span></div>
				-->
				<div style="display:none;">佰赞网版板所有；出国购物，出境购物尽在佰赞网</span></div>
				<div class="app_download">
					<a title="关注zanbai-赞佰苹果IOS客户端" href="https://itunes.apple.com/cn/app/zan-bai-wang-chu-jing-gou/id774874759?mt=8#" class="ios_app"></a>
				</div>
				<!--
				<div class="app_download">
					<a href="" class="ios_app"></a>
					<a href="" class="android_app"></a>
				</div>
				-->
			</div>

			<div class="links">
				<span>友情链接:</span>
				<ul>
				<?php foreach($link_list as $url=>$name):?>
				<li><a href="<?php echo $url;?>" target="_blank"><?php echo $name;?></a></li>
				<?php endforeach;?>
				</ul>
			</div>

		</div>
	</div>

<?php if($use_fe):?>
<script type="text/javascript">
    require('home/main1');
</script>
<?php else:?>
<?php
$this->config->load('env',TRUE);
$js_version = $this->config->item("js_version", "env");
?>
<script type="text/javascript" src="<?php echo $js_domain;?>/js/Lilac.js?version=<?php echo $js_version;?>"></script>
<script type="text/javascript" src="<?php echo $js_domain;?>/js/newhome1.js?version=<?php echo $js_version;?>"></script>
<?php endif;?>

<div style="display:none">
<?php if($_SERVER['SERVER_NAME']!='zan.com'):?>

<script type="text/javascript">

var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");

document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fff68fee1a56f64563d79ce07806ff504' type='text/javascript'%3E%3C/script%3E"));

</script>
<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1000199935'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s22.cnzz.com/z_stat.php%3Fid%3D1000199935%26show%3Dpic1' type='text/javascript'%3E%3C/script%3E"));</script>

<a href="http://zhanzhang.anquan.org/physical/report/?domain=www.zanbai.com" name="40sCwjpd4VWdaq2WOPWCpqPSEG0Z4H7WihNx27d7KaRX9fS1ok"><img height="47" src="http://zhanzhang.anquan.org/static/common/images/zhanzhang.png"alt="安全联盟站长平台" /></a>
<?php endif;?>
</div>

<script type="text/javascript" src="//s.skimresources.com/js/63422X1435865.skimlinks.js"></script>

<?php if(0&&isset($tj_id) && $tj_id && isset($tj[$tj_id])):?>
<img style="display:none;" src="<?php echo $tj_domain;?>/images/gif/<?php echo $tj[$tj_id];?>?rt=<?php echo mt_rand(1,10000);?>"/>
<?php endif;?>


</body>
</html>

