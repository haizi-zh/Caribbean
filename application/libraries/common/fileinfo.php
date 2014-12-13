<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class fileinfo{

	public static function check_exist($file){
		$executeTime = ini_get('max_execution_time');  
		
		ini_set('max_execution_time', 0);  
		$headers = @get_headers($file);  
		ini_set('max_execution_time', $executeTime); 

		if ($headers) {  
		$head = explode(' ', $headers[0]);  
		if ( !empty($head[1]) && intval($head[1]) < 400) return true;  
		}  
		return false;  
	}
}