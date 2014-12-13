<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class tool extends ZB_Controller {

	const PAGE_ID = 'home';
	# http://zan.com/base/shasha_shop 导出一批商家的品牌信息。
	public function shop_brand_name(){
		$this->load->model("mo_shop");
		$this->load->model("mo_brand");
		$this->load->database();
		$list = "3,4,6,5,42,7,255,16,11,9,234,12,13,14,15,8,26,27,729,20,28,83,101,31";
		$tmp = explode(',', $list);
		$shop_infos = $this->mo_shop->get_shopinfo_by_ids($tmp);
		foreach($tmp as $shop_id){
			echo "商户:".$shop_infos[$shop_id]['name']."\r\n\r\n";
			$sql = "select * from zb_index_brand_shop where shop_id={$shop_id}";
			$query = $this->db->query($sql);
			$list = $query->result_array();
			$brands = array();
			foreach($list as $v){
				$brands[] = $v['brand_id'];
			}
			$brands = array_unique($brands);
			$brand_infos = $this->mo_brand->get_brands_by_ids($brands);
			$names = array();
			foreach($brand_infos as $v){
				$names[] = $v['name'];
				echo $v['name']." ".$v['first_char']."\r\n";
			}
			$names = array_unique($names);
			natcasesort($names);
			foreach($names as $v){
				//echo $v." ".$."\r\n";
			}die;
			echo "\r\n";
		}


	}

}