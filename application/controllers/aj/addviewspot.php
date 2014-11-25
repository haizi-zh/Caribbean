<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class addviewspot extends ZB_Controller {

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
    

	#添加景点
	public function add_viewspot(){
		try{
			$data = array();
			$data['name'] = $this->input->post('name', true, '');
			$data['english_name'] = $this->input->post('english_name', true, '');
			$data['desc'] = $this->input->post('desc', true, '');

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
				
			$this->load->model('do/do_viewspot');
			$re = $this->do_viewspot->add($data);
			
			echo json_encode(array('code'=>'200','msg'=>'succ'));
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
	
	#编辑景点
	public function edit_viewspot(){
		try{

			$data = array();
			$data['id'] = $this->input->post('id', true, '');
			$data['name'] = $this->input->post('name', true, '');
			$data['price'] = $this->input->post('price', true, '');
			$data['desc'] = $this->input->post('desc', true, '');
			$data['address'] = $this->input->post('address', true, '');
			$data['phone'] = $this->input->post('phone', true, '');
			$data['business_hour'] = $this->input->post('business_hour', true, '');
			$data['score'] = $this->input->post('score', true, '');
			$data['visit_guide'] = $this->input->post('score', true, '');
			$data['anti_pit'] = $this->input->post('anti_pit', true, '');
			$data['travel_guide'] = $this->input->post('travel_guide', true, '');
			//$data['location'] = $this->input->post('location', true, '');
			
			$this->load->model("do/do_viewspot");
            $re = $this->do_viewspot->update($data);

			echo json_encode(array('code'=>'200','msg'=>'succ'));
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
}

?>