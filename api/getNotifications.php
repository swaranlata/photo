<?php
require 'config.php';
$encoded_data = file_get_contents('php://input');
$data = $_GET;
global $wpdb;
if(empty($data['userId'])){
 response(0,array(),'Please enter the user id.');   
}
$loggedInUser=AuthUser($data['userId'],array(),array(0,1));
$query='select * from `im_notifications` where `opponentId`="'.$data['userId'].'" order by `created` desc';
$results=$wpdb->get_results($query,ARRAY_A);
$notifications=array();
if(!empty($results)){
    foreach($results as $k=>$v){
        $notifications[$k]['id']=$v['id'];
        $notifications[$k]['userId']=$v['userId'];
        $notifications[$k]['name']=getUserName($v['userId']);
        $dataTi=explode('Date :',strip_tags($v['title']));
        $ti='';
        if(isset($dataTi[0])){
          $ti=$dataTi[0];  
        }
        $notifications[$k]['title']=$ti;
        $notifications[$k]['profileImage']=getUserProfile($v['userId']);
        $notifications[$k]['isRead']=$v['status'];
        $notifications[$k]['dateTime']=getTiming(strtotime($v['created']));
    }
}
if(!empty($notifications)){
   response(1,$notifications,'No Error Found.');   
}else{
  response(0,array(),'No Notifications found.');    
}
?>
