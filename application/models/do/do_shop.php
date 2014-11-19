<?php
#商家操作类
class Do_shop extends CI_Model {
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	#添加一个商家
	public function add($data){
		$shopdata = array(
				'name' => isset($data['name'])?$data['name']:'',
				'english_name' => isset($data['english_name'])?$data['english_name']:'',
				'desc' => isset($data['desc'])?$data['desc']:'',
				'pic' => isset($data['pic'])?$data['pic']:'',
				'address' => isset($data['address'])?$data['address']:'',
				'phone' => isset($data['phone'])?$data['phone']:'',
				'country' => isset($data['country'])?$data['country']:0,
				'city' => isset($data['city'])?$data['city']:0,
				'area' => isset($data['area'])?$data['area']:0,
				'status' => isset($data['status'])?$data['status']:0,
				'ctime' => time(),
				'branches' => isset($data['branches'])?$data['branches']:'',
				'parent' => isset($data['parent'])?$data['parent']:0,
				'property' => isset($data['property'])?$data['property']:0,
				'business_hour' => isset($data['business_hour'])?$data['business_hour']:'',
				'score' => isset($data['score'])?$data['score']:0,
				'total_score' => isset($data['total_score'])?$data['total_score']:0,
				'location' => isset($data['location'])?$data['location']:'',
				'rank_score' => isset($data['rank_score'])?$data['rank_score']:0,
				'reserve_1' => isset($data['reserve_1'])?$data['reserve_1']:'',
				'reserve_2' => isset($data['reserve_2'])?$data['reserve_2']:'',
				'reserve_3' => isset($data['reserve_3'])?$data['reserve_3']:'',
				'reserve_4' => isset($data['reserve_4'])?$data['reserve_4']:'',
				'reserve_5' => isset($data['reserve_5'])?$data['reserve_5']:'',
				'seo_keywords' => isset($data['seo_keywords'])?$data['seo_keywords']:'',
				'discount_type' => isset($data['discount_type'])?$data['discount_type']:0,
				
		);
		$this->db->insert('zb_shop', $shopdata);
	}
	
	public function update_info($data){
		$id = $data['id'];
		unset($data['id']);
		$this->db->where('id', $id);
		$re = false;
		if($data){
			$re = $this->db->update('zb_shop', $data);
		}
		return $re;
	}

	#添加一个商家
	public function update($data){
		$shopdata = array(
				'name' => isset($data['name'])?$data['name']:'',
				'english_name' => isset($data['english_name'])?$data['english_name']:'',
				'desc' => isset($data['desc'])?$data['desc']:'',
				'pic' => isset($data['pic'])?$data['pic']:'',
				'address' => isset($data['address'])?$data['address']:'',
				'phone' => isset($data['phone'])?$data['phone']:'',
				'country' => isset($data['country'])?$data['country']:0,
				'city' => isset($data['city'])?$data['city']:0,
				'area' => isset($data['area'])?$data['area']:0,
				'status' => isset($data['status'])?$data['status']:0,
				'ctime' => time(),
				'branches' => isset($data['branches'])?$data['branches']:'',
				'parent' => isset($data['parent'])?$data['parent']:0,
				'property' => isset($data['property'])?$data['property']:0,
				'business_hour' => isset($data['business_hour'])?$data['business_hour']:'',
				'score' => isset($data['score'])?$data['score']:0,
				'total_score' => isset($data['total_score'])?$data['total_score']:0,
				'location' => isset($data['location'])?$data['location']:'',
				'rank_score' => isset($data['rank_score'])?$data['rank_score']:0,
				'reserve_1' => isset($data['reserve_1'])?$data['reserve_1']:'',
				'reserve_2' => isset($data['reserve_2'])?$data['reserve_2']:'',
				'reserve_3' => isset($data['reserve_3'])?$data['reserve_3']:'',
				'reserve_4' => isset($data['reserve_4'])?$data['reserve_4']:'',
				'reserve_5' => isset($data['reserve_5'])?$data['reserve_5']:'',
				'seo_keywords' => isset($data['seo_keywords'])?$data['seo_keywords']:'',
				'discount_type' => isset($data['discount_type'])?$data['discount_type']:0,
		);
		$this->db->where('id', $data['id']);
		$re = $this->db->update('zb_shop', $shopdata);
		return $re;
	}
	
