<?php
class Do_cdn extends CI_Model {
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	public function add($data){
		$data = array(
			'file_name' => isset($data['file_name'])?$data['file_name']:'',
			'file_name_md5' => isset($data['file_name_md5'])?$data['file_name_md5']:'',
			'content_md5' => isset($data['content_md5'])?$data['content_md5']:'',
			'ctime' => isset($data['ctime'])?$data['ctime']:time(),
			'mtime' => isset($data['mtime'])?$data['mtime']:time(),
		);
		$this->db->insert('zb_cdn_file', $data);
	}
	
	public function update($data, $id){
		$this->db->where('id', $id);
		$re = $this->db->update('zb_cdn_file', $data);
		return $re;
	}

	public function get_info_by_filenamemd5($file_name_md5){
		$this->db->select("*");
		$this->db->where("file_name_md5", $file_name_md5);
		$query = $this->db->get("zb_cdn_file");
		$list = $query->row_array();
		return $list;
	}
}