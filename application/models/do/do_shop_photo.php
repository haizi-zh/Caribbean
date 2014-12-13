<?php
class Do_shop_photo extends CI_Model {
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function add_shop_photo($data){
		$this->db->insert('zb_shop_photo', $data);
		return $this->db->insert_id();
	}
	public function modify_photo_desc($data, $id){
		$this->db->where('id', $id);
		$re = $this->db->update('zb_shop_photo', $data);
		if ($re) {
			return $id;
		}
		return $re;
	}
	public function delete_shop_photo($id){
		$this->db->where('id', $id);
		return $this->db->delete('zb_shop_photo'); 
	}
	public function get_shop_photo($id){
		$this->db->select("*");
		$this->db->where("id", $id);
		$query = $this->db->get("zb_shop_photo");
		$re = $query->row_array();
		return $re;
	}
	public function get_shopphoto_by_shopid($shop_id, $page=1, $pagesize=10){
		$offset = ($page - 1) * $pagesize;

		$this->db->select("*");
		$this->db->where("shop_id", $shop_id);
		$this->db->limit($pagesize, $offset);
		$this->db->order_by("ctime", 'desc');
		$query = $this->db->get("zb_shop_photo");
		$list = $query->result_array();
		if($list){
			$tmp = array();
			foreach($list as $v){
				$tmp[$v['id']] = $v;
			}
			$re = $tmp;
		}
		return $list;
	}
	public function get_shopphoto_by_shopid_count($shop_id){
		$this->db->select("count(id) as cnt");
		$this->db->where("shop_id", $shop_id);
		$query = $this->db->get("zb_shop_photo");
		$re = $query->row_array();
		$cnt = $re['cnt'];
		return $cnt;
	}

}