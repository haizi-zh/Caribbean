<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class dataanalytics extends ZB_Controller {
		
	const PAGE_ID = 'dataanalytics';
	
	public function index(){

			
		#图片信息
		$this->load->model('mo_data_analytics');
		$this->config->load('data_analytics',TRUE);
		$data_analytics = $this->config->item('data_analytics');

		$slugs = array();
		foreach($data_analytics as $slug => $item){
			$slugs[] = $slug;
		}
		$params['data_analytics'] = $data_analytics;
		$params['all_slugs'] = implode(',', $slugs);
		$data['pageid'] = self::PAGE_ID;
		$this->load->admin_view('admin/dataanalytics', $params);


	}
	
}