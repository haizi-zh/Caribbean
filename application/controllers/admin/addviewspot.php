<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class addviewspot extends ZB_Controller {
		
	const PAGE_ID = 'addviewspot';
	const PAGESIZE = 100;
	public function __construct(){
		parent::__construct();
		// $this->load->model("mo_coupon");
		// $this->load->model("mo_brand");
		// $this->load->model("mo_geography");
		// $this->load->model("mo_directions");
	}

	public function index(){
		#load page
		$security = $this->tool->get_pic_securety('ZB_ADMIN_SHOP');#生成安全数据
		//$this->load->model('mo_geography');
		//$areas = $this->mo_geography->get_all_areas();
		$data = array();
		$data['pageid'] = self::PAGE_ID;
		$data['areas'] = $areas;
		$data['policy'] = $security['policy'];
		$data['signature'] = $security['signature'];
		$this->load->admin_view('admin/addviewspot', $data);
	}

	public function viewspotlist(){
		$pagesize = self::PAGESIZE;
		// $citys = $this->mo_geography->get_all_cityinfos();
		
		 $name = $this->input->get("name", true, '');
		 $id = $this->input->get("id", true, '');
		 $page = $this->input->get('page', true, 1);
		 $city = $this->input->get('city', true, 0);
		 $is_direction = $this->input->get('is_direction', true, 0);
		 if(!$page){
		 	$page = 1;
		 }

		//$this->load->model("mo_shop");
		$offset = ($page - 1) * $pagesize;
		$params = array();
		//$all_directions_shopids = $this->mo_directions->get_all_shop_ids();
		
		// if($is_direction && $all_directions_shopids){
		// 	$shop_ids_list = implode(",", $all_directions_shopids);
		// 	$params[] = " id in  ({$shop_ids_list})";
		// 	$page_html = "";
		// }
		// if($id){
		// 	$params[] = " id={$id}";
		// 	$page_html = "";
		// }
		// if($name){
		// 	$params[] = " name like '%{$name}%'";
		// 	$page_html = "";
		// 	$params[] = " english_name like '%{$name}%'";
		// 	$page_html = "";
		// }
		// if($city){
		// 	$params[] = " city={$city}";
		// 	$page_html = "";
		// 	$pagesize = 400;
		// }
		//$list = $this->mo_shop->get_shop_list_for_admin($page, $pagesize, $params);
		foreach($list as $k=>$v){
			if($v['status'] != 0){
				unset($list[$k]);
			}
		}

		//$count = $this->mo_shop->get_shop_cnt_for_admin( $params);

		
		$this->load->library ( 'extend' ); // 调用分页类
		$page_html = $this->extend->defaultPage ( ceil ( $count / $pagesize ) , $page, $count, $pagesize );

		$offset = ($page - 1) * $pagesize;
		$data['is_direction'] = $is_direction;
		//$data['all_directions_shopids'] = $all_directions_shopids;
		$data['city'] = $city;
		$data['citys'] = $citys;
		$data['offset'] = $offset;
		$data['name'] = $name;
		$data['id'] = $id;
		$data['page_html'] = $page_html;
		$data['list'] = $list;
		$data['pageid'] = "shoplist";
		//$data['citys'] = $this->mo_geography->get_all_cityinfos();
		
		$this->load->admin_view('admin/viewspotlist', $data);
	}

	// 
	public function repair_score(){
		$shop_id = $this->input->get("shop_id", true, "");
		$repair_all = $this->input->get("repair_all", true, '');
		$this->load->model("mo_shop");
		$this->load->model("mo_dianping");
		$content = "";
		if($shop_id){
			$re = $this->mo_dianping->repair_score($shop_id);
			if($re){
				$content = "操作成功";
			}else{
				$content = "请稍后再试";
			}
		}else{
			$shops = $this->mo_shop->get_all_shop(true);
			foreach ($shops as $key => $value) {
				if($value['status'] != 0){
					continue;
				}
				$id = $value['id'];
			 	$re = $this->mo_dianping->repair_score($id);
			 }
			 $content = "操作成功";
		}
		#load page
		$data = array();
		$data['content'] = $content;
		$data['shop_id'] = $shop_id;
		$data['pageid'] = self::PAGE_ID;

		$this->load->admin_view('admin/addshop_repair_score', $data);
		

	}

}