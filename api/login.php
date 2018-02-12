<?php
require 'config.php';
$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data,true);
$error=0;
if(empty($data['email'])){
    $error=1;
}
if(empty($data['password'])){
    $error=1;
}
$data['userType']=(string)$data['userType'];
if($data['userType']==''){
    $error=1;
}else{
    if(!in_array($data['userType'],array(0,1))){
      $error=1;
    }
}
if(empty($error)){
    $data['email']=strtolower($data['email']);
    if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^",$data['email'])){ 
       response(0,null,'Please enter the valid email.');  
    }   
    login($data,'app');
}else{
  response(0,null,'Please enter the required fields.');  
}
?>