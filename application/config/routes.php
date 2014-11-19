<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

//$route['discount_info/(:num)'] = "discount/detail?id=$1";
$route['guide/(:num)'] = 'coupon/detail/?guide_id=$1';
$route['discount/(:num)'] = 'discount/detail/?id=$1';
$route['discountcity/(:num)'] = 'discount/index/?city=$1';

$route['discountshop/(:num)'] = 'discount/index/?shop_id=$1';
$route['coupon_info/(:num)/(:any)'] = 'coupon/info/?id=$1&shop_id=$2';

$route['shoptips/(:num)'] = '/discount/shoptips_list/?city=$1';
$route['shoptipsinfo/(:num)/(:num)'] = '/discount/shoptips_detail/?city=$1&id=$2';
$route['shoptipsinfo/(:num)'] = '/discount/shoptips_detail/?id=$1';
$route['(:any)/directions'] = '/direction/index/?lower_name=$1';

$route['ping/(:num)'] = '/ping/index/?id=$1';
$route['city/(:num)'] = '/city/index/?city=$1';
$route['shop/(:num)'] = '/shop/index/?shop_id=$1';
$route['shop_printd/(:num)'] = '/shop/printd/?shop_id=$1';

$route['brandstreet/(:num)'] = '/brandstreet/index/?shop_id=$1';
// //http://www.zanbai.com/discount/1900      ->   http://www.zanbai.com/promotion1900
$route['promotion(:num)'] = "/discount/detail/?id=$1";

$route['home/more'] = "/home/index/?step=2";


$route['newyork'] = '/city/index/?city=1';
$route['losangeles'] = '/city/index/?city=2';
$route['chicago'] = '/city/index/?city=3';
$route['lasvegas'] = '/city/index/?city=4';
$route['sanfrancisco'] = '/city/index/?city=5';
$route['washington'] = '/city/index/?city=6';
$route['hawaii'] = '/city/index/?city=7';
$route['toronto'] = '/city/index/?city=8';
$route['vancouver'] = '/city/index/?city=9';
$route['boston'] = '/city/index/?city=10';
$route['houston'] = '/city/index/?city=11';
$route['dallas'] = '/city/index/?city=12';
$route['miami'] = '/city/index/?city=13';
$route['atlanta'] = '/city/index/?city=14';
$route['orlando'] = '/city/index/?city=15';
$route['sandiego'] = '/city/index/?city=16';
$route['philadelphia'] = '/city/index/?city=17';
$route['seattle'] = '/city/index/?city=18';
$route['montreal'] = '/city/index/?city=19';
$route['paris'] = '/city/index/?city=20';
$route['london'] = '/city/index/?city=21';
$route['milano'] = '/city/index/?city=22';
$route['roma'] = '/city/index/?city=23';
$route['venezia'] = '/city/index/?city=24';
$route['firenze'] = '/city/index/?city=25';
$route['berlin'] = '/city/index/?city=26';
$route['frankfurt'] = '/city/index/?city=27';
$route['munich'] = '/city/index/?city=28';
$route['barcelona'] = '/city/index/?city=29';
$route['madrid'] = '/city/index/?city=30';
$route['hamburg'] = '/city/index/?city=31';
$route['duesseldorf'] = '/city/index/?city=32';
$route['edinburgh'] = '/city/index/?city=33';
$route['liverpool'] = '/city/index/?city=34';
$route['manchester'] = '/city/index/?city=35';
$route['geneva'] = '/city/index/?city=36';
$route['zurich'] = '/city/index/?city=37';
$route['athens'] = '/city/index/?city=38';
$route['brussel'] = '/city/index/?city=39';
$route['luxembourg'] = '/city/index/?city=40';
$route['viena'] = '/city/index/?city=41';
$route['cardiff'] = '/city/index/?city=42';
$route['york'] = '/city/index/?city=43';
$route['hongkong'] = '/city/index/?city=44';
$route['macao'] = '/city/index/?city=45';
$route['taipei'] = '/city/index/?city=49';
$route['kaohsiung'] = '/city/index/?city=50';
$route['tokyo'] = '/city/index/?city=51';
$route['osaka'] = '/city/index/?city=52';
$route['nagoya'] = '/city/index/?city=53';
$route['dubai'] = '/city/index/?city=54';
$route['singapore'] = '/city/index/?city=55';
$route['dublin'] = '/city/index/?city=56';
$route['kobe'] = '/city/index/?city=57';
$route['kyoto'] = '/city/index/?city=58';
$route['beijing'] = '/city/index/?city=59';
$route['shanghai'] = '/city/index/?city=60';
$route['guangzhou'] = '/city/index/?city=61';
$route['shenzhen'] = '/city/index/?city=62';
$route['tianjin'] = '/city/index/?city=63';
$route['chongqing'] = '/city/index/?city=64';
$route['nanjing'] = '/city/index/?city=65';
$route['shenyang'] = '/city/index/?city=66';
$route['wuhan'] = '/city/index/?city=67';
$route['chengdu'] = '/city/index/?city=68';
$route['xian'] = '/city/index/?city=69';
$route['hangzhou'] = '/city/index/?city=70';
$route['dalian'] = '/city/index/?city=71';
$route['qingdao'] = '/city/index/?city=72';
$route['ningbo'] = '/city/index/?city=73';
$route['xiamen'] = '/city/index/?city=74';
$route['changsha'] = '/city/index/?city=75';
$route['dengzhou'] = '/city/index/?city=76';
$route['harbin'] = '/city/index/?city=77';
$route['jinan'] = '/city/index/?city=78';
$route['wuxi'] = '/city/index/?city=79';
$route['suzhou'] = '/city/index/?city=80';
$route['taiyuan'] = '/city/index/?city=81';
$route['changchun'] = '/city/index/?city=82';
$route['fuzhou'] = '/city/index/?city=83';
$route['urumqi'] = '/city/index/?city=84';
$route['kunming'] = '/city/index/?city=85';
$route['lanzhou'] = '/city/index/?city=86';
$route['nanchang'] = '/city/index/?city=87';
$route['guiyang'] = '/city/index/?city=88';
$route['nanning'] = '/city/index/?city=89';
$route['hefei'] = '/city/index/?city=90';
$route['shijiazhuang'] = '/city/index/?city=91';
$route['baotou'] = '/city/index/?city=92';
$route['hohhot'] = '/city/index/?city=93';
$route['haikou'] = '/city/index/?city=96';
$route['seoul'] = '/city/index/?city=97';

