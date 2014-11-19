<?php
#品牌操作类
class Do_brand extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	#添加一个品牌
	public function add($data){
		$brand_data = array(
				'name' => isset($data['name'])?$data['name']:'',
				'english_name' => isset($data['english_name'])?$data['english_name']:'',
				'desc' => isset($data['desc'])?$data['desc']:'',
				'pic' => isset($data['pic'])?$data['pic']:'',
				'first_char' => isset($data['first_char'])?$data['first_char']:'',
				'property' => isset($data['property'])?$data['property']:0,
				'big_pic' => isset($data['big_pic'])?$data['big_pic']:'',
				'rank_score' => isset($data['rank_score'])?$data['rank_score']:0,
				'reserve_1' => isset($data['reserve_1'])?$data['reserve_1']:'',
				'reserve_2' => isset($data['reserve_2'])?$data['reserve_2']:'',
				'reserve_3' => isset($data['reserve_3'])?$data['reserve_3']:'',
				'ebusiness_id' => isset($data['ebusiness_id'])?$data['ebusiness_id']:0,
				'eb_name' => isset($data['eb_name'])?$data['eb_name']:'',
				'eb_url' => isset($data['eb_url'])?$data['eb_url']:'',
		);
		$this->db->insert('zb_brand', $brand_data);
	}
	
	public function update_info($data){
		$id = $data['id'];
		unset($data['id']);
		$this->db->where('id', $id);
		$re = false;
		if($data){
			$re = $this->db->update('zb_brand', $data);
		}
		return $re;
	}
	
	#更新一个品牌
	public function update($data){
		$brand_data = array(
				'id' => $data['id'],
				'name' => isset($data['name'])?$data['name']:'',
				'english_name' => isset($data['english_name'])?$data['english_name']:'',
				'desc' => isset($data['desc'])?$data['desc']:'',
				'pic' => isset($data['pic'])?$data['pic']:'',
				'first_char' => isset($data['first_char'])?$data['first_char']:'',
				'property' => isset($data['property'])?$data['property']:0,
				'big_pic' => isset($data['big_pic'])?$data['big_pic']:'',
				'rank_score' => isset($data['rank_score'])?$data['rank_score']:0,
				'reserve_1' => isset($data['reserve_1'])?$data['reserve_1']:'',
				'reserve_2' => isset($data['reserve_2'])?$data['reserve_2']:'',
				'reserve_3' => isset($data['reserve_3'])?$data['reserve_3']:'',
				'ebusiness_id' => isset($data['ebusiness_id'])?$data['ebusiness_id']:0,
				'eb_name' => isset($data['eb_name'])?$data['eb_name']:'',
				'eb_url' => isset($data['eb_url'])?$data['eb_url']:'',
		);
		$this->db->where('id', $data['id']);
		return $this->db->update('zb_brand', $brand_data);
	}

	# 删除品牌
	public function delete($data){
		$this->db->where('id', $data['brand_id']);
		return $this->db->delete('zb_brand'); 
	}
	
	#根据首字母获取品牌列表
	public function get_brands_by_first_char($first_char, $size){
		$this->db->where('first_char', $first_char);
		$this->db->where('status', 0);
		$this->db->limit($size);
		$query = $this->db->get('zb_brand');
		return $query->result_array();
	}
	
	#根据id取品牌信息
	public function get_brands_by_ids($ids){
		if(!$ids){
			return array();
		}
		$this->db->select("*");
		$this->db->where_in("id", $ids);
		$this->db->where('status', 0);
		$query = $this->db->get("zb_brand");
		$re = $query->result_array();

		if($re){
			$tmp = array();
			foreach($re as $each){
				$tmp[$each['id']] = $each;
			}
			$re = $tmp;
		}
		
		return $re;
	}
	
	#获取全部品牌
	public function get_all_brand(){
		$this->db->select("*");
		$this->db->where('status', 0);
		$this->db->order_by("english_name", 'ASC');
		$query = $this->db->get("zb_brand");
		return $query->result_array();
	}
	
	#根据品牌名称，获得品牌id
	public function get_id_by_name($brand_names){
		if(!$brand_names){
			return array();
		}
		$this->db->select('id');
		$this->db->select('name');
		$this->db->select('property');
		$this->db->where_in('name', $brand_names);
		$this->db->where('status', 0);

		$query = $this->db->get('zb_brand');

		$brand_names_str = implode('","',$brand_names);
		return $query->result_array();
	}

	public function get_id_by_name_foradmin($name){
		if(!$name){
			return array();
		}
		$this->db->select('id');
		$this->db->select('name');
		$this->db->select('property');
		$this->db->where_in('name', $name);
		$this->db->where('status', 0);

		$query = $this->db->get('zb_brand');
		return $query->result_array();
	}

	public function get_id_by_englishname_foradmin($name){
		if(!$name){
			return array();
		}
		//$name =  iconv('GBK', 'UTF-8', $name);
		$this->db->select('id');
		$this->db->select('english_name');
		$this->db->select('property');
		$this->db->where_in('english_name', $name);
		$this->db->where('status', 0);

		$query = $this->db->get('zb_brand');
		return $query->result_array();
	}

	public function get_id_by_reserve1_foradmin($name){
		if(!$name){
			return array();
		}
		$this->db->select('id');
		$this->db->select('reserve_1');
		$this->db->select('property');
		$this->db->where('status', 0);
		
		$this->db->where_in('reserve_1', $name);
		$query = $this->db->get('zb_brand');
		return $query->result_array();
	}
	#临时用的搜索功能，limeng的suggest上线后，这个功能废弃掉
	public function demo_suggest($name){
		$this->db->select('*');
		$this->db->like('name', $name); 
		$query = $this->db->get('zb_brand');
		$re = $query->result();
		return $this->tool->std2array($re);
	}

	public function get_brand_where_reserve_1(){
		$sql = "SELECT * FROM zb_brand WHERE reserve_1 ='' ";
		$query = $this->db->query($sql);
		$re = $query->result();
		return $this->tool->std2array($re);
	}
	
	#更新一个品牌
	public function update_reserve_1($data){
		$brand_data = array(
				'id' => $data['id'],
				'reserve_1' => isset($data['reserve_1'])?$data['reserve_1']:'',
		);
		$this->db->where('id', $data['id']);
		return $this->db->update('zb_brand', $brand_data);
	}

}





