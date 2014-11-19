<?php
#数据统计
class Do_data_analytics extends CI_Model {
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	#添加一条记录
	public function add($business,$time,$value){
		$data = array(
				'business' => $business,
				'time' => $time,
				'year' => date('Y',$time),
				'month' => date('m',$time),
				'day' => date('d',$time),
				'hour' => date('H',$time),
				'minute' => date('i',$time),
				'second' => date('s',$time),
				'value' => $value,
		);
		$this->db->insert('zb_data_analytics', $data);
	}
	
	#获取数值
	public function get($business,$year=-1,$month=-1,$day=-1,$hour=-1,$minute=-1,$second=-1){
		$this->db->select('value');
		$this->db->select('time');
		if($year>=0){
			$this->db->where('year', $year);
		}
		if($month>=0){
			$this->db->where('month', $month);
		}
		if($day>=0){
			$this->db->where('day', $day);
		}
		if($hour>=0){
			$this->db->where('hour', $hour);
		}
		if($minute>=0){
			$this->db->where('minute', $minute);
		}
		if($second>=0){
			$this->db->where('second', $second);
		}
		$this->db->where('business', $business);
		$query = $this->db->get('zb_data_analytics');
		return $query->result();
	}
}
