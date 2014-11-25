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
		return $this->cimongo->insert($this->collection_name, $data);
	}
    
    #根据_id获取景点信息
    public function get_viewspotinfo_by_ids($ids){
        // if(!ids){
        //     return array();
        // }
        // return $this->cimongo->get($this->collection_name);
    }

    #更新景点
    public function update($data){
       
       $viewdata = array(
            'id' => isset($data['id'])?$data['id']:'',
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
       
       $id = new MongoId($viewdata['id']);
       return $this->cimongo->where(array('_id'=>(object)$id))->update('ViewSpotEdit', $viewdata);
    }


}

?>