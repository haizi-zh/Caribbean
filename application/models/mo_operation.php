<?php
#运营数据
class Mo_operation extends CI_Model {

	const INDEX_PICS = 1;
	const HOT_SHOP = 2;
	const HOT_CITY = 3;
	const HOT_SHAIDAN = 4;
	
	function __construct(){
		parent::__construct();
		$this->load->model('do/do_kv');
	}

	#更新图片
	public function update_home_pics($key,$value){
		$re = $this->do_kv->get_value($key);
		#没有则插入，有则更新
		if($re) return $this->do_kv->update($key,json_encode($value));
		else return $this->do_kv->add(array('key'=>$key,'value'=>json_encode($value)));
	}
	
	#设置
	public function set($key,$value){
		$re = $this->do_kv->get_value($key);
		
		#没有则插入，有则更新
		if($re) return $this->do_kv->update($key,json_encode($value));
		else return $this->do_kv->add(array('key'=>$key,'value'=>json_encode($value)));
	}
	
	#获取数据
	public function get_value($key){
		$re = $this->do_kv->get_value($key);
		
		#格式化成数组
		$format_re = $this->tool->std2array($re);
		$re = isset($format_re[0]['value'])?$format_re[0]['value']:'{}';
		
		return $this->tool->std2array(json_decode($re));
	}
}