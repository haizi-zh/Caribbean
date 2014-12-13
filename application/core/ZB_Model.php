<?php
/*
 * 定义了项目中各类页面的加载规则，包括前端页面和后台页面，如有特殊的还可继续定义。
 */
class ZB_Model extends CI_Model{
	function __construct(){
		parent::__construct();
	}

	public function get_simple_cache($key_template, $model_name, $key_params, $cache_time=0, $set_data = false ){
		$use_memcache = context::get('use_memcache', 0);
		if($use_memcache){
			$cache_keys = context::get("cache_keys", false);
			array_unshift($key_params, $cache_keys[$model_name]);
			$cache_key = vsprintf($key_template, $key_params);

			if($set_data !== false){
				$re = $this->memcached_library->set($cache_key, $set_data, $cache_time );
				return;
			}
			$no_cache = 0;
			if($_GET && isset($_GET['no_cache']) && $_GET['no_cache']==1){
				$no_cache = 1;
			}
			if($_GET && isset($_GET['nocache']) && $_GET['nocache']==1){
				$no_cache = 1;
			}
			if($_SERVER && isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']=="nocache=1"){
				$no_cache = 1;
			}
			if($_SERVER && isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']=="no_cache=1"){
				$no_cache = 1;
			}
			if($no_cache == 1){
				return false;
			}
			$data =  $this->memcached_library->get($cache_key);
			if($data !== false){
				return $data;
			}
		}
		return false;
	}

	public function delete_simple_cache($key_template, $model_name, $key_params, $cache_time=0){
		$use_memcache = context::get('use_memcache', 0);
		if($use_memcache){
			$cache_keys = context::get("cache_keys", false);
			array_unshift($key_params, $cache_keys[$model_name]);
			$cache_key = vsprintf($key_template, $key_params);

			$data =  $this->memcached_library->delete($cache_key);
			if($data !== false){
				return $data;
			}
		}
		return false;
	}

	public function get_multi_cache($key_template, $model_name, $ids, $key_params, $cache_time = 0, $set_data = false) {
		$use_memcache = context::get('use_memcache', 0);
		$diff_ids = array();
		$cache_data = array();
		if($use_memcache){
			$cache_keys = context::get("cache_keys", false);
			$model_name_key = $cache_keys[$model_name];
			$cache_keys = array();
			foreach($ids as $id){
				$tmp_key_params = $key_params;
				array_unshift($key_params, $id);
				array_unshift($key_params, $model_name_key);
				$cache_keys[$id] = vsprintf($key_template, $key_params);
			}
			
			if($set_data !== false){
				$multis = array();
				foreach($set_data as $id => $v){
					$multi = array();
					$multi['key'] = $cache_keys[$id];
					$multi['value'] = $v;
					$multi['expiration'] = $cache_time;
					$multis[$id] = $multi;
					$tmp_re = $this->memcached_library->set($multi['key'], $multi['value'], $multi['expiration']);
				}
				//$tmp_re = $this->memcached_library->set($multis);var_dump($cache_keys, $tmp_re, $multis);
			}
			$cache_data = $this->memcached_library->get ( $cache_keys );

			if($cache_data){
				$tmp = array();
				foreach($cache_data as $k => $v){
					//var_dump($v);
					if($v){
						$tmp[$v['id']] = $v;
					}
				}
				$cache_data = $tmp;
				foreach($ids as $v){
					if(!isset($cache_data[$v])){
						$diff_ids[$v] = $v;
					}
				}
			}else{
				$diff_ids = $ids;
			}
		}else{
			$diff_ids = $ids;
			$cache_data = $set_data;
		}

		$no_cache = 0;
		if($_GET && isset($_GET['no_cache']) && $_GET['no_cache']==1){
			$no_cache = 1;
		}
		if($_GET && isset($_GET['nocache']) && $_GET['nocache']==1){
			$no_cache = 1;
		}
		if($_SERVER && isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']=="nocache=1"){
			$no_cache = 1;
		}
		if($_SERVER && isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']=="no_cache=1"){
			$no_cache = 1;
		}
		if($no_cache == 1){
			$diff_ids = $ids;

		}

		$re = array();
		$re['data'] = $cache_data;
		$re['diff_ids'] = $diff_ids;
		return $re;
	}


}








