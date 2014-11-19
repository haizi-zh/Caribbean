<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dataformat extends ZB_Controller {
	# http://zan.com/dataformat/discount
	public function __construct(){
		parent::__construct();
		$this->load->model("mo_shop");
		$this->load->model("mo_coupon");
		$this->load->model("mo_geography");
		$this->load->model("mo_brand");
		$this->load->model("mo_common");
	}
	public function discount(){
		$this->load->database();
		$sql = " select * from zb_discount where type=1 ";
		$query = $this->db->query($sql);
		$list = $query->result_array();
		
		$time = array();
		foreach ($list as $key => $value) {
			$ctime = $value['ctime'];
			$format_ctime = date("Ymd", $ctime);
			if(!isset($time[$format_ctime])){
				$time[$format_ctime] = 0;
			}
			$time[$format_ctime] += 1;
		}

		$shop_id = array();
		$simple_brand = $multi_brand = array();
		$city_count = array();
		foreach ($list as $key => $value) {
			$ctime = $value['ctime'];
			$format_ctime = date("Ymd", $ctime);

			$id = $value['id'];
			$sql = "select * from zb_discount_shop where discount_id = {$id}";
			$query = $this->db->query($sql);
			$relation = $query->result_array();
			$count = count($relation);
			$brand_id = 0;

			if($count==1){
				$brand_id = $relation[0]['brand_id'];
				//$brand_info = $this->mo_brand->get_brand_by_id($brand_id);
				//$brand_name = $brand_info['name'];
				//$simple_brand[$format_ctime][$brand_name] += 1;
				$shop_id = $relation[0]['shop_id'];
				$shop_info = $this->mo_shop->get_shopinfo_by_id($shop_id);
				if ($shop_info && isset($shop_info['city'])) {
					$city = $shop_info['city'];
					if(!$city){
						continue;
					}
					$city_info = $this->mo_geography->get_city_info_by_id($city);

					$city_name = $city_info['name'];
					if (!isset($city_count[$format_ctime][$city_name])) {
						$city_count[$format_ctime][$city_name] = 0;
					}
					$city_count[$format_ctime][$city_name] += 1 ;

				}else{

				}
				

			}else{
				$tmp_city_name = "" ;
				$city_name = "";
				$country_name = "";
				foreach ($relation as $k => $v) {
					$brand_id = $v['brand_id'];
					//$brand_info = $this->mo_brand->get_brand_by_id($brand_id);
					//$brand_name = $brand_info['name'];
					$shop_id = $v['shop_id'];
					$shop_info = $this->mo_shop->get_shopinfo_by_id($shop_id);
					$city = $shop_info['city'];
					$city_info = $this->mo_geography->get_city_info_by_id($city);
					$city_name = $city_info['name'];
					if(!$tmp_city_name){
						$tmp_city_name = $city_name;
					}elseif($tmp_city_name != $city_name){
						$country = $city_info['country_id'];
						if($country){
							$country_info = $this->mo_geography->get_country_info_by_id($country);
							$country_name = $country_info['name'];
						}
					}
				}

				if($country_name){
					if (!isset($city_count[$format_ctime][$country_name])) {
						$city_count[$format_ctime][$country_name] = 0;
					}
					$city_count[$format_ctime][$country_name] += 1 ;
				}else{
					if (!isset($city_count[$format_ctime][$city_name])) {
						$city_count[$format_ctime][$city_name] = 0;
					}
					$city_count[$format_ctime][$city_name] += 1 ;
				}
			}
		}
		krsort($time);
		foreach($time as $k => $v){
			echo "时间：".$k ."总数：".$v."<br/>";
		}
		krsort($city_count);
		foreach($city_count as $k => $v){
			echo "时间：".$k ;
			foreach($v as $city=>$count){
				echo " ｜ 城市：".$city ."数量：".$count;
			}
			echo "<br/>";
		}
		
		die;
		print_r($city_count);die;

		var_dump($time);

	}
}