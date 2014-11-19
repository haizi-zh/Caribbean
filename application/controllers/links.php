<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Links extends ZB_Controller {
	const PAGE_ID = 'links';
	public function __construct(){
		parent::__construct();
		$this->load->model("mo_link");

	}
	public function index(){
		$data = array();

		$link_list = array();
$link_list['旅游类'] = array(
"http://www.kuxun.cn/" =>"酷讯",
"http://www.elong.com/" =>"艺龙网",
"http://www.tuniu.com/" =>"途牛旅游网",
"http://www.ctrip.com/" =>"携程网",
"http://www.shijiebang.com/" =>"出国旅游网",
"http://www.qunar.com/site/zh/Links_8.shtml" =>"去哪儿",
"http://www.lvmama.com/" =>"驴妈妈旅游网",
"http://www.cits.cn/cits/home.htm" =>"国旅",
"http://www.aoyou.com/" =>"遨游网",
"http://www.qulxw.com/" =>"北京国旅",
"http://www.eotour.com/" =>"北青旅",
"http://www.qi-miao.com/" =>"奇妙旅行",
"http://www.qi-miao.com/" =>"欣欣旅游",
"http://www.mafengwo.cn/" =>"蚂蜂窝",
"http://chanyouji.com/" =>"蝉游记",
"http://breadtrip.com" =>"面包旅行",
"http://www.lotour.com/" =>"乐途旅游",
"http://www.huanqiu.com/" =>"环球网",

);

$link_list['国外著名百货公司电商网站'] = array(
"http://www.bloomingdales.com/" =>"Bloomingdale's",
"https://www.saksfifthavenue.com/" =>"Saks Fifth Avenue",
"http://www.lordandtaylor.com/" =>"Lord & Taylor",
"http://www.barneys.com/" =>"Barneys New York",
"http://www.neimanmarcus.com/" =>"Neiman Marcus",
"http://www.target.com/" =>"Target",
"http://www.walmart.com/" =>"Walmart.com",
"http://www.amazon.com/" =>"Amazon",
"http://www.calvinklein.com/"=>"Aalvin Klein",
);


$link_list['购物类'] = array(
"http://www.ymatou.com/" =>"洋码头",
"http://link.mplife.com/" =>"名品导购",
"http://www.5lux.com/index.php" =>"第五大道奢侈品",
"http://www.jumei.com/about/friend_links" =>"聚美优品",
"http://w2.vipshop.com/help_center/friend.php" =>"唯品会",
"http://www.lefeng.com/zhuanti/help/lxkf.html?biid=7520" =>"乐峰网",
);
$link_list['时尚类'] = array(
"http://www.onlylady.com/" =>"Onlylady女人志",
"http://www.fashiontrenddigest.com/" =>"观潮网",
"http://www.marieclairechina.com/aboutus/partners/" =>"嘉人",
"http://www.grazia.com.cn/about/links/" =>"红秀",
"http://www.ellechina.com/aboutus/partners/index.shtml" =>"ELLE",
);

$link_list['创业类'] = array(
"http://www.cyzone.cn/" =>"创业邦",
);
      

//<a href="http://test.skimlinks.com">Skimlinks Test</a>
$link_list['其它'] = array(

"http://www.hao123.com/" =>"hao123",
"http://hao.360.cn/" =>"360安全网址导航",
"http://se.360.cn/" =>"360安全浏览器",
"http://www.mosh.cn/" =>"魔时网",
"http://www.xitek.com/html/about/tome.html" =>"色影无忌",
"http://tuchong.com/info/links/" =>"图虫网",
"http://test.skimlinks.com" => "Skimlinks Test",
);
/*
$this->load->database();	
$now = time();
$cat_list = $this->mo_link->get_cat_list();
var_dump($cat_list);
foreach($link_list as $k => $v){
	foreach($cat_list as $vv){
		if($k == $vv['name']){
			$cat_id = $vv['id'];
			break;
		}
	}
	foreach($v as $url=>$name){
		$this->db->select("*");
		$this->db->where("name", $name);
		$this->db->where("url", $url);
		$query = $this->db->get('zb_link');
		$re = $query->row_array();
		if(!$re){
			$add_data = array();
			$add_data['cat_id'] = $cat_id;
			$add_data['name'] = $name;
			$add_data['url'] = $url;
			$add_data['ctime'] = $now;
			$add_data['mtime'] = $now;
			
			$this->db->insert("zb_link", $add_data);
		}
	}
	var_dump($cat_id);

}
*/


$cat_list = $this->mo_link->get_cat_list();
if($cat_list){
	foreach($cat_list as $k=>$v){
		$cat_id = $v['id'];
		$link_list = $this->mo_link->get_link_list($cat_id);
		$cat_list[$k]['links'] = $link_list;
		$cat_list[$k]['links_count'] = count($link_list);
	}
}
$data['cat_list'] = $cat_list;

		$data['link_list'] = $link_list;
		$data['pageid'] = self::PAGE_ID;
		$data['page_title'] = "友情链接";
		$data['seo_keywords'] = "赞佰网,赞佰,zanbai,购物,出境,出国,攻略,指南,折扣,点评,购物信息";
		$data['seo_description'] = "购物街区、百货公司、奥特莱斯，一网打尽，赞佰网为您提供海外购物场所最全名录，经验分享，折扣优惠，购物攻略，带您畅购海外，一站搞定";
		

		$this->get_adv_data();
		
		$this->load->web_view('links', $data);
	}

}