<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Qq extends ZB_Controller {
	function index()
	{
			session_start();
			$this->load->library('session');
			define("QQ_API_ROOT",APPPATH."/third_party/qq/");
			require_once (QQ_API_ROOT."qqConnectAPI.php");

			if(!$_GET || (isset($_GET['source_url']) && !isset($_GET['o'])))
			{
				$source_url = $this->input->get("source_url", true, "http://". $_SERVER['HTTP_HOST']."/");
				$source_url = "/".urlencode("?source_url=".$source_url."&o=1");
				#登录QQ
				$qc = new QC();
				$qc->qq_login($source_url);		
			}
			//$_SESSION["callback"] = "http://www.zanbai.com/callback/qq/"; 
			
			$this->session->set_userdata($_SESSION);
			
			#QQ回调获取token
			$callback = new QC();
			$token = $callback->qq_callback();
			$this->session->set_userdata('access_token',$token);
			#获取用户openid
			$openid = $callback->get_openid();
			$this->session->set_userdata('openid',$openid);
			
			#获取用户user_info
			$user = new QC($_SESSION['access_token'],$_SESSION['openid']);
			$userinfo = $user->get_user_info();
			
			#整理user_info数据
			$formart_userinfo = self::tidy_userinfo($userinfo);

			#将user_info插入数据库
			$this->load->model('mo_user');
			$local_userinfo = $this->mo_user->get_local_userinfo($formart_userinfo);
			$this->session->set_userdata('user_info',$local_userinfo);
			$source_url = $this->input->get("source_url", true, "http://". $_SERVER['HTTP_HOST']."/");

			$from = $this->input->get('from', TRUE, '');
			if($from && $from == 'm1'){
				$suffix = '';
				$suffix .= 'sid=' . $this->session->userdata('session_id');
				$suffix .= '&uname=' . $local_userinfo['uname'];
				$suffix .= '&uid=' . $local_userinfo['uid'];
				header("Location:http://". $_SERVER['HTTP_HOST'] . $source_url . "&" . $suffix);
			}else{
				if ($source_url=='ios'||$source_url=='aod') {
					$re = $this->session->all_userdata();
					$code = '200';
					
					$headers_list = headers_list() ;
					
					foreach ($headers_list as $key => $value) {
						//echo $value;
						if (strpos($value, "zanbai_session")) {
							$cookie = substr($value, 12);
						}
					}
					//var_dump($cookie);
					$data = array();
					$data['user_info'] = $re['user_info'];
					$data['cookie'] = $cookie;
					$json_string = $this->mobile_json_encode(array('code'=>$code,'msg'=>'succ', 'data'=>$data));
					echo $json_string;
					exit();
				}else{
					header("Location:http://". $_SERVER['HTTP_HOST'].$source_url);
				}
			}
	}
	
	/*
	 * 整理用户信息函数，后续插入
	 */
	function tidy_userinfo($userinfo)
	{
		$data['source'] = 'qq';
		$data['sid'] = $this->session->userdata('openid');
		$data['uname'] = $userinfo['nickname'];
		$data['image'] = $userinfo['figureurl_qq_1'];
		$data['gender'] = $userinfo['gender'] == '男' ?1:0;
		$data['reserve_1'] = $this->session->userdata['access_token'];
		return $data;
	}	
	
}
?>