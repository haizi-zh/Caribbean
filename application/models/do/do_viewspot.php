<?php
#景点data model
class Do_viewspot extends CI_Model{
    
    var $collection_name = 'ViewSpot';

	function __construct(){
    	parent::__construct();
    	$this->load->library('cimongo');
        $this->cimongo->switch_db('poi');
        $this->load->database();
	}
    
    # 数组转码urlencode
    public function arrayRecursive(&$array, $function, $apply_to_keys_also = false)  
    {  
        static $recursive_counter = 0;  
        if (++$recursive_counter > 1000) {  
            die('possible deep recursion attack');  
        }  
        foreach ($array as $key => $value) {  
            if (is_array($value)) {  
                arrayRecursive($array[$key], $function, $apply_to_keys_also);  
            }else {  
                $array[$key] = $function($value);  
            }  
            if ($apply_to_keys_also && is_string($key)) {  
                $new_key = $function($key);  
                if ($new_key != $key) {  
                    $array[$new_key] = $array[$key];  
                    unset($array[$key]);  
                }  
            }  
        }  
        $recursive_counter--;  
    }                

    // 将数组转换成Json格式，中文需要进行URL编码处理  
    public function Array2Json($array) {  
        $this->arrayRecursive($array, 'urlencode', true);  
        $json = json_encode($array);  
        $json = urldecode($json);  
        // ext需要不带引号的bool类型  
        $json = str_replace("\"false\"","false", $json);  
        $json = str_replace("\"true\"","true", $json);  
        return $json;  
    }                                                          

    #sql加入log操作日志
    public function insert_log($refrence_id, $business, $data){

        $sql = " INSERT INTO `operation_log` (`id`, `refrence_id`, `business`, `create_time`, `data`) VALUES (NULL, '{$refrence_id}', '{$business}', CURRENT_TIMESTAMP, '{$data}') ";
        $query = $this->db->query($sql);
        return $query;
    }
	
    #添加景点
    public function add($data){

        $rating = floatval( (isset($data['ratingsScore'])?$data['ratingsScore']:'') );
        $openHour = intval((isset($data['openHour'])?$data['openHour']:''));
        $closeHour = intval((isset($data['closeHour'])?$data['closeHour']:''));
        $isEdited = (bool)0;

        $viewspot = array(
                //'country' => array('zhName'=>isset($data['country'])?$data['country']:''),
                //'locList' => array('zhName'=>isset($data['province'])?$data['province']:''),
                //'city' => isset($data['city'])?$data['city']:'',
                'isEdited' => $isEdited,
                'zhName' => isset($data['name'])?$data['name']:'',
                'desc' => isset($data['description'])?$data['description']:'',
                'address' => isset($data['address'])?$data['address']:'',
                'openTime' => isset($data['openTime'])?$data['openTime']:'',
                'openHour' => $openHour,
                'closeHour' => $closeHour,
                'priceDesc' => isset($data['priceDesc'])?$data['priceDesc']:'',
                'tel' => isset($data['phone'])?$data['phone']:'',
                'hotness' => $rating,       
                'visitGuide' => isset($data['visitGuide'])?$data['visitGuide']:'',
                'antiPit' => isset($data['antiPit'])?$data['antiPit']:'',
                'trafficInfo' => isset($data['travelGuide'])?$data['travelGuide']:'',
        );

        $json_data = json_encode($viewspot, JSON_UNESCAPED_UNICODE);
        mysql_query("SET NAMES 'UTF8'");
        $query = $this->insert_log('', 'add_viewspot', $json_data);
        
        if( $query ){
            return $this->cimongo->insert($this->collection_name, $viewspot);
        }
	}
    
    #根据_id获取景点信息
    public function get_viewspotinfo_by_ids($ids){

        $data = array();
        if(!$ids){
            return array();
        }

        $id = new MongoId($ids);
        $re = $this->cimongo->where(array('_id'=>(object)$id))->get($this->collection_name)->result();
        
        $data['viewspot_id'] = (string)($re['0']->_id);
        // $data['isEdited'] = $re['0']->isEdited;
        $data['name'] = $re['0']->zhname;
        if($re['0']->desc){
            $data['description'] = $re['0']->desc;
        }else{
            $data['description'] = $re['0']->description['desc'];
        }
        
        $data['address'] = $re['0']->address;
        $data['openTime'] = $re['0']->opentime;
        $data['openHour'] = $re['0']->openhour;
        $data['closeHour'] = $re['0']->closehour;
        $data['priceDesc'] = $re['0']->pricedesc;
        $data['phone'] =$re['0']->tel;
        $data['ratingsScore'] = $re['0']->hotness;
        $data['visitGuide'] = $re['0']->visitguide;
        $data['antiPit'] = $re['0']->antipit;
        $data['travelGuide'] = $re['0']->trafficinfo;
        $data['tips'] = $re['0']->tips;

        return  $data;
    }

