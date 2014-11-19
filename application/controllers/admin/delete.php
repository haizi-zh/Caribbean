<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class Delete extends ZB_Controller {
		
	const PAGE_ID = 'delete';
	
	public function index(){

		#page
		#图片信息
		$data = array();
		$data['pageid'] = self::PAGE_ID;
		$this->load->admin_view('admin/delete', $data);

	}
	
}