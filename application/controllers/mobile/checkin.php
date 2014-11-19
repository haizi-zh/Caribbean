<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class checkin extends ZB_Controller {
		
	public function find_shop(){
		$this->config->load('errorcode',TRUE);
		
		try{
			#获取参数
			$lat = $this->input->get('lat', TRUE);
			$lon =$this->input->get('lon', TRUE);
			$user_info=array('uid'=>1369557096);
			$this->config->load('env',TRUE);
			
			if(!$user_info){
				$code = '202';
				echo $this->mobile_json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
				exit;
			}
			
			if($lat == '' || $lon == ''){
				$code = '201';
				echo $this->mobile_json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
				exit;
			}

			#to do
			$shops = array(7,8,9,10,11,12,13,14,15,16);
			
			$this->load->model('mo_shop');
			$shop_re = $this->mo_shop->get_shopinfo_by_ids($shops);
			
			$code = 200;
			echo $this->mobile_json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'data'=>array_values($shop_re)));
			
		}catch(Exception $e){
			echo $this->mobile_json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
	
	public function check_in(){
		$this->config->load('errorcode',TRUE);
		try{
			#获取参数
			$shop_id = $this->input->post('shop_id', TRUE);
			$user_info=array('uid'=>1369557096);
			$this->config->load('env',TRUE);
		
			if(!$user_info){
				$code = '202';
				echo $this->mobile_json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'html'=>''));
				exit;
			}
		
			if($shop_id == ''){
				$code = '201';
				echo $this->mobile_json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
				exit;
			}
		
			$code = 200;
			echo $this->mobile_json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode'),'data'=>array()));
			
		}catch(Exception $e){
			echo $this->mobile_json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
}
