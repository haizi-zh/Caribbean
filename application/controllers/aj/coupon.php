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
	}
	// ALTER TABLE  `zb_coupon` ADD  `country_ids` VARCHAR( 100 ) NOT NULL default '' AFTER  `brand_id` 
	public function add(){

		$this->config->load('errorcode',TRUE);
		try{

			$coupon_id = $this->input->post('id', false, '');

			$body = $this->input->post('body', false, '');
			$level = $this->input->post('level', true, 1000);
			$title = $this->input->post('title', true, '');
			$share_content = $this->input->post('share_content', true, '');
			$country_ids = $this->input->post('country_ids', true, '');
			$img_size = $this->input->post("img_size", true, 0);
			$template_order = $this->input->post("template_order", true, 0);

			$has_pic = $this->input->post('pics', true, 0);
			if(!$coupon_id || $has_pic){
				if ($has_pic){
					$has_pic = 1;
				}else{
					$has_pic = 0;
				}
				$pics = $this->input->post('pics', true, '');
				if ($pics){
					$pics_list = explode(",",$_POST['pics']);
					foreach($pics_list as $k => $v){
						if(!$v){
							unset($pics_list[$k]);
						}
					}
					$pics = json_encode($pics_list);
				}else{
					$pics = '';
				}
			}

			$shop_ids_str = $this->input->post('shop_ids_str', true, '');
			$brand_infos = $this->input->post('brand_infos', true, '');
			if($shop_ids_str){
				$tmp = explode(",", $shop_ids_str);
				foreach($tmp as $k=> $v){
					if(!$v){
						unset($tmp[$k]);
					}
				}
				if($tmp){
					$shop_id = ",".implode(",", $tmp).",";
				}else{
					$shop_id = '';
				}
			}else{
				$shop_id = '';
			}
			$brand_id = $country_ids = "";
			if($brand_infos){
				$brand_id = ",";
				foreach($brand_infos as $brand_id_key =>$counrtys_value){
					$brand_id .= $brand_id_key.",";
					$country_ids .= $counrtys_value . "|";
				}
			}

			$user_info=$this->session->userdata('user_info');
			$this->config->load('env',TRUE);
			
			//$this->mo_shop->delete_shop_cache($shop_id, $brand_id);
			
			$this->load->model('mo_coupon');
			#判断body是否重复
			//$uid = $user_info['uid'];
			$uid = 0;
			$type=1;
			$now = $ctime = time();
			
			$ip = 0;
			#拼装
			$stime = strtotime($stime);
			$etime = strtotime($etime);
			$add_data = array(
					'level' => $level,
					'title' => $title,
					'has_pic' => $has_pic,
					'type' => $type,
					'ip'=>$ip,
					'uid' => $uid,
					'shop_id' => $shop_id,
					'brand_id' => $brand_id,
					'share_content'=>$share_content,
					'img_size'=>$img_size,
					'country_ids'=>$country_ids,
					'template_order'=>$template_order,
					);
			if($body){
				$add_data['body'] = $body;
			}
			if(isset($pics)){
				$add_data['pics'] = $pics;
			}
			#入库
			if($coupon_id){
				$add_data['mtime'] = $now;
				$coupon_id = $this->mo_coupon->update($add_data, $coupon_id);
			}else{
				$add_data['status'] = 1;
				$add_data['ctime'] = $now;
				$add_data['mtime'] = $now;
				$coupon_id = $this->mo_coupon->add($add_data);
			}
			
			if (!$coupon_id) {
				$code = '204';
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
				exit();
			}
			#返回
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			
		}catch(Exception $e){
			#先做个兼容
			if(isset($coupon_id) && $coupon_id){
				$code = '200';
				$this->config->load('errorcode',TRUE);
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			}else{
				$code = '204';
				echo json_encode(array('code'=>$code ,'msg'=>'系统繁忙，请稍后再试'));
			}
		}
	}
	public function add_rich(){
		$this->config->load('errorcode',TRUE);
		try{
			$id = $this->input->post('id', true, '0');
			$pics = $this->input->post('pics', true, '');
			$body = $this->input->post('body', true, '');
			if ($pics){
				$has_pic = 1;
			}else{
				$has_pic = 0;
			}
			$this->config->load('env',TRUE);
			$this->load->model('mo_coupon');

			$coupon_data = array(
					'has_pic' => $has_pic,
					'body' => $body,
					'is_rich'=>1,
					);

			#入库
			$coupon_id = $this->mo_coupon->update($coupon_data, $id);
			
			if (!$coupon_id) {
				$code = '204';
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
				exit();
			}
			#返回
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			
		}catch(Exception $e){
			#先做个兼容
			if(isset($coupon_id) && $coupon_id){
				$code = '200';
				$this->config->load('errorcode',TRUE);
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			}else{
				$code = '204';
				echo json_encode(array('code'=>$code ,'msg'=>'系统繁忙，请稍后再试'));
			}
		}
	}

	public function edit_coupon_seo(){
		$this->config->load('errorcode',TRUE);
		try{
			$id = $this->input->post('id', true, '0');
			$seo_title = $this->input->post('seo_title', true, '');
			$seo_keywords = $this->input->post('seo_keywords', true, '');
			$seo_description = $this->input->post('seo_description', true, '');
			$this->config->load('env',TRUE);
			

			$this->load->model('mo_coupon');
			#判断body是否重复
			#拼装

			$coupon_data = array(
					'seo_title' => $seo_title,
					'seo_keywords' => $seo_keywords,
					'seo_description' => $seo_description,
					);
			#入库
			$coupon_id = $this->mo_coupon->update($coupon_data, $id);
			if (!$coupon_id) {
				$code = '204';
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
				exit();
			}
			#返回
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			
		}catch(Exception $e){
			#先做个兼容
			if(isset($coupon_id) && $coupon_id){
				$code = '200';
				$this->config->load('errorcode',TRUE);
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			}else{
				$code = '204';
				echo json_encode(array('code'=>$code ,'msg'=>'系统繁忙，请稍后再试'));
			}
		}

	}


	public function add_coupon_mobile_image(){
		$this->config->load('errorcode',TRUE);
		try{

			$coupon_id = $this->input->post('id', false, '');
			//mobile_pics
			$has_pic = $this->input->post('mobile_pics', true, 0);
			if($has_pic){
				if ($has_pic){
					$has_pic = 1;
				}else{
					$has_pic = 0;
				}
				$pics = $this->input->post('mobile_pics', true, '');
				if ($pics){
					$pics_list = explode(",",$_POST['mobile_pics']);
					foreach($pics_list as $k => $v){
						if(!$v){
							unset($pics_list[$k]);
						}
					}
					$pics = json_encode($pics_list);
				}else{
					$pics = '';
				}
			}
			$this->config->load('env',TRUE);
			
			$this->load->model('mo_coupon');
			$add_data = array();
			$now = time();
			if(isset($pics)){
				$add_data['mobile_pics'] = $pics;
			}
			var_dump($add_data);
			#入库
			if($coupon_id){
				$add_data['mtime'] = $now;
				$coupon_id = $this->mo_coupon->update($add_data, $coupon_id);
			}else{
			}
			
			if (!$coupon_id) {
				$code = '204';
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
				exit();
			}
			#返回
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			
		}catch(Exception $e){
			#先做个兼容
			if(isset($coupon_id) && $coupon_id){
				$code = '200';
				$this->config->load('errorcode',TRUE);
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			}else{
				$code = '204';
				echo json_encode(array('code'=>$code ,'msg'=>'系统繁忙，请稍后再试'));
			}
		}
	}


	public function delete_coupon(){
		$id = $this->input->post('id', true, 0);
		if(!$id){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
		$this->load->model('mo_coupon');

		$coupon_info = $this->mo_coupon->get_info($id);
		$shop_id = $coupon_info['shop_id'];
		$brand_id = $coupon_info['brand_id'];
		$this->mo_shop->delete_shop_cache($shop_id, $brand_id);

		$re = $this->mo_coupon->delete_coupon(array('id' => $id));

		if($re){
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
		}else{
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
	}

	public function recover_coupon(){
		$id = $this->input->post('id', true, 0);
		if(!$id){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
		$this->load->model('mo_coupon');

		$coupon_info = $this->mo_coupon->get_info($id);
		$shop_id = $coupon_info['shop_id'];
		$brand_id = $coupon_info['brand_id'];
		$this->mo_shop->delete_shop_cache($shop_id, $brand_id);

		$re = $this->mo_coupon->recover_coupon(array('id' => $id));

		if($re){
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
		}else{
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
	}
	public function get_brand_countrys(){
		$brand_id = $this->input->get('brand_id', true, 0);
		$re = $this->mo_brand->get_brand_countrys($brand_id);
		echo json_encode($re);
	}


}