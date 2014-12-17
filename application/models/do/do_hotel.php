<?php
#酒店
class Do_hotel extends CI_Model{
    
    // var $collection_name = 'Column';

    function __construct(){
    	parent::__construct();
    	$this->load->library('cimongo');
        // $this->cimongo->switch_db('misc');
	}

    
    
}

?>



