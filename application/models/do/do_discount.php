<?php
class Do_discount extends CI_Model {

	const DISCOUNT_STATUS_NORMAL = 0;
	const DISCOUNT_STATUS_DELETE = 1;
	
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function add($data){
		$data = array(
				'level' => isset($data['level'])?$data['level']:0,
				'title' => isset($data['title'])?$data['title']:'',
				'title_mobile' => isset($data['title_mobile'])?$data['title_mobile']:'',
				'stime' => isset($data['stime'])?$data['stime']:'',
				'etime' => isset($data['etime'])?$data['etime']:'',
				'city' => isset($data['city'])?$data['city']:'',
				'country' => isset($data['country'])?$data['country']:'',
				'shop_id' => isset($data['shop_id'])?$data['shop_id']:'',
				'body' => isset($data['body'])?$data['body']:'',
				'pics' => isset($data['pics'])?$data['pics']:'',
				'has_pic' => isset($data['has_pic'])?$data['has_pic']:0,
				'uid' => isset($data['uid'])?$data['uid']:0,
				'type' => isset($data['type'])?$data['type']:1,
				'status' => isset($data['status'])?$data['status']:0,
				'ctime' => isset($data['ctime'])?$data['ctime']:time(),
				'mtime' => isset($data['mtime'])?$data['mtime']:time(),
				'ip' => isset($data['ip'])?$data['ip']:0,
				'reserve_1' => isset($data['reserve_1'])?$data['reserve_1']:'',
				'reserve_2' => isset($data['reserve_2'])?$data['reserve_2']:'',
				'reserve_3' => isset($data['reserve_3'])?$data['reserve_3']:'',
				'share_content' => isset($data['share_content'])?$data['share_content']:'',
				'brand_id' => isset($data['brand_id'])?$data['brand_id']:'',
				'shop_type' => isset($data['shop_type'])?$data['shop_type']:0,
				
		);
		$this->db->insert('zb_discount', $data);
		return $this->db->insert_id();
	}
	public function edit($data, $id){
		$this->db->where('id', $id);
		$re = $this->db->update('zb_discount', $data);
		return $re;
	}
	
	public function delete($discount_id){
		$data = array(
			'status' => self::DISCOUNT_STATUS_DELETE,
		);
		$this->db->where('id', $discount_id);
		$re = $this->db->update('zb_discount', $data);
		return $re;
	}

	public function recover($discount_id){
		$data = array(
			'status' => self::DISCOUNT_STATUS_NORMAL,
		);
		$this->db->where('id', $discount_id);
		return $this->db->update('zb_discount', $data);
	}

	public function get_info_by_ids($ids){
		if(!$ids){
			return array();
		}
		$this->db->select("*");
		$this->db->where_in("id", $ids);
		$this->db->order_by("id", "desc");
		$query = $this->db->get("zb_discount");
		return $query->result_array();
	}
	
	public function get_all_tips(){
		$this->db->select("*");
		$this->db->where("type", 2);
		$query = $this->db->get("zb_discount");
		$re = $query->result_array();
		return $re;
	}
	
	public function get_info_by_country($country_id, $type=1, $page=1,$pagesize=10,$has_pic=false,$max_id=0){
		$offset = ($page - 1) * $pagesize;
		$country_id = intval($country_id);

		$sql = "SELECT * FROM zb_discount WHERE status = 0 ";

		$sql .= " and ( country={$country_id} or country like '%,{$country_id},%' )";
		
		if($has_pic) {
			$sql .= " and has_pic = 1";
		}
		if($max_id != 0) {
			$max_id = intval($max_id);
			$sql .= " and id <{$max_id}";
		}
		$sql .= " and type = {$type}";

		$sql .= " order by level asc, ctime desc LIMIT ".$offset.",".$pagesize;
		
		$query = $this->db->query($sql);
		
		return $query->result();
	}

	
	public function get_info_by_shopid($country_id, $city_id, $shopid=0, $type=1, $page=1,$pagesize=10,$has_pic=false,$max_id=0){
		
		$offset = ($page - 1) * $pagesize;
		$country_id = intval($country_id);
		$city_id = intval($city_id);
		$shop_id = intval($shopid);
		$sql = "SELECT * FROM zb_discount WHERE status = 0 ";
		if ($shopid) {
			$sql .= " and ( country=".$country_id." or country like '%,{$country_id},%' or city=".$city_id." or city like '%,{$city_id},%' or shop_id = ".$shopid." )";
		}else{
			$sql .= " and ( country={$country_id} or country like '%,{$country_id},%' or city={$city_id} or city like '%,{$city_id},%' )";
		}

		if($has_pic) {
			$sql .= " and has_pic = 1";
		}
		if($max_id != 0) {
			$max_id = intval($max_id);
			$sql .= " and id <{$max_id}";
		}
		$sql .= " and type = {$type}";

		$sql .= " order by level asc, ctime desc LIMIT ".$offset.",".$pagesize;
		
		$query = $this->db->query($sql);
		
		return $query->result();
	}

	public function get_discount_cnt_by_shopid($country_id, $city_id, $shop_id=0, $type=1){
		$country_id = intval($country_id);
		$city_id = intval($city_id);
		$shop_id = intval($shop_id);

		$sql = "SELECT count(*) as cnt FROM zb_discount WHERE status = 0 ";
		if ($shop_id) {
			$sql .= " and ( country={$country_id} or country like '%,{$country_id},%' or city={$city_id} or city like '%,{$city_id},%' or shop_id = {$shop_id} )";
		}else{
			$sql .= " and ( country={$country_id} or country like '%,{$country_id},%' or city={$city_id} or city like '%,{$city_id},%' )";
		}
		$sql .= " and type = {$type}";
		$query = $this->db->query($sql);
	
		$result = $query->row_array();

		$cnt = $result['cnt'];
		return $cnt;
	}

	public function get_last_discount_by_uid($uid){
		$this->db->select("body");
		$this->db->where("uid", $uid);
		$this->db->order_by("id", "desc");
		$this->db->limit(1);

		$query = $this->db->get("zb_discount");
		return $query->result();

	}
	
	#foradmin
	public function get_discount_list_for_admin($page, $pagesize, $params = array()){
		$offset = ($page - 1) * $pagesize;
		$where = "";
		if($params){
			$where = " WHERE " .implode(" and ", $params);
		}
		
		$sql = "SELECT * FROM zb_discount {$where} order by id desc LIMIT ".$offset.",".$pagesize;
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	#foradmin
	public function get_discount_cnt_for_admin($params = array()){
		$where = "";
		if($params){
			$where = " WHERE " .implode(" and ", $params);
		}
		
		$sql = "SELECT count(id) as cnt FROM zb_discount {$where} ";

		$query = $this->db->query($sql);
		$result = $query->row_array();
		$cnt = $result['cnt'];
		return $cnt;
	}

	public function get_random_discount(){
		$this->db->select("count(id) as cnt, city");
		$this->db->where("type", 2);
		$this->db->where("status", 0);
		$this->db->group_by("city");
		$this->db->order_by("cnt", "desc");

		$query = $this->db->get("zb_discount");
		
		$result = $query->result_array();
		return $result;
	}
	
	// 1折扣 2攻略
	public function get_all_discount_ids_list($type=0 , $select = "id", $use_status=1){
		$this->db->select($select);
		if($type){
			$this->db->where("type", $type);
		}
		if($use_status){
			$this->db->where("status", 0);
		}
		
		$query = $this->db->get("zb_discount");
		$result = $query->result_array();
		return $result;
	}
}


