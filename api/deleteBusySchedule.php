<?php
require 'config.php';
$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data,true);
if(empty($data['userId'])){
 response(0,null,'Please enter the user id.');
}
$data['dayId']=(string) $data['dayId'];
if($data['dayId']==''){
 response(0,null,'Please enter the day.');
}
if(empty($data['busyScheduleId'])){
 response(0,null,'Please enter the schedule id.');
}
$loggedUser=AuthUser($data['userId'],'string',array(0));
$checkScheduleExist=$wpdb->get_row('select `id` from `im_schedules` where `userId`="'.$data['userId'].'" and `dayId`="'.$data['dayId'].'" and `id`="'.$data['busyScheduleId'].'"',ARRAY_A);
if(!empty($checkScheduleExist)){
  $wpdb->query('delete from `im_schedules` where `id`="'.$data['busyScheduleId'].'"');
  response(1,'Schedule deleted successfully.','No Schedule found for this day.');     
}else{
  response(0,null,'No Schedule found for this day.');  
}
?>