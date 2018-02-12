<?php
require 'config.php';
$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data,true);
$error=0;
if(empty($data['userId'])){
    $error=1;
}
if(empty($data['currentPassword'])){
    $error=1;
}
if(empty($data['newPassword'])){
    $error=1;
}
if(!empty($error)){
   response(0,null,'Please enter the required fields.'); 
}else{
    $loggedInUser=AuthUser($data['userId'],'string',array(0,1));
    $loggedInUser=convert_array($loggedInUser);
    $checkOldPassword= wp_check_password($data['currentPassword'],$loggedInUser['user_pass'],$data['userId']);
    if(!empty($checkOldPassword)){
       wp_set_password($data['newPassword'],$data['userId']); 
       response(1,1,'No Error Found.');    
    }else{
       response(0,null,'You have entered incorrect old Password.');    
    }
    
 }
?>