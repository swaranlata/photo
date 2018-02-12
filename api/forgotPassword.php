<?php
require 'config.php';
$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data,true);
$error=0;
if(empty($data['email'])){
    $error=1;
}
if(!empty($error)){
   response(0,null,'Please enter the required fields.'); 
}else{
    CheckValidEmail($data['email']); 
    $user=get_user_by('email',$data['email']);
    if(!empty($user)){
        $user=convert_array($user);
        $facebookId= get_user_meta($user['ID'],'facebookId',true);
        $googleId= get_user_meta($user['ID'],'googleId',true);
        if(!empty($facebookId)){
          response(0,null,'You have loggedIn from social media.');     
        }
        if(!empty($googleId)){
          response(0,null,'You have loggedIn from social media.');      
        }
        $password=randomString(8);
        wp_set_password($password,$user['ID']);  
        $getFirstName=get_user_meta($user['ID'],'firstName',true);
        $getLastName=get_user_meta($user['ID'],'lastName',true);
        $to = $data['email'];
        $subject = 'Password Update';
        $message='You have requested for password change,your new password has been updated, <br> New Password : '.$password.'<br> Login with your new password.';
        $emailTemplate=file_get_contents(get_stylesheet_directory_uri().'/email-template.php');
        $emailTemplate=str_replace('[NAME]',$getFirstName.' '.$getLastName,$emailTemplate);
        $emailTemplate=str_replace('[MESSAGE]',$message,$emailTemplate);
        send_email($to,'New Password Updation',$emailTemplate);  
        response(1,1,'No Error Found.');     
    }else{
        response(0,null,'Email is not registered with us.');    
    }
 }
?>