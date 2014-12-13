<?php
class Mo_count extends ZB_Model {
	function __construct(){
		parent::__construct();
		$this->load->model('do/do_count');
	}
	public function add_day($data){
		$type = $data['type'];
		$day = $data['day'];
		$exist = $this->do_count->get_day_exist($type, $day);
		if($exist){
			return;
		}else{
			return $this->do_count->add_day($data);
		}
	}
	public function update_day($data){
		if(!isset($data['id']) || !$data['id']){
			return false;
		}
		$re = $this->do_count->update_day($data);
		return $re;
	}
	public function get_all_count_day($status, $page=1, $pagesize=100){
		$re = $this->do_count->get_all_count_day($status, $page, $pagesize);
		return $re;
	}

	public function add_count($data){
		$type = $data['type'];
		$day = $data['day'];
		$sid = $data['sid'];
		$exist = $this->do_count->get_count_exist($type, $day, $sid);
		if($exist){
			return;
		}
		return $this->do_count->add_count($data);
	}
	public function update_count($data){
		if(!isset($data['id']) || !$data['id']){
			return false;
		}
		$re = $this->do_count->update_count($data);
		return $re;
	}

	public function get_all_count_by_sid($type, $sid){
		$type = intval($type);
		$sid = intval($sid);


		$re = $this->do_count->get_list_by_sid($type, $sid);

		$count = 0;
		if($re){
			foreach($re as $v){
				$count += $v;
			}
		}
		return $count;
	}

	public function get_list_by_sid($type, $sid , $stime=0, $etime=0){
		$type = intval($type);
		$sid = intval($sid);
		$stime = intval($stime);
		$etime = intval($etime);

		$re = $this->do_count->get_list_by_sid($type, $sid, $stime, $etime);

		$count = array();
		if($re){
			for($day=$stime; $day <= $etime; $day+=86400){
				if(isset($re[$day])){
					if(isset($count[$day])){
						$count[$day] += $re[$day];
					}else{
						$count[$day] = intval($re[$day]);
					}
				}
			}
		}
		return $count;
	}


	public function get_count_by_sids($type, $sids ,$stime=0, $etime=0){
		$type = intval($type);
		foreach($sids as $k => $v){
			$sids[$k] = intval($v);
		}
		$stime = intval($stime);
		$etime = intval($etime);

		$re = $this->do_count->get_count_by_sids($type, $sids ,$stime, $etime);
		$count = array();
		if($re){
			foreach($re as $v){
				if(isset($count[$v['sid']])){
					$count[$v['sid']] += $v['count'];
				}else{
					$count[$v['sid']] = intval($v['count']);
				}
			}
			foreach($sids as $k=>$v){
				if(!isset($count[$v])){
					$count[$v] = 0;
				}
			}
		}
		return $count;
	}
}