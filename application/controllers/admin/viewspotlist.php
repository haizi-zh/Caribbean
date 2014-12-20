<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class Viewspotlist extends ZB_Controller {
		
	const PAGE_ID = 'viewspotlist';
	const PAGESIZE = 20;
	public function __construct(){
		parent::__construct();
		$this->load->model("do/do_viewspot");
		$this->load->model('mo_geosql');
	}

	public function index(){
		
		$pagesize = self::PAGESIZE;
	
		$name = $this->input->get("name", true, '');
		$id = $this->input->get("id", true, '');
		$page = $this->input->get('page', true, 1);
		$country = $this->input->get("country", true, '');
		$city = $this->input->get("city", true, '');	
		$isEdited = $this->input->get("isEdited", true, '');	

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
			$params['name'] = "$name";
			$page_html = "";
		}
		if($country){
			$params['country'] = "$country";
			$page_html = "";
		}
		if($city){
			$params['city'] = "$city";
			$page_html = "";
		}
		if($isEdited){
			$params['isEdited'] = (boolean)("$isEdited");
			$page_html = "";
		}
        

        $list = $this->do_viewspot->get_viewspot_list_for_admin($page, $pagesize, $params);
	    $count = $this->do_viewspot->get_viewspot_cnt_for_admin($params);
		if ($params['country']) {
			if($params['city']){
               $list = $this->do_viewspot->get_viewspot_list_for_city($page, $pagesize, $params);
		       $count = $this->do_viewspot->get_viewspot_cnt_for_city($params);
			}else{
               $list = $this->do_viewspot->get_viewspot_list_for_country($page, $pagesize, $params);
		       $count = $this->do_viewspot->get_viewspot_cnt_for_country($params);
			}
				
        }
		

		$this->load->library ( 'extend' ); // 调用分页类
		$page_html = $this->extend->defaultPage ( ceil ( $count / $pagesize ) , $page, $count, $pagesize );

		$offset = ($page - 1) * $pagesize;
		$data['areas'] = $areas;
		$data['is_direction'] = $is_direction;		
		$data['offset'] = $offset;
		$data['name'] = $name;
		$data['id'] = $id;
		$data['page_html'] = $page_html;
		$data['list'] = $list;
		$data['pageid'] = "viewspotlist";
		
		$this->load->admin_view('admin/viewspotlist', $data);
	}

}