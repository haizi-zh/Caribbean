<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class Wxarticle extends ZB_Controller {
		
	const PAGE_ID = 'wxarticle';

	public function __construct(){
		parent::__construct();
		$this->load->model("do/do_weixin");
	}
	
	public function index(){
		
        $data = array();
        $data['pageid'] = self::PAGE_ID;

		$this->load->admin_view('admin/wxarticle', $data);	
	}
}
