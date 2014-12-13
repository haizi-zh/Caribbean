<?php

class Do_fav extends CI_Model {
	const STATUS_NORMAL = 0;
	const STATUS_DELETE = 1;

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_exist($uid, $favorite_id, $type){
		$this->db->select('id,status');
		$this->db->where('uid',$uid);
		$this->db->where('favorite_id', $favorite_id);
		$this->db->where('type', $type);
		$query = $this->db->get('zb_favorites');
		return $query->row_array();
	}

	public function delete($id){
		$data = array(
			'status' => self::STATUS_DELETE,
		);
		$this->db->where('id', $id);
		$re = $this->db->update('zb_favorites', $data);
		return $re;
	}

	public function recover($id){
		$data = array(
			'status' => self::STATUS_NORMAL,
		);
		$this->db->where('id', $id);
		return $this->db->update('zb_favorites', $data);
	}

	public function get_fav_list($uid, $type){
		$this->db->select("*");
		$this->db->where('status', 0);
		$this->db->where('uid', $uid);
		$this->db->where('type', $type);
		$this->db->order_by("ctime", "desc");

		$query = $this->db->get("zb_favorites");
		$list = $query->result_array();
		return $list;
	}


	public function add_favorite($data){
		$re = $this->db->insert('zb_favorites', $data);
		return $this->db->insert_id();
	}

	public function delete_favorite($data){
		$this->db->where('uid', $data['uid']);
		$this->db->where('type', $data['type']);
		$this->db->where('favorite_id', $data['favorite_id']);
		return $this->db->delete('zb_favorites');
	}

	public function get_favorite_list($uid){
		$this->db->select("*");

		$this->db->where('uid', $uid);
		$this->db->where('type', 1);
		$query = $this->db->get("zb_favorites");
		$list = $query->result_array();

		return $list;
	}
	
	public function get_favorite_count($uid){
		$this->db->select("count(distinct(favorite_id)) as cid");

		$this->db->where('uid', $uid);
		$this->db->where('type', 1);
		$query = $this->db->get("zb_favorites");
		$list = $query->row_array();

		$count = $list['cid'];
		
		return $count;
	}
}




