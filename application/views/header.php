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
$head_city_id = context::get("head_city_id", true , 0);
$city_lower_name = "";
if ($head_city_id && (!isset($city_id) || !$city_id || !$city_info)) {
	$head_city_name = context::get("cookie_city_name", "");
    $city_lower_name = context::get("cookie_city_lower_name", "");
}elseif($city_id){
	$head_city_name = $city_name;
	$head_city_id = $city_id;
    $city_lower_name = $city_info['lower_name'];
}else{

}
?>

<title><?php if(isset($page_title_single) && $page_title_single):?>
<?php echo $page_title_single;?>
<?php else:?>
<?php if(isset($page_title) && $page_title) echo $page_title;?><?php if($this->config->item($pageid,'page_title') !== FALSE) echo $this->config->item($pageid,'page_title'); else echo $this->config->item('default','page_title');?>
<?php endif;?>
</title>
<?php if(isset($seo_keywords) && $seo_keywords):?>
<meta name="keywords" content="<?php echo $seo_keywords;?>"/>
<?php elseif(isset($head_city_name) && $head_city_name):?>
<meta name="keywords" content="<?php echo $head_city_name;?>购物-出境购物-出国购物-赞佰网"/>
<?php else:?>
<meta name="keywords" content="出境购物，出国购物，赞佰网"/>
<?php endif;?>

<?php if(isset($seo_description) && $seo_description):?>
<meta name="description" content="<?php echo $seo_description;?>"/>
<?php elseif(isset($head_city_name) && $head_city_name):?>
<meta name="description" content="赞佰网( zanbai.com)为您提供<?php echo $head_city_name;?>购物攻略和<?php echo $head_city_name;?>购物中心的信息"/>
<?php else:?>
<meta name="description" content="购物街区、百货公司、奥特莱斯，一网打尽，赞佰网为您提供海外购物场所最全名录，经验分享，折扣优惠，购物攻略，带您畅购海外，一站搞定" />
<?php endif;?>


<meta http-equiv="content-type" content="text/html;charset=utf-8">
<meta property="wb:webmaster" content="aa9494be029a7677" />
<meta property="qc:admins" content="5447241216211631611006375" />

<link href="/favicon.ico" rel="icon" type="image/gif">
<meta name="baidu-site-verification" content="AGYtanqceJ" />
<meta name="google-site-verification" content="M6lXsWQuu4XEeubo6P8wIr9ELw3CfVgSy-9HzgTLhqc" />
<link rel="stylesheet" type="text/css" href="<?php echo $css_domain;?>/css/common.css?v=<?php echo $js_version;?>"/>
<?php if(isset($page_css) && is_array($page_css) && !empty($page_css)):?>
    <?php foreach($page_css as $css):?>
        <link rel="stylesheet" type="text/css" href="<?php echo $css_domain;?>/css/<?php echo $css?>?v=<?php echo $js_version;?>"/>
    <?php endforeach;?>
<?php elseif(isset($page_css) && $page_css):?>
<link rel="stylesheet" type="text/css" href="<?php echo $css_domain;?>/css/<?php echo $page_css?>?v=<?php echo $js_version;?>"/>
<?php else:?>
<link rel="stylesheet" type="text/css" href="<?php echo $css_domain;?>/css/ZB_<?php echo $pageid?>.css?v=<?php echo $js_version;?>"/>
<?php endif;?>
<?php if($pageid != 'home'):?><link rel="stylesheet" type="text/css" href="<?php echo $css_domain;?>/css/nivoslider.css?v=<?php echo $js_version;?>"><?php endif;?>
<?php if(isset($no_index) && $no_index):?>
<meta name="robots" content="noindex">
<?php endif;?>



