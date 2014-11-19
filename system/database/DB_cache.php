<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Database Cache Class
 *
 * @category	Database
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/database/
 */
class CI_DB_Cache {

	var $CI;
	var $db;	// allows passing of db object so that multiple database connections and returned db objects can be supported
//--SEA--
        private $_kvdb;
        private $_hasKVDB = false;
	/**
	 * Constructor
	 *
	 * Grabs the CI super object instance so we can access it.
	 *
	 */
	function __construct(&$db)
	{
		// Assign the main CI object to $this->CI
		// and load the file helper since we use it a lot
		$this->CI =& get_instance();
		$this->db =& $db;
                /*--SEA--
		$this->CI->load->helper('file');
                 * 
                 */
                 $this->_kvdb = new SaeKV();
                 $this->_hasKVDB = $this->_kvdb->init();
	}

	// --------------------------------------------------------------------

	/**
	 * Set Cache Directory Path
	 *
	 * @access	public
	 * @param	string	the path to the cache directory
	 * @return	bool
	 */
	function check_path($path = '')
	{
		if ($path == '')
		{
			if ($this->db->cachedir == '')
			{
				return $this->db->cache_off();
			}

			$path = $this->db->cachedir;
		}
/*--SEA--
		// Add a trailing slash to the path if needed
		$path = preg_replace("/(.+?)\/*$/", "\\1/",  $path);

		if ( ! is_dir($path) OR ! is_really_writable($path))
		{
			// If the path is wrong we'll turn off caching
			return $this->db->cache_off();
		}
 * 
 */

		$this->db->cachedir = $path;
		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Retrieve a cached query
	 *
	 * The URI being requested will become the name of the cache sub-folder.
	 * An MD5 hash of the SQL statement will become the cache file name
	 *
	 * @access	public
	 * @return	string
	 */
	function read($sql)
	{
		if ( ! $this->check_path())
		{
			return $this->db->cache_off();
		}
                //--SEA--
//                if(!$this->_hasKVDB){
//                    return FALSE;
//                }
		$segment_one = ($this->CI->uri->segment(1) == FALSE) ? 'default' : $this->CI->uri->segment(1);

		$segment_two = ($this->CI->uri->segment(2) == FALSE) ? 'index' : $this->CI->uri->segment(2);

		$filepath = $this->db->cachedir.$segment_one.'+'.$segment_two.'/'.md5($sql);
//--SEA--
                $cachedata = $this->_kvdb->get($filepath);
                if ($cachedata == false) {
                    return FALSE;
                }
               
//		if (FALSE === ($cachedata = read_file($filepath)))
//		{
//			return FALSE;
//		}

		return unserialize("$cachedata");
	}

	// --------------------------------------------------------------------

	/**
	 * Write a query to a cache file
	 *
	 * @access	public
	 * @return	bool
	 */
	function write($sql, $object)
	{
		if ( ! $this->check_path())
		{
			return $this->db->cache_off();
		}
                //--SEA--
//                if(!$this->_hasKVDB){
//                    return FALSE;
//                }

		$segment_one = ($this->CI->uri->segment(1) == FALSE) ? 'default' : $this->CI->uri->segment(1);

		$segment_two = ($this->CI->uri->segment(2) == FALSE) ? 'index' : $this->CI->uri->segment(2);

		$dir_path = $this->db->cachedir.$segment_one.'+'.$segment_two.'/';

		$filename = md5($sql);
     
                $this->_kvdb->set($dir_path.$filename,serialize($object));
/*--SEA--
		if ( ! @is_dir($dir_path))
		{
			if ( ! @mkdir($dir_path, DIR_WRITE_MODE))
			{
				return FALSE;
			}

			@chmod($dir_path, DIR_WRITE_MODE);
		}

		if (write_file($dir_path.$filename, serialize($object)) === FALSE)
		{
			return FALSE;
		}

		@chmod($dir_path.$filename, FILE_WRITE_MODE);
 * 
 */
		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Delete cache files within a particular directory
	 *
	 * @access	public
	 * @return	bool
	 */
	function delete($segment_one = '', $segment_two = '')
	{
		if ($segment_one == '')
		{
			$segment_one  = ($this->CI->uri->segment(1) == FALSE) ? 'default' : $this->CI->uri->segment(1);
		}

		if ($segment_two == '')
		{
			$segment_two = ($this->CI->uri->segment(2) == FALSE) ? 'index' : $this->CI->uri->segment(2);
		}

		$dir_path = $this->db->cachedir.$segment_one.'+'.$segment_two.'/';
/*--SEA--
		delete_files($dir_path, TRUE);
 * 
 */
                $this->_kvdb->delete($dir_path) ;
	}

	// --------------------------------------------------------------------

	/**
	 * Delete all existing cache files
	 *
	 * @access	public
	 * @return	bool
	 */
	function delete_all()
	{
            /*--SEA--
		delete_files($this->db->cachedir, TRUE);
         * 
         */ echo $this->db->cachedir;
            while(true){
                    $ret = $this->_kvdb->pkrget($this->db->cachedir, 100);
                    if( $ret == false ){
                        break;
                    }
                    foreach ($ret as $key => $value) {
                         echo $key;
                        $this->_kvdb->delete($key); 
                    }
            }
	}

}


/* End of file DB_cache.php */
/* Location: ./system/database/DB_cache.php */