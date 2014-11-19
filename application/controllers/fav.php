<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class fav extends ZB_Controller {
	const PAGE_ID = 'fav';
	public function __construct(){
		parent::__construct();
		$this->load->model("mo_user");
		$this->load->model("mo_module");
		$this->load->model("mo_fav");
	}

	public function index(){
		$data = array();
		if( isset($this->session->userdata['user_info']['uid']) ){
			$uid = $this->session->userdata['user_info']['uid'];
		}else{
			$this->tool->sorry();
		}

		$page = $this->input->get("page", true, 1);
		$page = intval($page);
		$user_info = $this->mo_user->get_middle_userinfo($uid);
		
		$right_user_html = $this->mo_module->right_user_info($uid, $uid);
		$data['right_user_html'] = $right_user_html;

		$re = $this->mo_fav->get_fav_shops($uid,0,1,4);
		$fav_shops = $re['list'];
		$fav_shops_count = $re['count'];
		$shop_city_infos = $re['city_infos'];
		

		$re = $this->mo_fav->get_fav_coupons($uid,0,1,4);
		$fav_coupons = $re['list'];
		$fav_coupons_count = $re['count'];
		$coupon_city_infos = $re['city_infos'];

		$data['fav_shops'] = $fav_shops;
		$data['fav_shops_count'] = $fav_shops_count;
		$data['shop_city_infos'] = $shop_city_infos;
		$data['type'] = 0;
		$data['page'] = $page;
		$shop_html = $this->load->view("template/fav_shop", $data, true);
		$data['shop_html'] = $shop_html;

		$data['fav_coupons'] = $fav_coupons;
		$data['fav_coupons_count'] = $fav_coupons_count;
		$data['coupon_city_infos'] = $coupon_city_infos;
		$data['type'] = 1;
		$data['page'] = $page;
		$coupon_html = $this->load->view("template/fav_coupon", $data, true);
		$data['coupon_html'] = $coupon_html;

		$data['pageid'] = self::PAGE_ID;
		$data['page_css'] = "ZB_ping.css";

		$this->get_adv_data();

		$data['macys_html'] = $this->mo_module->format_macys(1);
		
		$this->load->web_view('fav', $data);
	}
}