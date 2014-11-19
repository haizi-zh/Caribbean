<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class coupon extends ZB_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('mo_shop');
		$this->load->model('mo_brand');
		$this->load->model('mo_discount');
		$this->load->model('mo_common');
		$this->load->model('mo_geography');
		$this->load->model('mo_coupon');
		$this->load->model('mo_fav');
	}
	# http://zanbai.com/mobile/coupon/get_coupon_info?id=4
	// http://zan.com/mobile/coupon/get_coupon_info?id=4
	public function get_coupon_info(){
		$id = isset($_GET['id'])?$_GET['id']:0;
		$re = array();
		if($id){
			$coupon_info = $this->mo_coupon->get_info($id);
			$re = $this->format_coupon_info($coupon_info);
		}
		$code = '200';
		$this->config->load('errorcode',TRUE);
		echo $this->mobile_json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'data'=>$re));
	}

	# http://zanbai.com/mobile/coupon/add_favorite?id=4
	public function add_favorite(){
		$id = isset($_POST['id'])?$_POST['id']:0;
		$user_info=$this->session->userdata('user_info');
		$uid = 0;
		if ($user_info && isset($user_info['uid'])) {
			$uid = $user_info['uid'];
		}
		$data['user_id'] = $uid;
		$data['id'] = $id;
		$data['type'] = 1;
		$data['mobile'] = 0;
		$data['ctime'] = time();
		$re = $this->mo_fav->add_favorite($data);

		echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ', 'data'=>$data));
		return;
	}

	# http://zanbai.com/mobile/coupon/delete_favorite?id=4
	public function delete_favorite(){
		$favorite_id = isset($_POST['id'])?$_POST['id']:0;
		$user_info=$this->session->userdata('user_info');
		$uid = 0;
		if ($user_info && isset($user_info['uid'])) {
			$uid = $user_info['uid'];
		}
		if(!$uid){
			echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ', 'data'=>$data));
			return;
		}

		$type = 1;
		$exist = $this->mo_fav->get_exist($uid, $favorite_id, $type);
		if($exist && $exist['id']){
			$id = $exist['id'];
			$this->mo_fav->delete_favorite($id, $exist['uid']);
		}

		echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ', 'data'=>$data));
		return;
	}

	# http://zan.com/mobile/coupon/get_favorite_list?id=4
	public function get_favorite_list(){
		$user_info=$this->session->userdata('user_info');
		$uid = 0;
		if ($user_info && isset($user_info['uid'])) {
			$uid = $user_info['uid'];
		}
		$page = isset($_GET['page'])?$_GET['page']:1;
		$pagesize = isset($_GET['pagesize'])?$_GET['pagesize']:10;


		$re = $this->mo_fav->get_fav_coupons($uid);
		$count = $re['count'];
		$coupon_infos = $re['list'];
		$city_infos = $re['city_infos'];
		$coupon_infos = $this->format_coupon_infos($coupon_infos);
		
		if($coupon_infos){
			foreach($coupon_infos as $k => $v){
				$coupon_infos[$k]['is_fav'] = 1;
			}
		}

		$data = array();
		$data['total_number'] = $count;
		$data['list'] = $coupon_infos;
		echo $this->mobile_json_encode(array('code'=>'200','msg'=>'succ', 'data'=>$data));
		return;
	}

	public function format_coupon_infos($coupon_infos){
		$tmp = array();
		if(!$coupon_infos){
			return $tmp;
		}
		foreach($coupon_infos as $k=> $coupon_info){
			$re = $this->format_coupon_info($coupon_info);
			$tmp[$k] = $re;
		}
		return $tmp;
	}

	public function format_coupon_info($coupon_info){
		$re = array();
		if(!$coupon_info){
			return $re;
		}
		$re['id'] = $coupon_info['id'];
		$re['title'] = $coupon_info['title'];
		$re['body'] = $coupon_info['body'];
		$re['has_pic'] = $coupon_info['has_pic'];
		$re['shareurl'] = $coupon_info['shareurl'];

		$pdf_file = "";
		if($coupon_info['pdf_name']){
			$pdf_file = "http://zbfile.b0.upaiyun.com/coupon/".$coupon_info['pdf_name'];
		}
		$re['pdf_file'] = $pdf_file;
		
		$decode = array();
		if($coupon_info['mobile_pics_list']){
			$pic = $coupon_info['mobile_pics_list'][0];
		}else{
			$pic = $coupon_info['pics_list'][0];
		}
		$pic = tool::use_image_version($pic, "shopimagepop");
		$re['pics_list'][] = $pic;
		$re['pics'] = json_encode($re['pics_list']);

		return $re;
	}
}


