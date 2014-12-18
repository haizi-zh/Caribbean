<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class hotelrecom extends ZB_Controller {
		
	const PAGE_ID = 'hotelrecom';
	const PAGESIZE = 10;
	public function __construct(){
		parent::__construct();
		$this->load->model("do/do_hotel");
	}
	
	public function index(){		

		// $pagesize = self::PAGESIZE;
		// $data['pageid'] = self::PAGE_ID;
		// $name = $this->input->get("name", true, '');
		// $page = $this->input->get('page', true, 1);
		// if(!$page){
		//  	$page = 1;
		// }
		
		// $offset = ($page - 1) * $pagesize;
		// $params = array();

		// if($name){
		// 	$params['zhName'] = "$name";
		// 	$page_html = "";
		// }

		// if($params) {
  //       	$list = $this->do_hotel->get_hotel_by_name($page, $pagesize, $params);
	 //        $count = $this->do_hotel->get_hotel_cnt_for_admin($params);
  //       }
		

		// $this->load->library ( 'extend' ); // 调用分页类
		// $page_html = $this->extend->defaultPage ( ceil ( $count / $pagesize ) , $page, $count, $pagesize );

		// $offset = ($page - 1) * $pagesize;
		
		// $data['offset'] = $offset;
		// $data['name'] = $name;
		// $data['id'] = $id;
		// $data['page_html'] = $page_html;
		// $data['list'] = $list;	

		$this->load->admin_view('admin/hotelrecom', $data);
	}
	
}