<?php
#城市
class Do_city extends CI_Model {

	 var $collection_name = 'LocalityEdit';

	function __construct(){
		parent::__construct();
		$this->load->library('cimongo');
	}

	#根据国家、省份获取城市列表|直接根据国家获取城市列表： ok
	public function get_cities_by_provinces($countrys, $provinces){

        if($countrys){
	        $params = array('country.zhName'=>$countrys, 'locList.zhName'=>$provinces);
	        $re = $this->cimongo->where($params)->get('LocalityEdit')->result();
        }else{
        	$params = array('country.zhName'=>$countrys);
	        $re = $this->cimongo->where($params)->get('LocalityEdit')->result();
        }
       
	    return $re;
	}
   
	#添加一个城市
	public function add($data){
		
		$data = array(
				'name' => isset($data['name'])?$data['name']:'',
				'english_name' => isset($data['english_name'])?$data['english_name']:'',
				'area_id' => isset($data['area_id'])?$data['area_id']:'',
				'country_id' => isset($data['country_id'])?$data['country_id']:'',
				'level' => isset($data['level'])?$data['level']:'1000',
				'reserve_1' => isset($data['reserve_1'])?$data['reserve_1']:'',
				'reserve_2' => isset($data['reserve_2'])?$data['reserve_2']:'',
				'reserve_3' => isset($data['reserve_3'])?$data['reserve_3']:'',
		);
		$this->db->insert('zb_city', $data);
	}

	#编辑城市状态
	public function update($data){
		$list = array('name', 'english_name', 'area_id', 'country_id', 'level', 'reserve_1', 'reserve_2', 'reserve_3');
		$city_data = array();
		foreach($list as $v){
			if(isset($data[$v]) && $data[$v]){
				$city_data[$v] = $data[$v];
			}
		}
		if(!$city_data){
			return false;
		}
		$this->db->where('id', $data['id']);
		$re = $this->db->update('zb_city', $city_data);
	}
	public function update_foradmin($data){
		$list = array('name', 'english_name', 'area_id', 'country_id', 'level', 'level_top', 'reserve_1', 'reserve_2', 'reserve_3');
		$city_data = array();
		foreach ($list as $key => $value) {
			if(isset($data[$value])){
				$city_data[$value] = $data[$value];
			}
		}
		$this->db->where('id', $data['id']);
		$re = $this->db->update('zb_city', $city_data);
		return $re;
	}
	public function get_cities_by_area_foradmin($area_id){
		$this->db->select('*');
		$this->db->where('area_id', $area_id);
		$this->db->order_by("level", "asc"); 
		$query = $this->db->get('zb_city');
		return $query->result_array();
	}

	public function get_cities_by_country_foradmin($country_id){
		$this->db->select('*');
		$this->db->where('country_id', $country_id);
		$this->db->order_by("level", "asc"); 
		$query = $this->db->get('zb_city');
		return $query->result_array();
	}
	#根据地域id获取城市列表
	public function get_cities_by_area($area_id, $status=0, $order_by="level"){
		$this->db->select('*');
		$this->db->where('area_id', $area_id);
		$this->db->where('reserve_1', $status);

		$this->db->order_by($order_by, "asc");
		$query = $this->db->get('zb_city');
		
		return $query->result_array();
	}
	
	#根据国家id获取城市列表
	public function get_cities_by_country($country_id, $status=0){
		$this->db->select('id');
		$this->db->select('name');
		$this->db->where('country_id', $country_id);
		$this->db->where('reserve_1', $status);
		$this->db->order_by("level", "asc");
		$query = $this->db->get('zb_city');
		return $query->result_array();
	}
	
	#批量根据id获取名称
	public function get_name_by_ids($ids){
		if(!$ids){
			return array();
		}
		$this->db->select('id, name');
		$this->db->where_in("id", $ids);
		$query = $this->db->get("zb_city");
		return $query->result_array();
	}

	#批量根据id获取名称
	public function get_city_info_by_ids($ids){
		if(!$ids){
			return array();
		}
		$this->db->select("*");
		$this->db->where_in("id", $ids);
		$query = $this->db->get("zb_city");
		return $query->result_array();
	}

	public function get_all_citys(){
		$this->db->select('*');
		$query = $this->db->get('zb_city');
		$result = $query->result_array();
		if($result){
			$tmp = array();
			foreach ($result as $key => $value) {
				$tmp[$value['id']] = $value;
			}
			$result = $tmp;
		}
		return $result;
	}
    public function get_city_by_lowername($city_lower_name){

        $this->db->where('lower_name' , $city_lower_name) ;
        return $this->db->get('zb_city')->row() ;
    }
    public function get_city_by_name($city_name){

        $this->db->where('name' , $city_name) ;
        $re = $this->db->get('zb_city')->row_array();
 		
        return  $re;
    }

}





