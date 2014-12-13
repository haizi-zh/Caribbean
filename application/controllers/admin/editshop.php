<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class editshop extends ZB_Controller {
		
	const PAGE_ID = 'editshop';
	
	public function index(){

		#load page
		$security = $this->tool->get_pic_securety('ZB_ADMIN_SHOP');#生成安全数据
		$this->load->model('mo_geography');
		$areas = $this->mo_geography->get_all_areas();
		$has_map = isset($_GET['has_map'])?$_GET['has_map']:1;
		
		#商家信息
		$shop_id = isset($_GET['shop_id'])?$_GET['shop_id']:0;
		if(!$shop_id){
			$has_map = 0;
		}
		$this->load->model('mo_shop');
		$shopinfo_re = $this->mo_shop->get_shopinfo_by_ids(array($shop_id));
		$shop = isset($shopinfo_re[$shop_id])?$shopinfo_re[$shop_id]:array();
		
		$countries = array();
		$cities = array();
		if($shop){
			#获取默认国家/城市
			$this->load->model('mo_geography');
			$countries = $this->mo_geography->get_countries_by_area($shop['area']);
			$cities = $this->mo_geography->get_cities_by_country_formadmin($shop['country']);
		}
		
		#获取全部商家
		$shops = $this->mo_shop->get_all_shop();
		
		#header
		#计算地图位置
		$lat = 0;$lon=0;
		$location = isset($shop['location'])?$shop['location']:'';
		if($location){
			$locations = explode(',',$location);
			$lon = trim($locations[0]);
			$lat = trim($locations[1]);
		}
		
		$data = array('has_map'=>$has_map, 'shops'=>$shops,'areas'=>$areas,'policy'=> $security['policy'],'signature'=>$security['signature'],'shop'=>$shop,'countries'=>$countries,'cities'=>$cities);
		
		$data['pageid'] = self::PAGE_ID;
		$data['lat'] = $lat;
		$data['lon'] = $lon;
		$data['shop_id'] = $shop_id;
		$this->load->admin_view('admin/editshop', $data);
		

	}




}