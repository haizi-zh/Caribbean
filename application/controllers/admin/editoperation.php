<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class Editoperation extends ZB_Controller {
		
	const PAGE_ID = 'editoperation';
	
	public function index(){

		$this->load->admin_view('admin/editoperation', $data);	
	}

}