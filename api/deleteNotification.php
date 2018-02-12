<?php
require 'config.php';
$encoded_data = file_get_contents('php://input');
$request=$_REQUEST;
if(isset($request['type']) and $request['type']=='web'){
  $data = $_REQUEST; 
}else{
  $data = json_decode($encoded_data, true);
}
global $wpdb;
if(empty($data['userId'])){
 response(0,null,'Please enter the user id.');
}
if(empty($data['notificationId'])){
 response(0,null,'Please enter the notification id.');
}
$loggedInUser=AuthUser($data['userId'],'string',array(0,1));
$query='select * from `im_notifications` where `id`="'.$data['notificationId'].'" and `opponentId`="'.$data['userId'].'"';
$res=$wpdb->get_row($query,ARRAY_A);
if(!empty($res)){
   $query=$wpdb->query('delete from `im_notifications` where `id`="'.$res['id'].'"');
    if(isset($data['type']) and $data['type']=='web'){
      $count=getNotificationCount($data['userId']);
      response(1,'Notification deleted successfully.',$count);  
    }else{
      response(1,'Notification deleted successfully.','No Error Found.');
    }   
}else{
   response(0,null,'No Notification found to delete.'); 
}

?>