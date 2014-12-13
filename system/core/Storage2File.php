<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$GLOBALS['GLOBAL_STORAGE']=null;

function s_get_global_storage(){
    if($GLOBALS['GLOBAL_STORAGE'] == null){
        $GLOBALS['GLOBAL_STORAGE'] = new SaeStorage(); 
    }
    return $GLOBALS['GLOBAL_STORAGE'];
}
function s_get_storage_path($path){
    $path = preg_replace('/\/+|\\\+/','/',$path  );
    return array('domain'=> substr($path, 0,stripos($path,'/' )),
                 'fileName'=> substr($path, stripos($path,'/' )+1));
}
function s_copy($source,$destination){
   $storage = s_get_global_storage();
   $data =  s_readfile($source);
   if($data === false){
       return false;
   }
   return s_writefile($destination,$data);
}   
function s_unlink($file){
   $storage = s_get_global_storage();
   $storage_path =  s_get_storage_path($file);
   return $storage-> delete( $storage_path['domain'] , $storage_path['fileName'] ); 
}   
function s_rmdir($dir){
   $storage = s_get_global_storage();
   $storage_path =  s_get_storage_path($dir);
   return $storage->deleteFolder( $storage_path['domain'] , $storage_path['fileName']);
}
function s_file_exists($file){
   $storage = s_get_global_storage();
   $storage_path =  s_get_storage_path($file);
   return $storage->fileExists( $storage_path['domain'] , $storage_path['fileName'] ); 
}   
function s_rename($oldname,$newname){
 if(s_copy($oldname,$newname) === false){
     return false;
 }
 return s_unlink($oldname); 
}   
function s_writefile($file,$data){
   $storage = s_get_global_storage();
   $storage_path =  s_get_storage_path($file);     
   return $storage->write( $storage_path['domain'] , $storage_path['fileName'],$data ) ; 
}
function s_readfile($file){
   $storage = s_get_global_storage();
   $storage_path =  s_get_storage_path($file);
   return $storage->read( $storage_path['domain'] , $storage_path['fileName'] ) ;
}
function s_get_url($file){
    $storage = s_get_global_storage();
    $storage_path =  s_get_storage_path($file);
    return $storage->getUrl( $storage_path['domain'] , $storage_path['fileName'] ) ; 
}
function s_get_wrappers_bypath($path){
    $path = preg_replace('/\/+|\\\+/','/',$path  );
    return 'saestor://'.$path;
}