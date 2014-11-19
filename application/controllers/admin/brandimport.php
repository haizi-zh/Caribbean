<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class Brandimport extends ZB_Controller {
		
	const PAGE_ID = 'brandimport';
	
	public function index(){
		#page
		$shop_id = $this->input->get('shop_id',true);
		$this->load->model('mo_shop');
		$shopinfo_re = $this->mo_shop->get_shopinfo_by_ids(array($shop_id));
		$shop = isset($shopinfo_re[$shop_id])?$shopinfo_re[$shop_id]:array();
		
		#获取全部商家
		$shops = $this->mo_shop->get_all_shop();
		$data = array();
		$data['pageid'] = self::PAGE_ID;
		$data['shops'] = $shops;
		$data['shop'] = $shop;
		$this->load->admin_view('admin/brandimport', $data);

	}
	
}