<?php
class Do_baidu extends CI_Model {
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	public function get_info_by_md5($url_md5){
		$this->db->select("*");
		$this->db->where("url_md5", $url_md5);
		$query = $this->db->get("zb_baidu");
		$list = $query->row_array();
		return $list;
	}

	public function add($data){
		$brand_data = array(
				'url' => isset($data['url'])?$data['url']:'',
				'url_md5' => isset($data['url_md5'])?$data['url_md5']:'',
				'url_id' => isset($data['url_id'])?$data['url_id']: 0 ,
				'type' => isset($data['type'])?$data['type']: 0 ,
				'ctime' => isset($data['ctime'])?$data['ctime']:time(),
				'mtime' => isset($data['mtime'])?$data['mtime']:time(),
				'stime' => isset($data['stime'])?$data['stime']:0,
				'nstime' => isset($data['nstime'])?$data['nstime']:0,
				'status' => isset($data['status'])?$data['status']:0,
		);
		$this->db->insert('zb_baidu', $brand_data);
	}
	public function update($data){
		$id = $data['id'];
		unset($data['id']);
		$this->db->where('id', $id);
		return $this->db->update('zb_baidu', $data);
	}

	public function get_all_baidu($type=0, $stime=false, $last_time = 0, $limit=0){

		$this->db->select("*");
		if($type){
			$this->db->where('type', $type);
		}
		if($stime!==false){
			$this->db->where('stime', $stime);
		}
		if($last_time){
			$this->db->where('last_time < ', $last_time);
		}

		if($limit){
			$this->db->limit($limit, 0);
		}

		//$this->db->where('status', 0);
		$query = $this->db->get("zb_baidu");
		$re = $query->result_array();
		var_dump($this->db->last_query());

		if($re){
			$tmp = array();
			foreach($re as $each){
				$tmp[$each['id']] = $each;
			}
			$re = $tmp;
		}
		
		return $re;
	}

	public function get_all_baidu_by_type($type=0){
		$this->db->select("*");
		if($type){
			$this->db->where('type', $type);
		}
		$query = $this->db->get("zb_baidu");
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