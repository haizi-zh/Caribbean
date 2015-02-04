<?php
#酒店
class Do_hotel extends CI_Model{
    
    var $collection_name = 'Hotel';

    function __construct(){
    	parent::__construct();
    	  $this->load->library('cimongo');
        $this->cimongo->switch_db('poi');
        $this->load->database();
	  }

    #sql加入log操作日志
    public function insert_log($refrence_id, $business, $data){

        $sql = " INSERT INTO `operation_log` (`id`, `refrence_id`, `business`, `create_time`, `data`) VALUES (NULL, '{$refrence_id}', '{$business}', CURRENT_TIMESTAMP, '{$data}') ";
        $query = $this->db->query($sql);
        return $query;
    }

    #由SQL数据库mid查询monggo数据库内容
    public function get_hotel_by_midSQL($midSQL){

        $id = new MongoId($midSQL);
        $where = array(
                      "targets" => array(
                                          '$in'=> array( (object)$id )
                                        )
                      );

        $re = $this->cimongo->order_by(array('rating' => 'DESC'))->where( $where )->get( $this->collection_name )->result();
        return $re;
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

        // 切换数据库地理位置geo->Locality
        $this->cimongo->switch_db('geo');
        $result = $this->cimongo->where($params)->get('Locality')->result();

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

        // 切换数据库地理位置geo->Locality
        $this->cimongo->switch_db('geo');
        $result = $this->cimongo->where($params)->get('Locality')->result();

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

    #根据_id获取酒店信息
    public function get_hotel_by_ids($ids){

        $data = array();
        if(!$ids){
            return array();
        }

        $id = new MongoId($ids);
        $re = $this->cimongo->where(array('_id'=>(object)$id))->get($this->collection_name)->result();
        
        $data['zhname'] = $re['0']->zhname;
        $data['hotel_id'] = (string)($re['0']->_id);
        return  $data;
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
       $this->cimongo->where(array('_id'=>(object)$id))->update($this->collection_name, $hotel);

       $hotel_info = $this->get_hotel_by_ids($id);
       $json_data = json_encode($hotel_info, JSON_UNESCAPED_UNICODE);
       mysql_query("SET NAMES 'UTF8'");
       return  $this->insert_log($ids, 'recommend_hotel', $json_data);
    }
    
}

?>



