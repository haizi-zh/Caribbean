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

}

?>