    #更新景点:根据id更新
    public function update($data){

        $rating = floatval(  (isset($data['ratingsScore'])?$data['ratingsScore']:'') )  ;
        $openHour = intval((isset($data['openHour'])?$data['openHour']:''));
        $closeHour = intval((isset($data['closeHour'])?$data['closeHour']:''));
        //$isEdited = (bool)(isset($data['isEdited'])?$data['isEdited']:'');

        $viewspot = array(
                //'country' => array('zhName'=>isset($data['country'])?$data['country']:''),
                //'locList' => array('zhName'=>isset($data['province'])?$data['province']:''),
                //'city' => isset($data['city'])?$data['city']:'',
                //'isEdited' => $isEdited,
                'isEdited' => (boolean)TRUE,
                'zhName' => isset($data['name'])?$data['name']:'',
                'desc' => isset($data['description'])?$data['description']:'',
                'address' => isset($data['address'])?$data['address']:'',
                'openTime' => isset($data['openTime'])?$data['openTime']:'',
                'openHour' => $openHour,
                'closeHour' => $closeHour,
                'priceDesc' => isset($data['priceDesc'])?$data['priceDesc']:'',
                'tel' => isset($data['phone'])?$data['phone']:'',
                'hotness' => $rating,       
                'visitGuide' => isset($data['visitGuide'])?$data['visitGuide']:'',
                'antiPit' => isset($data['antiPit'])?$data['antiPit']:'',
                'trafficInfo' => isset($data['travelGuide'])?$data['travelGuide']:'',
        );
       
       $id = new MongoId($data['viewspot_id']);

       $json_data = json_encode($viewspot, JSON_UNESCAPED_UNICODE);
       mysql_query("SET NAMES 'UTF8'");
       $query = $this->insert_log($data['viewspot_id'], 'update_viewspot', $json_data);
        
       if( $query ){
            return $this->cimongo->where(array('_id'=>(object)$id))->update($this->collection_name, $viewspot);
       }
    }

    #根据名称name，获取景点id
    public function get_viewspot_for_name($viewspotname){
    
        $viewdata = array();
        if(!$viewspotname){
            return array();
        }
               
        $viewdata = array(         
                'zhName' => isset($viewspotname)?$viewspotname:'',          
        );
        
        $re = $this->cimongo->get_where($this->collection_name, $viewdata, $pagesize, $offset)->result();
        
        $viewspot_id= (string)($re['0']->_id);
        return  $viewspot_id;  
    }


    #foradmin管理员获取所有景点：根据id或name
    public function get_viewspot_list_for_admin($page, $pagesize, $params = array()){
    
        $offset = ($page - 1) * $pagesize;

        $viewdata = array();
        $viewdata = $params;
        if($params['id']){
             unset($viewdata['id']); 
             $id = new MongoId($params['id']);
             $viewdata['_id']=(object)$id;
        }
        
        return $this->cimongo->order_by(array('hotness' => 'DESC'))->get_where($this->collection_name, $viewdata, $pagesize, $offset)->result();
    }

    #foradmin管理员获取所有景点的数目
    public function get_viewspot_cnt_for_admin($params = array()){
        
        $viewdata = array();
        $viewdata = $params;
        if($params['id']){
             $viewdata = $params;
             unset($viewdata['id']); 
             $id = new MongoId($params['id']);
             $viewdata['_id']=(object)$id;
        }

        return $this->cimongo->where($params)->count_all_results($this->collection_name); 
    }

    #获取景点：根据country来查询
    public function get_viewspot_list_for_country($page, $pagesize, $params = array()){
    
        $offset = ($page - 1) * $pagesize;    
        
        $viewdata = $params['country'];

        $isEdited = (boolean)($params['isEdited']);
        $data = array(
            'isEdited' => $isEdited
        );
        
        return $this->cimongo->like('address', $viewdata, 'im', FALSE, TRUE)->get($this->collection_name, $pagesize, $offset)->result();  

    }

    #获取获取景点的数目：根据country来查询
    public function get_viewspot_cnt_for_country($params = array()){
      
        $viewdata = $params['country'];
        
        return $this->cimongo->like('address', $viewdata, 'im', FALSE, TRUE)->count_all_results($this->collection_name);  
    }

    #获取景点：根据city来查询
    public function get_viewspot_list_for_city($page, $pagesize, $params = array()){
    
        $offset = ($page - 1) * $pagesize;    
        $viewdata = $params['city'];
        
        return $this->cimongo->like('address', $viewdata, 'im', FALSE, TRUE)->get($this->collection_name, $pagesize, $offset)->result();  

    }

    #获取获取景点的数目：根据city来查询
    public function get_viewspot_cnt_for_city($params = array()){
      
        $viewdata = $params['city'];
        
        return $this->cimongo->like('address', $viewdata, 'im', FALSE, TRUE)->count_all_results($this->collection_name);  
    }

    #由SQL数据库mid查询monggo数据库内容
    public function get_viewspot_by_midSQL($midSQL, $isEdited){

        $edit = (boolean)$isEdited;
        $id = new MongoId($midSQL);
        $where = array(
                      "locList._id" => array(
                                          '$in'=> array( (object)$id )
                                        ),
                      "isEdited" => $edit,
                      "cmsReady" => (boolean)TRUE
                      );

        $re = $this->cimongo->order_by(array('hotness' => 'DESC'))->where( $where )->get( $this->collection_name )->result();
        return $re;
    }

    

}

?>
