<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class adminuser extends CI_Controller {
		
	const PAGE_ID = 'adminuser';
	const PAGESIZE = 50;
	
	public function index(){
		$powers = array("1"=>'折扣','2'=>'攻略','3'=>'品牌');
		$this->load->model("mo_adminuser");
		$data = array();
		$list = $this->mo_adminuser->get_list();
		$data['list'] = $list;
		$data['powers'] = $powers;
		$data['pageid'] = self::PAGE_ID;
		$data['offset'] = 0;

		$this->load->admin_view('admin/adminuserlist',$data);
	}
	public function add(){
		$this->load->model("mo_adminuser");
		$id = $this->input->get("id", true, 0);
		$powers = array("1"=>'折扣','2'=>'攻略','3'=>'品牌');
		$data = array();
		$data['pageid'] = self::PAGE_ID;
		$data['powers'] = $powers;
		$data['id'] = $id;
		$user_info = array();
		if($id){
			$user_info = $this->mo_adminuser->get_user_info($id);
		}
		$data['user_info'] = $user_info;
		$this->load->admin_view('admin/adminuser_add',$data);
	}
}