<?php if($use_fe):?>
<script type="text/javascript" src="<?php echo $js_domain;?>/fe/lib/Lilac.js"></script>
<script type="text/javascript">
    require.config({
        //baseUrl : '../../fe/src/',
        baseUrl : '<?php echo $js_domain;?>/fe/src/',
        site_version : <?php echo $js_version;?>,
        js_domain : '<?php echo $js_domain;?>',
        css_domain : '<?php echo $css_domain;?>',
        paths   : {
            // 'jquery' : '../dep/jquery/1.8.2/jquery.min',
            'jquery' : 'http://libs.baidu.com/jquery/1.8.2/jquery.min',
            'hogan' : '../dep/hogan/3.0.0/hogan'
        }
    });
    var $CONFIG =  {
       <?php if(isset($config_city)):?>
       city:<?php echo $config_city;?>,
       shop_id:<?php echo $config_shop_id;?>,
       <?php endif;?>
        <?php $user_info=$this->session->userdata('user_info'); if(empty($user_info)){?>
        isLogin: 0,
        <?php }else{?>
        isLogin: 1,
        <?php }?>
        normalUrl : '<?php echo $js_domain;?>',
        css_domain : '<?php echo $css_domain;?>',
        sourceUrl: '<?php echo $source_url;?>'
    }
</script>
<script type="text/javascript">
    // common 中是通用模块，应该不依赖于任何业务模块
    // 因此在 head 中载入
    require('common/main');

    // combine 测试
    // require('common/main1');
</script>

<?php else:?>

<script type="text/javascript">
    var $CONFIG =  {
       <?php if(isset($config_city)):?>
       city:<?php echo $config_city;?>,
       shop_id:<?php echo $config_shop_id;?>,
       <?php endif;?>
        <?php $user_info=$this->session->userdata('user_info'); if(empty($user_info)){?>
        isLogin: 0,
        <?php }else{?>
        isLogin: 1,
        <?php }?>
        normalUrl : '<?php echo $js_domain;?>',
        sourceUrl: '<?php echo $source_url;?>'
    }
</script>
<?php endif;?>


