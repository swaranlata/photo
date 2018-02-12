<?php
require 'config.php';
$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data, true);
global $wpdb;
if(empty($data['userId'])){
 response(0,null,'Please enter the user id.');
}
if(empty($data['otherUserId'])){
 response(0,null,'Please enter the other user id.');
}
if(empty($data['rateValue'])){
  response(0,null,'Please enter the rating value.');  
}
if(empty($data['jobId'])){
  response(0,null,'Please enter the job id.');  
}
if(empty($data['comment'])){
  response(0,null,'Please enter some feedback.');  
}
if($data['userId']==$data['otherUserId']){
    response(0,null,"You can't add review for yourself."); 
    
}
$loggedInUser=AuthUser($data['userId'],'string',array(0,1));
$userType=get_user_meta($data['userId'],'userType',true);
if(!empty($userType)){//traveller
   $getRequest=$wpdb->get_row('select `id`,`status` from  `im_requests` where (`id`="'.$data['jobId'].'" and`userId`="'.$data['userId'].'" and `otherUserId`="'.$data['otherUserId'].'" and `status` in("4","6")) or (`id`="'.$data['jobId'].'" and`userId`="'.$data['otherUserId'].'" and `otherUserId`="'.$data['userId'].'"  and `status` in("4","6"))',ARRAY_A); 
}else{
   $getRequest=$wpdb->get_row('select `id`,`status` from  `im_requests` where (`id`="'.$data['jobId'].'" and`userId`="'.$data['userId'].'" and `otherUserId`="'.$data['otherUserId'].'" and `status`="6") or (`id`="'.$data['jobId'].'" and`userId`="'.$data['otherUserId'].'" and `otherUserId`="'.$data['userId'].'"  and `status`="6")',ARRAY_A); 
}
if(!empty($getRequest)){
   if(!empty($userType)){//traveller
        if($getRequest['status']!='6'){
            $senderName=getUserName($data['userId']);
            $qy='select * from `im_reviews` where `userId`="'.$data['userId'].'" and  `requestId`="'.$getRequest['id'].'"';
            $checkRatingAdded=$wpdb->get_row($qy,ARRAY_A);
            if(!empty($checkRatingAdded)){
              $wpdb->query('update `im_reviews` set `created`="'.date('Y-m-d H:i:s').'", `comments`="'.$data['comment'].'" where `id`="'.$checkRatingAdded['id'].'"');  
              insert_notification($data['userId'],'1',$data['jobId'],$data['otherUserId'],'Rating has been added by '.$senderName,'app'); 
              response(1,"Reviews added successfully.",'No Error Found.');   
            }else{
              $senderName=getUserName($data['userId']);
              $addRating = addRating($data);   
              insert_notification($data['userId'],'1',$data['jobId'],$data['otherUserId'],'Rating has been added by '.$senderName,'app'); 
              response(1,"Reviews added successfully.",'No Error Found.');   
            }       
        }else{
            $senderName=getUserName($data['userId']);
            $addRating = addRating($data);    
            if(!empty($addRating)){
              insert_notification($data['userId'],'1',$data['jobId'],$data['otherUserId'],'Rating has been added by '.$senderName,'app'); 
              response(1,"Reviews added successfully.",'No Error Found.');    
            }else{      
              response(0,null,'You have already added reviews for this Job.');            
            }          
        }       
    }else{//photographer
        $senderName=getUserName($data['userId']);
        $addRating = addRating($data);    
        if(!empty($addRating)){
          insert_notification($data['userId'],'1',$data['jobId'],$data['otherUserId'],'Rating has been added by '.$senderName,'app'); 
          response(1,"Reviews added successfully.",'No Error Found.');    
        }else{      
          response(0,null,'You have already added reviews for this Job.');            
        } 
    }   
      
}else{
    response(0,null,"You can't add reviews for this job.");  
}


?>