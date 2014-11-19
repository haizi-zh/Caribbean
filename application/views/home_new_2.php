<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="购物街区、百货公司、奥特莱斯，一网打尽，赞佰网为您提供海外购物场所最全名录，经验分享，折扣优惠，购物攻略，带您畅购海外，一站搞定" />
<meta name="keywords" content="<?php echo $seo_keywords;?>"/>
<link href="/favicon.ico" rel="icon" type="image/gif">
<meta name="baidu-site-verification" content="AGYtanqceJ" />
<meta name="google-site-verification" content="M6lXsWQuu4XEeubo6P8wIr9ELw3CfVgSy-9HzgTLhqc" />

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
	<div class="bg_wrap" id="bg_wrap">
		<div class="main">
			<div class="content clearfix">
				<div class="state">
					<div class="state_bg">
						<div class="state_name" id="state-name">
							<p class="fs51">北美</p>
							<p class="fs24">North <br/>America</p>
						</div>
					</div>
				</div>
				<div class="city_list">
					<!-- 请吊哥通过style控制元素的left值，每一次移动距离是-830px-->
					<div class="city_wrap clearfix" style="left:0" id="city-list">
						
						<?php foreach($cities as $area => $city_list):?>
						<?php $count_city = count($city_list);?>
						<div class="single">
							<ul class="clearfix">
								<?php $i=0;?>
								<?php foreach($city_list as $item):?>
								<?php $i++;if($i>18)break;?>
								<li <?php if(isset($city_ids[$item['id']])):?>class="hot"<?php endif;?>>
									<a title="<?php echo $item['name'];?>-<?php echo $item['english_name'];?>购物指南" href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $item['lower_name'];?>/">
										<span class="city_name">
											<?php
												$name_length = mb_strlen($item['name']);
												$fs_l = 30;
												if($name_length==5){
													$fs_l = 18;
												}elseif($name_length == 4){
													$fs_l = 24;
												}
											?>
											<em class="fs<?php echo $fs_l;?>"><?php echo $item['name'];?></em>
											<em class="fs12"><?php echo $item['english_name'];?></em>
										</span>
										<span class="bg"></span>
									</a>
								</li>
								<?php endforeach;?>
							</ul>
							<?php if($count_city > 18):?>
							<div class="page_turn">
								<a href="javascript:void(0);" class="page_down" node-type="page-down" node-data="area=<?php echo $area;?>&page=2">
									下一页<span class="page_icon"></span>
								</a>
							</div>
							<?php endif;?>
						</div>
						<?php endforeach;?>
						
					</div>
				</div>
			</div>

			<div class="state_tab" id="state-tab">
				<a title="北美 North America 购物指南" href="javascript:void(0);" action-type="change-tab" action-data="index=0" class="cur">北美 North America</a><span class="v_line">|</span>
				<a title="欧洲 Europe 购物指南" href="javascript:void(0);" action-type="change-tab" action-data="index=1" class="">欧洲 Europe</a><span class="v_line">|</span>
				<a title="亚太 Asia Pacific 购物指南" href="javascript:void(0);" action-type="change-tab" action-data="index=2" class="">亚太 Asia Pacific</a>
			</div>
			<div class="bottom_tip">ZANBAI<span>出境购物指南全球百货攻略</span></div>
			<div style="display:none;">佰赞网版板所有；出国购物，出境购物尽在佰赞网</span></div>
		</div>
	</div>

<?php if($use_fe):?>
    <script type="text/javascript">
    	require('home/main2');
        //require('widget/cookie/main', function (cookie) {
         //   document.getElementById('bg_wrap').style.background =
          //      cookie.get('__curBgImg__') + ' no-repeat';
            //require('home/main2');
        //}, 'home/main2');
    </script>
<?php else:?>
<?php
$this->config->load('env',TRUE);
$js_version = $this->config->item("js_version", "env");
?>
<script type="text/javascript" src="<?php echo $js_domain;?>/js/Lilac.js?version=<?php echo $js_version;?>"></script>
<script type="text/javascript" src="<?php echo $js_domain;?>/js/newhome.js?version=<?php echo $js_version;?>"></script>
<?php endif;?>

<div style="display:none">
<?php if($_SERVER['SERVER_NAME']!='zan.com'):?>
<script type="text/javascript">

var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");

document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fff68fee1a56f64563d79ce07806ff504' type='text/javascript'%3E%3C/script%3E"));

</script>
<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1000199935'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s22.cnzz.com/z_stat.php%3Fid%3D1000199935%26show%3Dpic1' type='text/javascript'%3E%3C/script%3E"));</script>

<?php endif;?>
</div>

<?php if(0&&isset($tj_id) && $tj_id && isset($tj[$tj_id])):?>
<img style="display:none;" src="<?php echo $tj_domain;?>/images/gif/<?php echo $tj[$tj_id];?>?rt=<?php echo mt_rand(1,10000);?>"/>
<?php endif;?>

</body>
</html>

