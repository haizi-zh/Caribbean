<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class sync extends ZB_Controller {
	const PAGE_ID = 'sync';
	public function __construct(){
		parent::__construct();
		$this->load->model("mo_coupon");
		$this->load->model("mo_count");
	}

	// zan.com/admin/sync/coupon
	public function coupon(){
		$list = $this->mo_coupon->get_list(array(), 1, 100000);
		$list = tool::format_array_by_key($list, 'id');

		$coupon_ids = array_keys($list);
		$download_list = $this->mo_count->get_count_by_sids(18, $coupon_ids);

		foreach($download_list as $coupon_id => $count){
			if($list[$coupon_id]['download_count'] != $count){
				$add_data = array();
				$add_data['download_count'] = $count;
				$this->mo_coupon->update($add_data, $coupon_id);
			}
		}
		echo "ok";

	}

	
}





