<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class editcity extends ZB_Controller {
		
	const PAGE_ID = 'editcity';
	const PAGESIZE = 100;
	public function __construct(){
		parent::__construct();
		$this->load->model("do/do_viewcity");
	}
	
	public function index(){		
		 $pagesize = self::PAGESIZE;
		 $data['pageid'] = self::PAGE_ID;
		
		 $name = $this->input->get("name", true, '');
		 $id = $this->input->get("id", true, '');
		 $page = $this->input->get('page', true, 1);
		 if(!$page){
		 	$page = 1;
		 }

		$offset = ($page - 1) * $pagesize;
		$params = array();
		
		if($id){
			$params['id'] = "$id";
			$page_html = "";
		}

		if($name){
			$params['zhName'] = "$name";
			$page_html = "";
		}

        if ($params) {
        	$list = $this->do_viewcity->get_citys_by_name_id($page, $pagesize, $params);
	        $count = $this->do_viewcity->get_citys_cnt_for_admin($params);
        }
		

		$this->load->library ( 'extend' ); // 调用分页类
		$page_html = $this->extend->defaultPage ( ceil ( $count / $pagesize ) , $page, $count, $pagesize );

		$offset = ($page - 1) * $pagesize;
		
		$data['offset'] = $offset;
		$data['name'] = $name;
		$data['id'] = $id;
		$data['page_html'] = $page_html;
		$data['list'] = $list;	

		$this->load->admin_view('admin/editcity', $data);
	}
	
}