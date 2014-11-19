<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class weixin extends ZB_Controller {
	const PAGE_ID = 'ana';
	public function __construct(){
		parent::__construct();
		$this->load->model("mo_content");
		$this->load->model("mo_weixinevent");
		$this->load->model("mo_cronweixin");
	}

	// zan.com/admin/weixin/index
	public function index(){
		#图片信息
		$page = 1;
		$pagesize = 100;
		$list = $this->mo_cronweixin->get_weixin_list($page, $pagesize);
		$uids = tool::format_key_by_key($list, "uid");
		$user_infos = $this->mo_cronweixin->get_user_infos($uids);
		
		$data['user_infos'] = $user_infos;
		$data['list'] = $list;
		$this->load->admin_view('admin/weixin/list', $data);
	}

	public function user(){
		$data = array();
		$list = $this->mo_cronweixin->get_user();
		$data['list'] = $list;
		$this->load->admin_view('admin/weixin/user', $data);
	}
}