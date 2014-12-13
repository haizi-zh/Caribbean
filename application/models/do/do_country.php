<?php
#国家
class Do_country extends CI_Model {

    var $collection_name = 'LocalityEdit';

	function __construct(){
		parent::__construct();
		$this->load->library('cimongo');
		$this->cimongo->switch_db('geo');
	}

	#获得所有国家: _id=>名称 ok
	public function get_all_countrys(){
    
		$result = $this->cimongo->get('Country')->result();

		if($result){
			$tmp = array();
			foreach ($result as $value) {
				$id = $value->{'_id'}->{'$id'};
				$tmp[$id] =$value->zhname;
			}
			$result = $tmp;
		}

		return $result;
	}

	#根据国家获取省份列表：_id=>名称 ok
	public function get_provinces_by_countrys($countrys){

		$params = array('country.zhName'=>$countrys);
        $re = $this->cimongo->where($params)->get('LocalityEdit')->result();
		return $re;
	}

	#添加一个国家
	public function add($data){
		$data = array(
				'name' => isset($data['name'])?$data['name']:'',
				'english_name' => isset($data['english_name'])?$data['english_name']:'',
				'area_id' => isset($data['area_id'])?$data['area_id']:'',
				'reserve_1' => isset($data['reserve_1'])?$data['reserve_1']:'',
				'reserve_2' => isset($data['reserve_2'])?$data['reserve_2']:'',
				'reserve_3' => isset($data['reserve_3'])?$data['reserve_3']:'',
		);
		$this->db->insert('zb_country', $data);
	}
	
	
	public function get_country_info_by_id($id){
		$this->db->select("*");
		$this->db->where("id", $id);
		$query = $this->db->get("zb_country");
		$re = $query->row_array();
		return $re;
	}
	#批量根据id获取名称
	public function get_country_info_by_ids($ids){
		if(!$ids){
			return array();
		}
		$this->db->select("*");
		$this->db->where_in("id", $ids);
		$query = $this->db->get("zb_country");
		return $query->result_array();
	}

}
