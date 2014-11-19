<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class image{
	

	
	public static function upload_brand($brand_id){
		//define("UPYUN_API_ROOT",APPPATH."/third_party/upyun/");
		
		require_once (APPPATH."/third_party/upyun/"."upyun.class.php");
		$upyun = new UpYun('zanbai', 'habaishi', 'chunjiang');
		//$upyun = new UpYun('bucket', 'user', 'pwd');
		# http://zanbai.b0.upaiyun.com/2013/10/c6784f36ecea71ed.jpg!pingbody
		# http://zanbai.b0.upaiyun.com/demo/sample_normal.jpeg
		try {
			echo "=========直接上传文件\r\n";
			//$fh = fopen('sample.jpeg', 'rb');
			//$fh = fopen('sample.jpeg', 'rb');
			$file_path = FCPATH."/images/brand/{$brand_id}.jpg";
			$fh = fopen($file_path, 'rb');
			//var_dump($fh);die;
			echo 33;
			$opts = array(
				UpYun::CONTENT_MD5 => md5(file_get_contents($file_path))
			);
			$rsp = $upyun->writeFile("/brand/brand_{$brand_id}.jpg", $fh, True, $opts);   // 上传图片，自动创建目录
			fclose($fh);

		}catch(Exception $e) {
			var_dump($e);
			echo $e->getCode();
			echo $e->getMessage();
		}

	}


	public static function upload_dianping_image($file_path, $id){
		$md5 = md5($id);
		$save_path = "/dianping/{$md5}.jpg";

		require_once (APPPATH."/third_party/upyun/"."upyun.class.php");
		$upyun = new UpYun('zanbai', 'habaishi', 'chunjiang');
		//$upyun = new UpYun('bucket', 'user', 'pwd');
		# http://zanbai.b0.upaiyun.com/2013/10/c6784f36ecea71ed.jpg!pingbody
		# http://zanbai.b0.upaiyun.com/demo/sample_normal.jpeg
		try {
			$tmp_file = "/tmp/test.jpg";
			unlink($tmp_file);

			$content = file_get_contents($file_path);
			$exist = stripos($content,"error");
			if ($exist) {
				return false;
			}

			$re = file_put_contents($tmp_file, $content);

			$fh = fopen($tmp_file, 'rb');
			//var_dump($fh);die;
			$opts = array(
				UpYun::CONTENT_MD5 => md5(file_get_contents($tmp_file))
			);
			$rsp = $upyun->writeFile($save_path, $fh, True, $opts);   // 上传图片，自动创建目录
			fclose($fh);
			
			return $save_path;
		}catch(Exception $e) {
			var_dump($e);
			echo $e->getCode();
			echo $e->getMessage();
		}

	}

	public static function upload_image_by_content($content, $save_path){

		require_once (APPPATH."/third_party/upyun/"."upyun.class.php");
		$upyun = new UpYun('zanbai', 'habaishi', 'chunjiang');
		//$upyun = new UpYun('bucket', 'user', 'pwd');
		# http://zanbai.b0.upaiyun.com/2013/10/c6784f36ecea71ed.jpg!pingbody
		# http://zanbai.b0.upaiyun.com/demo/sample_normal.jpeg
		try {
			$tmp_file = "/tmp/test.jpg";
			unlink($tmp_file);
			$exist = stripos($content,"error");
			if ($exist) {
				return false;
			}

			$re = file_put_contents($tmp_file, $content);

			$fh = fopen($tmp_file, 'rb');
			//var_dump($fh);die;
			$opts = array(
				UpYun::CONTENT_MD5 => md5(file_get_contents($tmp_file))
			);
			$rsp = $upyun->writeFile($save_path, $fh, True, $opts);   // 上传图片，自动创建目录
			fclose($fh);
			return $rsp;

		}catch(Exception $e) {
			var_dump($e);
			echo $e->getCode();
			echo $e->getMessage();
		}
	}

	public static function upload_file_by_file($file, $save_path){
		require_once (APPPATH."/third_party/upyun/"."upyun.class.php");
		$upyun = new UpYun('zbfile', 'habaishi', 'chunjiang', NULL, 500);
		try {
			$fh = fopen($file, 'rb');
			$opts = array(
				UpYun::CONTENT_MD5 => md5(file_get_contents($file))
			);
			$rsp = $upyun->writeFile($save_path, $fh, True, $opts);   // 上传图片，自动创建目录
			fclose($fh);
			return $rsp;
		}catch(Exception $e) {
			var_dump($e);
			echo $e->getCode();
			echo $e->getMessage();
		}
	}

	public static function upload_file_by_file_css($file, $save_path){
		require_once (APPPATH."/third_party/upyun/"."upyun.class.php");
		$upyun = new UpYun('csstest2', 'habaishi', 'chunjiang', NULL, 500);
		try {
			$fh = fopen($file, 'rb');
			$opts = array(
				UpYun::CONTENT_MD5 => md5(file_get_contents($file))
			);
			$rsp = $upyun->writeFile($save_path, $fh, True, $opts);   // 上传图片，自动创建目录
			fclose($fh);
			return $rsp;
		}catch(Exception $e) {
			var_dump($e);
			echo $e->getCode();
			echo $e->getMessage();
		}
	}


	public static function upload_file_by_content($content, $save_path){
		require_once (APPPATH."/third_party/upyun/"."upyun.class.php");
		$upyun = new UpYun('zbfile', 'habaishi', 'chunjiang');
		//$upyun = new UpYun('bucket', 'user', 'pwd');
		# http://zanbai.b0.upaiyun.com/2013/10/c6784f36ecea71ed.jpg!pingbody
		# http://zanbai.b0.upaiyun.com/demo/sample_normal.jpeg
		try {
			$tmp_file = "/tmp/".time().".pdf";
			@unlink($tmp_file);
			$exist = stripos($content,"error");
			if ($exist) {
				return false;
			}

			$re = file_put_contents($tmp_file, $content);
			$fh = fopen($tmp_file, 'rb');
			$opts = array(
				UpYun::CONTENT_MD5 => md5(file_get_contents($tmp_file))
			);
			$rsp = $upyun->writeFile($save_path, $fh, True, $opts);   // 上传图片，自动创建目录
			fclose($fh);
			@unlink($tmp_file);
			return $rsp;

		}catch(Exception $e) {
			var_dump($e);
			echo $e->getCode();
			echo $e->getMessage();
		}
	}

	public static function upload_image($file_path, $save_path){

		require_once (APPPATH."/third_party/upyun/"."upyun.class.php");
		$upyun = new UpYun('zanbai', 'habaishi', 'chunjiang');
		//$upyun = new UpYun('bucket', 'user', 'pwd');
		# http://zanbai.b0.upaiyun.com/2013/10/c6784f36ecea71ed.jpg!pingbody
		# http://zanbai.b0.upaiyun.com/demo/sample_normal.jpeg
		try {
			$tmp_file = "/tmp/test.jpg";
			unlink($tmp_file);

			$content = file_get_contents($file_path);
			$exist = stripos($content,"error");
			if ($exist) {
				return false;
			}

			$re = file_put_contents($tmp_file, $content);

			$fh = fopen($tmp_file, 'rb');
			//var_dump($fh);die;
			$opts = array(
				UpYun::CONTENT_MD5 => md5(file_get_contents($tmp_file))
			);
			$rsp = $upyun->writeFile($save_path, $fh, True, $opts);   // 上传图片，自动创建目录
			fclose($fh);


		}catch(Exception $e) {
			var_dump($e);
			echo $e->getCode();
			echo $e->getMessage();
		}
	}

}


