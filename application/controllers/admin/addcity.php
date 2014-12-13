<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class Addcity extends ZB_Controller {
		
	const PAGE_ID = 'Addcity';
	public function __construct(){
		parent::__construct();
		
	}
	public function index(){

		#page
		#生成安全数据
		$security = $this->tool->get_pic_securety('ZB_ADMIN_BRAND');
		$data = array('policy'=> $security['policy'],'signature'=>$security['signature']);
		$data['pageid'] = self::PAGE_ID;
		#图片信息
		$this->load->admin_view('admin/addcity', $data);

	}
	
}