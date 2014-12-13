<?php
#品牌操作类
class Do_tag extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function get_cat_info($id){
		$this->db->select("*");
		$this->db->where("id", $id);
		$query = $this->db->get("zb_tagcat");
		return $query->row_array();
	}
	public function add_cat($data){
		$re = $this->db->insert('zb_tagcat', $data);
		return $re;
	}
	public function update_cat($data, $id){
		$this->db->where('id', $id);
		$re = $this->db->update('zb_tagcat', $data);
		return $re;
	}
	public function get_cat_list(){
		$query = $this->db->get('zb_tagcat');
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

	public function get_tag_info($id){
		$this->db->select("*");
		$this->db->where("id", $id);
		$query = $this->db->get("zb_taglist");
		return $query->row_array();
	}
	public function get_tag_infos($ids){
		if(!$ids){
			return array();
		}
		$this->db->select("*");
		$this->db->where_in("id", $ids);
		$query = $this->db->get("zb_taglist");
		return $query->result_array();
	}

	public function add_tag($data){
		$re = $this->db->insert('zb_taglist', $data);
		return $re;
	}
	public function update_tag($data, $id){
		$this->db->where('id', $id);
		$re = $this->db->update('zb_taglist', $data);
		return $re;
	}
	public function get_tag_by_shop($shop_id){
		$this->db->select("*");
		$this->db->where("shop_id", $shop_id);
		$query = $this->db->get('zb_index_tag_shop');
		$result = $query->result_array();
		if($result){
			$tmp = array();
			foreach($result as $v){
				$tmp[$v['tag_id']] = $v;
			}
			$result = $tmp;
		}
		return $result;
	}
	// zb_index_tag_shop
	public function delte_shop_tag($shop_id, $tag_id){
		$this->db->where('shop_id', $shop_id);
		$this->db->where('tag_id', $tag_id);
		return $this->db->delete('zb_index_tag_shop'); 
	}

	public function add_shop_tag($data){
		$re = $this->db->insert('zb_index_tag_shop', $data);
		return $re;
	}
	public function get_tag_list_by_type($type_id, $city_id=0){
		$this->db->select("*");
		$this->db->where("type", $type_id);
		if($city_id){
			$this->db->where("city_id", $city_id);
		}
		$query = $this->db->get("zb_taglist");
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

	public function get_tag_list(){
		$this->db->select("*");
		$query = $this->db->get("zb_taglist");
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

	public function get_tag_ids_by_shops($shop_ids=array()){
		if(!$shop_ids){
			return array();
		}
		$this->db->select('*');
		$this->db->where_in('shop_id', $shop_ids);
		$query = $this->db->get("zb_index_tag_shop");
		$result = $query->result_array();
		if($result){
			$tmp = array();
			foreach($result as $v){
				$tmp[$v['tag_id']] = $v['tag_id'];
			}
			$result = $tmp;
		}
		return $result;
	}


	public function get_user_info($id){
		$this->db->select("*");
		$this->db->where("id", $id);
		$query = $this->db->get("admin_info");
		return $query->row_array();
	}


	public function get_shop_ids_by_tagids($tag_ids, $shop_ids){
		if(!$shop_ids){
			return array();
		}
		$this->db->select("shop_id");
		foreach($tag_ids as $tag_id){
			$this->db->where("tag_id", $tag_id);
		}
		$this->db->where_in("shop_id", $shop_ids);
		

		$query = $this->db->get("zb_index_tag_shop");
		$result = $query->result_array();
		return $result;

	}

	public function get_shoptagids($shop_ids=array()){
		if(!$shop_ids){
			return array();
		}
		$this->db->select('*');
		$this->db->where_in('shop_id', $shop_ids);
		$query = $this->db->get("zb_index_tag_shop");
		$result = $query->result_array();
		if($result){
			$tmp = array();
			foreach($result as $v){
				$tmp[$v['shop_id']][$v['tag_id']] = $v['tag_id'];
			}
			$result = $tmp;
		}
		return $result;
	}

}




