<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class viewspotlist extends ZB_Controller {
		
	public function get_contries_by_area(){
		//$area = isset($_GET['area'])?$_GET['area']:'';
		$area = $this->input->get('area', true, '');
		$area = intval($area);

		#根据地域获取省份列表
		$this->load->model('mo_geosql');
		$re = $this->mo_geosql->get_countries_by_area($area);
		
		echo json_encode($re);
	}
	
	public function get_cities_by_country(){
		//$country = isset($_GET['country'])?$_GET['country']:'';
		$country = $this->input->get('country', true, '');
		$country = intval($country);
		#根据省份获取城市列表
		$this->load->model('mo_geosql');
		$re = $this->mo_geosql->get_cities_by_country_formadmin($country);
	
		echo json_encode($re);
	}

	public function select_city(){

        $area = $this->input->get('area', true, '');
        $country = $this->input->get('country', true, '');
        $city = $this->input->get('city', true, '');
        $isEdited = $this->input->get('isEdited', true, '');

        $area = intval($area);
        $country = intval($country);
        $city = intval($city);
        $isEdited = intval($isEdited);

		$this->load->model('mo_geosql');
		$re = $this->mo_geosql->get_viewspot_foradmin($area, $country, $city);
		$midSQL = $re[0]['mid'];

        //切换到mongo数据库
		$this->load->model("do/do_viewspot");
	    $re = $this->do_viewspot->get_viewspot_by_midSQL($midSQL, $isEdited);

        echo json_encode($re);
	}

	
}