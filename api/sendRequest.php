<?php
require 'config.php';
$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data, true);
if(empty($data['userId'])){
  response(0,null,'Please enter the user id.');  
}
if(empty($data['otherUserId'])){
  response(0,null,'Please enter the other user id.');  
}
if(empty($data['startDate'])){
  response(0,null,'Please enter the start date.');  
}
if(empty($data['startTime'])){
  response(0,null,'Please enter the start time.');  
}
if(empty($data['endTime'])){
  response(0,null,'Please enter the end time.');  
}
$data['startDate']=inputChangeDate($data['startDate']);
$loggedInUser = AuthUser($data['userId'],array(),array(1));
$photographers = getAllPhotographers();
$CheckUserSchedule = CheckUserSchedule($data['otherUserId'],$data['startDate'],$data['startTime'].'-'.$data['endTime']);
if(empty($CheckUserSchedule)){
  response(0,null,"Photographer is not available for this time duration.");         
}
$startDate = $data['startDate'].' '.$data['startTime'];
$endDate = $data['startDate'].' '.$data['endTime'];
$checkTime = checkDateTimeSelectionPattern($startDate,$endDate);
if(empty($checkTime)){
  response(0,null,"Please check your selected datetime.");   
}
if(!in_array($data['otherUserId'],$photographers)){
  response(0,null,"No Photographer found.");       
}
if($data['userId']==$data['otherUserId']){
  response(0,null,"Please do not try to send request to yourself.");      
}
$response=sendRequest($data,'app');
if(!empty($response)){
   $senderName=getUserName($data['userId']);
   insert_notification($data['userId'],'0',$response,$data['otherUserId'],'You have received request from '.$senderName.'.','app');
   $result= getRequestDetails($response);
   response(1,$result,'No Error Found.');   
}else{
  response(0,null,'Request Not sent.');     
}
?>