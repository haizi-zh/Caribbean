<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Minitool extends ZB_Controller {

	const PAGE_ID = 'minitool';

	public function index(){	
		$data = array();
		$data['pageid'] = self::PAGE_ID;
		#load page
		$this->load->admin_view('admin/minitool', $data);		
	}
	
}