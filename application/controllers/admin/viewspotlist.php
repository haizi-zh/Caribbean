<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class Viewspotlist extends ZB_Controller {
		
	const PAGE_ID = 'viewspotlist';
	const PAGESIZE = 100;
	public function __construct(){
		parent::__construct();
		$this->load->model("do/do_viewspot");
	}

	public function index(){
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

		$offset = ($page - 1) * $pagesize;
		$params = array();
		// $all_directions_shopids = $this->mo_directions->get_all_shop_ids();
		
		// if($is_direction && $all_directions_shopids){
		// 	$shop_ids_list = implode(",", $all_directions_shopids);
		// 	$params[] = " id in  ({$shop_ids_list})";
		// 	$page_html = "";
		// }
		if($id){
			$params['id'] = "$id";
			$page_html = "";
		}
		if($name){
			$params['name'] = "$name";
			$page_html = "";
		}
		// if($city){
		// 	$params[] = " city={$city}";
		// 	$page_html = "";
		// 	$pagesize = 400;
		// }
		if ($params) {
			$list = $this->do_viewspot->get_viewspot_list_for_admin($page, $pagesize, $params);
	        $count = $this->do_viewspot->get_viewspot_cnt_for_admin($params);
        }
		
		$list = $this->do_viewspot->get_viewspot_list_for_admin($page, $pagesize, $params);
	    $count = $this->do_viewspot->get_viewspot_cnt_for_admin($params);
		
		
		$this->load->library ( 'extend' ); // 调用分页类
		$page_html = $this->extend->defaultPage ( ceil ( $count / $pagesize ) , $page, $count, $pagesize );

		$offset = ($page - 1) * $pagesize;
		$data['is_direction'] = $is_direction;
		$data['city'] = $city;
		$data['citys'] = $citys;
		$data['offset'] = $offset;
		$data['name'] = $name;
		$data['id'] = $id;
		$data['page_html'] = $page_html;
		$data['list'] = $list;
		$data['pageid'] = "viewspotlist";
		//$data['citys'] = $this->mo_geography->get_all_cityinfos();
		
		$this->load->admin_view('admin/viewspotlist', $data);
	}

}