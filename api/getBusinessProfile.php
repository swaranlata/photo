<?php
require 'config.php';
$data =$_GET;
$error = 1;
if(empty($data['userId'])){
   response(0,null,'Please enter required fields.');
}else{
  $loggedUser=AuthUser($data['userId'],'string',array(0));   
  $hourlyRate=get_user_meta($loggedUser['ID'],'hourlyRate',true);  
  $minHours=get_user_meta($loggedUser['ID'],'minHours',true);  
  $experience=get_user_meta($loggedUser['ID'],'experience',true);  
  $results['userId']=(int)$loggedUser['ID'];
  $results['minHours']= $minHours;
  $results['hourlyRate']=$hourlyRate;
  $results['experience']= $experience;
  response(1,$results,'No Error Found.');  
}
?>