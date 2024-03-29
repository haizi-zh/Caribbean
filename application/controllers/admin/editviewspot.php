<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class editviewspot extends ZB_Controller {
		
	const PAGE_ID = 'editviewspot';
	
	public function index(){

		// #load page
	    $security = $this->tool->get_pic_securety('ZB_ADMIN_SHOP');#生成安全数据
		$has_map = isset($_GET['has_map'])?$_GET['has_map']:1;
		
		// #景点信息
		$viewspot_id = isset($_GET['viewspot_id'])?$_GET['viewspot_id']:0;
		$viewspot_name = isset($_GET['viewspot_name'])?$_GET['viewspot_name']:0;
		if(!$viewspot_id){
			$has_map = 0;
		}

		$this->load->model("do/do_viewspot");
		if($viewspot_name){
			$viewspot_id = $this->do_viewspot->get_viewspot_for_name($viewspot_name);
		}		
		$viewspotinfo_re = $this->do_viewspot->get_viewspotinfo_by_ids($viewspot_id);
	    $viewspot = empty($viewspotinfo_re['viewspot_id'])?array():$viewspotinfo_re;
	   
		$countries = array();
		$cities = array();
		
		#header
		$lat = 0;$lon=0;
		$location = isset($viewspot['location'])?$viewspot['location']:'';
		if($location){
			$locations = explode(',',$location);
			$lon = trim($locations[0]);
			$lat = trim($locations[1]);
		}
		
		$data = array('has_map'=>$has_map, 'areas'=>$areas,'policy'=> $security['policy'],'signature'=>$security['signature'], 'viewspot'=>$viewspot, 'countries'=>$countries, 'cities'=>$cities);
		
		$data['pageid'] = self::PAGE_ID;
		$data['lat'] = $lat;
		$data['lon'] = $lon;
 
		$this->load->admin_view('admin/editviewspot', $data);	
	}




}