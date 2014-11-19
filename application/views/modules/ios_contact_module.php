<?php
$this->config->load('env',TRUE);
$css_domain = $this->config->item("css_domain", "env");
$ios_pic = "http://zanbai.b0.upaiyun.com/2014/07/c26d3022afd9b9c1.png";
$weixin_pic = "http://zanbai.b0.upaiyun.com/2014/07/2c1363e39a4eaaf8.jpg";

?>
<!--<wb:follow-button uid="3222560392" type="red_1" width="67" height="24" ></wb:follow-button>-->

<div class="right_block">
	<div class="contact_area">
		<div class="social_media_list">
			<div class="social_media_item">
				<!--<wb:follow-button uid="3222560392" type="red_1" width="67" height="24" ></wb:follow-button>-->
			</div>
		</div>
		<div class="app_area clearfix">
		<div class="app_title">赞佰网，出境购物指南，全球百货攻略</div> 
		<div class="app_logo">
			<img rel="nofollow" alt="扫描二维码,关注zanbai-赞佰网 IOS客户端" src="<?php echo upimage::format_brand_up_image($ios_pic);?>" alt="" width="160" height="160">
		</div>
		<div class="app_link_text">
			<div class="app_name">iOS客户端</div>
			<div class="app_guide">出境购物尽在掌握</div>
		</div>
		<div class="app_logo">
			<img rel="nofollow" alt="扫描二维码,关注zanbai-赞佰网 微信订阅号" src="<?php echo upimage::format_brand_up_image($weixin_pic);?>" alt="" width="160" height="160"/>
		</div>
        <div class="app_link_text">
            <div class="app_name">微信订阅号</div>
            <div class="app_guide">最新攻略一扫而尽</div>
        </div>
		</div>
	</div>

</div>




