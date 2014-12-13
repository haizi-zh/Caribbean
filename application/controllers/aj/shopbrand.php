<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class shopbrand extends ZB_Controller {
		
	public function add_shop_brand(){
/* 		$brand_id = isset($_POST['brand_id'])?$_POST['brand_id']:0;
		$city = isset($_POST['city_id'])?$_POST['city_id']:0;
		$shop_id = isset($_POST['shop_id'])?$_POST['shop_id']:0; */
		
		$brand_id = $this->input->post('brand_id', true, 0);
		$city = $this->input->post('city_id', true, 0);
		$shop_id = $this->input->post('shop_id', true, 0);
		
		if(!$brand_id || !$city || !$shop_id){
			echo 0;
			exit;
		}
		
		#为商家添加品牌
		$data['shop_id'] = $shop_id;
		$data['brand_id'] = $brand_id;
		$data['city'] = $city;
		$this->load->model('mo_shop');
		$this->mo_shop->add_index_brand_shop($data);
		
		echo 1;
	}

	public function delete_shop_brand(){
		$brand_id = isset($_POST['brand_id'])?$_POST['brand_id']:0;
		$shop_id = isset($_POST['shop_id'])?$_POST['shop_id']:0;

		if(!$brand_id ||!$shop_id){
			echo 0;
			exit;
		}

		#为商家删除品牌
		$data['shop_id'] = $shop_id;
		$data['brand_id'] = $brand_id;
		$this->load->model('mo_shop');
		$this->mo_shop->delete_index_brand_shop($data);
		
		echo 1;
	}
	
	# 
	public function demo_suggest(){
		$brand_name = $this->input->get("brand_name", true, "");
		$list = array();
		if($brand_name){
			$this->load->model("do/do_brand");

			$list = $this->do_brand->demo_suggest($brand_name);
		}

		echo json_encode(array('code'=>'200','msg'=>'succ','data'=>$list));
		return;
		
	}

}