</head>
<body class="ZB_<?php if(isset($body_class)) echo $body_class; else echo $pageid;?>">
<div class="ZB_wrap">
    <?php if($pageid != 'home'):?>
    <?php
        $adv_infos = array();
        $adv_images = context::get('adv_images', '');

        if($adv_images){
            $default_images = $adv_images['default'];
            $adv_images = $adv_images['normal'];
           
            if(isset($adv_images[$head_city_id])){
                $adv_infos[] = $adv_images[$head_city_id];
            }else{
                //$rand_key = array_rand($adv_images);
                //$adv_info = $adv_images[$rand_key];
            }
            if($adv_infos){
                $adv_infos[] = $default_images;
            }
        }
    ?>
    <?php if(0 && $adv_infos):?>
    <div class="slider-wrapper theme-default">
        <div id="slider" class="nivoSlider">
            <?php foreach($adv_infos as $adv_info): ?>
            <a href="<?php echo $adv_info['url'];?>"><img rel="nofollow" src="<?php echo upimage::format_brand_up_image($adv_info['img']);?>" /></a>
            <?php endforeach ;?>
        </div>
    </div>
    <?php endif;?>

    <?php
    $con_adv_images = context::get('con_adv_images', '');
    ?>
    <?php if(0&&$con_adv_images):?>
    <div class="slider-wrapper theme-default">
        <div id="slider" class="nivoSlider">
            <?php foreach($con_adv_images as $adv_info): ?>
            <a href="<?php echo $adv_info['url'];?>"><img rel="nofollow" src="<?php echo upimage::format_brand_up_image($adv_info['img']);?>" /></a>
            <?php endforeach ;?>
        </div>
    </div>
    <?php endif;?>

    <?php if($con_adv_images):?>
    <div class="banner">
    <div class="focusimg-pic">
        <ul id="slide_ul">
            <?php $i=1;?>
            <?php foreach($con_adv_images as $adv_info): ?>
            <li <?php if($i>1):?>style="display: none;"<?php endif;?>>
                <a href="<?php echo $adv_info['url'];?>" title="">
                    <img width="960" height="90" src="<?php echo upimage::format_brand_up_image($adv_info['img']);?>">
                </a>
            </li>
            <?php $i++;?>
            <?php endforeach ;?>
        </ul>
       
        <a class="prev" target="_self" href="javascript:void(0);"></a>
        <a class="next" target="_self" href="javascript:void(0);"></a>

        <div class="hd">
            <ul>
            <?php $i=1;?>
            <?php foreach($con_adv_images as $adv_info): ?>
            <li <?php if($i==1):?>class="on"<?php endif;?>><a href="javascript:void(0);" target="_self"><?php echo $i;?></a></li>
            <?php $i++;?>
            <?php endforeach ;?>
            </ul>
        </div>
    </div>
    </div>
    <?php endif;?>

    <?php endif ;?>

    <div class="ZB_header clearfix">
		<a href="<?php echo view_tool::echo_isset($domain);?>/" class="logo fl" title="首页"></a>
		<?php if(isset($head_city_id) && $head_city_id):?>
		<a href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $city_lower_name;?>/"><span class="cur_city">▪<em><?php echo $head_city_name;?></em></span></a>
		<!--
		<a href="javascript:void(0);" class="change_city" id="change-city">▶</a>
		-->
		[<a href="javascript:void(0);" id="change-city" class="select_city">逛逛其它城市</a>
        <?php 
        $all_city_infos = context::get("all_city_infos", array());
        $recommend_city = context::get("recommend_city", array());
        $this_city_info = $all_city_infos[$head_city_id];
        $this_area_id = $this_city_info['area_id'];
        $this_recomment_city = $recommend_city[$this_area_id];
        $this_recomment_city = tool::my_shuffle($this_recomment_city);

        ?>
        <?php if($this_recomment_city):?>
        <?php $i=0;?>
        <?php foreach($this_recomment_city as $city_k => $city_v):?>
        <?php $i++;?>
        <?php if($i>3)break;?>
        <?php if($city_k == $head_city_id)continue;?>
        <a href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $all_city_infos[$city_k]['lower_name'];?>/" class="select_city"><?php echo $city_v;?></a> 
        <?php endforeach;?>
        <?php endif;?>
        ]
		<?php endif;?>
		<div class="login_wrap fr">
		<?php $user_info=$this->session->userdata('user_info'); if(empty($user_info)){?>
				<a rel="nofollow" href="javascript:void(0);" id="login-btn">登 录</a>
                <a rel="nofollow" href="http://www.zanbai.com/callback/qq/?source_url=<?php echo $source_url;?>" class="icon_sns QQ_login"></a>
                <a rel="nofollow" href="http://www.zanbai.com/callback/weibo/?source_url=<?php echo $source_url;?>" class="icon_sns weibo_login" ></a>


                <!--
                <a href="/register">注册</a>
                <a href="/login">赞佰登录</a>
            	-->
		<?php }else{?>
				欢迎您 <a rel="nofollow" href="<?php echo view_tool::echo_isset($domain);?>/myprofile?uid=<?php echo $user_info['uid'];?>"><?php echo $user_info['uname'];?>
				<img rel="nofollow" alt="出国购物" title="<?php echo $user_info['uname'];?>" width="30" height="30" src="<?php echo $user_info['image'];?>"></a>
				<a rel="nofollow" href="<?php echo view_tool::echo_isset($domain);?>/logout/?source_url=<?php echo $source_url;?>">退出</a>
		<?php }?>
		</div>
	</div>
	<div class="ZB_nav ">
        <div class="search_drop">
                <div class="search_area">
                    <div class="input_wrap">
                    	<!-- 去掉搜索的按钮
                        <a href="javascript:void(0)" class="zoom_glass"></a>-->
                        <a href="javascript:void(0)" class=""></a>
                        <!-- 请吊哥获得焦点后改成style:color:#000 -->
                        <input type="text" id="suggestion-text" class="search_input" value="商家名称联想">
                    </div>
                    <div class="drop_layer" id="suggestion-target" style="display:none">
                    </div>
                </div>
            </div>
		<ul class="clearfix">
			<li><a href="<?php echo view_tool::echo_isset($domain);?>/">首页</a></li>
            <?php
            $head_shop_tips = context::get("head_shop_tips", array());
            $head_shop_tips_count = context::get("head_shop_tips_count", 0);
            $head_country_id = context::get("head_country_id", 0);
            $head_city_id = context::get("head_city_id", 0);
            $head_shop_id = context::get("head_shop_id", 0);
            ?>
            <?php if(isset($head_shop_tips) && $head_shop_tips):?>
            <li>
            	<?php if(1 || $head_shop_tips_count > 3):?>
            	 <a href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $city_lower_name;?>-shoppingtips/" ><?php echo $head_city_name;?>购物攻略</a>
            	<?php else:?>
            	 <?php $discount_info = $head_shop_tips[0];?>
            	 <a href="<?php echo view_tool::echo_isset($domain);?>/shoptipsinfo/<?php echo $discount_info['id'];?>/" ><?php echo $head_city_name;?>购物攻略</a>
        		<?php endif;?>
            </li>
            <?php endif;?>

            <?php
            $discount_total = context::get("discount_total", 0);
            ?>
            <?php if($discount_total):?>
			<li>
				<a href="<?php echo view_tool::echo_isset($domain);?>/discountcity/<?php echo $head_city_id;?>/" ><?php echo $head_city_name;?>折扣信息</a>
			</li>
			<?php endif;?>


            <?php if(isset($head_city_id) && $head_city_id):?>
            <li>
                <a href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $city_lower_name;?>-shoppingmap/" target="_blank" title="<?php echo $head_city_name;?>地图查找"><?php echo $head_city_name;?>购物地图</a>
            </li>
            <?php else:?>
            <li>
                <a href="<?php echo view_tool::echo_isset($domain);?>/<?php echo $city_lower_name;?>-shoppingmap/" target="_blank" title="<?php echo $head_city_name;?>地图查找"><?php echo $head_city_name;?>购物地图</a>
            </li>
            <?php endif;?>

            <li>
                <?php if(isset($user_info) && $user_info):?>
                <a href="<?php echo view_tool::echo_isset($domain);?>/fav/">我的收藏</a>
                <?php else:?>
                <a href="javascript:void(0);" id="login-btn2" action-type="need_login">我的收藏</a>
                <?php endif;?>
            </li>
            <li>
                <?php if(isset($user_info) && $user_info):?>
                <a href="<?php echo view_tool::echo_isset($domain);?>/myprofile?uid=<?php echo $user_info['uid'];?>/" >关注圈</a>
                <?php else:?>
                <a href="javascript:void(0);" id="login-btn2" action-type="need_login">关注圈</a>
                <?php endif;?>
            </li>

		</ul>
	</div>

