<?php
class Do_content extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function get_info($id){
		$this->db->select("*");
		$this->db->where("id", $id);
		$query = $this->db->get("zb_content");
		return $query->row_array();
	}

	public function add($data){
		$re = $this->db->insert('zb_content', $data);
		return $re;
	}
	public function update($data, $id){
		$this->db->where('id', $id);
		$re = $this->db->update('zb_content', $data);
		return $re;
	}
	public function get_list($type=0){
		$this->db->where("status", 0);
		if($type){
			$this->db->where("type", $type);
		}
		$query = $this->db->get('zb_content');
		$result = $query->result_array();
		if($result){
			$tmp = array();
			foreach($result as $v){
				$tmp[$v['id']] = $v;
			}
			$result = $tmp;
		}
		return $result;
	}
}