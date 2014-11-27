<?php
#景点data model
class Do_viewspot extends CI_Model{
    
    var $collection_name = 'ViewSpotEdit';

	function __construct(){
    	parent::__construct();
    	$this->load->library('cimongo');
	}

	
    #添加景点
    public function add($data){
        $viewspot = array(
                'country' => isset($data['country'])?$data['country']:0,
                'city' => isset($data['city'])?$data['city']:0,
                'area' => isset($data['area'])?$data['area']:0,
                'name' => isset($data['name'])?$data['name']:'',
                'price' => isset($data['english_name'])?$data['english_name']:0,
                'desc' => isset($data['desc'])?$data['desc']:'',
                'address' => isset($data['address'])?$data['address']:'',
                // 'phone' => isset($data['phone'])?$data['phone']:'',
                // 'business_hour' => isset($data['business_hour'])?$data['business_hour']:'',
                // 'score' => isset($data['score'])?$data['score']:0,
                // 'visit_guide' => isset($data['visit_guide'])?$data['visit_guide']:'',
                // 'anti_pit' => isset($data['anti_pit'])?$data['anti_pit']:'',
                // 'travel_guide' => isset($data['travel_guide'])?$data['travel_guide']:'',
        );
		return $this->cimongo->insert($this->collection_name, $viewspot);
	}
    

    #根据_id获取景点信息
    public function get_viewspotinfo_by_ids($ids){

        $data = array();
        if(!ids){
            return array();
        }

        $id = new MongoId($ids);
        $re = $this->cimongo->where(array('_id'=>(object)$id))->get($this->collection_name)->result();
        
        $data['viewspot_id'] = (string)($re['0']->_id);
        $data['name'] = $re['0']->name;
        $data['price'] = $re['0']->price;
        $data['desc'] = $re['0']->desc;
        $data['address'] = $re['0']->address;
        $data['phone'] =$re['0']->phone;
        $data['business_hour'] = $re['0']->business_hour;
        $data['score'] = $re['0']->score;
        $data['visit_guide'] = $re['0']->visit_guide;
        $data['anti_pit'] = $re['0']->anti_pit;
        $data['travel_guide'] = $re['0']->travel_guide;
        //$data['location'] = $re['0']->location;
                
        return  $data;
    }

    #更新景点
    public function update($data){
       
       $viewdata = array(
            
            'name' => isset($data['name'])?$data['name']:'',
            'price' => isset($data['price'])?$data['price']:'',
            'desc' => isset($data['desc'])?$data['desc']:'',
            'address' => isset($data['address'])?$data['address']:'',
            //'phone' => isset($data['phone'])?$data['phone']:'',
            //'business_hour' => isset($data['business_hour'])?$data['business_hour']:'',
            //'visit_guide' => isset($data['visit_guide'])?$data['visit_guide']:'',
            //'anti_pit' => isset($data['anti_pit'])?$data['anti_pit']:'',  
            //'travel_guide' => isset($data['travel_guide'])?$data['travel_guide']:'',  
            //'location' => isset($data['loacetion'])?$data['loacetion']:'';              
        );
       
       $id = new MongoId($data['viewspot_id']);
       return $this->cimongo->where(array('_id'=>(object)$id))->update($this->collection_name, $viewdata);
    }


}

?>