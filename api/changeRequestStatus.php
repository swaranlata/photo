<?php
require 'config.php';
$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data, true);
global $wpdb;
if(empty($data['userId'])){
 response(0,null,'Please enter the user id.');
}
if(empty($data['requestId'])){
  response(0,null,'Please enter the request id.');  
}
$data['status']=(string) $data['status'];
if($data['status']==''){
  response(0,null,'Please select the request type.');  
}
if(!in_array($data['status'],array(0,1,2,3))){
   response(0,null,'Please select the correct request type.');    
}
$loggedInUser=AuthUser($data['userId'],'string',array(0,1));
$data['userId']=(string) $data['userId'];
$data['requestId']=(string) $data['requestId'];
$response=changeRequestStatus($data,'app');
if(!empty($response)){
   response(1,$response,'No Error Found.');    
}else{
   response(0,null,'No request found to change the status.'); 
}
?>