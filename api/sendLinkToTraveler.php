<?php
require 'config.php';
$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data, true);
global $wpdb;
if(empty($data['userId'])){
  response(0,null,'Please enter the user id.');  
}
if(empty($data['otherUserId'])){
  response(0,null,'Please enter the other user id.');  
} 
if(empty($data['link'])){
  response(0,null,'Please enter the link.');  
} 
if(empty($data['jobId'])){
  response(0,null,'Please enter the Job id.');  
} 
$loggedInUser = AuthUser($data['userId'],array(),array(0));
$data['optype']='app';
sendLinkTotraveler($data);
?>