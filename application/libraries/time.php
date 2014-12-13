<?php

class time{
	public static function format_stime_etime_month($stime, $etime, $diff="-"){
		if(date("Y",$stime) == date("Y", $etime)){
			$s_format = date("m月d日",$stime);
			$e_format = date("m月d日",$etime);
		}else{
			$s_format = date("Y年m月d日",$stime);
			$e_format = date("Y年m月d日",$etime);
		}
		$re = "{$s_format}{$diff}{$e_format}";
		return $re;
	}

	public static function format_time($time){
		$format = date("Y-m-d H:i:s",$time);
		return $format;
	}

	public static function format_day($time){
		$format = date("Y-m-d",$time);
		return $format;
	}

}