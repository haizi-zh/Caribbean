<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class hotelrecom extends ZB_Controller {
		
	const PAGE_ID = 'hotelrecom';
	public function __construct(){
		parent::__construct();
		$this->load->model("do/do_hotel");
	}
	
	public function index(){		
		
		// $id = $this->input->get("operation_id", TRUE);

		// if($id){
        //    $operation = $this->do_operation->get_operationinfo_by_ids($id);
		// }	
        
        // $data = array('operation'=>$operation);

		// $data['id'] = $id;
		$data['pageid'] = self::PAGE_ID;

		$this->load->admin_view('admin/hotelrecom', $data);
	}
	
}