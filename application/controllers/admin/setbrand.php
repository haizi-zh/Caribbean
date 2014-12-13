<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class Setbrand extends ZB_Controller {
		
	const PAGE_ID = 'setbrand';
	public function __construct(){
		parent::__construct();
		$this->load->model("mo_coupon");
		$this->load->model("mo_brand");
		$this->load->model("mo_ebusiness");
	}
	public function index(){

		#page
		#生成安全数据
		$security = $this->tool->get_pic_securety('ZB_ADMIN_BRAND');
		$data = array('policy'=> $security['policy'],'signature'=>$security['signature']);
		$ebusiness_list = $this->mo_ebusiness->get_list();
		$data['ebusiness_list'] = $ebusiness_list;
		$data['pageid'] = self::PAGE_ID;
		#图片信息
		$this->load->admin_view('admin/setbrand', $data);

	}
	
}