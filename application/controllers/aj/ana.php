<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class ana extends ZB_Controller {
	
	// http://zan.com/aj/ana/get_chart_data?business=1
	public function get_chart_data(){
		//$business_str = isset($_GET['business'])?$_GET['business']:1;
		$business_str = $this->input->get('business', true, 1);
		$business_array = explode(',',$business_str);
		$this->load->model('mo_ana');
		
		$this->load->model('mo_ana');
		$this->config->load('ana');
		$ana_urls = $this->config->item('ana_urls');

		/*
{"city":{"name":"\u57ce\u5e02\u9875","pointStart":1390752000000,"pointInterval":86400000,"data":[365,457],"unit":"\u6b21\uff0f\u5929"}}

		*/
		foreach($business_array as $business){
			$data = $this->mo_ana->get_stream_line($business);
			$data['name'] = $ana_urls[$business]['name'];
			$data['unit'] = "次／天";
			$result[$business] = $data;
		}
		echo json_encode($result, true);
	}

	public function get_chart_data_new(){
		$data_domain = context::get("data_domain", "");
		
		$REQUEST_URI = $_SERVER['REQUEST_URI'];
		$REQUEST_URI = str_replace("get_chart_data_new", "get_chart_data", $REQUEST_URI);
		$url = $data_domain.$REQUEST_URI;

		$content = file_get_contents($url);
		echo $content;
	}

	public function get_ana_new_where(){
		$select = $this->input->get('select', true, '');
		$where = $this->input->get('where', true, '');
		$group_by = $this->input->get('group_by', true, '');
		$order_by = $this->input->get('order_by', true, '');
		$select = urldecode($select);
		$where = urldecode($where);
		$group_by = urldecode($group_by);
		$order_by = urldecode($order_by);
		if(!$where){
			echo "error";
			exit();
		}
		$this->load->model('mo_ana');
		$data = $this->mo_ana->get_simple_from_where($select, $where, $group_by, $order_by);
		
		echo json_encode($data);
	}

	public function get_sql(){
		$sql = $this->input->get('s', true, '');
		$sql = urldecode($sql);
		if(!$sql){
			echo "error";
			exit();
		}
		$this->load->model('mo_ana');
		//$data = $this->mo_ana->get_sql($sql);
		
		echo json_encode($data);
	}
}
