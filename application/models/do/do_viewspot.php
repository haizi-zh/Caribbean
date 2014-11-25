<?php
#景点data model
class Do_viewspot extends CI_Model{
    
    var $collection_name = 'viewspot';//'ViewSpotEdit';

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
        return $this->cimongo->get($this->collection_name);
    }

    #更新景点
    public function update($data){
    	$viewdata = array(
            'shop_id' => isset($data['shop_id'])?$data['shop_id']:'',
    		'name' => isset($data['name'])?$data['name']:'',
			'english_name' => isset($data['english_name'])?$data['english_name']:'',
			'desc' => isset($data['desc'])?$data['desc']:'',	
    	);

        return $this->cimongo->where(array('shop_id'=>$data['shop_id']))->update($this->collection_name, $viewdata);
    }
}

?>