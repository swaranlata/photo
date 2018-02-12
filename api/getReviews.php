<?php
require 'config.php';
$encoded_data = file_get_contents('php://input');
global $wpdb;
$data = $_GET;
if(empty($_GET['userId'])){
    response(0,array(),'Please enter the user id.');
}
$loggedInUser=AuthUser($data['userId'],array(),array(0,1));
$getReviews=getReviews($data['userId']);
$reviews=array();
if(!empty($getReviews)){
  foreach($getReviews as $k=>$vv){
    $reviews[$k]['reviewId']=(int) $vv['id'];  
    $reviews[$k]['rating']=$vv['rateValue'];  
    $reviews[$k]['name']=getUserName($vv['userId']);  
    $reviews[$k]['userId']=(int) $vv['userId'];  
    $reviews[$k]['profileImage']=getUserProfile($vv['userId']);  
    $reviews[$k]['description']=$vv['comments'];  
    $reviews[$k]['dateTime']=getTiming(strtotime($vv['created'])).' ago';  
  }  
}
if(!empty($reviews)){
   response(1,$reviews,'No Error found.');  
}else{
   response(0,array(),'No Review(s) found.'); 
}
?>