<?php
#kv接口存储运营需求
class Do_kv extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	#添加一个业务
	public function add($data){
		$data = array(
				'key' => isset($data['key'])?$data['key']:'',
				'value' => isset($data['value'])?$data['value']:'',
				'desc' => isset($data['desc'])?$data['desc']:'',
		);
		$this->db->insert('zb_kv', $data);
	}
	
	#更新一个业务数据
	public function update($key,$value){
		$data = array(
				'value' => $value,
		);
		$this->db->where('key', $key);
		$this->db->update('zb_kv', $data);
	}
	
	#查询业务
	public function get_value($key){
		$this->db->select('value');
		$this->db->where('key', $key);
		$query = $this->db->get('zb_kv');
		return $query->result();
	}
}