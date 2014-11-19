<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class basecache extends ZB_Controller {
	var $browsers = array();
	var $http_code_count = array();
	var $ana_urls = array();
	var $my_route = array();
	var $spider_list = array();
	var $count = 0;
	public function __construct(){
		parent::__construct();
		$this->load->model('mo_shop');
		$this->load->model('mo_brand');
		$this->load->model('mo_discount');
		$this->load->model('mo_common');
		$this->load->model('mo_geography');
		$this->load->model('mo_coupon');
		$this->load->model("mo_dianping");
		$this->load->model("mo_ana");
	}


	// zan.com/basecache/cache
	public function cache(){
		$shoppingtips_template = "http://www.zanbai.com/%s-shoppingtips/?nocache=1";
		$citys = $this->mo_geography->get_all_cityinfos();
		foreach($citys as $kk=>$city){
			$shoppingtips_lines[] = sprintf($shoppingtips_template, $city['lower_name']);
		}
		tool::async_get_url($shoppingtips_lines);
		echo "ok";
	}




}