$route['newyork-shopdiscount'] = '/discount/index/?city=1';
$route['losangeles-shopdiscount'] = '/discount/index/?city=2';
$route['chicago-shopdiscount'] = '/discount/index/?city=3';
$route['lasvegas-shopdiscount'] = '/discount/index/?city=4';
$route['sanfrancisco-shopdiscount'] = '/discount/index/?city=5';
$route['washington-shopdiscount'] = '/discount/index/?city=6';
$route['hawaii-shopdiscount'] = '/discount/index/?city=7';
$route['toronto-shopdiscount'] = '/discount/index/?city=8';
$route['vancouver-shopdiscount'] = '/discount/index/?city=9';
$route['boston-shopdiscount'] = '/discount/index/?city=10';
$route['houston-shopdiscount'] = '/discount/index/?city=11';
$route['dallas-shopdiscount'] = '/discount/index/?city=12';
$route['miami-shopdiscount'] = '/discount/index/?city=13';
$route['atlanta-shopdiscount'] = '/discount/index/?city=14';
$route['orlando-shopdiscount'] = '/discount/index/?city=15';
$route['sandiego-shopdiscount'] = '/discount/index/?city=16';
$route['philadelphia-shopdiscount'] = '/discount/index/?city=17';
$route['seattle-shopdiscount'] = '/discount/index/?city=18';
$route['montreal-shopdiscount'] = '/discount/index/?city=19';
$route['paris-shopdiscount'] = '/discount/index/?city=20';
$route['london-shopdiscount'] = '/discount/index/?city=21';
$route['milano-shopdiscount'] = '/discount/index/?city=22';
$route['roma-shopdiscount'] = '/discount/index/?city=23';
$route['venezia-shopdiscount'] = '/discount/index/?city=24';
$route['firenze-shopdiscount'] = '/discount/index/?city=25';
$route['berlin-shopdiscount'] = '/discount/index/?city=26';
$route['frankfurt-shopdiscount'] = '/discount/index/?city=27';
$route['munich-shopdiscount'] = '/discount/index/?city=28';
$route['barcelona-shopdiscount'] = '/discount/index/?city=29';
$route['madrid-shopdiscount'] = '/discount/index/?city=30';
$route['hamburg-shopdiscount'] = '/discount/index/?city=31';
$route['duesseldorf-shopdiscount'] = '/discount/index/?city=32';
$route['edinburgh-shopdiscount'] = '/discount/index/?city=33';
$route['liverpool-shopdiscount'] = '/discount/index/?city=34';
$route['manchester-shopdiscount'] = '/discount/index/?city=35';
$route['geneva-shopdiscount'] = '/discount/index/?city=36';
$route['zurich-shopdiscount'] = '/discount/index/?city=37';
$route['athens-shopdiscount'] = '/discount/index/?city=38';
$route['brussel-shopdiscount'] = '/discount/index/?city=39';
$route['luxembourg-shopdiscount'] = '/discount/index/?city=40';
$route['viena-shopdiscount'] = '/discount/index/?city=41';
$route['cardiff-shopdiscount'] = '/discount/index/?city=42';
$route['york-shopdiscount'] = '/discount/index/?city=43';
$route['hongkong-shopdiscount'] = '/discount/index/?city=44';
$route['macao-shopdiscount'] = '/discount/index/?city=45';
$route['taipei-shopdiscount'] = '/discount/index/?city=49';
$route['kaohsiung-shopdiscount'] = '/discount/index/?city=50';
$route['tokyo-shopdiscount'] = '/discount/index/?city=51';
$route['osaka-shopdiscount'] = '/discount/index/?city=52';
$route['nagoya-shopdiscount'] = '/discount/index/?city=53';
$route['dubai-shopdiscount'] = '/discount/index/?city=54';
$route['singapore-shopdiscount'] = '/discount/index/?city=55';
$route['dublin-shopdiscount'] = '/discount/index/?city=56';
$route['kobe-shopdiscount'] = '/discount/index/?city=57';
$route['kyoto-shopdiscount'] = '/discount/index/?city=58';
$route['beijing-shopdiscount'] = '/discount/index/?city=59';
$route['shanghai-shopdiscount'] = '/discount/index/?city=60';
$route['guangzhou-shopdiscount'] = '/discount/index/?city=61';
$route['shenzhen-shopdiscount'] = '/discount/index/?city=62';
$route['tianjin-shopdiscount'] = '/discount/index/?city=63';
$route['chongqing-shopdiscount'] = '/discount/index/?city=64';
$route['nanjing-shopdiscount'] = '/discount/index/?city=65';
$route['shenyang-shopdiscount'] = '/discount/index/?city=66';
$route['wuhan-shopdiscount'] = '/discount/index/?city=67';
$route['chengdu-shopdiscount'] = '/discount/index/?city=68';
$route['xian-shopdiscount'] = '/discount/index/?city=69';
$route['hangzhou-shopdiscount'] = '/discount/index/?city=70';
$route['dalian-shopdiscount'] = '/discount/index/?city=71';
$route['qingdao-shopdiscount'] = '/discount/index/?city=72';
$route['ningbo-shopdiscount'] = '/discount/index/?city=73';
$route['xiamen-shopdiscount'] = '/discount/index/?city=74';
$route['changsha-shopdiscount'] = '/discount/index/?city=75';
$route['dengzhou-shopdiscount'] = '/discount/index/?city=76';
$route['harbin-shopdiscount'] = '/discount/index/?city=77';
$route['jinan-shopdiscount'] = '/discount/index/?city=78';
$route['wuxi-shopdiscount'] = '/discount/index/?city=79';
$route['suzhou-shopdiscount'] = '/discount/index/?city=80';
$route['taiyuan-shopdiscount'] = '/discount/index/?city=81';
$route['changchun-shopdiscount'] = '/discount/index/?city=82';
$route['fuzhou-shopdiscount'] = '/discount/index/?city=83';
$route['urumqi-shopdiscount'] = '/discount/index/?city=84';
$route['kunming-shopdiscount'] = '/discount/index/?city=85';
$route['lanzhou-shopdiscount'] = '/discount/index/?city=86';
$route['nanchang-shopdiscount'] = '/discount/index/?city=87';
$route['guiyang-shopdiscount'] = '/discount/index/?city=88';
$route['nanning-shopdiscount'] = '/discount/index/?city=89';
$route['hefei-shopdiscount'] = '/discount/index/?city=90';
$route['shijiazhuang-shopdiscount'] = '/discount/index/?city=91';
$route['baotou-shopdiscount'] = '/discount/index/?city=92';
$route['hohhot-shopdiscount'] = '/discount/index/?city=93';
$route['haikou-shopdiscount'] = '/discount/index/?city=96';
$route['seoul-shopdiscount'] = '/discount/index/?city=97';



