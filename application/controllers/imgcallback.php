<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Imgcallback extends CI_Controller {

	public function index()
	{     
		#返回值
		$code = $_GET['code'];
		if(!isset($code) || !$code) {
			echo json_encode(array('code'=>0)); exit;
		}elseif($code != '200'){
			echo json_encode(array('code'=>$code,'msg'=>$_GET['message'])); exit;
		}

		#url
		$url = $_GET['url'];
		$source_url = $url;
		
		$this->config->load('env',TRUE);
		$url = $this->config->item('imgdomain','env').$url;
		
		#imgcallback函数名 js用
		$imgcallback = isset($_GET['ext-param'])?$_GET['ext-param']:'default';
		
		
		if($imgcallback == 'mobile'){#如果是移动端
			echo $url;
		}else{
			#js需要的html元素
			$basic_html = '<html><head><title></title><script type="text/javascript">try {/** parse location.search to an Object **/var queryToJson = function(QS, isDecode) {var _Qlist = QS.split("&");var _json = {};for (var i = 0, len = _Qlist.length; i < len; i++) {var _hsh = _Qlist[i].split("=");if (!_json[_hsh[0]]) {_json[_hsh[0]] = _hsh[1];	} else {_json[_hsh[0]] = [_hsh[1]].concat(_json[_hsh[0]]);}}return _json;};var query = window.location.search.slice(1);var res = queryToJson(query, true);%s%svar func = res["ext-param"];if (window.parent) {window.parent[func](res, query);}} catch(e) {}</script></head><body></body></html>';
			$segment[] = "res.fullurl ='".$url."';";
			$segment[] = "res.source_url ='".$source_url."';";
			echo vsprintf($basic_html, $segment);
		}
	}
}