<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class uploadpic extends CI_Controller {
	
	public function hi(){
		echo 'hi';
	}
	
	#为又拍云的图片上传提供安全数据接口
	public function getSecurityData(){
		
		#生成安全数据
		$this->config->load('env',TRUE);
		$bucket = $this->config->item('upyun-bucket','env'); /// 空间名
		$form_api_secret = $this->config->item('upyun-form-api-secret','env'); /// 表单 API 功能的密匙（请访问又拍云管理后台的空间管理页面获取）
		
		$options = array();
		$options['bucket'] = $bucket; /// 空间名
		$options['expiration'] = time()+600; /// 授权过期时间
		$options['save-key'] = '/{year}/{mon}/{random}{.suffix}'; /// 文件名生成格式，请参阅 API 文档
		$options['allow-file-type'] = 'jpg,jpeg,gif,png'; /// 控制文件上传的类型，可选
// 		$options['content-length-range'] = '0,1024000'; /// 限制文件大小，可选
// 		$options['image-width-range'] = '0,1024000'; /// 限制图片宽度，可选
// 		$options['image-height-range'] = '0,1024000'; /// 限制图片高度，可选
		$options['return-url'] = $this->config->item('upyun-callback','env');; /// 页面跳转型回调地址
		if(isset($_POST['imgCallback'])) $options['ext-param'] = $_POST['imgCallback']; #js需要的回调方法名
		//$options['notify-url'] = 'http://a.com/form-test/notify.php'; /// 服务端异步回调地址, 请注意该地址必须公网可以正常访问
		
		$policy = base64_encode(json_encode($options));
		$sign = md5($policy.'&'.$form_api_secret); /// 表单 API 功能的密匙（请访问又拍云管理后台的空间管理页面获取）
		echo json_encode(array('policy'=> $policy,'signature'=>$sign));
	}
}