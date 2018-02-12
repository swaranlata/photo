<?php
require 'config.php';
$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data, true);
if(empty($data['userId'])){
    response(0, null, 'Please enter the user id.');   
}
if(empty($data['deviceToken'])){
   response(0, null, 'Please enter the device token.'); 
}
if(empty($data['deviceType'])){
   response(0, null, 'Please enter the device type.'); 
}
$loggedUser=AuthUser($data['userId'],'string',array(0,1)); 
update_user_meta($data['userId'],'deviceToken',$data['deviceToken']);
update_user_meta($data['userId'],'deviceType',$data['deviceType']);
response(1, 'Details updated successfully.', 'No Error found.');  
?>