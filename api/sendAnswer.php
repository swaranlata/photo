<?php
require 'config.php';
$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data, true);
if(empty($data['userId'])){
   response(0,null,'Please enter the user id.'); 
}
if(empty($data['jobId'])){
   response(0,null,'Please enter the Job id.'); 
}
if(empty($data['answerArray'])){
   response(0,null,'Please enter the answer.'); 
}
$loggedInUser=AuthUser($data['userId'],'string',array(1));
$temp=0;
if(!empty($data['answerArray'])){
    foreach($data['answerArray'] as $kk=>$vv){
       $checkQuestionExists=get_posts(array(
        'post_type'=>'questions',
        'include'=>$vv['questionId']
        ));
        if(empty($checkQuestionExists)){
          $temp=1;  
        }      
    }
}
if(!empty($temp)){
   response(0,null,'Please check your questions.');  
}
$select='select * from `im_requests` where `id`="'.$data['jobId'].'"';
$res=$wpdb->get_row($select,ARRAY_A);
$otherUserId='';
if(!empty($res)){
    if($res['userId']==$data['userId']){
      $otherUserId=$res['otherUserId'];  
    }else{
      $otherUserId=$res['userId'];   
    }
}
$sendAnswer=sendAnswer($data['userId'],$otherUserId,$data['jobId'],$data['answerArray']);
if(!empty($sendAnswer)){
  response(1,'Answer submitted successfully.','No Error Found.');   
}else{
  response(0,null,'You have already answered the questions for this job.');   
}
?>