<?php
class Do_discount_shop extends CI_Model {

	const DISCOUNT_SHOP_STATUS_NORMAL = 0;
	const DISCOUNT_SHOP_STATUS_DELETE = 1;
	const DISCOUNT_STATUS_NORMAL = 0;
	const DISCOUNT_STATUS_DELETE = 1;
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function add($data){
		$data = array(
				'brand_id' => isset($data['brand_id'])?$data['brand_id']:0,
				'shop_id' => isset($data['shop_id'])?$data['shop_id']:0,
				'discount_id' => isset($data['discount_id'])?$data['discount_id']:'',
				'discount_type' => isset($data['discount_type'])?$data['discount_type']:0,
				'ctime' => isset($data['ctime'])?$data['ctime']:0,
				'stime' => isset($data['stime'])?$data['stime']:0,
				'etime' => isset($data['etime'])?$data['etime']:0,
				'reserve_1' => isset($data['reserve_1'])?$data['reserve_1']:'',
				'reserve_2' => isset($data['reserve_2'])?$data['reserve_2']:'',
				'reserve_3' => isset($data['reserve_3'])?$data['reserve_3']:'',
		);
		$this->db->insert('zb_discount_shop', $data);
		return $this->db->insert_id();
	}
	public function edit_time($id, $data){
		$this->db->where('discount_id', $id);
		$re = $this->db->update('zb_discount_shop', $data);
		return $re;
	}

	public function delete($discount_id){
		$data = array(
			'status' => self::DISCOUNT_STATUS_DELETE,
		);
		$this->db->where('discount_id', $discount_id);
		$re = $this->db->update('zb_discount_shop', $data);
		return $re;
	}

	public function recover($discount_id){
		$data = array(
			'status' => self::DISCOUNT_STATUS_NORMAL,
		);
		$this->db->where('discount_id', $discount_id);
		return $this->db->update('zb_discount_shop', $data);
	}

	
	
	public function get_discount_ids_by_shopid($shopid, $page=1, $pagesize=10){
		$offset = ($page - 1) * $pagesize;
		$this->db->select('discount_id');
		$this->db->where("shop_id", $shopid);
		$this->db->where("etime >", time());
		$this->db->order_by("ctime", "desc");
		$this->db->limit($pagesize, $offset);
		$query = $this->db->get('zb_discount_shop');
		$result = $query->result_array();
		if(!$result){
			return array();
		}
		$re = array();
		foreach ($result as $key => $value) {
			$re[] = $value['discount_id'];
		}
		return $re;
	}

	public function get_discount_ids_by_shopids($shop_ids, $page=1, $pagesize=10){
		if(!$shop_ids){
			return array();
		}
		$offset = ($page - 1) * $pagesize;
		$this->db->select('distinct(discount_id) as discount_id, brand_id');
		$this->db->where_in("shop_id", $shop_ids);
		$this->db->where("status", 0);
		$this->db->where("etime >", time());
		$this->db->order_by("etime", "desc");
		$this->db->order_by("id", "desc");
		$this->db->limit(2000,0);
		$query = $this->db->get('zb_discount_shop');

		$result = $query->result_array();
		if(!$result){
			return array();
		}
		return $result;
	}
	
	public function get_discount_ids_cnt_by_shopid($shop_id){
		$this->db->where('shop_id', $shop_id);
		$this->db->select('count(id) as cnt');
		$this->db->order_by("id", "desc"); 
		$query = $this->db->get('zb_discount_shop');
		return $query->row();
	}



	public function get_discount_cnt_by_shopids($shop_ids, $etime=0) {
		if(!$shop_ids){
			return array();
		}
		if(!$etime){
			$etime = time();
		}
		$this->db->select('count(distinct(discount_id)) as cnt');
		$this->db->where_in("shop_id", $shop_ids);
		$this->db->where("status", 0);
		$this->db->where("etime >", $etime);
		$query = $this->db->get('zb_discount_shop');
		return $query->row();
	}
	


	public function get_discount_shop_info_by_discountid($discount_ids){
		if(!$discount_ids){
			return array();
		}
		$this->db->select('*');
		$this->db->where_in("discount_id", $discount_ids);
		$this->db->order_by("id", "desc");
		$query = $this->db->get('zb_discount_shop');
		$result = $query->result();
		if(!$result){
			return array();
		}
		$re = array();
		$result = $this->tool->std2array($result);
		foreach ($result as $key => $value) {
			$re[$value['discount_id']] = $value;
		}
		return $re;
	}

	public function get_discount_shops_by_discountid($discount_ids){
		if(!$discount_ids){
			return array();
		}
		$this->db->select('*');
		$this->db->where_in("discount_id", $discount_ids);
		$this->db->order_by("id", "desc");
		$query = $this->db->get('zb_discount_shop');
		$result = $query->result_array();
		if(!$result){
			return array();
		}
		$re = array();
		foreach ($result as $key => $value) {
			$re[$value['shop_id']] = $value;
		}
		return $re;
	}

	public function get_have_dicount_shopids($shop_ids, $etime=0){
		if(!$shop_ids){
			return array();
		}
		$this->db->select('shop_id');
		$this->db->where_in("shop_id", $shop_ids);
		if(!$etime){
			$etime = time();
		}
		$this->db->where("etime > ", $etime);
		$query = $this->db->get('zb_discount_shop');
		return $query->result_array();
	}

}


