<?php
#运营内容
class Do_operation extends CI_Model{
    
    var $collection_name = 'Column';

    function __construct(){
    	parent::__construct();
    	$this->load->library('cimongo');
        $this->cimongo->switch_db('misc');
	}

    #foradmin管理员获取所有
    function get_all_Info($page, $pagesize, $params = array()){
    
        $offset = ($page - 1) * $pagesize;

        $data = array();
        $data = $params;
        if($params['id']){
             unset($data['id']); 
             $id = new MongoId($params['id']);
             $data['_id']=(object)$id;
        }
        
        return $this->cimongo->get_where($this->collection_name, $data, $pagesize, $offset)->result();
    }

    #foradmin管理员获取计数
    function get_Info_cnt($params){

        $data = array();
        $data = $params;
        if($params['id']){
             $data = $params;
             unset($data['id']); 
             $id = new MongoId($params['id']);
             $data['_id']=(object)$id;
        }

        return $this->cimongo->where($params)->count_all_results($this->collection_name); 
    }
}

?>



