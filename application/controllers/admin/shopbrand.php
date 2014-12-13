<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class Shopbrand extends ZB_Controller {
		
	const PAGE_ID = 'shopbrand';
	
	public function index(){

		#page
		#商家信息
		$shop_id = isset($_GET['shop_id'])?$_GET['shop_id']:0;
		$this->load->model('mo_shop');
		$this->load->model('mo_brand');
		$shopinfo_re = $this->mo_shop->get_shopinfo_by_ids(array($shop_id));
		$shop = isset($shopinfo_re[$shop_id])?$shopinfo_re[$shop_id]:array();
		
		$all_brand = array();
		$shop_brands_info = array();
		#获取商家的品牌
		if($shop){
			$all_brand = $this->mo_shop->get_all_brand();
			$shop_brands = $this->mo_shop->get_brands_by_shop($shop_id);
			$shop_brands_info = $this->mo_brand->get_brands_by_ids($shop_brands);
		}
		$data=array('shops'=>$shops,'shop'=>$shop,'all_brand'=>$all_brand,'shop_brands_info'=>$shop_brands_info);
		$data['pageid'] = self::PAGE_ID;

		#获取全部商家
		$shops = $this->mo_shop->get_all_shop();
		
		$this->load->admin_view('admin/shopbrand', $data);

	}
	
}