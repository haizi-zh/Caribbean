<?php
#品牌商家关联操作
class Do_index_brand_shop extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	#添加一个品牌
	public function add($data){
		$data = array(
				'shop_id' => isset($data['shop_id'])?$data['shop_id']:0,
				'brand_id' => isset($data['brand_id'])?$data['brand_id']:0,
				'city'=> isset($data['city'])?$data['city']:0,
				'shop_property' => isset($data['status'])?$data['shop_property']:0,
		);
		return $this->db->insert('zb_index_brand_shop', $data);
	}

	#为商家删除品牌
	public function delete($data){
		$data = array(
				'shop_id' => isset($data['shop_id'])?$data['shop_id']:0,
				'brand_id' => isset($data['brand_id'])?$data['brand_id']:0,
		);
		return $this->db->delete('zb_index_brand_shop', $data);
	}

	# 删除品牌
	public function delete_brand($data){
		$data = array(
				'brand_id' => isset($data['brand_id'])?$data['brand_id']:0,
		);
		$re = $this->db->delete('zb_index_brand_shop', $data);
		return $re;
	}
	
	#根据品牌/属性获取商家id列表
	public function get_shops_by_brand_property_city($brand_id,$property=0,$city=0,$page=1,$pagesize=10){
		$offset = ($page - 1) * $pagesize;

		$this->db->select('shop_id');
		if($property){
			$this->db->where('shop_property', $property);
		}
		if($brand_id){
			$this->db->where('brand_id', $brand_id);
		}
		if($city){
			$this->db->where('city', $city);
		}
		$this->db->order_by("id", "desc");
		$this->db->limit($pagesize, $offset);
		$query = $this->db->get('zb_index_brand_shop');
		return $query->result();
	}
	#根据商家id获取品牌列表
	public function get_brand_exist($shop_id, $brand_id){
		$this->load->database();
		$this->db->select('brand_id');
		$this->db->where('shop_id',$shop_id);
		$this->db->where('brand_id', $brand_id);
		$query = $this->db->get('zb_index_brand_shop');
		return $query->result();
	}
	#根据商家id获取品牌列表
	public function get_brands_by_shops($shop_ids){
		if(!$shop_ids){
			return array();
		}
		$shop_ids_list = implode(",", $shop_ids);

		$this->db->select("brand_id, shop_id");
		$this->db->where_in("shop_id", $shop_ids);
		$query = $this->db->get("zb_index_brand_shop");
		return $query->result_array();
	}

	#根据商家id获取品牌列表
	public function get_brands_by_shop($shop_id){
		$this->db->select('brand_id');
		$this->db->where('shop_id',$shop_id);
		$query = $this->db->get('zb_index_brand_shop');
		return $query->result();
	}
	#根据商家id获取品牌列表
	public function get_shops_by_brand($brand_id){
		$this->db->select('shop_id');
		$this->db->where('brand_id',$brand_id);
		$query = $this->db->get('zb_index_brand_shop');
		return $query->result();
	}
	#根据品牌/城市/属性 获取城市总数 分页用
	public function get_shopcnt_by_brand_property_city($brand_id,$property,$city){
		$this->db->select('count(*)');
		if($property){
			$this->db->where('shop_property', $property);
		}
		if($brand_id){
			$this->db->where('brand_id', $brand_id);
		}
		if($city){
			$this->db->where('city', $city);
		}
		$query = $this->db->get('zb_index_brand_shop');
		return $query->result();
	}

	public function get_brands_by_shopids($shop_ids){
		if(!$shop_ids){
			return array();
		}
		$this->db->select('distinct(brand_id) as brand_id');
		$this->db->where_in('shop_id', $shop_ids);
		$query = $this->db->get('zb_index_brand_shop');
		$re = $query->result_array();
		if($re){
			$tmp = array();
			foreach($re as $v){
				$tmp[$v['brand_id']] = $v['brand_id'];
			}
			$re = $tmp;
		}
		return $re;
	}
}





