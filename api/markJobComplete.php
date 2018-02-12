<?php
require 'config.php';
global $wpdb;
$date=strtotime(date('Y-m-d',time()));
$remidate=strtotime(date('Y-m-d 05:00:00',time()));
$weekDate= strtotime(date('Y-m-d', strtotime('+1 Week')));
$getJobRecords=$wpdb->get_results('select * from `im_requests` where  DATE(startDate)="'.date('Y-m-d').'" and `status`="4"',ARRAY_A);
if(!empty($getJobRecords)){
    foreach($getJobRecords as $k=>$v){
        $StartDate = strtotime($v['startDate']);
        $completionDate = strtotime("+7 day", $StartDate);
        $reminderDate = strtotime("+3 day", $StartDate);
        if($date==$completionDate){
          $wpdb->query('update `im_requests` set `status`="6" where `id`="'.$v['id'].'"');  
        }
        $setReminderDate=strtotime(date('Y-m-d 05:00:00',$reminderDate));
        if($remidate==$setReminderDate){
            $getUserType=getUserType($v['userId']);
            if(!empty($getUserType)){
                $traveler=$v['userId'];
                $photo=$v['otherUserId'];
            }else{
                $photo=$v['userId'];
                $traveler=$v['otherUserId'];
            }
            insert_notification($photo,'0',$v['id'],$traveler,'This is to remind you after 7 days of the Photoshoot  job will be marked completed automatically.So you can take action on the Job.','app');            
        }        
    }
}
echo json_encode(array('status'=>'true'));
die();  
?>