<?php if(!$use_fe):?>
<!-- 登陆弹层 -->
<div id="login-layer-wraper" style="display: none;">
    <div class="layer_login detail">
        <p class="login_title"></p>
        <div class="login_icon_wrap">
            <ul class="icon_list clearfix">
                <li><a rel="nofollow" class="cur" href="http://www.zanbai.com/callback/weibo/?source_url=<?php echo $source_url;?>"><em class="icon_sns weibo_login"></em><span>weibo</span></a></li>
                <li><a rel="nofollow" class="cur" href="http://www.zanbai.com/callback/qq/?source_url=<?php echo $source_url;?>" ><em class="icon_sns QQ_login"></em><span>tencent</span></a></li>
                <li><a rel="nofollow" class="cur" href="http://www.zanbai.com/callback/douban"><em class="icon_sns douban_login"></em><span>douban</span></a></li>
                <li><a rel="nofollow" class="cur" href="http://www.zanbai.com/callback/renren/?source_url=<?php echo $source_url;?>" class="icon_sns renren_login"><em class="icon_sns renren_login"></em><span>renren</span></a></li>
                <li><a rel="nofollow" href=""><em class="icon_sns facebook_login"></em><span>facebook</span></a></li>
                <li><a rel="nofollow" href=""><em class="icon_sns twitter_login"></em><span>twitter</span></a></li>
            </ul>
        </div>
        <div class="sign_wrap">
            <h3>使用Zanbai登录</h3>
            <div class="info_list clearfix">
                <div class="tit fl"><i>*</i>账号：</div>
                <div class="inp">
                    <input name="email" type="text" class="W_input" id="email" value="">
                </div>
            </div>

            <div class="info_list clearfix">
                <div class="tit fl"><i>*</i>密码：</div>
                <div class="inp">
                    <input name="passwd" type="password" class="W_input" id="passwd" value="">
                </div>
                <div class="tips"></div>
            </div>
        </div>
        <div class="btn_wrap">
            <div class="tit fl"></div>
            <a href="javascript:void(0);" id="header-login" class="login_btn">立即登录</a>
            <a target="_blank" href="<?php echo view_tool::echo_isset($domain);?>/register/?source_url=<?php echo $source_url;?>" class="sign_btn">立即注册</a>
        </div>
    </div>
</div>
<!-- /登陆弹层 -->
<?php endif;?>

