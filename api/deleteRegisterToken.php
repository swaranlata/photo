<?php
require 'config.php';
$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data, true);
if(empty($data['userId'])){
    response(0, null, 'Please enter the user id.');   
}
$loggedUser=AuthUser($data['userId'],'string',array(0,1)); 
update_user_meta($data['userId'],'deviceToken','');
update_user_meta($data['userId'],'deviceType','');
response(1, 'Device type and token deleted successfully.', 'No Error found.');  
?>