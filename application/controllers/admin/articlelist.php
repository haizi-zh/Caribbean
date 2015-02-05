<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class Articlelist extends ZB_Controller {
		
	const PAGE_ID = 'articlelist';
	const PAGESIZE = 4;

	public function __construct(){
		parent::__construct();
		$this->load->model("do/do_article");
	}

	public function index(){
		$pagesize = self::PAGESIZE;

        $id = $this->input->get("id", true, '');
		$name = $this->input->get("name", true, '');
		$page = $this->input->get('page', true, 1);

		if(!$page){
		 	$page = 1;
		}

		$offset = ($page - 1)*$pagesize;
		$params = array();

        if($id){
			$params['id'] = "$id";
			$page_html = "";
		}
		if($name){
			$params['name'] = "$name";
			$page_html = "";
		}
 
        if ($params) {
			$infos = $this->do_article->get_all_info($page, $pagesize, $params);
	        $count = $this->do_article->get_info_cnt($params);
        }
        $infos = $this->do_article->get_all_info($page, $pagesize, $params);
        $count = $this->do_article->get_info_cnt($params);
		
		$this->load->library('extend');
		$page_html = $this->extend->defaultPage ( ceil ( $count / $pagesize ) , $page, $count, $pagesize );

		$data = array();
		$data['infos'] = $infos;
		$data['offset'] = $offset;
		$data['name'] = $name;
		$data['id'] = $id;
		$data['page_html'] = $page_html;
		$data['pageid'] = self::PAGE_ID;

		$this->load->admin_view('admin/articlelist', $data);	
	}
}
