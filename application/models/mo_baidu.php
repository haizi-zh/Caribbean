<?php

class Mo_baidu extends ZB_Model {
	function __construct(){
		parent::__construct();
		$this->load->model('do/do_baidu');
	}
	public function add($data){
		$url = $data['url'];
		if(!$url){
			return;
		}
		$url_md5 = md5($url);
		$exist = $this->do_baidu->get_info_by_md5($url_md5);
		if($exist){
			if($exist['status'] == $data['status']){
				return;
			}
			$up_data = array();
			$up_data['id'] = $exist['id'];
			$up_data['status'] = $data['status'];
			$re = $this->do_baidu->update($up_data);
			return;
		}
		$data['url_md5'] = $url_md5;
		return $this->do_baidu->add($data);
	}
	public function update($data){
		if(!isset($data['id']) || !$data['id']){
			return false;
		}
		$re = $this->do_baidu->update($data);
		return $re;
	}

	public function get_all_baidu($type=0, $stime = 0, $last_time = 0, $limit = 0 ){
		#获取返回值
		$re = $this->do_baidu->get_all_baidu($type, $stime, $last_time, $limit);
		return $re;
	}
	public function get_tips_baidu(){
		$list = $this->do_baidu->get_all_baidu_by_type(1);
		if($list){
			$tmp = array();
			foreach($list as $v){
				$tmp[$v['url_id']] = $v;
			}
			$list = $tmp;
		}

		return $list;
	}

	public function get_baidu_stime($type=0, $url_ids = array()){
		$re = $this->do_baidu->get_baidu_stime($type, $url_ids);
		return $re;
	}
}