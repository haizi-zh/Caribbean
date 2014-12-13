<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config['js_version'] = "20140430";
#----通用----
$domain = $_SERVER['HTTP_HOST'];
$full_domain = 'http://'.$domain;
$host = $_SERVER['HTTP_HOST'];

$config['head_name'] = "赞佰网";

$config['use_fe'] = 0;
if(isset($_SERVER['ZANBAI_ENV'])){
	if($host == "zanbai.com" || $host == "www.zanbai.com" ){
		$config['js_domain'] = "http://js.zanbai.com";
		$config['css_domain'] = "http://css.zanbai.com";
		$full_domain = 'http://www.zanbai.com';
	}else{
		$config['use_fe'] = 1;
	}
}else{
	$http_host = $_SERVER['HTTP_HOST'];
	//$config['js_domain'] = "..";
	//$config['css_domain'] = "../..";
	$config['js_domain'] = "http://".$http_host;
	$config['css_domain'] = "http://".$http_host;
}
$config['domain'] = $full_domain;
$config['use_fe'] = 1;
#----图床相关----
$config['imgdomain'] = 'http://zanbai.b0.upaiyun.com';
#--又拍特有的
$config['upyun-bucket'] = 'zanbai';
$config['upyun-form-api-secret'] = 'EtMT1efoAB4KJbtQqPxNLctxzo4=';
$config['upyun-callback'] = $full_domain.'/imgcallback';

$config['brand_domain'] = 'http://zanbai.b0.upaiyun.com/brand/';
#----登录相关----
#weibo
if(isset($_SERVER['HTTP_APPNAME'])){#sae
	$weibo['WB_AKEY'] = '2363320324';
	$weibo['WB_SKEY'] = 'a967c49371e85445d867381836d5d234';
}else{
	$weibo['WB_AKEY'] = '3809461175';
	$weibo['WB_SKEY'] = 'b15a2f17e414b20980a0534fc66a06a9';
}
$my_domain = "www.zanbai.com";
$config['my_domain'] = $my_domain;
//$weibo['WB_CALLBACK_URL'] = 'http://'.$_SERVER['HTTP_HOST'].'/callback/weibo';
//$weibo['WB_OPENAPI_URL'] = 'https://api.weibo.com/oauth2/authorize?client_id='.$weibo['WB_AKEY'].'&response_type=code&redirect_uri=http%3A%2F%2F'.$_SERVER['HTTP_HOST'].'%2Findex.php%2Fcallback%2Fweibo';

$weibo['WB_CALLBACK_URL'] = 'http://'.$my_domain.'/callback/weibo';
$weibo['WB_OPENAPI_URL'] = 'https://api.weibo.com/oauth2/authorize?client_id='.$weibo['WB_AKEY'].'&response_type=code&redirect_uri=http%3A%2F%2F'.$my_domain.'%2Findex.php%2Fcallback%2Fweibo';


$config['weibo'] = $weibo;

#qq
if(isset($_SERVER['HTTP_APPNAME'])){#sae
	$qq['appid'] = '100381982';
	$qq['appkey'] = 'bc9a125c36ecbbb94a31b35f724008cc';
}else{
	//$qq['appid'] = '100348313';
	//$qq['appkey'] = 'c6f3f607a2b353196a0bc8b1c92c182a';
	$qq['appid'] = '100382203';
	$qq['appkey'] = '374b67d5761832b2ec75923ba745be03';
}
$config['qq'] = $qq;


#renren
if(isset($_SERVER['HTTP_APPNAME'])){#sae
	$renren['appid'] = "234880";
	$renren['apikey'] = "e84502baffaa41669de80cd3360244f3";
	$renren['secretkey'] = "391774c5374b477ca62277c3497ff899";
	$renren["redirecturi"] = "http://zanbai.com/callback/renren";
}else{
	$renren['appid'] = "242328";
	$renren['apikey'] = "bd790b3303a14dfa8f40afad60d4e147";
	$renren['secretkey'] = "4cc2b857323348b48eeb687326216b0a";
	$renren["redirecturi"] = "http://zanbai.com/callback/renren";
}
$renren["scope"] = "publish_feed,photo_upload";
$renren['apiversion'] = '1.0';
$renren["decodeFormat"] = "json";
$renren['apiurl'] = "http://api.renren.com/restserver.do";
$config['renren'] = $renren;

#douban
if(isset($_SERVER['HTTP_APPNAME'])){#sae
	$douban['apikey'] = "04f4ab27b609dae40ede0177221d90ac";
	$douban['secretkey'] = "e6b806f0dff9a006";
	$douban['redirect_uri'] = "http://zanbai.com/callback/douban";
	$douban['scope'] = "huo_basic_r,shuo_basic_w,douban_basic_common";
}else{
	$douban['apikey'] = "04f4ab27b609dae40ede0177221d90ac";
	$douban['secretkey'] = "e6b806f0dff9a006";
	$douban['redirect_uri'] = "http://zanbai.com/callback/douban";
	$douban['scope'] = "huo_basic_r,shuo_basic_w,douban_basic_common";
}
$config['douban'] = $douban;

$config['use_memcache'] = 1;




