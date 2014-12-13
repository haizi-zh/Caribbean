<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class addshop extends ZB_Controller {
		
	public function get_contries_by_area(){
		//$area = isset($_GET['area'])?$_GET['area']:'';
		$area = $this->input->get('area', true, '');
		$area = intval($area);

		#根据地域获取国家列表
		$this->load->model('mo_geography');
		$re = $this->mo_geography->get_countries_by_area($area);
		
		echo json_encode($re);
	}
	
	public function get_cities_by_country(){
		//$country = isset($_GET['country'])?$_GET['country']:'';
		$country = $this->input->get('country', true, '');
		$country = intval($country);
		#根据地域获取国家列表
		$this->load->model('mo_geography');
		$re = $this->mo_geography->get_cities_by_country_formadmin($country);
	
		echo json_encode($re);
	}
	
	#添加商家
	public function add_shop(){
		try{
			$data = array();
			$data['name'] = $this->input->post('name', true, '');
			$data['english_name'] = $this->input->post('english_name', true, '');
			$data['desc'] = $this->input->post('desc', true, '');
			$data['pic'] = $this->input->post('img', true, '');
			$data['address'] = $this->input->post('address', true, '');
			$data['phone'] = $this->input->post('phone', true, '');
			$data['area'] = $this->input->post('area', true, 0);
			$data['country'] = $this->input->post('country', true, 0);
			$data['city'] = $this->input->post('city', true, 0);
			$data['property'] = $this->input->post('property', true, 0);
			$data['business_hour'] = $this->input->post('business_hour', true, '');
			$data['score'] = $this->input->post('score', true, 0);
			$data['total_score'] = $this->input->post('total_score', true, 0);
			$data['location'] = $this->input->post('location', true, '');
			$data['rank_score'] = $this->input->post('rank_score', true, 0);
			$data['reserve_1'] = $this->input->post('reserve_1', true, '');
			$data['reserve_2'] = $this->input->post('reserve_2', true, '');
			$data['reserve_3'] = $this->input->post('reserve_3', true, '');
			$data['reserve_4'] = $this->input->post('reserve_4', true, '');
			$data['reserve_5'] = $this->input->post('reserve_5', true, '');
			$data['seo_keywords'] = $this->input->post('seo_keywords', true, '');
			$data['discount_type'] = $this->input->post('discount_type', true, 0);

			if ($this->input->get('char') !== false){
				$char = $this->input->get('char', true);
			}else{
				$char = '';
			}
			if ($this->input->get('char') !== false){
				$char = $this->input->get('char', true);
			}else{
				$char = '';
			}
			if ($this->input->get('char') !== false){
				$char = $this->input->get('char', true);
			}else{
				$char = '';
			}
			
			
			
			
			$this->load->model('mo_shop');
			$re = $this->mo_shop->add($data);
			
			echo json_encode(array('code'=>'200','msg'=>'succ'));
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
	
	#编辑商家
	public function edit_shop(){
		try{
			$data = array();
			$data['id'] = $this->input->post('id', true, '');
			$data['name'] = $this->input->post('name', true, '');
			$data['english_name'] = $this->input->post('english_name', true, '');
			$data['desc'] = $this->input->post('desc', true, '');
			$data['pic'] = $this->input->post('img', true, '');
			$data['address'] = $this->input->post('address', true, '');
			$data['phone'] = $this->input->post('phone', true, '');
			$data['area'] = $this->input->post('area', true, 0);
			$data['country'] = $this->input->post('country', true, 0);
			$data['city'] = $this->input->post('city', true, 0);
			$data['property'] = $this->input->post('property', true, 0);
			$data['business_hour'] = $this->input->post('business_hour', true, '');
			$data['score'] = $this->input->post('score', true, 0);
			$data['total_score'] = $this->input->post('total_score', true, 0);
			$data['location'] = $this->input->post('location', true, '');
			$data['rank_score'] = $this->input->post('rank_score', true, 0);
			$data['reserve_1'] = $this->input->post('reserve_1', true, '');
			$data['reserve_2'] = $this->input->post('reserve_2', true, '');
			$data['reserve_3'] = $this->input->post('reserve_3', true, '');
			$data['reserve_4'] = $this->input->post('reserve_4', true, '');
			$data['reserve_5'] = $this->input->post('reserve_5', true, '');
			$data['seo_keywords'] = $this->input->post('seo_keywords', true, '');
			$data['discount_type'] = $this->input->post('discount_type', true, 0);
			
			$this->load->model('mo_shop');
			$re = $this->mo_shop->update($data);
	
			echo json_encode(array('code'=>'200','msg'=>'succ'));
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
}