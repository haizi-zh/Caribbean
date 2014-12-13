<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class editcitylist extends ZB_Controller {
		
	const PAGE_ID = 'editcitylist';
	public function __construct(){
		parent::__construct();

        $this->load->model("do/do_viewcity");
	}
	
	public function index(){
			
		//#page
		$city_id = $this->input->get('city_id', TRUE);

        $city = $this->do_viewcity->get_viewcityinfo_by_ids($city_id);

		$data = array('city'=>$city);		
		$data['pageid'] = self::PAGE_ID;
		
		$this->load->admin_view('admin/editcitylist', $data);

	}
	
}