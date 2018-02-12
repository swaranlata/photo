<?php
require 'config.php';
$data =$_GET;
if(empty($data['userId'])){
  response(0,null,'Please enter the user id.');
}
$loggedUser=AuthUser($data['userId'],'string',array(0));
$photographer=get_user_by('id',$data['userId']);
if(!empty($photographer)){
    $photographer=convert_array($photographer);
    $finalArray['notificationCount']=getNotificationCount($data['userId']);
    $finalArray['userId']=$data['userId'];
    $finalArray['name']=getUserName($data['userId']);
    $finalArray['memberSince']=getMemberSince($data['userId']);
    $finalArray['bannerImage']=getBannerProfile($data['userId']);
    $finalArray['profileImage']=getUserProfile($data['userId']);
    $finalArray['successRate']=getSuccessRate($data['userId']);
    $finalArray['rating']=getUserRating($data['userId']);
    $finalArray['reviews']=getReviewsCount($data['userId']);
    $address=get_user_meta($data['userId'],'address',true);
    if(empty($address)){
       $address=''; 
    }
    $finalArray['address']=$address;
    $finalArray['todaySessionsCount']=getTodaySessionsCount($data['userId']);
    $finalArray['upcomingSessionsCount']=getUpcomingSessionsCount($data['userId']);
    $finalArray['jobRequestsCount']=getJobRequestsCount($data['userId']);
    response(1,$finalArray,'No Error Found.');  
}else{
    response(0,null,'No User Found.');  
}
?>