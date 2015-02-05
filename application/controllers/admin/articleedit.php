<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class Articleedit extends ZB_Controller {
		
	const PAGE_ID = 'articleedit';

	public function __construct(){
		parent::__construct();
		$this->load->model("do/do_article");
	}
	
	public function index(){
		$id = $this->input->get("article_id", TRUE);
		if($id){
        	$article = $this->do_article->get_articleinfo_by_ids($id);
		}
        $data = array('article'=>$article);
		$data['id'] = $id;
		$data['pageid'] = self::PAGE_ID;
		$this->load->admin_view('admin/articleedit', $data);
	}
}