	#根据id获取商家信息
	public function get_shopinfo_by_ids($ids){
		if(!$ids){
			return array();
		}
		$this->db->select("*");
		$this->db->where_in("id", $ids);
		$this->db->where("status", 0);
		$query = $this->db->get("zb_shop");
		return $query->result_array();
	}

	public function get_shopinfo_by_ids_nostatus($ids){
		if(!$ids){
			return array();
		}
		$this->db->select("*");
		$this->db->where_in("id", $ids);
		$query = $this->db->get("zb_shop");
		return $query->result_array();
	}
	
	#根据id获取商家属性信息
	public function get_property_by_ids($ids){
		$this->db->select("id,property");
		$this->db->where_in("id", $ids);
		$query = $this->db->get("zb_shop");
		return $query->result();
	}
	
	#根据城市和商家属性，获取商家列表
	public function get_shops_by_city_property($city,$property,$page=1,$pagesize =10){
		$offset = ($page - 1) * $pagesize;
		
		$this->db->select("id,property");
		$this->db->where("city", $city);
		$this->db->where("status", 0);
		if($property) {
			$this->db->where("property", $property);
		}
		
		$this->db->order_by("rank_score", "desc");
		$this->db->limit($pagesize,$offset);
		$query = $this->db->get("zb_shop");
		
		return $query->result_array();
	}


	public function get_shops_by_country($country){

		$this->db->select("id");
		$this->db->where("country", $country);
		$this->db->where("status", 0);
		
		$this->db->order_by("rank_score", "desc");
		$query = $this->db->get("zb_shop");
		
		return $query->result_array();
	}


	#根据城市，属性获取商家总数(分页用)
	public function get_shopcnt_by_property_city($city,$property){
		$this->db->select("count(*)");
		$this->db->where("city", $city);
		$this->db->where("status", 0);

		if($property) {
			$this->db->where("property", $property);
		}
		$query = $this->db->get("zb_shop");

		return $query->result();
	}

	public function get_shops_list_by_shopids($shop_ids, $page=1, $pagesize = 10){
		if(!$shop_ids){
			return array();
		}
		$offset = ($page - 1) * $pagesize;
		
		$this->db->select("id,property");
		$this->db->where_in("id", $shop_ids);
		$this->db->where("status", 0);
		$this->db->order_by("rank_score", "desc");
		$this->db->limit($pagesize,$offset);
		$query = $this->db->get("zb_shop");
		return $query->result();
	}
	
	#获取所有商家
	public function get_all_shop($show_all = false){
		if($show_all){
			$this->db->select('*');
		}else{
			$this->db->select('id');
			$this->db->select('name');
		}
		$query = $this->db->get('zb_shop');
		return $query->result_array();
	}
	

	
	#更新商家分数
	public function update_score($data){
		$this->db->where('id', $data['id']);
		unset($data['id']);
		$re = $this->db->update('zb_shop', $data);
		return $re;
	}

	
	#foradmin
	public function get_shop_list_for_admin($page, $pagesize, $params = array()){
		$offset = ($page - 1) * $pagesize;
		$where = "";
		if($params){
			$where = " WHERE " .implode(" and ", $params);
		}
		
		$sql = "SELECT * FROM zb_shop {$where} order by id desc LIMIT ".$offset.",".$pagesize;
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	#foradmin
	public function get_shop_cnt_for_admin($params = array()){
		$where = "";
		if($params){
			$where = " WHERE " .implode(" and ", $params);
		}
		
		$sql = "SELECT count(id) as cnt FROM zb_shop {$where} ";

		$query = $this->db->query($sql);
		$result = $query->row_array();
		$cnt = $result['cnt'];
		return $cnt;
	}

	# for map
	public function get_shop_info_by_limit($limit=6000){
		$sql = "select id,name,english_name,location,property,left(`desc`, 100) as `desc`,address from zb_shop limit ".$limit;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function search_shop($name, $page=1, $pagesize=10){
		$offset = ($page - 1) * $pagesize;
		$sql = "select * from zb_shop where name like '%{$this->db->escape_like_str($name)}%' or english_name like '%{$this->db->escape_like_str($name)}%'  limit {$offset}, {$pagesize}";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function search_shop_cnt($name){
		$sql = "select count(*) as cnt from zb_shop where name like '%{$this->db->escape_like_str($name)}%'  or english_name like '%{$this->db->escape_like_str($name)}%' ";
		$query = $this->db->query($sql);
		$re = $query->row_array();
		$cnt = $re['cnt'];
		return $cnt;
	}



}



