<?php
#运营内容
class Do_operation extends CI_Model{
    
    var $collection_name = 'Column';

    function __construct(){
    	parent::__construct();
    	$this->load->library('cimongo');
        $this->cimongo->switch_db('misc');
        $this->load->database();
	}

    #sql加入log操作日志
    public function insert_log($refrence_id, $business, $data){

        $sql = " INSERT INTO `operation_log` (`id`, `refrence_id`, `business`, `create_time`, `data`) VALUES (NULL, '{$refrence_id}', '{$business}', CURRENT_TIMESTAMP, '{$data}') ";
        $query = $this->db->query($sql);
        return $query;
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

    #添加运营内容
    function add($data){

        $operation = array(
            
                'title' => isset($data['title'])?$data['title']:'',
                'cover' => isset($data['cover'])?$data['cover']:'',
                'link' => isset($data['link'])?$data['link']:'',
                'content' => isset($data['content'])?$data['content']:'',
        );

        $this->cimongo->insert($this->collection_name, $operation);

        $json_data = json_encode($operation, JSON_UNESCAPED_UNICODE);
        mysql_query("SET NAMES 'UTF8'");
        return  $this->insert_log('', 'add_operation', $json_data);
    }

    #根据_id获取运营信息
    public function get_operationinfo_by_ids($ids){

        $data = array();
        if(!$ids){
            return array();
        }

        $id = new MongoId($ids);
        $re = $this->cimongo->where(array('_id'=>(object)$id))->get($this->collection_name)->result();

        $data['operation_id'] = (string)($re['0']->_id);
        $data['title'] = $re['0']->title;
        $data['cover'] = $re['0']->cover;
        $data['link'] = $re['0']->link;
        $data['content'] = $re['0']->content;

        return  $data;
    }


    #更新运营内容
    public function operation_update($data){

        $operation = array(
            
                'title' => isset($data['title'])?$data['title']:'',
                'cover' => isset($data['cover'])?$data['cover']:'',
                'link' => isset($data['link'])?$data['link']:'',
                'content' => isset($data['content'])?$data['content']:'',
        );

       $id = new MongoId($data['operation_id']);

       $this->cimongo->where(array('_id'=>(object)$id))->update($this->collection_name, $operation);
       $json_data = json_encode($operation, JSON_UNESCAPED_UNICODE);
       mysql_query("SET NAMES 'UTF8'");
       return  $this->insert_log($data['operation_id'], 'update_operation', $json_data);
    }
    
}

?>



