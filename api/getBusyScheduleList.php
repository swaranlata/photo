<?php
require 'config.php';
$data =$_GET;
$error = 1;
if(empty($data['userId'])){
   response(0,array(),'Please enter the user id.');
}
$data['dayId']=(string) $data['dayId'];
if($data['dayId']==""){
   response(0,array(),'Please enter the day.');
}
$loggedUser=AuthUser($data['userId'],array(),array(0));
$getSchedule=getPhotographerBusySchedule($data['userId'],$data['dayId']);
$scheduleLists=array();
if(!empty($getSchedule)){
  foreach($getSchedule as $k=>$v){
    $scheduleLists[$k]['startTime']=$v['startTime'];  
    $scheduleLists[$k]['endTime']=$v['endTime'];  
    $scheduleLists[$k]['busyScheduleId']=(int) $v['id'];  
  } 
 response(1,$scheduleLists,'No Error Found.');
}else{
 response(0,array(),'No Schedules Found.');   
}

?>