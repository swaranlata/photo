<?php
require 'config.php';
$encoded_data = file_get_contents('php://input');
//$data = json_decode($encoded_data, true);
$data = $_GET;
$data['userId']=(int) $data['userId'];
$data['offset']=(string) $data['offset'];
if(empty($data['userId'])){
  // response(0,array(),'Please enter the user id.'); 
}
if(!empty($data['country'])){
   
}
$location='';
if(!empty($data['city'])){
   $location .=$data['city'];
}
if(!empty($data['country'])){
   $location.= $data['country'];
}
//pr($data);
if($data['offset']==''){
    response(0,array(),'Please enter the offset.');  
}
if(!empty($data['userId'])){
  $loggedInUser=AuthUser($data['userId'],array(),array(1));   
}
if(!empty($data['date']) and !empty($data['time'])){
        $data['date']=inputChangeDate($data['date']);
        $time=explode('-',$data['time']);
        $startTime=$data['date'].' '.$time[0];
        $endTime=$data['date'].' '.$time[1];
        $crnt=time();
        $start=strtotime($startTime);
        $end=strtotime($endTime);
        if($crnt<$start and $end>$start){
           //return true; 
        }else{
          response(0,null,'Please check your date time selection');    
        }   
    
}
if(!empty($data['date']) and empty($data['time'])){
      $data['date']=inputChangeDate($data['date']);
      $crnt=strtotime(date('Y-m-d'));
      $start=strtotime($data['date']);
        if($crnt>$start){
          response(0,null,'Please check your date time selection');   
        }   
}
$photographerList=getAllPhotographerList($data,'app');
if(!empty($photographerList)){
    $array['notificationCount']=getNotificationCount($data['userId']);
    $array['photographerList']=$photographerList;        
    response(1,$array,'No Error Found.');  
}else{
    $array['notificationCount']=getNotificationCount($data['userId']);
    $array['photographerList']=array();  
    response(0,$array,'No Photographer Found.');   
}
?>