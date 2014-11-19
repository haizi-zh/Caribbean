<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class Setpic extends ZB_Controller {
		
	const PAGE_ID = 'setpic';
	
	public function index(){

		#page
		#生成安全数据
		$security[] = $this->tool->get_pic_securety('ZB_ADMIN_TOPIC1');
		$security[] = $this->tool->get_pic_securety('ZB_ADMIN_TOPIC2');
		$security[] = $this->tool->get_pic_securety('ZB_ADMIN_TOPIC3');
		$security[] = $this->tool->get_pic_securety('ZB_ADMIN_TOPIC4');
	
		#图片信息
		$this->load->model('mo_operation');
		$pics = $this->mo_operation->get_value(mo_operation::INDEX_PICS);
		$data=array();
		$data['pageid'] = self::PAGE_ID;
		$data['security'] = $security;
		$data['pics'] = $pics;

		$this->load->admin_view('admin/setpic', $data);

	}
	
	// ALTER TABLE  `zb_city` ADD  `level` INT( 10 ) NOT NULL COMMENT  '显示排名' AFTER  `country_id` ;
	public function city(){
		$pageid = "city";

		#图片信息
		$this->load->model('mo_operation');
		$this->load->model('mo_geography');
		$this->load->model('do/do_city');

		$areas = $this->mo_geography->get_all_areas();
		$area_citys = array();
		foreach ($areas as $area) {
			$area_id = $area['id'];
			$citys = $this->do_city->get_cities_by_area_foradmin($area_id);

			$area_citys[$area_id] = $citys;
		}
		$data['status'] = array(''=>'显示','0'=>'显示','1'=>'隐藏');
		$data['areas'] = $areas;
		$data['area_citys'] = $area_citys;
		$data['pageid'] = $pageid;
		//$pics = $this->mo_operation->get_value(mo_operation::INDEX_PICS);
		$this->load->admin_view('admin/setpic_city', $data);
		

		
	}

	public function city_modify(){
		$security = $this->tool->get_pic_securety('ZB_ADMIN_SHOP');#生成安全数据

		$this->load->model("mo_geography");
		$id = $this->input->get("id", true, 0);
		$data = array('pageid'=>"setpic_city_modify", 'policy'=> $security['policy'],'signature'=>$security['signature']);
		$data['id'] = $id;
		$city_info = $this->mo_geography->get_city_info_by_id($id);
		$data['city_info'] = $city_info;
		
		$this->load->admin_view('admin/setpic_city_modify', $data);
	}
	
}