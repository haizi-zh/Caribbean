<?php
#景点data model
class Do_viewspot extends CI_Model{
    
    var $collection_name = 'viewspot';

	function __construct(){
    	parent::__construct();
    	$this->load->library('cimongo');
	}

	public function add($data){
		return $this->cimongo->insert($this->collection_name, $data);
	}
    
    #更新一个景点
    public function update($data){
    	$viewdata = array(
            'shop_id' => isset($data['shop_id'])?$data['shop_id']:'',
    		'name' => isset($data['name'])?$data['name']:'',
			'english_name' => isset($data['english_name'])?$data['english_name']:'',
			'desc' => isset($data['desc'])?$data['desc']:'',	
    	);

        return $this->cimongo->where(array('shop_id'=>$data['shop_id']))->update('viewspot', $viewdata);
    }

    // #根据id获取商家信息
    // public function get_shopinfo_by_ids($ids){
    //     if(!$ids){
    //         return array();
    //     }
    //     $this->cimongo->select(array());
    //     $this->cimongo->where_in("shop_id", $ids);
    //     $this->cimongo->where("status", 0);
    //     $query = $this->cimongo->get("zb_shop");
    //     return $query->result_array();
    // }
}

?>