$route['newyork/(:num)'] = '/shop/index/?shop_id=$1';
$route['losangeles/(:num)'] = '/shop/index/?shop_id=$1';
$route['chicago/(:num)'] = '/shop/index/?shop_id=$1';
$route['lasvegas/(:num)'] = '/shop/index/?shop_id=$1';
$route['sanfrancisco/(:num)'] = '/shop/index/?shop_id=$1';
$route['washington/(:num)'] = '/shop/index/?shop_id=$1';
$route['hawaii/(:num)'] = '/shop/index/?shop_id=$1';
$route['toronto/(:num)'] = '/shop/index/?shop_id=$1';
$route['vancouver/(:num)'] = '/shop/index/?shop_id=$1';
$route['boston/(:num)'] = '/shop/index/?shop_id=$1';
$route['houston/(:num)'] = '/shop/index/?shop_id=$1';
$route['dallas/(:num)'] = '/shop/index/?shop_id=$1';
$route['miami/(:num)'] = '/shop/index/?shop_id=$1';
$route['atlanta/(:num)'] = '/shop/index/?shop_id=$1';
$route['orlando/(:num)'] = '/shop/index/?shop_id=$1';
$route['sandiego/(:num)'] = '/shop/index/?shop_id=$1';
$route['philadelphia/(:num)'] = '/shop/index/?shop_id=$1';
$route['seattle/(:num)'] = '/shop/index/?shop_id=$1';
$route['montreal/(:num)'] = '/shop/index/?shop_id=$1';
$route['paris/(:num)'] = '/shop/index/?shop_id=$1';
$route['london/(:num)'] = '/shop/index/?shop_id=$1';
$route['milano/(:num)'] = '/shop/index/?shop_id=$1';
$route['roma/(:num)'] = '/shop/index/?shop_id=$1';
$route['venezia/(:num)'] = '/shop/index/?shop_id=$1';
$route['firenze/(:num)'] = '/shop/index/?shop_id=$1';
$route['berlin/(:num)'] = '/shop/index/?shop_id=$1';
$route['frankfurt/(:num)'] = '/shop/index/?shop_id=$1';
$route['munich/(:num)'] = '/shop/index/?shop_id=$1';
$route['barcelona/(:num)'] = '/shop/index/?shop_id=$1';
$route['madrid/(:num)'] = '/shop/index/?shop_id=$1';
$route['hamburg/(:num)'] = '/shop/index/?shop_id=$1';
$route['duesseldorf/(:num)'] = '/shop/index/?shop_id=$1';
$route['edinburgh/(:num)'] = '/shop/index/?shop_id=$1';
$route['liverpool/(:num)'] = '/shop/index/?shop_id=$1';
$route['manchester/(:num)'] = '/shop/index/?shop_id=$1';
$route['geneva/(:num)'] = '/shop/index/?shop_id=$1';
$route['zurich/(:num)'] = '/shop/index/?shop_id=$1';
$route['athens/(:num)'] = '/shop/index/?shop_id=$1';
$route['brussel/(:num)'] = '/shop/index/?shop_id=$1';
$route['luxembourg/(:num)'] = '/shop/index/?shop_id=$1';
$route['viena/(:num)'] = '/shop/index/?shop_id=$1';
$route['cardiff/(:num)'] = '/shop/index/?shop_id=$1';
$route['york/(:num)'] = '/shop/index/?shop_id=$1';
$route['hongkong/(:num)'] = '/shop/index/?shop_id=$1';
$route['macao/(:num)'] = '/shop/index/?shop_id=$1';
$route['taipei/(:num)'] = '/shop/index/?shop_id=$1';
$route['kaohsiung/(:num)'] = '/shop/index/?shop_id=$1';
$route['tokyo/(:num)'] = '/shop/index/?shop_id=$1';
$route['osaka/(:num)'] = '/shop/index/?shop_id=$1';
$route['nagoya/(:num)'] = '/shop/index/?shop_id=$1';
$route['dubai/(:num)'] = '/shop/index/?shop_id=$1';
$route['singapore/(:num)'] = '/shop/index/?shop_id=$1';
$route['dublin/(:num)'] = '/shop/index/?shop_id=$1';
$route['kobe/(:num)'] = '/shop/index/?shop_id=$1';
$route['kyoto/(:num)'] = '/shop/index/?shop_id=$1';
$route['beijing/(:num)'] = '/shop/index/?shop_id=$1';
$route['shanghai/(:num)'] = '/shop/index/?shop_id=$1';
$route['guangzhou/(:num)'] = '/shop/index/?shop_id=$1';
$route['shenzhen/(:num)'] = '/shop/index/?shop_id=$1';
$route['tianjin/(:num)'] = '/shop/index/?shop_id=$1';
$route['chongqing/(:num)'] = '/shop/index/?shop_id=$1';
$route['nanjing/(:num)'] = '/shop/index/?shop_id=$1';
$route['shenyang/(:num)'] = '/shop/index/?shop_id=$1';
$route['wuhan/(:num)'] = '/shop/index/?shop_id=$1';
$route['chengdu/(:num)'] = '/shop/index/?shop_id=$1';
$route['xian/(:num)'] = '/shop/index/?shop_id=$1';
$route['hangzhou/(:num)'] = '/shop/index/?shop_id=$1';
$route['dalian/(:num)'] = '/shop/index/?shop_id=$1';
$route['qingdao/(:num)'] = '/shop/index/?shop_id=$1';
$route['ningbo/(:num)'] = '/shop/index/?shop_id=$1';
$route['xiamen/(:num)'] = '/shop/index/?shop_id=$1';
$route['changsha/(:num)'] = '/shop/index/?shop_id=$1';
$route['dengzhou/(:num)'] = '/shop/index/?shop_id=$1';
$route['harbin/(:num)'] = '/shop/index/?shop_id=$1';
$route['jinan/(:num)'] = '/shop/index/?shop_id=$1';
$route['wuxi/(:num)'] = '/shop/index/?shop_id=$1';
$route['suzhou/(:num)'] = '/shop/index/?shop_id=$1';
$route['taiyuan/(:num)'] = '/shop/index/?shop_id=$1';
$route['changchun/(:num)'] = '/shop/index/?shop_id=$1';
$route['fuzhou/(:num)'] = '/shop/index/?shop_id=$1';
$route['urumqi/(:num)'] = '/shop/index/?shop_id=$1';
$route['kunming/(:num)'] = '/shop/index/?shop_id=$1';
$route['lanzhou/(:num)'] = '/shop/index/?shop_id=$1';
$route['nanchang/(:num)'] = '/shop/index/?shop_id=$1';
$route['guiyang/(:num)'] = '/shop/index/?shop_id=$1';
$route['nanning/(:num)'] = '/shop/index/?shop_id=$1';
$route['hefei/(:num)'] = '/shop/index/?shop_id=$1';
$route['shijiazhuang/(:num)'] = '/shop/index/?shop_id=$1';
$route['baotou/(:num)'] = '/shop/index/?shop_id=$1';
$route['hohhot/(:num)'] = '/shop/index/?shop_id=$1';
$route['haikou/(:num)'] = '/shop/index/?shop_id=$1';
$route['seoul/(:num)'] = '/shop/index/?shop_id=$1';






