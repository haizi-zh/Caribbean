<?php
class Do_count extends CI_Model {
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	public function get_day_exist($type, $day){
		$this->db->select("*");
		$this->db->where("type", $type);
		$this->db->where("day", $day);
		$query = $this->db->get("zb_count_day");
		$list = $query->row_array();
		return $list;
	}
	public function add_day($data){
		$add_data = array(
			'type' => isset($data['type'])?$data['type']:0,
			'day' => isset($data['day'])?$data['day']:0,
			'status' => isset($data['status'])?$data['status']: 0 ,
			'ctime' => isset($data['ctime'])?$data['ctime']:time(),
		);
		$this->db->insert('zb_count_day', $add_data);
	}
	public function update_day($data){
		$id = $data['id'];
		unset($data['id']);
		$this->db->where('id', $id);
		return $this->db->update('zb_count_day', $data);
	}

	public function get_all_count_day($status=0, $page=1,$pagesize =100){
		$offset = ($page - 1) * $pagesize;
		$this->db->select("*");
		$this->db->where('status', $status);
		$this->db->limit($pagesize, $offset);
		$query = $this->db->get("zb_count_day");

		$re = $query->result_array();
		if($re){
			$tmp = array();
			foreach($re as $each){
				$tmp[$each['id']] = $each;
			}
			$re = $tmp;
		}
		return $re;
	}
	public function get_count_exist($type, $day, $sid){
		$this->db->select("*");
		$this->db->where("type", $type);
		$this->db->where("day", $day);
		$this->db->where("sid", $sid);
		$query = $this->db->get("zb_count");
		$list = $query->row_array();
		return $list;
	}
	public function add_count($data){
		$add_data = array(
			'sid' => isset($data['sid'])?$data['sid']:0,
			'type' => isset($data['type'])?$data['type']:0,
			'day' => isset($data['day'])?$data['day']:0,
			'count' => isset($data['count'])?$data['count']: 0 ,
			'ctime' => isset($data['ctime'])?$data['ctime']:time(),
		);
		$this->db->insert('zb_count', $add_data);
	}

	public function update_count($data){
		$id = $data['id'];
		unset($data['id']);
		$this->db->where('id', $id);
		return $this->db->update('zb_count', $data);
	}

	public function get_list_by_sid($type, $sid , $stime=0, $etime=0){
		$this->db->select("*");
		$this->db->where('type', $type);
		$this->db->where('sid', $sid);
		if($stime){
			$this->db->where('day >=', $stime);
		}
		if($etime){
			$this->db->where('day <=', $etime);
		}
		$query = $this->db->get("zb_count");
		$re = $query->result_array();
		if($re){
			$tmp = array();
			foreach($re as $v){
				$tmp[$v['day']] = $v['count'];
			}
			$re = $tmp;
		}
		return $re;
	}


	public function get_count_by_sids($type, $sids, $stime=0, $etime=0){
		$this->db->select("*");
		$this->db->where('type', $type);
		if($stime){
			$this->db->where('day >=', $stime);
		}
		if($etime){
			$this->db->where('day <=', $etime);
		}
		
		
		$this->db->where_in('sid', $sids);
		$query = $this->db->get("zb_count");
		$re = $query->result_array();
		return $re;
	}

	public function get_all_count_day1($status=0){
		$this->db->select("sum");
		$this->db->where('status', $status);
		$query = $this->db->get("zb_count_day");
		$re = $query->result_array();
		if($re){
			$tmp = array();
			foreach($re as $each){
				$tmp[$each['id']] = $each;
			}
			$re = $tmp;
		}
		return $re;
	}



	public function get_baidu_stime($type=0, $url_ids = array()){
		$this->db->select("*");
		if($type){
			$this->db->where('type', $type);
		}
		$this->db->where_in("url_id", $url_ids);
		$query = $this->db->get("zb_baidu");
		$re = $query->result_array();
		if($re){
			$tmp = array();
			foreach($re as $each){
				$tmp[$each['url_id']] = $each;
			}
			$re = $tmp;
		}
		return $re;

	}

}