<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class Allbrand extends ZB_Controller {
		
	const PAGE_ID = 'allbrand';
	
	public function index(){

		$s_char = $this->input->get('s_char', true, 'A');
		#page
		$first_char_array = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','1','7', 'All');
		$this->load->model('mo_brand');
		$this->load->model('do/do_brandtag');
		if (!in_array($s_char, $first_char_array)) {
			$s_char = 'A';
		}
		
		if ($s_char == 'All') {
			$brands = $this->mo_brand->get_all_brand();
		}else{
			$brands = $this->mo_brand->get_brands_by_first_char($s_char, 10000);
		}
		$brandtag_list = $this->do_brandtag->get_brandtag_list();
		if($brands){
			foreach($brands as $k=>$v){
				$brand_id = $v['id'];
				$brandtags = $this->do_brandtag->get_brandtag_by_shop($brand_id);
				$brands[$k]['brandtags'] = $brandtags;
			}
		}
		$data = array();
		$data['brandtag_list'] = $brandtag_list;
		$data['brands'] = $brands;
		$data['s_char'] = $s_char;
		$data['first_chars'] = $first_char_array;
		$data['pageid'] = self::PAGE_ID;

		$this->load->admin_view('admin/allbrand', $data);
		
	}
	
}