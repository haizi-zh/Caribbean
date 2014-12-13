<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Weibo extends ZB_Controller {

	public function index()
	{
		
		#获取微博用户信息
       	require_once APPPATH .'third_party/weibo/weibo_authv2.php';
		require_once APPPATH .'config/oau.php';
		if(!$_GET  || (isset($_GET['source_url']) && !isset($_GET['o']))) {
			#跳转到第三方的登录页面
			$source_url = $this->input->get("source_url", true, "http://". $config['my_domain']."/");
			$source_url = "/?".urlencode("source_url=".$source_url."&o=1");
			$weibo['WB_CALLBACK_URL'] .= $source_url;
			$weibo['WB_OPENAPI_URL'] .= $source_url;
	    	header("Location:".$weibo['WB_OPENAPI_URL']);  
	    	exit;
		}

		$o = new SaeTOAuthV2( $config['weibo']['WB_AKEY'] , $config['weibo']['WB_SKEY'] );
		if (isset($_REQUEST['code'])) {
			$keys = array();
			$keys['code'] = $_REQUEST['code'];
			$keys['redirect_uri'] = $config['weibo']['WB_CALLBACK_URL'];
			try {
				$token = $o->getAccessToken( 'code', $keys ) ;
			} catch (OAuthException $e) {
			}
			
			$c = new SaeTClientV2( $config['weibo']['WB_AKEY'] , $config['weibo']['WB_SKEY'] , $token['access_token'] );
			$ms  = $c->home_timeline();
			$uid_get = $c->get_uid();
			$uid = $uid_get['uid'];
			$user_message = $c->show_user_by_id($uid);
			
			#获取本地用户信息
			$data['source'] = 'weibo';
			$data['sid'] = $uid;
			$data['uname'] = $user_message['screen_name'];
			$data['image'] = $user_message['avatar_large'];
			$data['gender'] = $user_message['gender'] == 'm' ?1:0;
			$data['desc'] = isset($user_message['description'])?$user_message['description']:'';
			$data['token'] = $token['access_token'];
			
			$this->load->model('mo_user');
			$user_info = $this->mo_user->get_local_userinfo($data);
			
			#设置session
			$this->load->library('session');
			$this->session->set_userdata(array('user_info'=>$user_info));
			$source_url = $this->input->get("source_url", true, "http://". $config['my_domain']."/");
			$from = $this->input->get('from', TRUE, '');
			
			if($from && $from == 'm1'){
				$suffix = '';
				$suffix .= 'sid=' . $this->session->userdata('session_id');
				$suffix .= '&uname=' . $data['uname'];
				$suffix .= '&uid=' . $user_info['uid'];
				header("Location:http://". $config['my_domain'] . $source_url . "&" . $suffix);
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

					$data = array();
					$data['user_info'] = $re['user_info'];
					$data['cookie'] = $cookie;
					$json_string = $this->mobile_json_encode(array('code'=>$code,'msg'=>'succ', 'data'=>$data));
					echo $json_string;
					exit();
				}else{
					
					header("Location:http://". $config['my_domain'].$source_url);
				}
			}
		}
		
		
	}
}