$route['newyork-shoppingtips'] = '/discount/shoptips_list/?city=1';
$route['losangeles-shoppingtips'] = '/discount/shoptips_list/?city=2';
$route['chicago-shoppingtips'] = '/discount/shoptips_list/?city=3';
$route['lasvegas-shoppingtips'] = '/discount/shoptips_list/?city=4';
$route['sanfrancisco-shoppingtips'] = '/discount/shoptips_list/?city=5';
$route['washington-shoppingtips'] = '/discount/shoptips_list/?city=6';
$route['hawaii-shoppingtips'] = '/discount/shoptips_list/?city=7';
$route['toronto-shoppingtips'] = '/discount/shoptips_list/?city=8';
$route['vancouver-shoppingtips'] = '/discount/shoptips_list/?city=9';
$route['boston-shoppingtips'] = '/discount/shoptips_list/?city=10';
$route['houston-shoppingtips'] = '/discount/shoptips_list/?city=11';
$route['dallas-shoppingtips'] = '/discount/shoptips_list/?city=12';
$route['miami-shoppingtips'] = '/discount/shoptips_list/?city=13';
$route['atlanta-shoppingtips'] = '/discount/shoptips_list/?city=14';
$route['orlando-shoppingtips'] = '/discount/shoptips_list/?city=15';
$route['sandiego-shoppingtips'] = '/discount/shoptips_list/?city=16';
$route['philadelphia-shoppingtips'] = '/discount/shoptips_list/?city=17';
$route['seattle-shoppingtips'] = '/discount/shoptips_list/?city=18';
$route['montreal-shoppingtips'] = '/discount/shoptips_list/?city=19';
$route['paris-shoppingtips'] = '/discount/shoptips_list/?city=20';
$route['london-shoppingtips'] = '/discount/shoptips_list/?city=21';
$route['milano-shoppingtips'] = '/discount/shoptips_list/?city=22';
$route['roma-shoppingtips'] = '/discount/shoptips_list/?city=23';
$route['venezia-shoppingtips'] = '/discount/shoptips_list/?city=24';
$route['firenze-shoppingtips'] = '/discount/shoptips_list/?city=25';
$route['berlin-shoppingtips'] = '/discount/shoptips_list/?city=26';
$route['frankfurt-shoppingtips'] = '/discount/shoptips_list/?city=27';
$route['munich-shoppingtips'] = '/discount/shoptips_list/?city=28';
$route['barcelona-shoppingtips'] = '/discount/shoptips_list/?city=29';
$route['madrid-shoppingtips'] = '/discount/shoptips_list/?city=30';
$route['hamburg-shoppingtips'] = '/discount/shoptips_list/?city=31';
$route['duesseldorf-shoppingtips'] = '/discount/shoptips_list/?city=32';
$route['edinburgh-shoppingtips'] = '/discount/shoptips_list/?city=33';
$route['liverpool-shoppingtips'] = '/discount/shoptips_list/?city=34';
$route['manchester-shoppingtips'] = '/discount/shoptips_list/?city=35';
$route['geneva-shoppingtips'] = '/discount/shoptips_list/?city=36';
$route['zurich-shoppingtips'] = '/discount/shoptips_list/?city=37';
$route['athens-shoppingtips'] = '/discount/shoptips_list/?city=38';
$route['brussel-shoppingtips'] = '/discount/shoptips_list/?city=39';
$route['luxembourg-shoppingtips'] = '/discount/shoptips_list/?city=40';
$route['viena-shoppingtips'] = '/discount/shoptips_list/?city=41';
$route['cardiff-shoppingtips'] = '/discount/shoptips_list/?city=42';
$route['york-shoppingtips'] = '/discount/shoptips_list/?city=43';
$route['hongkong-shoppingtips'] = '/discount/shoptips_list/?city=44';
$route['macao-shoppingtips'] = '/discount/shoptips_list/?city=45';
$route['taipei-shoppingtips'] = '/discount/shoptips_list/?city=49';
$route['kaohsiung-shoppingtips'] = '/discount/shoptips_list/?city=50';
$route['tokyo-shoppingtips'] = '/discount/shoptips_list/?city=51';
$route['osaka-shoppingtips'] = '/discount/shoptips_list/?city=52';
$route['nagoya-shoppingtips'] = '/discount/shoptips_list/?city=53';
$route['dubai-shoppingtips'] = '/discount/shoptips_list/?city=54';
$route['singapore-shoppingtips'] = '/discount/shoptips_list/?city=55';
$route['dublin-shoppingtips'] = '/discount/shoptips_list/?city=56';
$route['kobe-shoppingtips'] = '/discount/shoptips_list/?city=57';
$route['kyoto-shoppingtips'] = '/discount/shoptips_list/?city=58';
$route['beijing-shoppingtips'] = '/discount/shoptips_list/?city=59';
$route['shanghai-shoppingtips'] = '/discount/shoptips_list/?city=60';
$route['guangzhou-shoppingtips'] = '/discount/shoptips_list/?city=61';
$route['shenzhen-shoppingtips'] = '/discount/shoptips_list/?city=62';
$route['tianjin-shoppingtips'] = '/discount/shoptips_list/?city=63';
$route['chongqing-shoppingtips'] = '/discount/shoptips_list/?city=64';
$route['nanjing-shoppingtips'] = '/discount/shoptips_list/?city=65';
$route['shenyang-shoppingtips'] = '/discount/shoptips_list/?city=66';
$route['wuhan-shoppingtips'] = '/discount/shoptips_list/?city=67';
$route['chengdu-shoppingtips'] = '/discount/shoptips_list/?city=68';
$route['xian-shoppingtips'] = '/discount/shoptips_list/?city=69';
$route['hangzhou-shoppingtips'] = '/discount/shoptips_list/?city=70';
$route['dalian-shoppingtips'] = '/discount/shoptips_list/?city=71';
$route['qingdao-shoppingtips'] = '/discount/shoptips_list/?city=72';
$route['ningbo-shoppingtips'] = '/discount/shoptips_list/?city=73';
$route['xiamen-shoppingtips'] = '/discount/shoptips_list/?city=74';
$route['changsha-shoppingtips'] = '/discount/shoptips_list/?city=75';
$route['dengzhou-shoppingtips'] = '/discount/shoptips_list/?city=76';
$route['harbin-shoppingtips'] = '/discount/shoptips_list/?city=77';
$route['jinan-shoppingtips'] = '/discount/shoptips_list/?city=78';
$route['wuxi-shoppingtips'] = '/discount/shoptips_list/?city=79';
$route['suzhou-shoppingtips'] = '/discount/shoptips_list/?city=80';
$route['taiyuan-shoppingtips'] = '/discount/shoptips_list/?city=81';
$route['changchun-shoppingtips'] = '/discount/shoptips_list/?city=82';
$route['fuzhou-shoppingtips'] = '/discount/shoptips_list/?city=83';
$route['urumqi-shoppingtips'] = '/discount/shoptips_list/?city=84';
$route['kunming-shoppingtips'] = '/discount/shoptips_list/?city=85';
$route['lanzhou-shoppingtips'] = '/discount/shoptips_list/?city=86';
$route['nanchang-shoppingtips'] = '/discount/shoptips_list/?city=87';
$route['guiyang-shoppingtips'] = '/discount/shoptips_list/?city=88';
$route['nanning-shoppingtips'] = '/discount/shoptips_list/?city=89';
$route['hefei-shoppingtips'] = '/discount/shoptips_list/?city=90';
$route['shijiazhuang-shoppingtips'] = '/discount/shoptips_list/?city=91';
$route['baotou-shoppingtips'] = '/discount/shoptips_list/?city=92';
$route['hohhot-shoppingtips'] = '/discount/shoptips_list/?city=93';
$route['haikou-shoppingtips'] = '/discount/shoptips_list/?city=96';
$route['seoul-shoppingtips'] = '/discount/shoptips_list/?city=97';

