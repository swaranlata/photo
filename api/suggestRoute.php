<?php
require 'config.php';
$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data, true);
if(empty($data['jobId'])){
  response(0,null,'Please enter the job id.');  
}
if(empty($data['userId'])){
  response(0,null,'Please enter the user id.');  
}
if(empty($data['suggestRoute'])){
  response(0,null,'Please enter the route.');  
}
$loggedInUser=AuthUser($data['userId'],'string',array(0));
$suggestRoute=suggestRoute($data['jobId'],$data['userId'],$data['suggestRoute'],'app');
 if(!empty($suggestRoute)){         
   response(1,'Route suggested successfully.','No Error Found.');    
  }else{
      response(0,null,'Error Found.');    
  } 

?>