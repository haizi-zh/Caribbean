<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class shop extends CI_Controller {
		
	const PAGE_ID = 'shop_discount';

	public function index(){

		#load page
		$security = $this->tool->get_pic_securety('ZB_ADMIN_SHOP');#生成安全数据
		$this->load->model('mo_geography');
		$areas = $this->mo_geography->get_all_areas();

		$data = array('areas'=>$areas,'policy'=> $security['policy'],'signature'=>$security['signature']);

		$data['pageid'] = self::PAGE_ID;

		$this->load->admin_view('admin/addshop', $data);
		

	}
	// http://10.11.12.13/cas/shop/discount_list?shop_id=550
	public function discount_list(){
		$this->load->view('cas/header', array('pageid'=>self::PAGE_ID));
		$data = array();
		$shop_id = $this->input->get("shop_id", true, 0);
		if(!$shop_id){
			tool::sorry();
		}
		$this->load->model("mo_shop");
		$shop_info = $this->mo_shop->get_shopinfo_by_id($shop_id);
		if(!$shop_info){
			tool::sorry();
		}
		$this->load->model("mo_discount");
		$discount_list = $this->mo_discount->get_discount_ids_by_shopid($shop_id);
		$discount_count = $this->mo_discount->get_discount_ids_cnt_by_shopid($shop_id);

		$data['discount_list'] = $discount_list;
		$data['discount_count'] = $discount_count;

		$page_cnt = ceil($discount_count/10);
		$data['page_cnt'] = $page_cnt;

		$this->load->view('cas/discount_list', $data);
		$this->load->view('cas/footer', array('pageid'=>self::PAGE_ID));
	}

	public function discount_info(){
		$this->load->view('cas/header', array('pageid'=>self::PAGE_ID));
		$data = array();
		$this->load->model("mo_discount");
		$discount_id = $this->input->get("discount_id", true , 0);
		if(!$discount_id){
			tool::sorry();
		}
		$discount_info = $this->mo_discount->get_info_by_id($discount_id);
		if(!$discount_info){
			tool::sorry();
		}

		

		$this->load->view('cas/discount_info', $data);
		$this->load->view('cas/footer', array('pageid'=>self::PAGE_ID));
	}
	
	public function add_discount(){
		
	}

	public function edit_discount(){

	}


}