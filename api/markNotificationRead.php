<?php
require 'config.php';
$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data, true);
global $wpdb;
if(empty($data['userId'])){
 response(0,null,'Please enter the user id.');
}
if(empty($data['notificationId'])){
 response(0,null,'Please enter the notification id.');
}
$loggedInUser=AuthUser($data['userId'],'string',array(0,1));
$res=markReadNotification($data['userId'],$data['notificationId']);
if(!empty($res)){
  response(1,'Notification marked read successfully.','No Error Found.');
}else{
   response(0,null,'No Notification found.'); 
}
?>