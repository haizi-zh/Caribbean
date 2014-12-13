<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cdn extends ZB_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('mo_shop');
		$this->load->model('mo_brand');
		$this->load->model('mo_discount');
		$this->load->model('mo_common');
		$this->load->model('mo_geography');
		$this->load->model('mo_coupon');
		$this->load->model("mo_dianping");
		$this->load->model("mo_cdn");
	}
	// zanbai.com/cdn/js_upyun_upload
	// zan.com/cdn/js_upyun_upload
	public function js_upyun_upload(){
		$this->load->library("common/image");
		$path = FCPATH;
		$css_path = FCPATH."/css/";
		$img_path = FCPATH . "/images/";
		$fe_path = FCPATH . "/fe/";
		$js_path = FCPATH . "/js/";
		$now = time();
		$paths = array($css_path, $img_path, $fe_path, $js_path);
		foreach($paths as $my_path){
			$files = $this->get_files($my_path);
			foreach($files as $v){
				$save_path = str_replace($path, '', $v);
				$save_path = "/".$save_path;
				$content =file_get_contents($v);
				$content_md5 = md5($content);
				$file_name_md5 = md5($save_path);
				$exist = $this->mo_cdn->get_info_by_filenamemd5($file_name_md5);
				if($exist){
					$old_content_md5 = $exist['content_md5'];
					if($content_md5 == $old_content_md5){
						continue;
					}
				}
				$re = $this->image->upload_file_by_file_css( $v, $save_path );
				
				if($re){
					if($exist){
						$add_data['content_md5'] = $content_md5;
						$add_data['mtime'] = $now;
						$this->mo_cdn->update($add_data, $exist['id']);
					}else{
						$add_data = array();
						$add_data['file_name'] = $save_path;
						$add_data['file_name_md5'] = $file_name_md5;
						$add_data['content_md5'] = $content_md5;
						$add_data['ctime'] = $now;
						$add_data['mtime'] = $now;
						$this->mo_cdn->add($add_data);
					}
				}
				unset($content, $content_md5, $file_name_md5);
			}
			unset($files);
		}

		echo "ok";
	}

    function get_files($dir) {
        $dir = realpath($dir) . "/";
        $files = array();

        if (!is_dir($dir)) {
            return $files;
        }

        $pattern = $dir . "*";
        $file_arr = glob($pattern);

        foreach ($file_arr as $file) {
            if (is_dir($file)) {
                $temp = $this->get_files($file);
                if (is_array($temp)) {
                    $files = array_merge($files, $temp);
                }
            } else {
                $files[] = $file;
            }   //  end if
        }
        return $files;
    }
}