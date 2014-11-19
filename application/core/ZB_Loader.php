<?php
/*
 * 定义了项目中各类页面的加载规则，包括前端页面和后台页面，如有特殊的还可继续定义。
 */
class ZB_Loader extends CI_Loader{
	function __construct(){
		parent::__construct();
	}
	public function view($view, $vars = array(), $return = FALSE){
		$domain = context::get('domain', "");
		$vars['domain'] = $domain;
		return parent::view($view, $vars, $return);
	}
	/*
	 * 给前端页面使用的。
	 */
	public function web_view($view, $vars = array(), $return = FALSE, $include_header = TRUE, $include_footer = TRUE){
		$domain = context::get('domain', "");
		$vars['domain'] = $domain;
		$head_name = context::get('head_name', "");
		$vars['head_name'] = $head_name;


		$content = '';
		if ($include_header){
			$content .= parent::view('header', $vars, $return);
		}
		$content .= parent::view($view, $vars, $return);
		if ($include_footer){
			$content .= parent::view('footer', $vars, $return);
		}
		//记录性能
		if(defined('IS_DEBUG_XHPROF')){
			if(IS_DEBUG_XHPROF){
				$xhprofData = xhprof_disable();
				include "/var/www/htdocs/xhprof/xhprof_lib/utils/xhprof_lib.php";
				include "/var/www/htdocs/xhprof/xhprof_lib/utils/xhprof_runs.php";
				$xhprofRuns = new XHProfRuns_Default();
				$re = $xhprofRuns->save_run($xhprofData, "xhprof");
			}
		}

		return $content;
	}
	/*
	 * 给后台页面使用的。
	 */
	public function admin_view($view, $vars = array(), $return = FALSE, $include_header = TRUE, $include_footer = TRUE){
		$domain = context::get('domain', "");
		$vars['domain'] = $domain;
		$data_domain = context::get("data_domain", "");
		$vars['data_domain'] = $data_domain;
		$imgdomain = context::get('imgdomain', "");
		$vars['imgdomain'] = $imgdomain;

		$js_domain = context::get('admin_js_domain', "");
		$vars['js_domain'] = $js_domain;

		$css_domain = context::get('admin_css_domain', "");
		$vars['css_domain'] = $css_domain;
		$js_version = context::get('js_version', "");
		$vars['js_version'] = $js_version;


		$content = '';
		if ($include_header){
			$content .= parent::view('adminheader', $vars, $return);
		}
		$content .= parent::view($view, $vars, $return);
		if ($include_footer){
			$content .= parent::view('adminfooter', $vars, $return);
		}
		return $content;
	}
	/*
	 * 给前端页面使用的。
	 */
	public function h5_view($view, $vars = array(), $return = FALSE, $include_header = TRUE, $include_footer = TRUE){
		$domain = context::get('domain', "");
		$vars['domain'] = $domain;
		$head_name = context::get('head_name', "");
		$vars['head_name'] = $head_name;
		
		$css_domain = context::get('css_domain', "");
		$vars['css_domain'] = $css_domain;

		$content = '';
		if ($include_header){
			$content .= parent::view('h5header', $vars, $return);
		}
		$content .= parent::view($view, $vars, $return);
		if ($include_footer){
			$content .= parent::view('h5footer', $vars, $return);
		}
		//记录性能
		if(defined('IS_DEBUG_XHPROF')){
			if(IS_DEBUG_XHPROF){
				$xhprofData = xhprof_disable();
				include "/var/www/htdocs/xhprof/xhprof_lib/utils/xhprof_lib.php";
				include "/var/www/htdocs/xhprof/xhprof_lib/utils/xhprof_runs.php";
				$xhprofRuns = new XHProfRuns_Default();
				$re = $xhprofRuns->save_run($xhprofData, "xhprof");
			}
		}

		return $content;
	}
}