$route['newyork-shoppingmap'] = '/city_map/index/?city=1';
$route['losangeles-shoppingmap'] = '/city_map/index/?city=2';
$route['chicago-shoppingmap'] = '/city_map/index/?city=3';
$route['lasvegas-shoppingmap'] = '/city_map/index/?city=4';
$route['sanfrancisco-shoppingmap'] = '/city_map/index/?city=5';
$route['washington-shoppingmap'] = '/city_map/index/?city=6';
$route['hawaii-shoppingmap'] = '/city_map/index/?city=7';
$route['toronto-shoppingmap'] = '/city_map/index/?city=8';
$route['vancouver-shoppingmap'] = '/city_map/index/?city=9';
$route['boston-shoppingmap'] = '/city_map/index/?city=10';
$route['houston-shoppingmap'] = '/city_map/index/?city=11';
$route['dallas-shoppingmap'] = '/city_map/index/?city=12';
$route['miami-shoppingmap'] = '/city_map/index/?city=13';
$route['atlanta-shoppingmap'] = '/city_map/index/?city=14';
$route['orlando-shoppingmap'] = '/city_map/index/?city=15';
$route['sandiego-shoppingmap'] = '/city_map/index/?city=16';
$route['philadelphia-shoppingmap'] = '/city_map/index/?city=17';
$route['seattle-shoppingmap'] = '/city_map/index/?city=18';
$route['montreal-shoppingmap'] = '/city_map/index/?city=19';
$route['paris-shoppingmap'] = '/city_map/index/?city=20';
$route['london-shoppingmap'] = '/city_map/index/?city=21';
$route['milano-shoppingmap'] = '/city_map/index/?city=22';
$route['roma-shoppingmap'] = '/city_map/index/?city=23';
$route['venezia-shoppingmap'] = '/city_map/index/?city=24';
$route['firenze-shoppingmap'] = '/city_map/index/?city=25';
$route['berlin-shoppingmap'] = '/city_map/index/?city=26';
$route['frankfurt-shoppingmap'] = '/city_map/index/?city=27';
$route['munich-shoppingmap'] = '/city_map/index/?city=28';
$route['barcelona-shoppingmap'] = '/city_map/index/?city=29';
$route['madrid-shoppingmap'] = '/city_map/index/?city=30';
$route['hamburg-shoppingmap'] = '/city_map/index/?city=31';
$route['duesseldorf-shoppingmap'] = '/city_map/index/?city=32';
$route['edinburgh-shoppingmap'] = '/city_map/index/?city=33';
$route['liverpool-shoppingmap'] = '/city_map/index/?city=34';
$route['manchester-shoppingmap'] = '/city_map/index/?city=35';
$route['geneva-shoppingmap'] = '/city_map/index/?city=36';
$route['zurich-shoppingmap'] = '/city_map/index/?city=37';
$route['athens-shoppingmap'] = '/city_map/index/?city=38';
$route['brussel-shoppingmap'] = '/city_map/index/?city=39';
$route['luxembourg-shoppingmap'] = '/city_map/index/?city=40';
$route['viena-shoppingmap'] = '/city_map/index/?city=41';
$route['cardiff-shoppingmap'] = '/city_map/index/?city=42';
$route['york-shoppingmap'] = '/city_map/index/?city=43';
$route['hongkong-shoppingmap'] = '/city_map/index/?city=44';
$route['macao-shoppingmap'] = '/city_map/index/?city=45';
$route['taipei-shoppingmap'] = '/city_map/index/?city=49';
$route['kaohsiung-shoppingmap'] = '/city_map/index/?city=50';
$route['tokyo-shoppingmap'] = '/city_map/index/?city=51';
$route['osaka-shoppingmap'] = '/city_map/index/?city=52';
$route['nagoya-shoppingmap'] = '/city_map/index/?city=53';
$route['dubai-shoppingmap'] = '/city_map/index/?city=54';
$route['singapore-shoppingmap'] = '/city_map/index/?city=55';
$route['dublin-shoppingmap'] = '/city_map/index/?city=56';
$route['kobe-shoppingmap'] = '/city_map/index/?city=57';
$route['kyoto-shoppingmap'] = '/city_map/index/?city=58';
$route['beijing-shoppingmap'] = '/city_map/index/?city=59';
$route['shanghai-shoppingmap'] = '/city_map/index/?city=60';
$route['guangzhou-shoppingmap'] = '/city_map/index/?city=61';
$route['shenzhen-shoppingmap'] = '/city_map/index/?city=62';
$route['tianjin-shoppingmap'] = '/city_map/index/?city=63';
$route['chongqing-shoppingmap'] = '/city_map/index/?city=64';
$route['nanjing-shoppingmap'] = '/city_map/index/?city=65';
$route['shenyang-shoppingmap'] = '/city_map/index/?city=66';
$route['wuhan-shoppingmap'] = '/city_map/index/?city=67';
$route['chengdu-shoppingmap'] = '/city_map/index/?city=68';
$route['xian-shoppingmap'] = '/city_map/index/?city=69';
$route['hangzhou-shoppingmap'] = '/city_map/index/?city=70';
$route['dalian-shoppingmap'] = '/city_map/index/?city=71';
$route['qingdao-shoppingmap'] = '/city_map/index/?city=72';
$route['ningbo-shoppingmap'] = '/city_map/index/?city=73';
$route['xiamen-shoppingmap'] = '/city_map/index/?city=74';
$route['changsha-shoppingmap'] = '/city_map/index/?city=75';
$route['dengzhou-shoppingmap'] = '/city_map/index/?city=76';
$route['harbin-shoppingmap'] = '/city_map/index/?city=77';
$route['jinan-shoppingmap'] = '/city_map/index/?city=78';
$route['wuxi-shoppingmap'] = '/city_map/index/?city=79';
$route['suzhou-shoppingmap'] = '/city_map/index/?city=80';
$route['taiyuan-shoppingmap'] = '/city_map/index/?city=81';
$route['changchun-shoppingmap'] = '/city_map/index/?city=82';
$route['fuzhou-shoppingmap'] = '/city_map/index/?city=83';
$route['urumqi-shoppingmap'] = '/city_map/index/?city=84';
$route['kunming-shoppingmap'] = '/city_map/index/?city=85';
$route['lanzhou-shoppingmap'] = '/city_map/index/?city=86';
$route['nanchang-shoppingmap'] = '/city_map/index/?city=87';
$route['guiyang-shoppingmap'] = '/city_map/index/?city=88';
$route['nanning-shoppingmap'] = '/city_map/index/?city=89';
$route['hefei-shoppingmap'] = '/city_map/index/?city=90';
$route['shijiazhuang-shoppingmap'] = '/city_map/index/?city=91';
$route['baotou-shoppingmap'] = '/city_map/index/?city=92';
$route['hohhot-shoppingmap'] = '/city_map/index/?city=93';
$route['haikou-shoppingmap'] = '/city_map/index/?city=96';
$route['seoul-shoppingmap'] = '/city_map/index/?city=97';

$route['help/(:num)'] = '/help/index/?tab=$1';

$route['default_controller'] = "home";
# http://zan.com/discount_info/171




$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */