<?php
#景点data model
class Do_viewspot extends CI_Model{
    
    var $collection_name = 'ViewSpotEdit';

	function __construct(){
    	parent::__construct();
    	$this->load->library('cimongo');
        $this->cimongo->switch_db('poi');
	}
	
    #添加景点
    public function add($data){

        $description = array( 'desc'=>  (isset($data['description'])?$data['description']:'')  );
        $ratingsScore = array( 'score'=> intval( (isset($data['ratingsScore'])?$data['ratingsScore']:'') )  );
        $openHour = intval((isset($data['openHour'])?$data['openHour']:''));
        $closeHour = intval((isset($data['closeHour'])?$data['closeHour']:''));

        $viewspot = array(
                //'country' => array('zhName'=>isset($data['country'])?$data['country']:''),
                //'locList' => array('zhName'=>isset($data['province'])?$data['province']:''),
                //'city' => isset($data['city'])?$data['city']:'',
                'name' => isset($data['name'])?$data['name']:'',
                'description' => $description,
                'address' => isset($data['address'])?$data['address']:'',
                'openTime' => isset($data['openTime'])?$data['openTime']:'',
                'openHour' => $openHour,
                'closeHour' => $closeHour,
                'priceDesc' => isset($data['priceDesc'])?$data['priceDesc']:'',
                'phone' => isset($data['phone'])?$data['phone']:'',
                'ratings' => $ratingsScore,       
                'visitGuide' => isset($data['visitGuide'])?$data['visitGuide']:'',
                'antiPit' => isset($data['antiPit'])?$data['antiPit']:'',
                'travelGuide' => isset($data['travelGuide'])?$data['travelGuide']:'',
        );
		return $this->cimongo->insert($this->collection_name, $viewspot);
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
        $data['name'] = $re['0']->name;
        $data['description'] = $re['0']->description['desc'];
        $data['address'] = $re['0']->address;
        $data['openTime'] = $re['0']->opentime;
        $data['openHour'] = $re['0']->openhour;
        $data['closeHour'] = $re['0']->closehour;
        $data['priceDesc'] = $re['0']->pricedesc;
        $data['phone'] =$re['0']->phone;
        $data['ratingsScore'] = $re['0']->ratings['score'];
        $data['visitGuide'] = $re['0']->visitguide;
        $data['antiPit'] = $re['0']->antipit;
        $data['travelGuide'] = $re['0']->travelguide;

        return  $data;
    }

    #更新景点:根据id更新
    public function update($data){

        $description = array( 'desc'=>  (isset($data['description'])?$data['description']:'')  );
        $ratingsScore = array( 'score'=> intval(  (isset($data['ratingsScore'])?$data['ratingsScore']:'') )  );
        $openHour = intval((isset($data['openHour'])?$data['openHour']:''));
        $closeHour = intval((isset($data['closeHour'])?$data['closeHour']:''));

        $viewspot = array(
                //'country' => array('zhName'=>isset($data['country'])?$data['country']:''),
                //'locList' => array('zhName'=>isset($data['province'])?$data['province']:''),
                //'city' => isset($data['city'])?$data['city']:'',
                'name' => isset($data['name'])?$data['name']:'',
                'description' => $description,
                'address' => isset($data['address'])?$data['address']:'',
                'openTime' => isset($data['openTime'])?$data['openTime']:'',
                'openHour' => $openHour,
                'closeHour' => $closeHour,
                'priceDesc' => isset($data['priceDesc'])?$data['priceDesc']:'',
                'phone' => isset($data['phone'])?$data['phone']:'',
                'ratings' => $ratingsScore,       
                'visitGuide' => isset($data['visitGuide'])?$data['visitGuide']:'',
                'antiPit' => isset($data['antiPit'])?$data['antiPit']:'',
                'travelGuide' => isset($data['travelGuide'])?$data['travelGuide']:'',
        );
       
       $id = new MongoId($data['viewspot_id']);
       return $this->cimongo->where(array('_id'=>(object)$id))->update($this->collection_name, $viewspot);
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
        
        return $this->cimongo->get_where($this->collection_name, $viewdata, $pagesize, $offset)->result();
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



    

}

?>
