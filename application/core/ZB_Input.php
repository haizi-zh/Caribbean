<?php
class ZB_Input extends CI_Input {
	public function __construct(){
		parent::__construct();
	}
	
	public function get($index = NULL, $xss_clean = FALSE, $default = FALSE){
		$re = parent::get($index, $xss_clean);
		
		if ($re===false){
			return $default;
		}
		return $re;
	}
	public function post($index = NULL, $xss_clean = FALSE, $default = FALSE){
		$re = parent::post($index, $xss_clean);
		if ($re===false){
			return $default;
		}
		return $re;
	}
	function cookie($index = '', $xss_clean = FALSE, $default = false)
	{
		$re = parent::cookie($index, $xss_clean);
		if ($re===false){
			return $default;
		}
		return $re;
	}

}