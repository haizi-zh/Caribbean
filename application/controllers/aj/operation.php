<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
@header('Content-type: text/html;charset=utf-8');
class operation extends ZB_Controller {
	
	#添加城市
	public function addcity(){
		try{
			
			$name = $this->input->post('name', true, '');
			$desc = $this->input->post('desc', true, '');
			$timeCostDesc = $this->input->post('timeCostDesc', true, '');
			$travelMonth = $this->input->post('travelMonth', true, '');

			$json_geoHistory = $this->input->post('geoHistory', true, '');
			$json_activities = $this->input->post('activities', true, '');
			$json_specials = $this->input->post('specials', true, '');
			$json_tips = $this->input->post('tips', true, '');

			$json_localTraffic = $this->input->post('localTraffic', true, '');
			$json_remoteTraffic = $this->input->post('remoteTraffic', true, '');
			// $img = $this->input->post('img', true, '');

            $arr_geoHistory = json_decode($json_geoHistory, true);
			$geoHistory = array();
			foreach ($arr_geoHistory as $key=>$value) {
            	 $title_geoHistory = reset( explode(',', $value) );
            	 $desc_geoHistory = end( explode(',', $value) );
            	 $geoHistory[$key] = array('title'=>$title_geoHistory, 'desc'=>$desc_geoHistory);
            }

            $arr_activities = json_decode($json_activities, true);
			$activities = array();
			foreach ($arr_activities as $key=>$value) {
            	 $title_activities = reset( explode(',', $value) );
            	 $desc_activities = end( explode(',', $value) );
            	 $activities[$key] = array('title'=>$title_activities, 'desc'=>$desc_activities);
            }

            $arr_specials = json_decode($json_specials, true);
			$specials = array();
			foreach ($arr_specials as $key=>$value) {
            	 $title_specials = reset( explode(',', $value) );
            	 $desc_specials = end( explode(',', $value) );
            	 $specials[$key] = array('title'=>$title_specials, 'desc'=>$desc_specials);
            }

            $arr_tips = json_decode($json_tips, true);
			$tips = array();
			foreach ($arr_tips as $key=>$value) {
            	 $title_tips = reset( explode(',', $value) );
            	 $desc_tips = end( explode(',', $value) );
            	 $tips[$key] = array('title'=>$title_tips, 'desc'=>$desc_tips);
            }
           
            $arr_localTraffic = json_decode($json_localTraffic, true);
			$localTraffic = array();
			foreach ($arr_localTraffic as $key=>$value) {
            	 $title_localTraffic = reset( explode(',', $value) );
            	 $content_localTraffic = end( explode(',', $value) );
            	 $localTraffic[$key] = array('title'=>$title_localTraffic, 'contents'=>$content_localTraffic);
            }

            $arr_remoteTraffic = json_decode($json_remoteTraffic, true);
            $remoteTraffic = array();
            foreach ($arr_remoteTraffic as $key=>$value) {
            	 $title_remoteTraffic = reset( explode(',', $value) );
                 $content_remoteTraffic = end( explode(',', $value) );
                 $remoteTraffic[$key] = array('title'=>$title_remoteTraffic, 'contents'=>$content_remoteTraffic);
            }

            if ($this->input->get('char') !== false){
				$char = $this->input->get('char', true);
			}else{
				$char = '';
			}
            

			#拼装
			$citydata = array(

					'name' => $name,
					'desc' => $desc,
					'timeCostDesc' => $timeCostDesc,
					'travelMonth' => $travelMonth,
					'geoHistory' => $geoHistory,
					'activities' => $activities,
					'specials' => $specials,
					'tips' => $tips,
					'localTraffic' => $localTraffic,
					'remoteTraffic' => $remoteTraffic,
			);
	
			#入库
			$this->load->model('do/do_viewcity');
			$re = $this->do_viewcity->add($citydata);

            if($re){
                #返回
				$code = '200';
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
            }		
			
		
		}catch(Exception $e){
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}
	
	#编辑城市
	public function editcity(){
		try{
		
			$id = $this->input->post('id', true, '');
			$name = $this->input->post('name', true, '');
			$desc = $this->input->post('desc', true, '');
			$timeCostDesc = $this->input->post('timeCostDesc', true, '');
			$travelMonth = $this->input->post('travelMonth', true, '');
			$json_geoHistory = $this->input->post('geoHistory', true, '');
			$json_activities = $this->input->post('activities', true, '');
			$json_specials = $this->input->post('specials', true, '');
			$json_tips = $this->input->post('tips', true, '');

			$json_localTraffic = $this->input->post('localTraffic', true, '');
			$json_remoteTraffic = $this->input->post('remoteTraffic', true, '');
			// $img = $this->input->post('img', true, '');

            $arr_geoHistory = json_decode($json_geoHistory, true);
			$geoHistory = array();
			foreach ($arr_geoHistory as $key=>$value) {
            	 $title_geoHistory = reset( explode(',', $value) );
            	 $desc_geoHistory = end( explode(',', $value) );
            	 $geoHistory[$key] = array('title'=>$title_geoHistory, 'desc'=>$desc_geoHistory);
            }

            $arr_activities = json_decode($json_activities, true);
			$activities = array();
			foreach ($arr_activities as $key=>$value) {
            	 $title_activities = reset( explode(',', $value) );
            	 $desc_activities = end( explode(',', $value) );
            	 $activities[$key] = array('title'=>$title_activities, 'desc'=>$desc_activities);
            }

            $arr_specials = json_decode($json_specials, true);
			$specials = array();
			foreach ($arr_specials as $key=>$value) {
            	 $title_specials = reset( explode(',', $value) );
            	 $desc_specials = end( explode(',', $value) );
            	 $specials[$key] = array('title'=>$title_specials, 'desc'=>$desc_specials);
            }

            $arr_tips = json_decode($json_tips, true);
			$tips = array();
			foreach ($arr_tips as $key=>$value) {
            	 $title_tips = reset( explode(',', $value) );
            	 $desc_tips = end( explode(',', $value) );
            	 $tips[$key] = array('title'=>$title_tips, 'desc'=>$desc_tips);
            }


			$arr_localTraffic = json_decode($json_localTraffic, true);
			$localTraffic = array();
			foreach ($arr_localTraffic as $key=>$value) {
            	 $title_localTraffic = reset( explode(',', $value) );
            	 $content_localTraffic = end( explode(',', $value) );
            	 $localTraffic[$key] = array('title'=>$title_localTraffic, 'desc'=>$content_localTraffic);
            }
            $arr_remoteTraffic = json_decode($json_remoteTraffic, true);
            $remoteTraffic = array();
            foreach ($arr_remoteTraffic as $key=>$value) {
            	 $title_remoteTraffic = reset( explode(',', $value) );
            	 $content_remoteTraffic = end( explode(',', $value) );
            	 $remoteTraffic[$key] = array('title'=>$title_remoteTraffic, 'desc'=>$content_remoteTraffic);
            }

			#拼装
			$citydata = array(
					'id' => $id,
					'name' => $name,
					'desc' => $desc,
					'timeCostDesc' => $timeCostDesc,
					'travelMonth' => $travelMonth,
					'geoHistory' => $geoHistory,
					'activities' => $activities,
					'specials' => $specials,
					'tips' => $tips,
					'localTraffic' => $localTraffic,
					'remoteTraffic' => $remoteTraffic,
			);	

			// #入库
			$this->load->model('do/do_viewcity');
			$re = $this->do_viewcity->update($citydata);

		
            if($re)
            {
            	#返回
				$code = '200';
				echo json_encode(array('code'=>$code,'msg'=>$this->config->item($code,'errorcode')));
            }
			
	
		}catch(Exception $e){
			
			echo json_encode(array('code'=>$e->getCode(),'msg'=>$e->getMessage()));
		}
	}


}