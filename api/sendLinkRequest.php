<?php
require 'config.php';
global $wpdb;
$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data, true);
if(empty($data['userId'])){
  response(0,null,'Please enter the user id.');  
}
if(empty($data['jobId'])){
  response(0,null,'Please enter the other user id.');  
}
$data['type']=(string) $data['type'];
if($data['type']==''){
  response(0,null,'Please enter the type.');  
}else{
    if(!in_array($data['type'],array(0,1,2))){
      response(0,null,'Please enter the type.');    
    }
}
$data['userId']=(string) $data['userId'];
$data['jobId']=(string) $data['jobId'];
$loggedInUser=AuthUser($data['userId'],null,array(0,1));
$data['optype']='app';
sendLinkRequest($data);
?>