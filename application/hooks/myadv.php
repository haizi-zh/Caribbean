<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class myadv {

    public $CI;

    public function head() {
    	
    	$is_ajax_request = context::get("is_ajax_request", 0);
    	if(!$is_ajax_request){
    		return;
    	}
        $this->CI = & get_instance();
        $country_id = context::get("country_id", 0);
        $city_id = context::get("city_id", 0);
        $shop_id = context::get("shop_id", 0);


        var_dump($country_id, $city_id, $shop_id);
       // log_message('info', 'GET --> ' . var_export($this->CI->input->get(null), true));

    }

}