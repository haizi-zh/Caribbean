<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class addviewspot extends ZB_Controller {

    #根据国家获取省市列表
	public function get_provinces_by_countrys(){

		$countrys = $this->input->get('countrys', true, '');

		#根据国家获取省市列表
		$this->load->model('mo_geography');
		$re = $this->mo_geography->get_provinces_by_countrys($countrys);

		echo json_encode($re);
	}
	
	#根据国家、省市获取城市列表
    public function get_cities_by_provinces(){

		$countrys = $this->input->get('countrys', true, '');
		$provinces = $this->input->get('provinces', true, '');

		#根据省市获取城市列表
		$this->load->model('mo_geography');
		$re = $this->mo_geography->get_cities_by_provinces($countrys,$provinces);
	
		echo json_encode($re);
	}


	#添加景点
	public function add_viewspot(){
		try{
			$data = array();

			$data['country'] = $this->input->post('country', true, '');
			$data['province'] = $this->input->post('province', true, '');
			$data['city'] = $this->input->post('city', true, '');
			$data['name'] = $this->input->post('name', true, '');
			$data['description'] = $this->input->post('description', true, '');
			$data['address'] = $this->input->post('address', true, '');
			$data['openTime'] = $this->input->post('openTime', true, '');
			$data['openHour'] = $this->input->post('openHour', true, '');
			$data['closeHour'] = $this->input->post('closeHour', true, '');
			$data['priceDesc'] = $this->input->post('priceDesc', true, '');
			$data['phone'] = $this->input->post('phone', true, '');
			$data['ratingsScore'] = $this->input->post('ratingsScore', true, '');
			$data['visitGuide'] = $this->input->post('visitGuide', true, '');
			$data['antiPit'] = $this->input->post('antiPit', true, '');
			$data['travelGuide'] = $this->input->post('travelGuide', true, '');

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
			$data['viewspot_id'] = $this->input->post('id', true, '');
			$data['country'] = $this->input->post('country', true, '');
			$data['province'] = $this->input->post('province', true, '');
			$data['city'] = $this->input->post('city', true, '');
			$data['name'] = $this->input->post('name', true, '');
			$data['description'] = $this->input->post('description', true, '');
			$data['address'] = $this->input->post('address', true, '');
			$data['openTime'] = $this->input->post('openTime', true, '');
			$data['openHour'] = $this->input->post('openHour', true, '');
			$data['closeHour'] = $this->input->post('closeHour', true, '');
			$data['priceDesc'] = $this->input->post('priceDesc', true, '');
			$data['phone'] = $this->input->post('phone', true, '');
			$data['ratingsScore'] = $this->input->post('ratingsScore', true, '');
			$data['visitGuide'] = $this->input->post('visitGuide', true, '');
			$data['antiPit'] = $this->input->post('antiPit', true, '');
			$data['travelGuide'] = $this->input->post('travelGuide', true, '');
			
			$this->load->model("do/do_viewspot");
            $re = $this->do_viewspot->update($data);

			echo json_encode(array('code'=>'200','msg'=>'succ'));
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
}

?>