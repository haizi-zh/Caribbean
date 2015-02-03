<?php
#景点城市操作类
class Do_viewcity extends CI_Model {

	var $collection_name = 'Locality';

	function __construct()
	{
		parent::__construct();
		$this->load->library('cimongo');
        $this->cimongo->switch_db('geo');
        $this->load->database();
	}

    #sql加入log操作日志
    public function insert_log($refrence_id, $business, $data){

        $sql = " INSERT INTO `operation_log` (`id`, `refrence_id`, `business`, `create_time`, `data`) VALUES (NULL, '{$refrence_id}', '{$business}', CURRENT_TIMESTAMP, '{$data}') ";
        $query = $this->db->query($sql);
        return $query;
    }

	#添加一个城市
	public function add($data){
		$citydata = array(
				'zhName' => isset($data['name'])?$data['name']:'',
				'desc' => isset($data['desc'])?$data['desc']:'',
				'timeCostDesc' => isset($data['timeCostDesc'])?$data['timeCostDesc']:'',
				'travelMonth' => isset($data['travelMonth'])?$data['travelMonth']:'',
				'culture' => isset($data['culture'])?$data['culture']:'',
				'activityIntro' => isset($data['activityIntro'])?$data['activityIntro']:'',
				'lightspot' => isset($data['lightspot'])?$data['lightspot']:'',
				'tips' => isset($data['tips'])?$data['tips']:'',
				'localTraffic' => isset($data['localTraffic'])?$data['localTraffic']:'',
				'remoteTraffic' => isset($data['remoteTraffic'])?$data['remoteTraffic']:'',

		);

        $this->cimongo->insert($this->collection_name, $citydata);

        $json_data = json_encode($citydata, JSON_UNESCAPED_UNICODE);
        mysql_query("SET NAMES 'UTF8'");
		return  $this->insert_log('', 'add_city', $json_data);
	}

	#更新城市信息
    public function update($data){
       
       $citydata = array(
                'city_id' => isset($data['id'])?$data['id']:'',
                'zhName' => isset($data['name'])?$data['name']:'',
				'desc' => isset($data['desc'])?$data['desc']:'',
				'timeCostDesc' => isset($data['timeCostDesc'])?$data['timeCostDesc']:'',
				'travelMonth' => isset($data['travelMonth'])?$data['travelMonth']:'',
				'culture' => isset($data['culture'])?$data['culture']:'',
				'activityIntro' => isset($data['activityIntro'])?$data['activityIntro']:'',
				'lightspot' => isset($data['lightspot'])?$data['lightspot']:'',
				'tips' => isset($data['tips'])?$data['tips']:'',
				'localTraffic' => isset($data['localTraffic'])?$data['localTraffic']:'',
				'remoteTraffic' => isset($data['remoteTraffic'])?$data['remoteTraffic']:'',         
        );
       
       $id = new MongoId($citydata['city_id']);

       $this->cimongo->where(array('_id'=>(object)$id))->update($this->collection_name, $citydata);

       $json_data = json_encode($citydata, JSON_UNESCAPED_UNICODE);
       mysql_query("SET NAMES 'UTF8'");
       return  $this->insert_log($citydata['city_id'], 'update_city', $json_data);
    }

    #根据id,获取城市所有信息
    public function get_viewcityinfo_by_ids($ids){
    
        $data = array();
        if(!$ids){
            return array();
        }

        $id = new MongoId($ids);
        $re = $this->cimongo->where(array('_id'=>(object)$id))->get($this->collection_name)->result();

        $data['city_id'] = (string)($re['0']->_id);
        $data['name'] = $re['0']->zhname;
        $data['desc'] = $re['0']->desc;
        //城市图片 无
        $data['timeCostDesc'] = $re['0']->timecostdesc;
        $data['travelMonth'] = $re['0']->travelmonth;
        $data['culture'] = $re['0']->culture;
        $data['activityIntro'] =$re['0']->activityintro;
        $data['lightspot'] =  $re['0']->lightspot;
        $data['tips'] = $re['0']->tips;
        $data['localTraffic'] = $re['0']->localtraffic;
        $data['remoteTraffic'] = $re['0']->remotetraffic;
       
        return  $data;
    }

	#根据省份，获取城市列表
    public function get_citys_for_city($page, $pagesize, $params = array()){
    
        $offset = ($page - 1) * $pagesize;    
        $citydata = $params['country'];
        
        return $this->cimongo->like('desc', $citydata, 's', FALSE, TRUE)->get($this->collection_name, $pagesize, $offset)->result();  
    }

    #根据省份，获取所有城市的数目
    public function get_citys_cnt_for_city($params = array()){

        $citydata = $params['country'];
        
        return $this->cimongo->like('desc', $citydata, 's', FALSE, TRUE)->count_all_results($this->collection_name);       
    }


    #根据id和名称，获取城市列表
    public function get_citys_for_admin($page, $pagesize, $params = array()){
    
        $offset = ($page - 1) * $pagesize;

        $citydata = array();
        $citydata = $params;
        if($params['id']){      
             unset($citydata['id']); 
             $id = new MongoId($params['id']);
             $citydata['_id']=(object)$id;
        }
        
        return $this->cimongo->get_where($this->collection_name, $citydata, $pagesize, $offset)->result();
    }

    #根据id和名称，获取城市数目
    public function get_citys_cnt_for_admin($params = array()){

        $citydata = array();
        $citydata = $params;
        if($params['id']){ 
             $citydata = $params;
             unset($citydata['id']); 
             $id = new MongoId($params['id']);
             $citydata['_id']=(object)$id;
        }

        return $this->cimongo->where($citydata)->count_all_results($this->collection_name); 
    }

}





