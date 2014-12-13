<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class Addoperation extends ZB_Controller {
		
	const PAGE_ID = 'addoperation';
	
	public function index(){

		$this->load->admin_view('admin/addoperation', $data);	
	}

}