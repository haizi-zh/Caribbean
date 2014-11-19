<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class Ebusiness extends ZB_Controller {
		
	const PAGESIZE = 20;
	const PAGE_ID = 'ebusiness';
	public function __construct(){
		parent::__construct();
		$this->load->model("mo_coupon");
		$this->load->model("mo_brand");
		$this->load->model("mo_geography");
		$this->load->model("mo_ebusiness");
		$this->load->helper(array('form', 'url'));
	}

	public function elist(){

		$page = $this->input->get("page", true, 1);
		$pagesize = self::PAGESIZE;
		$data = array();
		$data['pageid'] = self::PAGE_ID;
		$list = $this->mo_ebusiness->get_list();
		$count = $this->mo_ebusiness->get_list_count();
		$data['list'] = $list;
		$this->load->library ( 'extend' ); // 调用分页类
		$page_html = $this->extend->defaultPage ( ceil ( $count / $pagesize ) , $page, $count, $pagesize );
		$data['page_html'] = $page_html;
		$offset = ($page - 1) * $pagesize;
		$data['offset'] = $offset;
		
		$this->load->admin_view ( "admin/ebusiness/list", $data );
	}
	public function add(){

		$id = $this->input->get("id", true, 0);
		$data = array();
		$info = array();
		if ($id) {
			$info = $this->mo_ebusiness->get_info($id);
		}
		$data['pageid'] = self::PAGE_ID;

		$security = $this->tool->get_pic_securety('ZB_ADMIN_SHOP');#生成安全数据
		$data['policy'] = $security['policy'];
		$data['signature'] = $security['signature'];
		$data['id'] = $id;
		$data['info'] = $info;
		$this->load->admin_view ( "admin/ebusiness/add", $data );

	}


	public function del_singlepage(){
		$id = $this->input->get("id", true, 0);
		if ($id) {
			$data = array('status'=>1);
			$this->BaseModel->updates('mba_site_page', array('id'=>$id), $data);
		}
		alert("删除成功！", "/msite/singlepage_list");
	}

}