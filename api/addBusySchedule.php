<?php
require 'config.php';
$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data,true);
if(empty($data['userId'])){
    response(0,null,'Please enter the user id.');
}
$data['dayId']=(string) $data['dayId'];
if($data['dayId']==''){
    response(0,null,'Please enter the day.');
}
if(empty($data['startTime'])){
   response(0,null,'Please enter the start time.');  
}
if(empty($data['endTime'])){
   response(0,null,'Please enter the end time.');    
}
$loggedUser=AuthUser($data['userId'],'string',array(0)); 
$response=addBusySchedule($data);
if(!empty($response)){
 response(1,$response,'No Error Found.');   
}else{
 response(0,null,'Schedule already added for the same day.');   
}
?>