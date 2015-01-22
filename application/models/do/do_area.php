<?php
#地域
class Do_area extends CI_Model {

	var $collection_name = 'Locality';

	function __construct(){
		parent::__construct();
		$this->load->library('cimongo');
		$this->cimongo->switch_db('geo');
	}

	#添加一个地域
	public function add($data){
		$data = array(
				'name' => isset($data['name'])?$data['name']:'',
				'english_name' => isset($data['english_name'])?$data['english_name']:'',
				'reserve_1' => isset($data['reserve_1'])?$data['reserve_1']:'',
				'reserve_2' => isset($data['reserve_2'])?$data['reserve_2']:'',
				'reserve_3' => isset($data['reserve_3'])?$data['reserve_3']:'',
		);
		$this->db->insert('zb_area', $data);
	}
	
	#获取所有地域信息
	public function get_all_areas(){

		$return = $this->cimongo->get_where($this->collection_name, '', 5)->result();
		// if($result){
		// 	$tmp = array();
		// 	foreach ($result as $key => $value) {
		// 		$tmp[$value['id']] = $value;
		// 	}
		// 	$result = $tmp;
		// }
		return $result;
	}

	
}
