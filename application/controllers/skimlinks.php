<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class Skimlinks extends ZB_Controller {
		
	const PAGE_ID = 'skimlinks';
	public function __construct(){
		parent::__construct();
		$this->load->model("mo_coupon");
		$this->load->model("mo_brand");
		$this->load->model("mo_geography");
		$this->load->helper(array('form', 'url'));
	}
	public function lists(){
		$data = array();
		$data['pageid'] = self::PAGE_ID;
		$this->load->web_view('/skimlinks/lists', $data);
	}
}