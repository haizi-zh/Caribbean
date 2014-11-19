<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class view_tool{
	public static function echo_isset($value, $default=''){
		if(isset($value) && $value){
			echo $value;
		}
		echo $default;
	}
     
     
}