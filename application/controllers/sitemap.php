<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sitemap extends ZB_Controller {
	const PAGE_ID = 'sitemap';
	const CACHA_TIME = 3000;

	public function __construct(){
		parent::__construct();
		$this->load->model('mo_shop');
		$this->load->model('mo_brand');
		$this->load->model('mo_discount');
		$this->load->model('mo_common');
		$this->load->model('mo_geography');
		$this->load->model('mo_coupon');
		$this->load->model("mo_dianping");
	}

	public function index(){
		$data = $this->get_data();
		$this->get_adv_data();
		
		$this->load->web_view('sitemap', $data);
	}

	private function get_data(){
		//缓存的key
		$use_memcache = context::get('use_memcache', 0);

		if($use_memcache){
			$cache_keys = context::get("cache_keys", false);
			$cache_key_templage = "%s_sitemap";
			$cache_key = sprintf($cache_key_templage, $cache_keys['sitemap_pre']);
			

			$data =  $this->memcached_library->get($cache_key);
			if($data){
				return $data;
			}
		}

		$data = array();

		$citys = $this->mo_geography->get_all_cityinfos();
		$city_template = "http://www.zanbai.com/%s/";
		$shoppingtips_template = "http://www.zanbai.com/%s-shoppingtips/";
		$shoppingmap_template = "http://www.zanbai.com/%s-shoppingmap/";

		$north = $eurpoe = $asia = array();

		$list = array(1=>'north',2=>'eurpoe',3=>'asia');

		foreach ($list as $area_id=>$save_list){
			$city_lines = $tips_lines = $map_lines = array();
			$lines = array();
			foreach($citys as $kk=>$city){

				if($city['area_id'] == $area_id){
					$city_line = sprintf($city_template, $city['lower_name']);
					$lines[$city_line] = $city['name']."购物中心";
					$shoppingtips_line = sprintf($shoppingtips_template, $city['lower_name']);
					$lines[$shoppingtips_line] = $city['name']."购物攻略";
					$shoppingmap_line = sprintf($shoppingmap_template, $city['lower_name']);
					$lines[$shoppingmap_line] = $city['name']."购物地图";
				}
			}
			${$save_list} = $lines;
		}

		// 城市购物中心列表   
		// 城市购物攻略列表 
		// 城市购物地图
		
		$link_list['北美'] = $north;
		$link_list['亚太'] = $asia;
		$link_list['欧洲'] = $eurpoe;

		$data['link_list'] = $link_list;
		$data['pageid'] = self::PAGE_ID;
		$data['page_css'] = "ZB_links.css";
		$data['page_title'] = "网站地图";
		$data['seo_keywords'] = "赞佰网,赞佰,zanbai,购物,出境,出国,攻略,指南,折扣,点评,购物信息";
		$data['seo_description'] = "购物街区、百货公司、奥特莱斯，一网打尽，赞佰网为您提供海外购物场所最全名录，经验分享，折扣优惠，购物攻略，带您畅购海外，一站搞定";
		

		//写入缓存
		if($use_memcache){
			$this->memcached_library->set($cache_key, $data, self::CACHA_TIME);
		}

		return $data;
	}

}