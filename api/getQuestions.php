<?php
require 'config.php';
$encoded_data = file_get_contents('php://input');
global $wpdb;
$data = $_GET;
if(empty($data['userId'])){
    response(0,array(),'Please enter the User id.');
}
if(empty($data['jobId'])){
    response(0,array(),'Please enter the Job id.');
}
$loggedInUser=AuthUser($data['userId'],array(),array(0,1));
$getQuestions=getQuestions($data['userId'],$data['jobId']);
if($getQuestions==2){
   response(0,array(),"You can't see the Question/Answer of this job.");  
}
$getUserType=getUserType($data['userId']);
$questions=array();
if(!empty($getQuestions)){
    $getQuestions=convert_array($getQuestions);    
    foreach($getQuestions as $k=>$v){
        $questions[$k]['questionId']=(int) $v['ID'];
        $questions[$k]['question']=$v['post_content'];        
        $questions[$k]['answer']=getAnswer($data['jobId'],$v['ID'],$data['userId']); 
    } 
    response(1,$questions,"No Error Found.");  
}else{
  response(0,array(),"No Questions Found.");   
}
?>