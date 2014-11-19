<?php
#数据统计
class Mo_data_analytics extends CI_Model {
	
	const DEFAULT_UNIT = '次／天'; 

	function __construct(){
		parent::__construct();
		$this->load->model('do/do_data_analytics');
	}

	#添加一个统计
	public function add($business,$time,$value){
		$re = $this->do_data_analytics->add($business,$time,$value);
	}		
	
	#查询一个统计
	public function get($business,$year=-1,$month=-1,$day=-1,$hour=-1,$minute=-1,$second=-1){
		$re = $this->do_data_analytics->get($business,$year,$month,$day,$hour,$minute,$second);
		
		#格式化成数组
		$format_re = $this->tool->std2array($re);
		
		if(empty($format_re)) return 0; #没有结果
		if(count($format_re) > 1){
			$re = array();
			foreach($format_re as $each){
				$re[] = intval($each['value']);
			}
			return $re;
		}
		return $format_re[0]['value'];
	}
	
	#获取这个业务的历史数据
	public function get_stream_line($business){
		#前段需要的秒倍数
		$times = 1000;
		$Interval = 86400;
		$re = $this->do_data_analytics->get($business);
		
		#格式化成数组
		$format_re = $this->tool->std2array($re);	
		$data = array();
		foreach($format_re as $each){
			$data[$each['time']] = intval($each['value']);
		}
		
		#从开始时间到昨天，每天一个点
		$e_time = strtotime("today -1 day");
		$s_time = self::get_start_time();
		$time = $s_time;
		$full_data = array();
		while($time <= $e_time){
			$full_data[] = isset($data[$time]) ? $data[$time] : 0;
			$time += $Interval;
		}
		
		$this->config->load('data_analytics',TRUE);
		$data_analytics = $this->config->item('data_analytics');
		$name = $data_analytics[$business]['name'];
		$unit = isset($data_analytics[$business]['unit']) ? $data_analytics[$business]['unit'] : self::DEFAULT_UNIT;
		
		return array('name'=>$name, 'pointStart'=>$s_time * $times, 'pointInterval'=>$Interval * $times, 'data'=>$full_data, 'unit'=>$unit);
	}
	
	#获取数据统计开始的时间点
	public function get_start_time(){
		$ori_stime = strtotime("2014-01-27");#start from 2014-01-27
		$yesterday = strtotime("today -1 day");
		$show_days = 365; #统计图表的最长显示跨度天数
		$stime = $yesterday - $show_days * 86400;
		
		$stime = $ori_stime > $stime ? $ori_stime : $stime;
		return $stime;
	}
	
}
