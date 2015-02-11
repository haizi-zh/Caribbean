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

		$this->config->load("qiniu");
		$bucket = 'testss';
		$accessKey = $this->config->item('accessKey');
		$secretKey = $this->config->item('secretKey');

		//qiniu model
		define('__appliction__', dirname(dirname(dirname(__FILE__))));
		require_once(__appliction__."/libraries/qiniu/rs.php");

		//get token
		Qiniu_SetKeys($accessKey, $secretKey);
		$putPolicy = new Qiniu_RS_PutPolicy($bucket);
		$upToken = $putPolicy->Token(null);
		$data['token'] = $upToken;
		$this->load->admin_view('admin/articleedit', $data);
	}
}
