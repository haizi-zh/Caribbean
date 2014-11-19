<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//

$images = array();
$images['1']['img'] = "http://zanbai.b0.upaiyun.com/2014/04/ad637e74a629c944.png";
$images['1']['url'] = "http://zh.citypass.com/new-york?mv_source=zanbai";


$images['1']['img'] = "http://zanbai.b0.upaiyun.com/2014/06/0d0097bc50caa5b7.jpg";

$images['1']['img'] = "http://zanbai.b0.upaiyun.com/2014/07/69f7e0feb853cd13.jpg";
$images['1']['img'] = "http://zanbai.b0.upaiyun.com/2014/07/4423cd8cc1b457e3.jpg";
$images['1']['url'] = "http://www.zanbai.com/coupon_info/198/2161";

$images['2']['img'] = "http://zanbai.b0.upaiyun.com/2014/04/4cbd1c0df4a28fc6.png";
$images['2']['url'] = "http://zh.citypass.com/southern-california?mv_source=zanbai";

$images['3']['img'] = "http://zanbai.b0.upaiyun.com/2014/04/4f3c885dcd4e7f86.png";
$images['3']['url'] = "http://zh.citypass.com/chicago?mv_source=zanbai";

$images['3']['img'] = "http://zanbai.b0.upaiyun.com/2014/06/0d0097bc50caa5b7.jpg";

$images['3']['img'] = "http://zanbai.b0.upaiyun.com/2014/07/a61bff7607c54a8e.jpg";
$images['3']['img'] = "http://zanbai.b0.upaiyun.com/2014/07/4379425128cc7750.jpg";
$images['3']['url'] = "http://www.zanbai.com/coupon_info/199/2163";

$images['5']['img'] = "http://zanbai.b0.upaiyun.com/2014/04/6ceae4a3af5425a8.png";
$images['5']['url'] = "http://zh.citypass.com/san-francisco?mv_source=zanbai";

//
$images['5']['img'] = "http://zanbai.b0.upaiyun.com/2014/06/0d0097bc50caa5b7.jpg";

$images['5']['img'] = "http://zanbai.b0.upaiyun.com/2014/07/0294d3d79ce29959.jpg";
$images['5']['img'] = "http://zanbai.b0.upaiyun.com/2014/07/0b343a07307e9c9b.jpg";
$images['5']['url'] = "http://www.zanbai.com/coupon_info/197/2169";
//http://zanbai.b0.upaiyun.com/2014/06/649b2f26fad265e6.jpg

$images['8']['img'] = "http://zanbai.b0.upaiyun.com/2014/04/b72a94a76290bc03.png";
$images['8']['url'] = "http://zh.citypass.com/toronto?mv_source=zanbai";

$images['10']['img'] = "http://zanbai.b0.upaiyun.com/2014/04/b6325e0fa164e9b6.png";
$images['10']['url'] = "http://zh.citypass.com/boston?mv_source=zanbai";

$images['11']['img'] = "http://zanbai.b0.upaiyun.com/2014/04/a478ae87920d4ce6.png";
$images['11']['url'] = "http://zh.citypass.com/houston?mv_source=zanbai";

$images['13']['img'] = "http://zanbai.b0.upaiyun.com/2014/06/0d0097bc50caa5b7.jpg";

$images['13']['img'] = "http://zanbai.b0.upaiyun.com/2014/07/633f5fb402603d0d.jpg";
$images['13']['img'] = "http://zanbai.b0.upaiyun.com/2014/07/bba4a5f78ca8c611.jpg";
$images['13']['url'] = "http://www.zanbai.com/coupon_info/200/2164";

$images['14']['img'] = "http://zanbai.b0.upaiyun.com/2014/04/644ed698ea166255.png";
$images['14']['url'] = "http://zh.citypass.com/atlanta?mv_source=zanbai";

$images['16']['img'] = "http://zanbai.b0.upaiyun.com/2014/04/4cbd1c0df4a28fc6.png";
$images['16']['url'] = "http://zh.citypass.com/southern-california?mv_source=zanbai";

$images['17']['img'] = "http://zanbai.b0.upaiyun.com/2014/04/b3eab8c1ffeeea00.png";
$images['17']['url'] = "http://zh.citypass.com/philadelphia?mv_source=zanbai";

$images['18']['img'] = "http://zanbai.b0.upaiyun.com/2014/04/4e2c496246facfc6.png";
$images['18']['url'] = "http://zh.citypass.com/seattle?mv_source=zanbai";

//$images['111']['img'] = "http://zanbai.b0.upaiyun.com/2014/04/e398810cc876365f.png";
//$images['111']['url'] = "http://www.citypass.com/tampa?mv_source=zanbai";

$item = array();
$item['img'] = "http://zanbai.b0.upaiyun.com/2014/04/40fa31dd0c35cc85.jpg";
$item['url'] = "http://zh.citypass.com/?mv_source=zanbai";
//北美剩余的城市用这个
//,9,19
//，，，4，，6，7，，，12，13,,15,,,
$images['9']=$images['19']=$images['4']=$images['6']=$images['7']=$images['12']=$images['15']=$item;

$config['adv_images'] = array("normal"=>$images, "default"=>$item);

$adv_types = array();
$adv_types[1] = "顶部banner(960px*60px)";
$adv_types[2] = "右侧梅西百货";
$config['adv_types'] = $adv_types;




