<?php
require 'config.php';
$encoded_data = file_get_contents('php://input');
$data = $_GET;
global $wpdb;
$data['userId']= $data['userId'];
if(empty($data['userId'])){
 response(0,array(),'Please enter the user id.');   
}
$loggedInUser=AuthUser($data['userId'],array(),array(0,1));
$getPaymentHistoryComplete=getPaymentHistory($data['userId'],0);//complete
if(!empty($getPaymentHistoryComplete)){
    foreach($getPaymentHistoryComplete as $k=>$v){
        $complete[$k]['jobId']=(int)$v['id'];
        if($v['userId']==$data['userId']){
            $userId=$v['otherUserId'];
        }else{
            $userId=$v['userId'];
        }
        $complete[$k]['userId']=(int)$userId;
        $complete[$k]['name']=getUserName($userId);
        $complete[$k]['profileImage']=getUserProfile($userId);
        $complete[$k]['rating']=getUserRating($userId);
        $address=get_user_meta($userId,'address',true);
        if(empty($address)){
           $address=''; 
        }
        $complete[$k]['address']=$address;
        $complete[$k]['status']=$v['status'];
        $complete[$k]['link']=getJobLink($v['id']);
    }    
}
$getWorkingJobs=$wpdb->get_results('select `requestId` from `im_shootlinks` where (`userId`="'.$data['userId'].'" or `otherUserId`="'.$data['userId'].'") and `link`!=""',ARRAY_A);
$workingWithLink=array();
$links='';
if(!empty($getWorkingJobs)){
    foreach($getWorkingJobs as $k=>$v){
       $workingWithLink[]=$v['requestId']; 
    }
    $links=implode('","',$workingWithLink);
}
    $counter=count($complete);
if(!empty($links)){
   $finalJobs=$wpdb->get_results('select * from `im_requests` where `status`="4" and `id` in("'.$links.'")',ARRAY_A); 
   if(!empty($finalJobs)){
    $temp=1;
    foreach($finalJobs as $key=>$v){
        $k=$counter;
        $complete[$k]['jobId']=(int)$v['id'];
        if($v['userId']==$data['userId']){
            $userId=$v['otherUserId'];
        }else{
            $userId=$v['userId'];
        }
        $complete[$k]['userId']=(int)$userId;
        $complete[$k]['name']=getUserName($userId);
        $complete[$k]['profileImage']=getUserProfile($userId);
        $complete[$k]['rating']=getUserRating($userId);
        $address=get_user_meta($userId,'address',true);
        if(empty($address)){
           $address=''; 
        }
        $complete[$k]['address']=$address;
        $complete[$k]['status']=$v['status'];
        $complete[$k]['link']=getJobLink($v['id']);
        $k++;
    }    
}    
}
if(!empty($complete)){
  response(1,$complete,'No Error Found.');  
}else{
  response(0,array(),'No users found.');  
}








?>