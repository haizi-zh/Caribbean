<?php
class Mo_city extends Zb_model {
    public function __construct(){
        parent::__construct() ;
        $this->load->database();
    }

    public function get_city_by_lowername($city_name){
        $this->db->where('lower_name' , $city_name) ;
        return $this->db->get('zb_city')->row() ;
    }
}