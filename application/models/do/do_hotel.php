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

        if( $result ){       	
        	$id = $result['0']->_id;
        	if($id){				
                // 再切换数据库酒店poi->Hotel
                $this->cimongo->switch_db('poi');
                $obj_id = new MongoId($id);
                $where = array(
                      "targets" => array(
                                          '$in'=> array( (object)$obj_id )
                                        )
                              );
                $re_result = $this->cimongo->order_by(array('rating' => 'DESC'))->get_where($this->collection_name, $where, $pagesize, $offset)->result();
                return $re_result;
		    }

        }           


    }

    #foradmin管理员获取所有酒店的数目
    public function get_hotel_cnt_for_admin($params = array()){

        // 切换数据库地理位置geo->LocalityEdit
        $this->cimongo->switch_db('geo');
        $result = $this->cimongo->where($params)->get('LocalityEdit')->result();

        if( $result ){          
            $id = $result['0']->_id;
            if($id){                
                // 再切换数据库酒店poi->Hotel
                $this->cimongo->switch_db('poi');
                $obj_id = new MongoId($id);
                $where = array(
                      "targets" => array(
                                          '$in'=> array( (object)$obj_id )
                                        )
                              );
                $re_result = $this->cimongo->where($where)->count_all_results($this->collection_name); 
                return $re_result;
            }

        }      

        return $this->cimongo->where($data)->count_all_results($this->collection_name); 
    }

    #根据id修改推荐酒店
    public function modify_recommend($ids){

        if(!$ids){
            return array();
        }

        $hotel = array(           
                'editPick' => (boolean)TRUE
        );
       
       $id = new MongoId($ids);
       return $this->cimongo->where(array('_id'=>(object)$id))->update($this->collection_name, $hotel);
    }
    
}

?>



