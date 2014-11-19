<?php
#品牌操作类
class Do_brandtag extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function get_brandtag_list($type=array(1)){
		if(!$type){
			return array();
		}
		$this->db->select("*");
		$this->db->where_in("type", $type);
		$this->db->where_in("status", 0);
		$query = $this->db->get("zb_brand_tag");
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

	public function add_tag($data){
		$re = $this->db->insert('zb_brand_tag', $data);
		return $re;
	}
	public function update_tag($data, $id){
		$this->db->where('id', $id);
		$re = $this->db->update('zb_brand_tag', $data);
		return $re;
	}


	public function get_tag_info($id){
		$this->db->select("*");
		$this->db->where("id", $id);
		$query = $this->db->get("zb_brand_tag");
		return $query->row_array();
	}


	public function get_brandtag_by_shop($brand_id){
		$this->db->select("*");
		$this->db->where("brand_id", $brand_id);
		$query = $this->db->get('zb_index_brand_tag');
		$result = $query->result_array();
		if($result){
			$tmp = array();
			foreach($result as $v){
				$tmp[$v['brandtag_id']] = $v;
			}
			$result = $tmp;
		}else{
			$result = array();
		}
		return $result;
	}

	public function delte_index_tag($brand_id, $brandtag_id){
		$this->db->where('brand_id', $brand_id);
		$this->db->where('brandtag_id', $brandtag_id);
		return $this->db->delete('zb_index_brand_tag'); 
	}

	public function add_index_tag($data){
		$re = $this->db->insert('zb_index_brand_tag', $data);
		return $re;
	}

}


