<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class context{
	private static $context_data = array();
	private static $has_inited = false;
	protected static $server = array();
	public static $keep_server_copy = true;

	public static function init(){
		if(self::$has_inited){
			return ;
		}
		self::$has_inited = true;
		self::$server = $_SERVER;
		if(!self::$keep_server_copy){
			unset($_SERVER);
		}
	}
	/**
	 * 根据指定的上下文键名获取一个已经设置过的上下文键值
	 * 
	 * @param string|int|float $key 键名
	 * @param mixed $if_not_exist 当键值未设置的时候的默认返回值。可选，默认是Null。如果该值是Null,当键值未设置则会抛出一个异常；否则，返回该值。
	 * @return mixed 如果指定的$key不存在，根据 $if_not_exist 的值，会抛出一个异常或者 $if_not_exist 本身。
	 */
	public static function get($key, $if_not_exist = NULL){
		if(!array_key_exists($key, self::$context_data)){
			if($if_not_exist === NULL){
			}else{
				return $if_not_exist;
			}
		}
		return self::$context_data[$key];
	}
	
	/**
	 * 往一个指定的上下文键名中设置键值。如果该键值已经被设置，则会抛出异常。
	 * 
	 * @param string|int|float $key
	 * @param mixed $value
	 * @param array $rule
	 * @throws Comm_Exception_Program
	 */
	public static function set($key, $value, array $rule = array(),$is_check=true){
		if($is_check==true && array_key_exists($key, self::$context_data)){
		}
		
		if($rule){
			$type = $rule[0];
			$rule[0] = $value;
			$value = call_user_func_array(array('Comm_Argchecker', $type), $rule);
		}
		self::$context_data[$key] = $value;
	}

	/**
	 * 清除context中的所有内容
	 */
	public static function clear(){
		//为了防止引用计数产生的内存泄漏，此处显式的unset掉所有set进来的值
		foreach (self::$context_data as $key => $value){
			self::$context_data[$key] = null;
			$value = null;
		}
		self::$context_data = array();
	}

	public static function get_server($name){
		return isset(self::$server[$name]) ? self::$server[$name] : null;
	}
	public static function cookie($name, $if_not_exist = NULL) {
	    return isset($_COOKIE[$name]) ? $_COOKIE[$name] : $if_not_exist;
	}
	public static function get_domain(){
		return self::get_server('SERVER_NAME');
	}
	public static function get_client_ip($to_long = false){

		$forwarded = self::get_server('HTTP_X_FORWARDED_FOR');
		if($forwarded){
			$ip_chains = explode(',', $forwarded);
			$proxied_client_ip = $ip_chains ? trim(array_pop($ip_chains)) : '';
		}
		
		$real_ip = self::get_server('REMOTE_ADDR');
		$re = $to_long ? self::ip2long($real_ip) : $real_ip;
		return $re;
	}
	
	public static function ip2long($ip){
		$ip_chunks = explode('.', $ip, 4);
		foreach ($ip_chunks as $i => $v){
			$ip_chunks[$i] = abs(intval($v));
		}
		return sprintf('%u', ip2long(implode('.', $ip_chunks)));
	}
	public static function get_http_method(){
		return self::get_server('REQUEST_METHOD');
	}
	/**
	 * 判断当前请求是否是XMLHttpRequest(AJAX)发起
	 * @return boolean
	 */
	public static function is_xmlhttprequest () {
		return (self::get_server('HTTP_X_REQUESTED_WITH') == 'XMLHttpRequest') ? true : false;
	}
	
	
	/**
	 * 返回当前url
	 * 
	 * @param bool $urlencode 是否urlencode后返回，默认true
	 */
    public static function get_current_url($urlencode = true) {
        $req_uri = self::get_server('REQUEST_URI');
        if (NULL === $req_uri) {
            $req_uri = self::get_server('PHP_SELF');
        }
        
        $https = self::get_server('HTTPS');
        $s = NULL === $https ? '' : ('on' == $https ? 's' : '');
        
        $protocol = self::get_server('SERVER_PROTOCOL');
        $protocol =  strtolower(substr($protocol, 0, strpos($protocol, '/'))).$s;
        
        $port = self::get_server('SERVER_PORT');
        $port = ($port == '80') ? '' : (':'.$port);
        
        $server_name =self::get_server('SERVER_NAME');
        $current_url = $protocol . '://'.$server_name.$port.$req_uri;
        
        return $urlencode ? rawurlencode($current_url): $current_url;
    }

	
}
