<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Generally localhost
if($_SERVER['SERVER_NAME'] == 'localhost'){
    $config['host'] = "127.0.0.1";
}else{
    $config['host'] = "localhost";//"api.lvxingpai.cn";    
}


// Generally 27017
$config['port'] = 27017;


// The database you want to work on
if($_SERVER['SERVER_NAME'] == 'localhost'){
	$config['db'] = "misc";
}else{
	$config['db'] = "admin";
	$config['user'] = "cms";
    $config['pass'] = "ciJ5mum6uct2uJ0hi";
}

$config['host'] = "182.92.159.203";
$config['port'] = 31001;

$config['server_list'] = array(array('host'=> '182.92.159.203', 'port'=> 31001), 
	array('host'=>'121.201.7.184', 'port'=>27017));
$config['conn_options'] = array("replicaSet" => "aizou");

/*  
 * Defaults to FALSE. If FALSE, the program continues executing without waiting for a database response. 
 * If TRUE, the program will wait for the database response and throw a MongoCursorException if the update did not succeed.
*/
$config['query_safety'] = TRUE;

//If running in auth mode and the user does not have global read/write then set this to true
$config['db_flag'] = TRUE;

//consider these config only if you want to store the session into mongoDB
//They will be used in MY_Session.php
$config['sess_use_mongo'] = TRUE;
$config['sess_collection_name']	= 'ci_sessions';
 
