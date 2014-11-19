<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class access_analytics extends CI_Controller {
		
	public function set($business, $time, $value){
		$this->load->model('mo_data_analytics');
		$this->mo_data_analytics->add($business, $time, $value);
	}	
}