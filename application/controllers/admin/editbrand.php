<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class editbrand extends ZB_Controller {
		
	const PAGE_ID = 'editbrand';
	public function __construct(){
		parent::__construct();
		$this->load->model("mo_coupon");
		$this->load->model("mo_brand");
		$this->load->model("mo_ebusiness");
		$this->load->model("do/do_brandtag");
	}
	
	public function index(){
			
		#page
		$small_security = $this->tool->get_pic_securety('ZB_ADMIN_EDIT_BRAND_SMALL');#生成小图片安全数据
		$big_security = $this->tool->get_pic_securety('ZB_ADMIN_EDIT_BRAND_BIG');#生成大图片安全数据
		$brand_id = $this->input->get('brand_id', TRUE);

		$this->load->model('mo_brand');
		$brands = $this->mo_brand->get_brands_by_ids(array($brand_id));
		
		$brand = isset($brands[$brand_id])?$brands[$brand_id]:array();
		$data = array('brand'=>$brand,
				'small_policy'=> $small_security['policy'],'small_signature'=>$small_security['signature'],
				'big_policy'=> $big_security['policy'],'big_signature'=>$big_security['signature']);
		$ebusiness_list = $this->mo_ebusiness->get_list();
		$data['ebusiness_list'] = $ebusiness_list;

		$brandtag_list = $this->do_brandtag->get_brandtag_list();
		$data['brandtag_list'] = $brandtag_list;

		$brandtag = $this->do_brandtag->get_brandtag_by_shop($brand_id);
		$data['brandtag'] = $brandtag;
		$data['pageid'] = self::PAGE_ID;
		
		$this->load->admin_view('admin/editbrand', $data);

	}
	
}