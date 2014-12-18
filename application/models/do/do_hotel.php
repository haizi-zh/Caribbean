<?php
#酒店
class Do_hotel extends CI_Model{
    
    var $collection_name = 'Hotel';

    function __construct(){
    	parent::__construct();
    	$this->load->library('cimongo');
        $this->cimongo->switch_db('poi');
	}

    #根据名称，获取酒店列表
    public function get_hotel_by_name($page, $pagesize, $params = array()){
    
        $offset = ($page - 1) * $pagesize;

        $data = array();
        $data = $params;
        if($params['id']){      
             unset($data['id']); 
             $id = new MongoId($params['id']);
             $data['_id']=(object)$id;
        }

        // 切换数据库地理位置geo->LocalityEdit
        $this->cimongo->switch_db('geo');
        $result = $this->cimongo->where($params)->get('LocalityEdit')->result();

        $re_data = array();
        $re_params = array();
        if( $result ){
        	
        	$id = $result['0']->_id;
        	if($id){				
                // 再切换数据库酒店poi->Hotel
                $this->cimongo->switch_db('poi');
                $re_params = array('targets.(2)'=>$id);
                return $this->cimongo->where($re_params)->get('Hotel')->result();
		    }

        }           


    }

    // #foradmin管理员获取所有酒店的数目
    // public function get_hotel_cnt_for_admin($params = array()){

    //     $data = array();
    //     $data = $params;
    //     if($params['id']){ 
    //          $data = $params;
    //          unset($data['id']); 
    //          $id = new MongoId($params['id']);
    //          $data['_id']=(object)$id;
    //     }

    //     return $this->cimongo->where($data)->count_all_results($this->collection_name); 
    // }
    
}

?>



