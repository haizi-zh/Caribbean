<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class fav extends ZB_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('mo_shop');
		$this->load->model('mo_brand');
		$this->load->model('mo_discount');
		$this->load->model('mo_common');
		$this->load->model('mo_geography');
		$this->load->model('mo_coupon');
		$this->load->model('mo_tag');
		$this->load->model('mo_fav');
	}

	# http://zan.com/aj/fav/get_area_city?area=3&page=2
	public function getFavHtml(){
		$city_id = $this->input->get("city", true , 0);
		$page = $this->input->get("page", true, 1);
		$type = $this->input->get("type", true, 0);
		$pagesize = 4;
		$data = array();
		if( isset($this->session->userdata['user_info']['uid']) ){
			$uid = $this->session->userdata['user_info']['uid'];
		}else{
			$code = '202';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
			exit;
		}
		if($type==0){
			$re = $this->mo_fav->get_fav_shops($uid,$city_id,$page,$pagesize);
			$fav_shops = $re['list'];
			$fav_shops_count = $re['count'];
			$shop_city_infos = $re['city_infos'];
			$add_data = array();
			$add_data['fav_shops'] = $fav_shops;
			$add_data['fav_shops_count'] = $fav_shops_count;
			$add_data['shop_city_infos'] = $shop_city_infos;
			$add_data['page'] = $page;
			$page_total = ceil($fav_shops_count / $pagesize);

			$html = $this->load->view("template/fav_shop", $add_data, true);
		}else{
			$re = $this->mo_fav->get_fav_coupons($uid,$city_id,$page,$pagesize);
			$fav_coupons = $re['list'];
			$fav_coupons_count = $re['count'];
			$coupon_city_infos = $re['city_infos'];
			$add_data = array();
			$add_data['fav_coupons'] = $fav_coupons;
			$add_data['fav_coupons_count'] = $fav_coupons_count;
			$add_data['coupon_city_infos'] = $coupon_city_infos;
			$add_data['page'] = $page;
			$page_total = ceil($fav_coupons_count / $pagesize);
			$html = $this->load->view("template/fav_coupon", $add_data, true);
		}
		$data['page_total'] = $page_total;
		$data['html'] = $html;
		$data['city'] = $city_id;
		$page = $page+1;
		if($page >= $page_total){
			$page = 0;
		}
		$data['page'] = $page;

		echo json_encode(array('code'=>'200','msg'=>'succ', 'data'=> $data));

	}
	public function add_shop(){
		$this->config->load('errorcode',TRUE);
		$shop_id = $this->input->post("shop_id", true, 0);
		if(!$shop_id){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
			exit;
		}

		if( isset($this->session->userdata['user_info']['uid']) ){
			$uid = $this->session->userdata['user_info']['uid'];
		}else{
			$code = '202';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
			exit;
		}
		$add_data = array();
		$add_data['id'] = $shop_id;
		$add_data['type'] = 0;
		$add_data['user_id'] = $uid;
		$add_data['ctime'] = time();

		$re = $this->mo_fav->add_favorite($add_data);
		if($re){
			$code = 200;
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
		}else{
			$code = '204';
			echo json_encode(array('code'=>$code ,'msg'=>'系统繁忙，请稍后再试'));
		}
	}

	public function delete_shop(){
		$this->config->load('errorcode',TRUE);
		$shop_id = $this->input->post("shop_id", true, 0);
		if(!$shop_id){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
			exit;
		}
		if( isset($this->session->userdata['user_info']['uid']) ){
			$uid = $this->session->userdata['user_info']['uid'];
		}else{
			$code = '202';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
			exit;
		}
		$type = 0;
		$re = 0;
		$exist = $this->mo_fav->get_exist($uid, $shop_id, $type);
		if($exist && $exist['id']){
			$id = $exist['id'];
			$re = $this->mo_fav->delete_favorite($id, $uid);
		}

		if($re){
			$code = 200;
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
		}else{
			$code = '204';
			echo json_encode(array('code'=>$code ,'msg'=>'系统繁忙，请稍后再试'));
		}
	}


	public function add_fav(){
		$this->config->load('errorcode',TRUE);
		$id = $this->input->post("id", true, 0);
		$type = $this->input->post("type", true, 0);
		if(!$id){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
			exit;
		}

		if( isset($this->session->userdata['user_info']['uid']) ){
			$uid = $this->session->userdata['user_info']['uid'];
		}else{
			$code = '202';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
			exit;
		}
		$add_data = array();
		$add_data['id'] = $id;
		$add_data['type'] = $type;
		$add_data['user_id'] = $uid;
		$add_data['ctime'] = time();

		$re = $this->mo_fav->add_favorite($add_data);
		if($re){
			$code = 200;
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
		}else{
			$code = '204';
			echo json_encode(array('code'=>$code ,'msg'=>'系统繁忙，请稍后再试'));
		}
	}

	public function delete_fav(){
		$this->config->load('errorcode',TRUE);
		$id = $this->input->post("id", true, 0);
		$type = $this->input->post("type", true, 0);
		if(!$id){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
			exit;
		}
		if( isset($this->session->userdata['user_info']['uid']) ){
			$uid = $this->session->userdata['user_info']['uid'];
		}else{
			$code = '202';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
			exit;
		}
		$re = 0;
		$exist = $this->mo_fav->get_exist($uid, $id, $type);
		if($exist && $exist['id']){
			$id = $exist['id'];
			$re = $this->mo_fav->delete_favorite($id, $uid);
		}

		if($re){
			$code = 200;
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
		}else{
			$code = '204';
			echo json_encode(array('code'=>$code ,'msg'=>'系统繁忙，请稍后再试'));
		}
	}


}



