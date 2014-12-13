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
			$culture = $this->input->post('culture', true, '0');
			$activityIntro = $this->input->post('activityIntro', true, '');
			$lightspot = $this->input->post('lightspot', true, 0);
			$tips = $this->input->post('tips', true, '');
			$json_localTraffic = $this->input->post('localTraffic', true, '');
			$json_remoteTraffic = $this->input->post("remoteTraffic", true, '');
            //$img = $this->input->post('img', true, '');
           
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
					'culture' => $culture,
					'activityIntro' => $activityIntro,
					'lightspot' => $lightspot,
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
			$culture = $this->input->post('culture', true, '');
			$activityIntro = $this->input->post('activityIntro', true, '');
			$lightspot = $this->input->post('lightspot', true, '');
			$tips = $this->input->post('tips', true, '');
			$json_localTraffic = $this->input->post('localTraffic', true, '');
			$json_remoteTraffic = $this->input->post('remoteTraffic', true, '');
			// $img = $this->input->post('img', true, '');

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

			#拼装
			$citydata = array(
					'id' => $id,
					'name' => $name,
					'desc' => $desc,
					'timeCostDesc' => $timeCostDesc,
					'travelMonth' => $travelMonth,
					'culture' => $culture,
					'activityIntro' => $activityIntro,
					'lightspot' => $lightspot,
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