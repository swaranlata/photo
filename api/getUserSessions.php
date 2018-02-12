<?php
require 'config.php';
$encoded_data = file_get_contents('php://input');
global $wpdb;
$data = $_GET;
if(empty($data['userId'])){
   response(0,array(),'Please enter the user id.'); 
}
if($data['type']==''){//0-today,1-upcoming
   response(0,array(),'Please enter the session type.'); 
}
$data['userId']=(string) $data['userId'];
$data['type']=(string) $data['type'];
$loggedInUser=AuthUser($data['userId'],array(),array(0,1));
$getUserSessions=getUserSessions($data['userId'],$data['type']);
$sessions=array();
if(!empty($getUserSessions)){
  foreach($getUserSessions as $k=>$v){
    if($v['userId']==$data['userId']){
       $userId = $v['otherUserId'];
    }else{
       $userId = $v['userId']; 
    }
    $sessions[$k]['jobId']=(int)$v['id'];  
    $sessions[$k]['userId']=(int)$userId;  
    $sessions[$k]['name']=getUserName($userId);  
    $sessions[$k]['profileImage']=getUserProfile($userId);  
    $sessions[$k]['rating']=getUserRating($userId);        
    $phoneNumber=get_user_meta($userId,'contactNo',true);
    if(empty($phoneNumber)){
       $phoneNumber=''; 
    }
    $sessions[$k]['phoneNumber']=$phoneNumber;
    $sessions[$k]['memberSince']=getMemberSince($userId);  
    $sessions[$k]['successRate']=getSuccessRate($userId);  
    $hourlyRate=get_user_meta($userId,'hourlyRate',true);
    if(empty($hourlyRate)){
      $hourlyRate="0";  
    }
    $sessions[$k]['hourlyRate']=$hourlyRate; 
    $minHours=get_user_meta($userId,'minHours',true);
    if(empty($minHours)){
     $minHours="0";  
    }
    $sessions[$k]['minHours']=$minHours;  
    $sessions[$k]['bannerImage']=getBannerProfile($userId);  
    $address=get_user_meta($userId,'address',true);
    if(empty($address)){
       $address=''; 
    }
    $sessions[$k]['address']=$address;  
    $sessions[$k]['suggestedRoutes']=getSuggestedRoutes($userId,$v['id']);  
    $sessions[$k]['reviewsCount']=getReviewsCount($userId);  
    $sessions[$k]['date']=getDateFormat($v['startDate']);  
    $sessions[$k]['originalTimeSlot']=$v['startTime'].' - '.$v['endTime'];  
    $sessions[$k]['isAnswered']=(int) isAnswered($data['userId'],$v['id']); 
    $sessions[$k]['requestStatus']=(int)$v['status'];  
  }
  response(1,$sessions,'No Error Found.');   
}else{
  response(0,array(),'No Session(s) Found.');   
}
?>