<?php
require 'config.php';
$encoded_data = file_get_contents('php://input');
$data = $_GET;
$error = 1;
if(empty($data['userId'])){
   $error = 0; 
}
if($data['type']==''){
   $error = 0; 
}else{
    if(!in_array($data['type'],array(0,1,2))){//0-email,1-pushnotification, 2- location
        $error = 0; 
    }
}
if(!empty($error)){
    $loggedUser=AuthUser($data['userId'],'string',array(0,1)); 
    if($data['type']==1){
        $getNotification=get_user_meta($data['userId'],'pushNotification',true); 
        if(!empty($getNotification)){
           $status='0'; 
        }else{
           $status='1';   
        }
        update_user_meta($data['userId'],'pushNotification',$status);        
    }elseif($data['type']==2){
        $getNotification=get_user_meta($data['userId'],'locationNotification',true); 
        if(!empty($getNotification)){
           $status='0'; 
        }else{
           $status='1';   
        }
        update_user_meta($data['userId'],'locationNotification',$status);               
    }else{
       $getNotification=get_user_meta($data['userId'],'emailNotification',true); 
        if(!empty($getNotification)){
           $status='0'; 
        }else{
           $status='1';   
        }
        update_user_meta($data['userId'],'emailNotification',$status); 
    }
   response(1, $status, 'No Error found.');  
}else{
   response(0, null, 'Please enter required fields.');    
}
?>