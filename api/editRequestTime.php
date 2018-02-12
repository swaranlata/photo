<?php
require 'config.php';
$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data, true);
if(empty($data['userId'])){
 response(0,null,'Please enter the user id.');
}
if(empty($data['requestId'])){
  response(0,null,'Please enter the request id.');  
}
if(empty($data['startTime'])){
  //response(0,null,'Please enter the start time.');  
}
if(empty($data['endTime'])){
  //response(0,null,'Please enter the end time.');    
}
$loggedInUser=AuthUser($data['userId'],array(),array(0,1));
$getRequestDetails=$wpdb->get_row('select `id`,`startDate`,`startTime`,`endTime`,`userId`,`otherUserId` from `im_requests` where `id`="'.$data['requestId'].'" and `otherUserId`="'.$data['userId'].'" and `status`="0"',ARRAY_A);
if(!empty($getRequestDetails)){
    $getAddedRecords=$wpdb->get_row('select * from `im_editcount` where `requestId`="'.$getRequestDetails['id'].'"',ARRAY_A);
    if(empty($data['startTime']) and empty($data['endTime'])){
        $getAddedRecords=$wpdb->get_row('select * from `im_editcount` where `requestId`="'.$getRequestDetails['id'].'"',ARRAY_A);
        if(!empty($getAddedRecords)){
            if($getRequestDetails['userId']==$data['userId']){
              $receiver=$getRequestDetails['otherUserId'];
            }else{
              $receiver=$getRequestDetails['userId'];
            }   
          $wpdb->query('update `im_requests` set `userId`="'.$getRequestDetails['otherUserId'].'",`otherUserId`="'.$getRequestDetails['userId'].'",`modified`="'.date('Y-m-d H:i:s').'" where `id`="'.$getRequestDetails['id'].'"');
           $clearTimeslot=$wpdb->query('update `im_editcount` set `startTime`="",`endTime`="" where `requestId`="'.$getRequestDetails['id'].'"'); 
           $wpdb->query('insert into `im_editcount`(`requestId`,`userId`,`startTime`,`endTime`) values("'.$getRequestDetails['id'].'","'.$data['userId'].'","","")');
        }  
        $senderName=getUserName($data['userId']);
        insert_notification($data['userId'],'0',$getRequestDetails['id'],$receiver,$senderName.' requested for original time.','app'); 
        response(1,'Original time requested successfully.','No Error Found.');
    }else{
       if(!empty($getAddedRecords)){
          response(0,null,"You can't suggest time for this job.");
       }  
    }
    if($getRequestDetails['userId']==$data['userId']){
      $receiver=$getRequestDetails['otherUserId'];
    }else{
      $receiver=$getRequestDetails['userId'];
    }   
    
    $startDate=$getRequestDetails['startDate'].' '.$data['startTime'];
    $endDate=$getRequestDetails['startDate'].' '.$data['endTime'];
    $checkTime=checkDateTimeSelectionPattern($startDate,$endDate);
    if(empty($checkTime)){
      response(0,null,"Please check your selected datetime.");   
    }
    $editCount= getEditCount($getRequestDetails['id']);
    if($editCount==2){
       response(0,null,"You can't suggest time for this request.");  
    }
    if($getRequestDetails['startTime']==$data['startTime'] and $getRequestDetails['endTime']==$data['endTime'] ){
       response(0,null,'Request have already this time slot.');      
    }
    if($getRequestDetails['userId']==$data['userId']){
        $userId=$getRequestDetails['otherUserId'];
    }else{
        $userId=$getRequestDetails['userId'];
    }
    $wpdb->query('update `im_requests` set  `userId`="'.$data['userId'].'",`otherUserId`="'.$userId.'"  where `id`="'.$getRequestDetails['id'].'"');
    $wpdb->query('insert into `im_editcount`(`requestId`,`userId`,`startTime`,`endTime`) values("'.$getRequestDetails['id'].'","'.$data['userId'].'","'.$data['startTime'].'","'.$data['endTime'].'")');
    $senderName=getUserName($data['userId']);
    insert_notification($data['userId'],'0',$getRequestDetails['id'],$receiver,$senderName.' suggested new time.','app');  
    response(1,'Suggested time successfully.','No Error Found.');
}else{
  response(0,null,'No Request Found to suggest time.');    
}




?>