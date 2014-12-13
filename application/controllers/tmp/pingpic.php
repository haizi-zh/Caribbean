<?php
// nohup /usr/local/php/bin/php -f /data/site/new/apps/account/action/setfile.php >/dev/null 2>&1 &

function get_by_url($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
	$contents = curl_exec($ch);
	//var_dump($contents);
	curl_close($ch);

	return $contents;
}





for($i=1;;$i++){
	$url = "http://zanbai.com";
	get_by_url($url);
	sleep(60);
}



