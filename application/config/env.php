<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config['js_version'] = "20141030037";
#----通用----
$domain = $_SERVER['HTTP_HOST'];
$full_domain = 'http://'.$domain;
$host = $_SERVER['HTTP_HOST'];

$config['head_name'] = "赞佰网";

$config['use_fe'] = 0;
if(isset($_SERVER['ZANBAI_ENV'])){
	if($host == "zanbai.com" || $host == "www.zanbai.com"|| $host == "dev.zanbai.com"){
		$config['js_domain'] = "http://js.zanbai.com";
		$config['css_domain'] = "http://css.zanbai.com";
		$config['admin_js_domain'] = "";
		$config['admin_css_domain'] = "";

		$config['tj_domain'] = "http://tj.zanbai.com";
		$full_domain = 'http://www.zanbai.com';

		$config['css_domain'] = "http://static.zanbai.com";
		$config['js_domain'] = "http://static.zanbai.com";
		$config['tj_domain'] = "http://static.zanbai.com";
		$config['data_domain'] = "http://data.zanbai.com:8080";
		/*
		$config['css_domain'] = "http://csstest2.b0.upaiyun.com";
		$config['js_domain'] = "http://csstest2.b0.upaiyun.com";
		$config['tj_domain'] = "http://csstest2.b0.upaiyun.com";
		*/
	}else{
		$config['use_fe'] = 1;
	}
}else{
	$http_host = $_SERVER['HTTP_HOST'];
	//$config['js_domain'] = "..";
	//$config['css_domain'] = "../..";
	$config['admin_js_domain'] = "http://".$http_host;
	$config['admin_css_domain'] = "http://".$http_host;

	$config['js_domain'] = "http://".$http_host;
	$config['css_domain'] = "http://".$http_host;
	$config['tj_domain'] = "http://".$http_host;
	$config['data_domain'] = "http://".$http_host;
	$config['js_version'] = time();
}
//$config['data_domain'] = "http://data.zanbai.com";
//$config['css_domain'] = "http://static.zanbai.com";
//$config['js_domain'] = "http://static.zanbai.com";
//$config['tj_domain'] = "http://static.zanbai.com";

$config['domain'] = $full_domain;
$config['use_fe'] = 1;
#----图床相关----
$config['imgdomain'] = 'http://zanbai.b0.upaiyun.com';
$config['filedomain'] = 'http://zbfile.b0.upaiyun.com';
#--又拍特有的
$config['upyun-bucket'] = 'zanbai';
$config['upyun-form-api-secret'] = 'EtMT1efoAB4KJbtQqPxNLctxzo4=';
$config['upyun-callback'] = $full_domain.'/imgcallback';

$config['brand_domain'] = 'http://zanbai.b0.upaiyun.com/brand/';
#----登录相关----
#weibo
if(isset($_SERVER['HTTP_APPNAME'])){#sae
	$weibo['WB_AKEY'] = '';
	$weibo['WB_SKEY'] = '';
}else{
	$weibo['WB_AKEY'] = '';
	$weibo['WB_SKEY'] = '';
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
	$qq['appid'] = '';
	$qq['appkey'] = '';
}else{
	$qq['appid'] = '';
	$qq['appkey'] = '';
}
$config['qq'] = $qq;


#renren
if(isset($_SERVER['HTTP_APPNAME'])){#sae
	$renren['appid'] = "234880";
	$renren['apikey'] = "";
	$renren['secretkey'] = "";
	$renren["redirecturi"] = "http://zanbai.com/callback/renren";
}else{
	$renren['appid'] = "";
	$renren['apikey'] = "";
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
	$douban['apikey'] = "";
	$douban['secretkey'] = "";
	$douban['redirect_uri'] = "http://zanbai.com/callback/douban";
	$douban['scope'] = "huo_basic_r,shuo_basic_w,douban_basic_common";
}else{
	$douban['apikey'] = "";
	$douban['secretkey'] = "";
	$douban['redirect_uri'] = "http://zanbai.com/callback/douban";
	$douban['scope'] = "huo_basic_r,shuo_basic_w,douban_basic_common";
}
$config['douban'] = $douban;

$config['use_memcache'] = 1;




