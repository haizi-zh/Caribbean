<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Renren extends ZB_Controller {
	function index() {
		session_start();
		define("RENREN_API_ROOT",APPPATH."/third_party/renren/");
		require_once (RENREN_API_ROOT."RenrenOAuthApiService.class.php");
		require_once APPPATH .'config/env.php';
		
		if(!$_GET || (isset($_GET['source_url']) && !isset($_GET['o']))) {
			$source_url = $this->input->get("source_url", true, "http://". $_SERVER['HTTP_HOST']."/");
			//$source_url = urlencode($source_url);
			$source_url = ("?source_url=".$source_url."&o=1");
			$renren['redirecturi'] .= $source_url;
			$renren['redirecturi'] = urlencode($renren['redirecturi']);
	        $url = "https://graph.renren.com/oauth/authorize?client_id={$renren['appid']}&response_type=code&scope={$renren['scope']}&state=a%3d1%26b%3d2&redirect_uri={$renren['redirecturi']}&x_renew=true";
	        header("Location:{$url}");
	        exit;
		}
		$code = $_GET['code'];
		if($code)
		{
			//获取accesstoken
			$oauthApi = new RenrenOAuthApiService;
			$this->config->load('env',TRUE);
			$env = $this->config->item('env');
            $renren = $env['renren'];

			$source_url = $this->input->get("source_url", true, "http://". $_SERVER['HTTP_HOST']."/");
			//$source_url = urlencode($source_url);
			$source_url = ("?source_url=".$source_url."&o=1");
			$renren['redirecturi'] .= $source_url;
			$renren['redirecturi'] = ($renren['redirecturi']);

			$post_params = array('client_id'=>$renren['apikey'],
					'client_secret'=>$renren['secretkey'],
					'redirect_uri'=>$renren['redirecturi'],
					'grant_type'=>'authorization_code',
					'code'=>$code);
			$token_url='http://graph.renren.com/oauth/token';
			$access_info=$oauthApi->rr_post_curl($token_url,$post_params);//使用code换取token
			
			//$access_info=$oauthApi->rr_post_fopen($token_url,$post_params);//如果你的环境无法支持curl函数，可以用基于fopen函数的该函数发送请求
			$access_token=$access_info["access_token"];
			$expires_in=$access_info["expires_in"];
			$refresh_token=$access_info["refresh_token"];
			$this->session->set_userdata($_SESSION);
			$source_url = $this->input->get("source_url", true, "http://". $_SERVER['HTTP_HOST']."/");

			if(isset($access_info['user']))//如果userId已经存在
			{
				//更新数据库的access_token、expires_in、refresh_token、获取token的时间
				//直接登录到网站
				$userinfo = $access_info['user'];
				$this->session->set_userdata('access_token',$access_token);
				#获取用户openid
				$openid = $userinfo['id'];
				$this->session->set_userdata('openid',$openid);
				$info = array();
				$info['openid'] = $userinfo['id'];
				$info['uname'] = $userinfo['name'];
				$info['image'] = $userinfo['avatar'][0]['url'];

				#整理user_info数据
				$formart_userinfo = self::tidy_userinfo($info);
				#将user_info插入数据库
				$this->load->model('mo_user');
				$local_userinfo = $this->mo_user->get_local_userinfo($formart_userinfo);
				$this->session->set_userdata('user_info',$local_userinfo);
				
				$from = $this->input->get('from', TRUE, '');
				if($from && $from == 'm1'){
					$suffix = '';
					$suffix .= 'sid=' . $this->session->userdata('session_id');
					$suffix .= '&uname=' . $local_userinfo['uname'];
					$suffix .= '&uid=' . $local_userinfo['uid'];
					header("Location:http://". $_SERVER['HTTP_HOST'] . $source_url . "&" . $suffix);
				}
			}
			if ($source_url=='ios'||$source_url=='aod') {
				$re = $this->session->all_userdata();
				$code = '200';

				$headers_list = headers_list() ;
				
				foreach ($headers_list as $key => $value) {
					if (strpos($value, "zanbai_session")) {
						$cookie = substr($value, 12);
					}
				}

				$data = array();
				$data['user_info'] = $re['user_info'];
				$data['cookie'] = $cookie;
				$json_string = $this->mobile_json_encode(array('code'=>$code,'msg'=>'succ', 'data'=>$data));
				echo $json_string;
				exit();
			}else{
				header("Location:http://". $_SERVER['HTTP_HOST'].$source_url);
			}
			//header("Location:http://". $_SERVER['HTTP_HOST'].$source_url);
		}
	}

	/*
	 * 整理用户信息函数，后续插入
	 */
	function tidy_userinfo($userinfo)
	{
		$data['source'] = 'renren';
		$data['sid'] = $this->session->userdata('openid');
		$data['uname'] = $userinfo['uname'];
		$data['image'] = $userinfo['image'];
		$data['reserve_1'] = $this->session->userdata['access_token'];
		return $data;
	}	

}
?>
