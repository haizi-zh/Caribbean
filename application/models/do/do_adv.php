<?php
class Do_adv extends CI_Model {
	const STATUS_NORMAL = 0;
	const STATUS_DELETE = 1;
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function add($data){
		$data = array(
			'name' => isset($data['name'])?$data['name']:'',
			'pic' => isset($data['pic'])?$data['pic']:'',
			'url' => isset($data['url'])?$data['url']:'',
			'type' => isset($data['type'])?$data['type']:0,
			'city' => isset($data['city'])?$data['city']:'',
			'country' => isset($data['country'])?$data['country']:'',
			'shop_id' => isset($data['shop_id'])?$data['shop_id']:'',
			'level' => isset($data['level'])?$data['level']:0,
			'ctime' => isset($data['ctime'])?$data['ctime']:time(),
			'mtime' => isset($data['mtime'])?$data['mtime']:time(),
			'status' => isset($data['status'])?$data['status']:time(),
			'n_shop_id' => isset($data['n_shop_id'])?$data['n_shop_id']:'',
			'n_city' => isset($data['n_city'])?$data['n_city']:'',
			'n_coupon_id' => isset($data['n_coupon_id'])?$data['n_coupon_id']:'',
		);
		return $this->db->insert('zb_adv', $data);
	}
	
	public function update($data, $id){
		$this->db->where('id', $id);
		$re = $this->db->update('zb_adv', $data);
		return $re;
	}

	public function get_info($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$this->db->where('status', 0);
		$query = $this->db->get("zb_adv");
		$result = $query->row_array();
		return $result;
	}

	public function get_list($status=0, $page=1,$pagesize=10){
		$offset = ($page - 1) * $pagesize;
		$this->db->select('*');
		$this->db->where('status', $status);
		$this->db->order_by("id", "desc");
		$this->db->limit($pagesize, $offset);
		$query = $this->db->get("zb_adv");
		$result = $query->result_array();
		return $result;
	}
	public function get_list_count($status=0){
		$this->db->select('count(*) as cnt');
		$this->db->where('status', $status);
		$query = $this->db->get('zb_adv');
		$re = $query->row_array();
		if($re){
			return $re['cnt'];
		}
		return 0;
	}
	public function get_adv_by_country_city_shop($country=0, $city=0, $shop_id=0, $type=1){
		$where = "";
		$and = $or = array();
		if($country){
			$or[] = "  country like  '%,{$country},%'";
		}
		if($city){
			$or[] = "  city like  '%,{$city},%'";
			$and[] = " n_city not like  '%,{$city},%' ";
		}
		if($shop_id){
			$or[] = "  shop_id like  '%,{$shop_id},%'";
			$and[] = " n_shop_id not like  '%,{$shop_id},%' ";
		}
		$or_list = $and_list = "";
		if($or){
			$or_list = implode(" or ", $or);
			$or_list = " and ( {$or_list} )";
		}
		if($and){
			$and_list = implode(" and ", $and);
			$and_list = " and ( {$and_list} )";
		}
		$sql = "select * from zb_adv where status=0 and type={$type} {$or_list} {$and_list} order by level asc, id desc";

		$query = $this->db->query($sql);
		$result = $query->result_array();

		return $result;
	}


}