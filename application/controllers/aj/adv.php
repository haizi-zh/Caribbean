<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class adv extends ZB_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('mo_adv');

	}

	public function add(){
		$this->config->load('errorcode',TRUE);
		try{
			$id = $this->input->post('id', false, '');
			$name = $this->input->post('name', false, '');
			$url = $this->input->post('url', false, '');
			$pic = $this->input->post('pic', false, '');
			$country = $this->input->post('country', false, '');
			$city = $this->input->post('city', false, '');
			$shop_id = $this->input->post('shop_id', false, '');

			$n_shop_id = $this->input->post('n_shop_id', false, '');
			$n_city = $this->input->post('n_city', false, '');
			$n_coupon_id = $this->input->post('n_coupon_id', false, '');

			if($country){
				$country = ",{$country},";
			}
			if($city){
				$city = ",{$city},";
			}
			if($shop_id){
				$shop_id = ",{$shop_id},";
			}
			if($n_city){
				$n_city = ",{$n_city},";
			}
			if($n_shop_id){
				$n_shop_id = ",{$n_shop_id},";
			}
			if($n_coupon_id){
				$n_coupon_id = ",{$n_coupon_id},";
			}
			$level = $this->input->post('level', true, 1000);
			$type = $this->input->post('type', true, 0);
			$now = time();

			$add_data = array(
				'name' => $name,
				'url' => $url,
				'pic' => $pic,
				'country' => $country,
				'city' => $city,
				'shop_id'=>$shop_id,
				'level' => $level,
				'type' => $type,
				'mtime' => $now,
				'n_city' => $n_city,
				'n_shop_id' => $n_shop_id,
				'n_coupon_id'=>$n_coupon_id,
			);
			
			#入库
			if($id){
				$id = $this->mo_adv->update($add_data, $id);
			}else{
				$add_data['status'] = 0;
				$add_data['ctime'] = $now;
				$id = $this->mo_adv->add($add_data);
			}
			if (!$id) {
				$code = '204';
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
				exit();
			}
			#返回
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			
		}catch(Exception $e){var_dump($e);
			#先做个兼容
			if(isset($id) && $id){
				$code = '200';
				$this->config->load('errorcode',TRUE);
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			}else{
				$code = '204';
				echo json_encode(array('code'=>$code ,'msg'=>'系统繁忙，请稍后再试'));
			}
		}
	}

	public function delete(){
		$id = $this->input->post('id', true, 0);
		if(!$id){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}

		$re = $this->mo_adv->delete($id);

		if($re){
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
		}else{
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
	}

	public function recover(){
		$id = $this->input->post('id', true, 0);
		if(!$id){
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}

		$re = $this->mo_adv->recover($id);

		if($re){
			$code = '200';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
		}else{
			$code = '201';
			echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
			return ;
		}
	}



}