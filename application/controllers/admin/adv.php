<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class adv extends ZB_Controller {
		
	const PAGE_ID = 'adv';
	const PAGESIZE = 50;
	public function __construct(){
		parent::__construct();
		$this->load->model('mo_adv');
	}


	// zan.com/admin/adv/index
	public function index(){
		$status = $this->input->get('status', true, 0);
		
		$this->load->config("adv");
		$adv_types = $this->config->item("adv_types");
		$page = $this->input->get('page', true, 1);
		$page = intval($page);

		$pagesize = self::PAGESIZE;
		$list = $this->mo_adv->get_list($status, $page, $pagesize);
		$count = $this->mo_adv->get_list_count($status);
		$brand_name = $shop_name = $city_name = $country_name = "";
		$shop_infos = array();
		$level = 0;
		if($list){
			$this->load->model("do/do_city");
			$this->load->model('mo_geography');
			$this->load->model('mo_shop');
			$citys = $this->do_city->get_all_citys();
			$countrys = $this->mo_geography->get_all_countrys();
			$shops = $this->mo_shop->get_all_shop();

			foreach($list as $k => $v){
				$country = $v['country'];
				$city = $v['city'];
				$shop_id = $v['shop_id'];
				$n_shop_id = $v['n_shop_id'];
				$n_city = $v['n_city'];
				$country_name = $city_name = $shop_name = $n_shop_name = $n_city_name = "";
				if($country){
					$tmp = explode(",", $country);
					foreach($tmp as $v){
						if($v && isset($countrys[$v])){
							$country_name .=  ",". $countrys[$v]['name'];
						}
					}
				}
				if($city){
					$tmp = explode(",", $city);
					foreach($tmp as $v){
						if($v && isset($citys[$v])){
							$city_name .=  ",". $citys[$v]['name'];
						}
					}
				}
				if($shop_id){
					$tmp = explode(",", $shop_id);
					foreach($tmp as $v){
						if($v && isset($shops[$v])){
							$shop_name .=  ",". $shops[$v]['name'];
						}
					}
				}
				if($n_shop_id){
					$tmp = explode(",", $n_shop_id);
					foreach($tmp as $v){
						if($v && isset($shops[$v])){
							$n_shop_name .=  ",". $shops[$v]['name'];
						}
					}
				}
				if($n_city){
					$tmp = explode(",", $n_city);
					foreach($tmp as $v){
						if($v && isset($citys[$v])){
							$n_city_name .=  ",". $citys[$v]['name'];
						}
					}
				}
				$list[$k]['country_name'] = $country_name;
				$list[$k]['city_name'] = $city_name;
				$list[$k]['shop_name'] = $shop_name;
				$list[$k]['n_shop_name'] = $n_shop_name;
				$list[$k]['n_city_name'] = $n_city_name;
			}

		}
		$this->load->library ( 'extend' ); // 调用分页类
		$page_html = $this->extend->defaultPage ( ceil ( $count / $pagesize ) , $page, $count, $pagesize );


		$data = array();
		$data['status'] = $status;
		$data['list'] = $list;
		$data['page_html'] = $page_html;
		$data['offset'] = ($page - 1)*$pagesize;
		$data['adv_types'] = $adv_types;
		$data['pageid'] = self::PAGE_ID;
		$this->load->admin_view('admin/adv/lists', $data);
	}
	
	// zan.com/admin/adv/add
	public function add(){
		$data = array();
		$this->load->config("adv");
		$adv_types = $this->config->item("adv_types");
		$data['adv_types'] = $adv_types;
		$id = $this->input->get('id', true, 0);
		$info = array();
		if($id){
			$info = $this->mo_adv->get_info($id);
		}
		$data['info'] = $info;
		$data['id'] = $id;

		$security = $this->tool->get_pic_securety('ZB_ADMIN_SHOP');#生成安全数据
		$data['policy'] = $security['policy'];
		$data['signature'] = $security['signature'];

		$data['pageid'] = self::PAGE_ID;
		$this->load->admin_view('admin/adv/add', $data);
	}
}