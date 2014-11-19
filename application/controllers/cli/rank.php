<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class rank extends CI_Controller {
		
	public function setHot($shop_ids = '', $key = 2){
		$cnt = 10; #取top x
		
		$shops = split('-',$shop_ids);
		if(!$shops || empty($shops) || count($shops) == 0) return;
		
		$this->load->model('mo_operation');
		if(count($shops) < $cnt){#不足cnt个
			$pre_shops = $this->mo_operation->get_value($key);
			if(!empty($pre_shops)){
				$shops = array_merge($shops,$pre_shops);
				$shops = array_slice($shops,0,$cnt);
			}
		}else{
			$shops = array_slice($shops,0,$cnt);
		}
		
		$this->mo_operation->set($key,$shops);
	}	
}