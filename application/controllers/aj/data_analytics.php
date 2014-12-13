<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class data_analytics extends CI_Controller {
	
	public function get_chart_data(){
		//$business_str = isset($_GET['business'])?$_GET['business']:1;
		$business_str = $this->input->get('business', true, 1);
		$business_array = explode(',',$business_str);
		$this->load->model('mo_data_analytics');
		
		foreach($business_array as $business){
			$data = $this->mo_data_analytics->get_stream_line($business);
			$result[$business] = $data;
		}
		echo json_encode($result);
	}
}
