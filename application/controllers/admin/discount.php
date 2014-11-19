<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class discount extends ZB_Controller {
	const PAGE_ID = 'discount';
	public function add(){
		$pageid = "discount_add";

		$data = array();
		$data['pageid'] = $pageid;
		$this->load->admin_view('admin/discount_add', $data);
	}

	public function edit_seo(){
		$pageid = "discount_edit_seo";
		$id = $this->input->get("id", true, '');
		
		#header

		$this->load->model("mo_discount");
		$discount_info = $this->mo_discount->get_info_by_id_foradmin($id);
		$data = array();
		$data['pageid'] = $pageid;
		$data['id'] = $id;
		$data['title'] = $discount_info['title'];
		$data['seo_title'] = $discount_info['seo_title'];
		$data['seo_keywords'] = $discount_info['seo_keywords'];
		$data['seo_description'] = $discount_info['seo_description'];
		$data['pageid'] = $pageid;
		$this->load->admin_view('admin/discount_edit_seo', $data);
		#footer

	}

	
	public function edit(){
		$pageid = "discount_edit";
		$id = $this->input->get("id", true, '');
		$this->load->model("mo_brand");
		$this->load->model("mo_geography");
		#header

		$this->load->model("mo_discount");
		$this->load->model("mo_shop");
		$discount_info = $this->mo_discount->get_info_by_id_foradmin($id);
		$type_name = "折扣";
		$brand_name = $shop_name = $city_name = $country_name = "";
		$shop_infos = array();
		$level = 0;
		if($discount_info['type'] == 2){
			$type_name = "攻略";
			$city_id = $discount_info['city'];
			$country_id = $discount_info['country'];
			$this->load->model("do/do_city");
			$citys = $this->do_city->get_all_citys();
			$countrys = $this->mo_geography->get_all_countrys();

			if($city_id){
				$tmp = explode(",", $city_id);
				foreach($tmp as $v){
					if($v && isset($citys[$v])){
						$city_name .=  ",". $citys[$v]['name'];
					}
				}
			}
			if($country_id){
				$tmp = explode(",", $country_id);
				foreach($tmp as $v){
					if($v && isset($countrys[$v])){
						$country_name .=  ",". $countrys[$v]['name'];
					}
				}
			}

			$level = $discount_info['level'];
		}else{

			$shop_list = $this->mo_discount->get_discount_shops_by_discountid(array($id));
			foreach ($shop_list as $key => $value) {
				
				$brand_id = $value['brand_id'];
			}
			$shop_ids = array_keys($shop_list);
			$shop_infos = $this->mo_shop->get_shopinfo_by_ids($shop_ids);
			$tmp_names = array();
			foreach ($shop_infos as $key => $value) {
				$tmp_names[] = $value['id'].".".$value['name'];
			}

			if ($brand_id) {
				$brand_info = $this->mo_brand->get_brand_by_id($brand_id);
				$brand_name = $brand_info['name'];
			}
			$shop_name = implode(",   ", $tmp_names);
		}
		$data = array();
		$data['level'] = $level;
		$data['id'] = $id;
		$data['discount_info'] = $discount_info;
		$data['stime'] = date('Y-m-d', $discount_info['stime']);
		$data['etime'] = date('Y-m-d', $discount_info['etime']);
		$data['type'] = $discount_info['type'];
		$data['city_name'] = $city_name;
		$data['country_name'] = $country_name;
		$data['shop_infos'] = $shop_infos;
		$data['type_name'] = $type_name;
		$data['shop_name'] = $shop_name;
		$data['brand_name'] = $brand_name;
		$data['pageid'] = $pageid;

		$this->load->admin_view('admin/discount_edit', $data);

	}

	#根据品牌添加折扣
	public function brand_add(){
		$pageid = "discount_add_brand";
		#header
		$brand_id = $this->input->get("brand_id", true, 0);
		$shop_ids = $this->input->get("shop_ids", true, "");
		$shop_infos = $brand_info = array();
		$shop_names = "";
		if ($brand_id) {
			$this->load->model("mo_brand");
			$this->load->model("mo_shop");
			$brand_info = $this->mo_brand->get_brand_by_id($brand_id);
			if ($shop_ids) {
				$shop_ids_list = explode(',', $shop_ids);
				foreach ($shop_ids_list as $key => $value) {
					if (!$value) {
						unset($shop_ids_list[$key]);
					}
				}
				$tmp = array();
				$tmp_names = array();
				if ($shop_ids_list) {
					$shop_infos = $this->mo_shop->get_shopinfo_by_ids($shop_ids_list);
					if($shop_infos){
						$i=1;
						foreach ($shop_infos as $key => $value) {
							if ($value['status'] == 0) {
								$i++;
								$tmp[$value['id']] = $value;
								$tmp_names[] = $i.".".$value['name'];
							}
						}
					}
					$shop_infos = $tmp;
				}
				$shop_ids = implode(',', array_keys($shop_infos));
				$shop_names = implode(" ", $tmp_names);
			}
		}
		$data = array();
		$data['brand_id'] = $brand_id;
		$data['shop_ids'] = $shop_ids;
		$data['shop_infos'] = $shop_infos;
		$data['shop_names'] = $shop_names;
		$data['brand_info'] = $brand_info;
		$data['pageid'] = $pageid;
		$this->load->admin_view('admin/discount_add_brand', $data);


	}
	public function discount_list(){
		$pageid = "discount_list";
		$pagesize = 100;
		$body = $this->input->get("body", true, '');
		$id = $this->input->get("id", true, '');
		$shop_id = $this->input->get("shop_id", true, '');
		$page = $this->input->get('page', true, 1);
		$status = $this->input->get('status', true, 0);
		if(!$page){
			$page = 1;
		}

		$this->load->model("mo_discount");
		$offset = ($page - 1) * $pagesize;
		$params = array();
		if( $id && is_numeric($id) ){
			$params[] = " id={$id}";
			$page_html = "";
		}
		
		$params[] = " status={$status}";
		$page_html = "";
		
		if($shop_id && is_numeric($shop_id) ){
			$params[] = " shop_id={$shop_id}";
			$page_html = "";
		}
		if($body){
			$params[] = " body like '%{$body}%'";
			$page_html = "";
		}
		$params[] = "type = 1";
		$list = $this->mo_discount->get_discount_list_for_admin($page, $pagesize, $params);
		$count = $this->mo_discount->get_discount_cnt_for_admin( $params);

		
		$this->load->library ( 'extend' ); // 调用分页类
		$page_html = $this->extend->defaultPage ( ceil ( $count / $pagesize ) , $page, $count, $pagesize );

		$offset = ($page - 1) * $pagesize;
		$data['offset'] = $offset;
		$data['body'] = $body;
		$data['shop_id'] = $shop_id;
		$data['page_html'] = $page_html;
		$data['list'] = $list;
		$data['id'] = $id;
		$data['status'] = $status;
		$data['pageid'] = $pageid;

		$this->load->admin_view('admin/discount_list', $data);

	}



	public function shoptips_add(){
		$pageid = "shoptips_add";
		#header

		$data = array();
		$data['pageid'] = $pageid;
		$this->load->admin_view('admin/shoptips_add', $data);

	}
	# http://10.11.12.13/admin/discount/shoptips_edit/?id=1
	public function shoptips_edit(){
		$pageid = "shoptips_edit";
		$id = $this->input->get("id", true, 0);
		if (!$id) {
			echo 123;
			exit();
		}
		$this->load->model("mo_discount");
		$shoptips_info = $this->mo_discount->get_info_by_id($id);
		


		$data = array();
		$data['id'] = $id;
		$data['shoptips_info'] = $shoptips_info;
		$data['pageid'] = $pageid;
		$this->load->admin_view('admin/shoptips_edit', $data);
		#footer

	}
	public function shoptips_list(){
		$pageid = "shoptips_list";
		$pagesize = 100;
		$body = $this->input->get("body", true, '');
		$id = $this->input->get("id", true, '');
		$shop_id = $this->input->get("shop_id", true, '');
		$city_id = $this->input->get("city_id", true, '');
		$country_id = $this->input->get("country_id", true, '');
		$page = $this->input->get('page', true, 1);
		$status = $this->input->get("status", true, 0);
		if(!$page){
			$page = 1;
		}
		$data['city_id'] = $city_id;
		$data['country_id'] = $country_id;

		$this->load->model("mo_discount");
		$this->load->model("mo_geography");
		$this->load->model("mo_baidu");

		$citys = $this->mo_geography->get_all_citys();
		$countrys = $this->mo_geography->get_all_countrys();


		$offset = ($page - 1) * $pagesize;
		$params = array();
		if($status == 0){
			$params[] = " status!=1 ";
		}else{
			$params[] = " status=$status ";
		}
		
		$page_html = "";
		if( $id && is_numeric($id) ){
			$params[] = " id={$id}";
			$page_html = "";
		}
		if( $country_id && is_numeric($country_id) ){
			$params[] = " ( country={$country_id} or country like '%,{$country_id},%' ) ";
			$page_html = "";
		}
		if( $city_id && is_numeric($city_id) ){
			$params[] = " (city={$city_id} or city like '%,{$city_id},%' )";
			$page_html = "";
		}
		if( $shop_id && is_numeric($shop_id) ){
			$params[] = " shop_id={$shop_id}";
			$page_html = "";
		}
		if($body){
			$params[] = " body like '%{$body}%'";
			$page_html = "";
		}
		$params[] = " type = 2";
		$url_ids = array();
		$list = $this->mo_discount->get_discount_list_for_admin($page, $pagesize, $params);
		if($list){
			foreach($list as $k => $v){
				$url_ids[$v['id']] = $v['id'];
				$city_name = $country_name = "";
				$country_id = $v['country'];
				$city_id = $v['city'];
				if($city_id){
					$tmp = explode(",", $city_id);
					foreach($tmp as $v){
						if($v && isset($citys[$v])){
							$city_name .=  ",". $citys[$v]['name'];
						}
					}
				}
				if($country_id){
					$tmp = explode(",", $country_id);
					foreach($tmp as $v){
						if($v && isset($countrys[$v])){
							$country_name .=  ",". $countrys[$v]['name'];
						}
					}
				}
				$list[$k]['country_name'] = $country_name;
				$list[$k]['city_name'] = $city_name;
			}
			$baidu_infos = $this->mo_baidu->get_baidu_stime(1, $url_ids);
		}
		

		$count = $this->mo_discount->get_discount_cnt_for_admin( $params);

		$this->load->model("mo_geography");
		$citys = $this->mo_geography->get_all_cityinfos();
		$data['citys'] = $citys;

		$this->load->library ( 'extend' ); // 调用分页类
		$page_html = $this->extend->defaultPage ( ceil ( $count / $pagesize ) , $page, $count, $pagesize );



		#header

		$offset = ($page - 1) * $pagesize;
		$data['offset'] = $offset;
		$data['body'] = $body;
		$data['shop_id'] = $shop_id;

		$data['page_html'] = $page_html;
		$data['list'] = $list;
		$data['id'] = $id;
		$data['status'] = $status;
		$data['pageid'] = $pageid;
		$data['baidu_infos'] = $baidu_infos;

		$this->load->admin_view('admin/shoptips_list', $data);

		
		#footer
		//$this->load->view('adminfooter',array('pageid'=>$pageid));
	}

	public function delete_shoptips_country_list(){
		$this->load->model("mo_geography");
		$domain = context::get('domain', "");
		$country = $this->input->get("country", true, "");
		if(!$domain){
			echo "error,联系维护工程师";
		}
		if($country){
			$countrys = explode(",", $country);
			foreach($countrys as $v){
				if($v){
					$citys = $this->mo_geography->get_cities_by_country_formadmin($v);
					foreach($citys as $city){
						$url = $domain."/".$city['lower_name']."-shoppingtips/?nocache=1";
						$re = tool::curl_get($url);
					}
				}
			}

		}
		echo "清除成功,ok!";
	}

}
