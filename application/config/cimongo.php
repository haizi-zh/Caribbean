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
	$config['db'] = "admin";//"poi";//"geo"
	// Required if Mongo is running in auth mode
	$config['user'] = "cms";
    $config['pass'] = "ciJ5mum6uct2uJ0hi";
}


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
 
