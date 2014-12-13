<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ebusiness extends ZB_Controller {
	const PAGE_ID = 'ebusiness';
	public function __construct(){
		parent::__construct();
		$this->load->model("mo_coupon");
		$this->load->model("mo_geography");
		$this->load->model("mo_brand");
		$this->load->model("mo_common");
		$this->load->model("mo_ebusiness");
	}

	public function index(){
		$data = array();
		$data['pageid'] = self::PAGE_ID;
		$list = $this->mo_ebusiness->get_list();
		$data['list'] = $list;
		$data['page_css'] = "ZB_brand.css";
		$this->get_adv_data();
		
		$this->load->web_view('ebusiness', $data);
	}
}