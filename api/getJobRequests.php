<?php
require 'config.php';
$encoded_data = file_get_contents('php://input');
global $wpdb;
$data = $_GET;
if(empty($_GET['userId'])){
    response(0,array(),'Please enter the user id.');
}
$loggedInUser=AuthUser($data['userId'],array(),array(0));   
$query='select * from `im_requests` where (`userId`="'.$data['userId'].'" and status in("0","1","5","2")) or (`otherUserId`="'.$data['userId'].'" and status in("0","1","5","2"))';
$results=$wpdb->get_results($query,ARRAY_A);
if(!empty($results)){
    foreach($results as $kk=>$vv){
        $createdDate = strtotime($vv['startDate']);
        $after24hours=date('Y-m-d H:i:s', strtotime('+1 day', $createdDate));
        if(strtotime($after24hours)<time()){
           continue; 
        }
        $requestCount=getEditCount($vv['id']); 
        if($requestCount=="1"){
            if($vv['userId']==$data['userId']){//count is 1 userid is sender Id
              $allRequests[]= $vv['id']; 
            }
        }else{
           $allRequests[]=$vv['id']; 
        }        
    }
    $finalArray=array();
    if(!empty($allRequests)){
        $allRequestsIds=implode('","',$allRequests);
        $queryResults='select * from `im_requests` where `id` in("'.$allRequestsIds.'") order by `modified` desc';
        $results=$wpdb->get_results($queryResults,ARRAY_A);
        if(!empty($results)){
          foreach($results as $k=>$v){
             $finalArray[$k]['requestId']=(int) $v['id']; 
             if($v['userId']==$data['userId']){
                 $userId=$v['otherUserId'];
             }else{
                 $userId=$v['userId'];
             }
             $finalArray[$k]['requestStatus']= (int) "0";
             $finalArray[$k]['userId']=(int) $userId; 
             $finalArray[$k]['name']=getUserName($userId); 
             $finalArray[$k]['profileImage']=getUserProfile($userId); 
             $finalArray[$k]['bannerImage']=getBannerProfile($userId); 
             $finalArray[$k]['memberSince']=getMemberSince($userId); 
             $finalArray[$k]['successRate']=getSuccessRate($userId); 
             $finalArray[$k]['reviewsCount']=getReviewsCount($userId); 
             $finalArray[$k]['rating']=getUserRating($userId); 
             $address=get_user_meta($userId,'address',true);
             if(empty($address)){
                $address='';  
             }
             $finalArray[$k]['address']=$address; 
             $finalArray[$k]['date']=getDateFormat($v['startDate']); 
             $finalArray[$k]['originalTimeSlot']=$v['startTime'].' - '.$v['endTime']; 
             $requestCount=getEditCount($v['id']); 
             if(!empty($requestCount)){
               $getTimeSlot=getModifiedRequestTime($v['id']);               
               $timeSlot='';
               if(!empty($getTimeSlot)){
                   if(!empty($getTimeSlot['startTime'])){
                     $timeSlot= $getTimeSlot['startTime'].' - '.$getTimeSlot['endTime'];   
                   }                  
               }
               $finalArray[$k]['newTimeSlot']=$timeSlot;  
               $userType=get_user_meta($getTimeSlot['userId'],'userType',true);
               $finalArray[$k]['lastModifiedBy']= $userType;                
               $finalArray[$k]['requestStatus']=(int) "3";
             }else{
               $finalArray[$k]['newTimeSlot']=""; 
               $finalArray[$k]['lastModifiedBy']=null;              
             }
             if(!empty($v['status'])){
               $finalArray[$k]['requestStatus']= (int) $v['status'];  
             }
             $finalArray[$k]['reason']=$v['reason'];    
          }  
          response(1,$finalArray,'No Error found.');
        }
        else{
         response(0,array(),'No Requests found.');
        }
        
    }else{
     response(0,array(),'No Requests found.');
    }
}else{
    response(0,array(),'No Requests found.');
}
?>