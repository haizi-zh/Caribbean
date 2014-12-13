<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class Viewspot extends ZB_Controller {
		
	const PAGE_ID = 'viewspot';
	public function __construct(){
		parent::__construct();
		//$this->load->model("mo_geography");
		//$this->load->model("mo_count");
	}

	public function photo(){
		$pageid = "shop_photo";
		$pagesize = 112;
		$page = $this->input->get('page', true, 1);
		if(!$page){
			$page = 1;
		}
		$offset = ($page - 1) * $pagesize;

		$this->load->model("mo_shop");
		$data = array();
		$security = $this->tool->get_pic_securety('ZB_ADMIN_SHOP');#生成安全数据

		$this->load->model("mo_geography");
		$id = $this->input->get("id", true, 0);
		$data = array( 'policy'=> $security['policy'],'signature'=>$security['signature']);

		$shop_id = $this->input->get("shop_id", true, 0);
		$list = $this->mo_shop->get_shopphoto_by_shopid($shop_id, $page, $pagesize);
		$count = $this->mo_shop->get_shopphoto_by_shopid_count( $shop_id);
		$page_cnt = ceil($count/$pagesize);
		$this->load->library('pagination');
		$config['use_page_numbers'] = TRUE;
		$config['num_links'] = 8;
		$config['base_url'] = '/admin/shop/photo/?shop_id='.$shop_id;
		$config['total_rows'] = $count;
		$config['per_page'] = $pagesize;
		$config['query_string_segment'] = 'page';
		//$config['use_page_numbers'] = TRUE;
		//$config['page_query_string'] = TRUE;
		$config['page_query_string']  = TRUE;

		$this->pagination->initialize($config);
		$page_html = $this->pagination->create_links();
		$data['page_html'] = $page_html;

		$data['list'] = $list;
		$data['pageid'] = $pageid;
		
		$data['offset'] = $offset;
		$id = $this->input->get("id", true, 0);
		$shop_info = $info = array();
		if($id){
			$info = $this->mo_shop->get_shop_photo($id);
			$shop_id = $info['shop_id'];
		}
		if($shop_id){
			$shop_info = $this->mo_shop->get_shopinfo_by_id($shop_id);
		}
		$data['shop_id'] = $shop_id;
		
		$data['shop_info'] = $shop_info;
		$data['id'] = $id;
		$data['info'] = $info;
		$this->load->admin_view("admin/shop/photo", $data);
	}

	public function lists(){
		$this->load->model("mo_shop");
		$this->load->model("mo_geography");
		$shops = $this->mo_shop->get_all_shop(true);
		$countrys = $this->mo_geography->get_all_countrys();
		$citys = $this->mo_geography->get_all_citys();
		
		$data['countrys'] = $countrys;
		$data['citys'] = $citys;
		$data['shops'] = $shops;
		$data['pageid'] = "shop";
		$data['offset'] = 0;
		$this->load->admin_view("admin/shop/lists", $data);

	}

}