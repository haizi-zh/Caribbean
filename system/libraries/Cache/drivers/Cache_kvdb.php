<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CI_Cache_KVDB
 * 见 其它 同级子类 注释
 * @author ogopogo
 */
class CI_Cache_KVDB extends CI_Driver{
   private $_kvdb;
   private $_hasKVDB = false;
   
   protected $_prefixKey;
   
   public function __construct() {
            $this->_kvdb = new SaeKV();
            $this->_hasKVDB = $this->_kvdb->init();
            $CI =& get_instance();
            $path = $CI->config->item('cache_path');
            $this->_prefixKey = ($path == '') ? 'system_cache_' : $path;
   }
   public function get($id) {
        $stored = $this->_kvdb->get($this->_prefixKey.$id);
        if ($stored == false) {
            return FALSE;
        }
        $stored = unserialize($stored);
        if (time() > $stored['time'] + $stored['ttl']) {
            $this->_kvdb->delete( $id );
            return FALSE;
        }
        return $stored['data'];
    }

    public function save($id, $data, $ttl = 60){
     $contents = array(
				'time'		=> time(),
				'ttl'		=> $ttl,			
				'data'		=> $data
			);
      $this->_kvdb->set($this->_prefixKey.$id, serialize($contents));
      return TRUE;
   }
   public function delete($id) {
        return $this->_kvdb->delete($this->_prefixKey.$id) ;
    }
   public function clean() {
       while(true){
            $ret = $this->_kvdb->pkrget($this->_prefixKey, 100);
            if( $ret == false ){
                break;
            }
            foreach ($ret as $key => $value) {
                $this->_kvdb->delete($key);
            }
       }
        
       return TRUE;
    }

    public function cache_info($type = NULL) {
        return $this->_kvdb->get_options();
    }
    public function get_metadata($id) {
       $stored = $this->_kvdb->get($this->_prefixKey.$id);
        if ($stored == false) {
            return FALSE;
        }
        $stored = unserialize($stored);
        if (count($stored) !== 3) {
            return FALSE;
        }
        return array(
            'expire' => $stored['time']+$stored['ttl'],
            'mtime' => $stored['time'],
            'data' => $stored['data']
        );
    }
    
   public function is_supported() {
        if (!$this->_hasKVDB) {
            return FALSE;
        }
        return TRUE;
    }
}

