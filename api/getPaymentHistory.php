<?php
require 'config.php';
$encoded_data = file_get_contents('php://input');
$data = $_GET;
global $wpdb;
$data['userId']=(int) $data['userId'];
if(empty($data['userId'])){
 response(0,array(),'Please enter the user id.');   
}
$loggedInUser=AuthUser($data['userId'],array(),array(0,1));
$getPaymentHistoryWorking=getPaymentHistory($data['userId'],1);//working
$getPaymentHistoryComplete=getPaymentHistory($data['userId'],0);//complete
$working=array();
$complete=array();
$temp=0;
if(!empty($getPaymentHistoryWorking)){
    $temp=1;
    foreach($getPaymentHistoryWorking as $k=>$v){
        $working[$k]['jobId']=(int) $v['id'];
        if($v['userId']==$data['userId']){
            $userId=$v['otherUserId'];
        }else{
            $userId=$v['userId'];
        }
        $working[$k]['userId']=(int)$userId;
        $working[$k]['name']=getUserName($userId);
        $working[$k]['profileImage']=getUserProfile($userId);
        $working[$k]['rating']=getUserRating($userId);
        $working[$k]['date']=date('d-M-Y',strtotime($v['startDate']));
        $working[$k]['time']=date('h:i:s A',strtotime($v['startTime']));
        $address=get_user_meta($userId,'address',true);
        if(empty($address)){
           $address=''; 
        }
        $working[$k]['address']=$address;
        $working[$k]['status']=$v['status'];
        $working[$k]['isFeedback']=isFeedback($v['id'],$data['userId']);
        $working[$k]['amount']="500";
        $working[$k]['transactionId']="#43564264256";
    }
}
if(!empty($getPaymentHistoryComplete)){
    $temp=1;
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
        $complete[$k]['date']=date('d-M-Y',strtotime($v['startDate']));
        $complete[$k]['time']=date('h:i:s A',strtotime($v['startTime']));
        $address=get_user_meta($userId,'address',true);
        if(empty($address)){
           $address=''; 
        }
        $complete[$k]['address']=$address;
        $complete[$k]['status']=$v['status'];
        $complete[$k]['isFeedback']=isFeedback($v['id'],$data['userId']);
        $complete[$k]['amount']="500";
        $complete[$k]['transactionId']="#43564264256";
    }
}
if(!empty($temp)){
  $results['working']=$working;
  $results['complete']=$complete;  
  response(1,$results,'No Error Found.');
}else{
  $results['working']=$working;
  $results['complete']=$complete;  
  response(0,$results,'No Jobs Found.');
}



?>