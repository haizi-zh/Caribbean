<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class hotel extends ZB_Controller {
		
	#推荐酒店
	public function hotelrecom(){
		
		try{
			
			$json_recommend = $this->input->post('recomdata', true, '');
            $arr_recommend = json_decode($json_recommend, true);
		    $recommend = array();

			foreach ($arr_recommend as $key=>$value) {
            	$recommend[$key] = explode(',', $arr_recommend[$key]) ;
            }

            $this->load->model('do/do_hotel');           
            foreach ($recommend as $key=>$value) {
            	$id_recom = $recommend[$key][0];
            	$re = $this->do_hotel->modify_recommend($id_recom);
            }


            if ($this->input->get('char') !== false){
				$char = $this->input->get('char', true);
			}else{
				$char = '';
			}	
			
		
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}

   
	
}