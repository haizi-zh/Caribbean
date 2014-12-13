<?php
/* PHP SDK
 * @version 2.0.0
 * @author connect@qq.com
 * @copyright © 2013, Tencent Corporation. All rights reserved.
 */

require_once(QQ_CLASS_PATH."ErrorCase.class.php");
class Recorder{
    private static $data;
    private $inc;
    private $error;

    public function __construct(){
        $this->error = new ErrorCase();

        //-------读取配置文件
        $incFileContents = file_get_contents(QQ_API_ROOT."comm/inc.php");
        require APPPATH .'config/env.php';
        $segment_data[] = $config['qq']['appid'];
        $segment_data[] = $config['qq']['appkey'];
        //$segment_data[] = $config['domain'];
        $segment_data[] = "http://www.zanbai.com";
        $qqConfig = vsprintf($incFileContents, $segment_data);
// 		$incFileContents = '{"appid":"100348313","appkey":"c6f3f607a2b353196a0bc8b1c92c182a","callback":"'.$_SERVER['HTTP_HOST'].'/callback/qq","scope":"get_user_info","errorReport":true,"storageType":"file","host":"localhost","user":"root","password":"root","database":"test"}';
        $this->inc = json_decode($qqConfig);
        if(empty($this->inc)){
            $this->error->showError("20001");
        }

        if(empty($_SESSION)){
            self::$data = array();
        }else{
            self::$data = $_SESSION;
        }
    }

    public function write($name,$value){
        self::$data[$name] = $value;
        $_SESSION[$name] = $value;
    }

    public function read($name){
        if(empty($_SESSION[$name])){
            return null;
        }else{
            return $_SESSION[$name];
        }
    }

    public function readInc($name){
        if(empty($this->inc->$name)){
            return null;
        }else{
            return $this->inc->$name;
        }
    }

    public function delete($name){
        unset(self::$data[$name]);
    }

    function __destruct(){
        //$_SESSION['QC_userData'] = self::$data;
    }
}
