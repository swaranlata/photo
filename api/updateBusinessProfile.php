<?php
require 'config.php';
$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data,true);
$error=0;
if(empty($data['userId'])){
    $error=1;
}
if(empty($data['hourlyRate'])){
    $error=1;
}
if(empty($data['minHours'])){
    $error=1;
}
if(empty($data['experience'])){
    $error=1;
}
if(!empty($error)){
   response(0,null,'Please enter the required fields.'); 
}else{
    $loggedUser=AuthUser($data['userId'],'string',array(0));    
    $response=updateBusinessProfile($loggedUser['ID'],$data);    
    if(!empty($response)){
     response(1,'Business profile updated successfully.','No Error Found.');      
    }else{
     response(0,null,'We are unable to update the data.Please try again after some time.');      
    }
    
}
?>