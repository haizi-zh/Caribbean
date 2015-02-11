<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class Articleadd extends ZB_Controller {

	const PAGE_ID = 'articleadd';

	public function __construct(){
		parent::__construct();
		$this->load->model("do/do_article");
	}
	
	public function index(){
		
        $data = array();
        $data['pageid'] = self::PAGE_ID;

		$this->load->admin_view('admin/articleadd', $data);	
		
        #load page
		// $security = $this->tool->get_pic_securety('ZB_ADMIN_SHOP');#生成安全数据	

  //       $data = array();
  //       $data['pageid'] = self::PAGE_ID;
		// $data['policy'] = $security['policy'];
		// $data['signature'] = $security['signature'];
		// $this->load->admin_view('admin/addoperation', $data);	
	}
}
