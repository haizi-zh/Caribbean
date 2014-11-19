<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class brand extends ZB_Controller {
	# http://10.11.12.13/aj/brand/get_area_city_shop_by_brand?brand_id=1&__rnd=1382434358727
	public function get_area_city_shop_by_brand(){
		$this->load->model("mo_brand");
		$this->load->model("mo_shop");
		$this->load->model("mo_geography");
		$this->load->model("do/do_area");
		$this->load->model("do/do_country");
		$this->load->model("do/do_city");
		$brand_id = $this->input->get("brand_id", true, '');
		$brand_id = intval($brand_id);
		
		$re = array();
		if ($brand_id) {
			$shops = $this->mo_brand->get_shops_by_brand($brand_id);
			if ($shops) {
				$shop_infos = $this->mo_shop->get_shopinfo_by_ids($shops);
				
				foreach ($shop_infos as $key => $shop) {
					if ($shop['area'] && $shop['city']) {
						$re[$shop['area']][$shop['country']][$shop['city']][$shop['id']] = $shop;
					}
				}
				$data['list'] = $re;
				$areas = $this->mo_geography->get_all_areas();
				$countrys = $this->do_country->get_all_countrys();
				$citys = $this->do_city->get_all_citys();
				
				$data['areas'] = $areas;
				$data['countrys'] = $countrys;
				$data['citys'] = $citys;
				$shoptips_html = $this->load->view("admin/discount_brand_city_module", $data, true);
			}
		}
		echo json_encode(array('code'=>'200','msg'=>'succ','data'=>$shoptips_html));
		return;
	}

	# http://zan.com/aj/brand/get_anchor_layer?brand_id=1723
	public function get_anchor_layer(){
		$this->load->model("mo_brand");
		$brand_id = $this->input->get("brand_id", true, '');
		$html = "";
		if($brand_id){
			$brand_info = $this->mo_brand->get_brand_by_id($brand_id);
			$data['brand_info'] = $brand_info;
			//var_dump($brand_info);
			$html = $this->load->view("template/brand_layer", $data, true);

		}
		echo json_encode(array('code'=>'200','msg'=>'succ','data'=>array('html'=>$html)));
		return;
	}
	
}