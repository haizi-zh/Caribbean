<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class feedback extends ZB_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('mo_shop');
		$this->load->model('mo_brand');
		$this->load->model('mo_discount');
		$this->load->model('mo_common');
		$this->load->model('mo_geography');
		$this->load->model('mo_coupon');
		$this->load->model('mo_tag');
		$this->load->model('mo_fav');
	}
	
	// /aj/feedback/add_feedback
	public function add_feedback(){
		$assoc 	 = array() ;
		$this->config->load('errorcode',TRUE);
		$cur_uid = $this->session->userdata['user_info']['uid'] ;
		if(!$cur_uid) $cur_uid = 0 ;
		$this->load->model('mo_feedback') ;
		$type_assoc 	= array('sug_prov' => 1 , 'sug_con' => 2 , 'sug_bug' => 3) ;
		$assoc['uid'] = $cur_uid ;
		$assoc['ctime'] = time() ;
		$assoc['content']	= $this->input->post('item_content') ;
		$cur_type		= $this->input->post('item_bug_type' ,1);
		$assoc['type'] 	= $type_assoc[$cur_type] ;
		$assoc['link']  = ($assoc['type'] == 2)?$this->input->post('item_link'):'' ;
		$assoc['email'] = $this->input->post('item_email') ;
		$assoc['ip']	= context::get_client_ip(true) ;
		$res = $this->mo_feedback->add($assoc) ;
		/*
		if(!isset($this->session->userdata['user_info']['uid'])) {
			$code = '207' ;
			echo json_encode('code' => '207' ,msg=>$this->config->item($code,'errorcode')) ;
			return ;
		}
		*/
		if($res) {
			$code = "200" ;
		} else {
			$code = "204" ;
		}
		echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
	}
}