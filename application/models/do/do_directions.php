<?php

class Do_directions extends CI_Model {
	const DISCOUNT_STATUS_NORMAL = 0;
	const DISCOUNT_STATUS_DELETE = 1;
	
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	#添加一个地域
	public function add($data){
		$data = array(
				'shop_id' => isset($data['shop_id'])?$data['shop_id']:0,
				'body' => isset($data['body'])?$data['body']:'',
				'description' => isset($data['description'])?$data['description']:'',
				'description_url' => isset($data['description_url'])?$data['description_url']:'',
				'description_simple' => isset($data['description_simple'])?$data['description_simple']:'',
				'description_url_simple' => isset($data['description_url_simple'])?$data['description_url_simple']:'',
				'type' => isset($data['type'])?$data['type']:0,
				'level' => isset($data['level'])?$data['level']:0,
				'ctime' => isset($data['ctime'])?$data['ctime']:time(),
				'mtime' => isset($data['mtime'])?$data['mtime']:time(),
				'status' => isset($data['status'])?$data['status']:0,
		);
		$this->db->insert('zb_directions', $data);
		return $this->db->insert_id();
	}
	public function update($data, $id){
		$this->db->where('id', $id);
		$re = $this->db->update('zb_directions', $data);
		return $re;
	}


	public function delete($discount_id){
		$data = array(
			'status' => self::DISCOUNT_STATUS_DELETE,
		);
		$this->db->where('id', $discount_id);
		$re = $this->db->update('zb_directions', $data);
		return $re;
	}

	public function recover($discount_id){
		$data = array(
			'status' => self::DISCOUNT_STATUS_NORMAL,
		);
		$this->db->where('id', $discount_id);
		return $this->db->update('zb_directions', $data);
	}
	public function get_all_shop_ids(){
		$this->db->select("shop_id");
		$this->db->where("status", 0);
		$query = $this->db->get("zb_directions");
		$re = $query->result_array();
		if($re){
			$shop_ids = array();
			foreach($re as $v){
				$shop_ids[$v['shop_id']] = $v['shop_id'];
			}
			$re = $shop_ids;
		}
		return $re;
	}
	public function get_info_by_shopid($shop_id){
		if(!$shop_id){
			return array();
		}
		$this->db->select("*");
		$this->db->where('shop_id', $shop_id);
		$this->db->where("status", 0);
		$query = $this->db->get("zb_directions");
		$re = $query->row_array();
		return $re;
	}


	public function get_info($id){
		$infos = $this->get_info_by_ids(array($id));
		if(isset($infos[$id])){
			return $infos[$id];
		}
		return array();
	}
	public function get_exist_type($shop_id, $type){
		$this->db->select("*");
		$this->db->where("shop_id", $shop_id);
		$this->db->where("type", $type);
		$this->db->where("status", 0);
		$query = $this->db->get("zb_directions");

		$re = $query->row_array();
		return $re;

	}

	public function get_info_by_ids($ids){
		if(!$ids){
			return array();
		}
		$this->db->select("*");
		$this->db->where_in("id", $ids);
		$this->db->order_by("id", "desc");
		$query = $this->db->get("zb_directions");
		$list = $query->result_array();
		$tmp = array();
		if($list){
			foreach($list as $v){
				$tmp[$v['id']] = $v;
			}
			$list = $tmp;
		}
		return $list;
	}

	#添加一个地域
	public function add_line($data){
		$data = array(
				'directions_id' => isset($data['directions_id'])?$data['directions_id']:0,
				'item_type' => isset($data['item_type'])?$data['item_type']:0,
				'description' => isset($data['description'])?$data['description']:'',
				'description_url' => isset($data['description_url'])?$data['description_url']:'',
				'level' => isset($data['level'])?$data['level']:0,
				'ctime' => isset($data['ctime'])?$data['ctime']:time(),
				'mtime' => isset($data['mtime'])?$data['mtime']:time(),
				'status' => isset($data['status'])?$data['status']:0,
		);
		$this->db->insert('zb_directions_line', $data);
		return $this->db->insert_id();
	}

	public function update_line($data, $id){
		$this->db->where('id', $id);
		$re = $this->db->update('zb_directions_line', $data);
		return $re;
	}
	public function delete_line($id){
		$data = array(
			'status' => self::DISCOUNT_STATUS_DELETE,
		);
		$this->db->where('id', $id);
		$re = $this->db->update('zb_directions_line', $data);
		return $re;
	}

	public function recover_line($id){
		$data = array(
			'status' => self::DISCOUNT_STATUS_NORMAL,
		);
		$this->db->where('id', $id);
		return $this->db->update('zb_directions_line', $data);
	}
	public function get_directions_list($shop_id, $status = 0){
		$this->db->select('*');
		$this->db->where("shop_id", $shop_id);
		$this->db->where("status", $status);
		
		$this->db->order_by("level", "asc");
		$query = $this->db->get('zb_directions');
		$result = $query->result_array();
		$result = $this->tool->format_array_by_key($result, "id");
		return $result;
	}

	public function get_directions_line_list($directions_ids, $status=0){
		if(!$directions_ids){
			return array();
		}
		$this->db->select('*');
		$this->db->where_in("directions_id", $directions_ids);
		if($status == 0){
			$this->db->where("status", 0);
		}
		$this->db->order_by("level", "asc");
		$query = $this->db->get('zb_directions_line');
		$result = $query->result_array();
		$result = $this->tool->format_array_by_key($result, "id");
		return $result;
	}
	
	public function get_line_info($id){
		$infos = $this->get_line_info_by_ids(array($id));
		if(isset($infos[$id])){
			return $infos[$id];
		}
		return array();
	}
	public function get_line_info_by_ids($ids){
		if(!$ids){
			return array();
		}
		$this->db->select("*");
		$this->db->where_in("id", $ids);
		$this->db->order_by("id", "desc");
		$query = $this->db->get("zb_directions_line");
		$list = $query->result_array();
		$tmp = array();
		if($list){
			foreach($list as $v){
				$tmp[$v['id']] = $v;
			}
			$list = $tmp;
		}
		return $list;
	}

}



