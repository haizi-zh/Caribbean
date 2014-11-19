<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends ZB_Controller {

	const PAGE_ID = 'register';

	public function index()
	{
		#header
		//$this->load->view('header',array('pageid'=>self::PAGE_ID));
		
		#load page
		//$this->load->view('register');
		
		#footer
		$jsplugin_list = array('drag','popup');#需要用到的js插件
		//$this->load->view('footer',array('pageid'=>self::PAGE_ID,'jsplugin_list'=>$jsplugin_list));
		# ?source_url=<?php echo $source_url;
		$source_url = $this->input->get("source_url", true, '/');

		$data = array();
		$data['pageid'] = self::PAGE_ID;
		$data['jsplugin_list'] = $jsplugin_list;
		$data['source_url'] = urlencode($source_url);
		$this->load->web_view('register', $data);
	}
}