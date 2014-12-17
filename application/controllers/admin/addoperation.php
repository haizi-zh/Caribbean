<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class Addoperation extends ZB_Controller {
		
	const PAGE_ID = 'addoperation';

	public function __construct(){
		parent::__construct();
		$this->load->model("do/do_operation");
	}
	
	public function index(){

        #load page
		$security = $this->tool->get_pic_securety('ZB_ADMIN_SHOP');#生成安全数据	

        $data = array();
        $data['pageid'] = self::PAGE_ID;
		$data['policy'] = $security['policy'];
		$data['signature'] = $security['signature'];
		$this->load->admin_view('admin/addoperation', $data);	
	}

}