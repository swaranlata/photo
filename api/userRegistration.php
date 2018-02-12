<?php
require 'config.php';
$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data, true);
$error = 1;
$data=$_REQUEST;
if(empty($data['firstName'])){
   $error = 0; 
}
if(empty($data['lastName'])){
   //$error = 0; 
}
$data['userType']=(string) $data['userType'];
if($data['userType']==''){
    $error = 0; 
}else{
    if(!in_array($data['userType'],array(0,1))){
        $error = 0;    
    }
}
if(empty($data['email'])){
   $error = 0; 
}
if(empty($data['gender'])){
   //$error = 0; 
}
if(empty($data['password'])){
   $error = 0; 
} 
if(!empty($error)){
     $data['name']=$data['firstName'].' '.$data['lastName'];
     if(!empty($data['facebookId']) and  !empty($data['email'])){//Facebook Signup or Login
         CheckValidEmail($data['email']);
         loginWithFacebook($data,'app');
        /* $rows=$wpdb->get_row('select * from `im_usermeta` where  `meta_key`="facebookId" and `meta_value`="'.$data['facebookId'].'"');
          if(!empty($rows)){
                $rows=convert_array($rows);                 
                $user_id=$rows['user_id'];
                $getUserType=get_user_meta($user_id,'userType',true);
                if($getUserType!=$data['userType']){
                  response(0, null, 'Please check your entered login credentials.'); 
                }
                if(!empty($data['deviceToken'])){
                    update_user_meta($user_id, "deviceToken", $data['deviceToken']);  
                }
                if(!empty($data['deviceType'])){
                    update_user_meta($user_id, "deviceType", $data['deviceType']);  
                } 
                if(!empty($data['profileImage'])){
                  update_user_meta($user_id, "user_image",$data['profileImage']);  
                }
                $result['userId']="$user_id";
                $result['firstName']=get_user_meta($user_id,'firstName',true);
                $result['lastName']=get_user_meta($user_id,'lastName',true);
                $result['email']=$data['email'];
                $result['gender']=getGender($user_id);
                $profile_image=getUserProfile($user_id);
                $result['profileImage']=$profile_image;
                $result['pushNotification']=isEnablePushNotification($user_id,'push');
                $result['emailNotification']=isEnablePushNotification($user_id,'email');
                $result['contactNo']=get_user_meta($user_id,'contactNo',true);
                $result['address']=get_user_meta($user_id,'address',true);
                $result['bio']=get_user_meta($user_id,'bio',true);
                $result['lat']=get_user_meta($user_id,'lat',true);
                $result['long']=get_user_meta($user_id,'long',true);
                $result['dob']=get_user_meta($user_id,'dob',true);
                $result['bannerImage']=getBannerProfile($user_id);
                response(1,$result,'No Error Found.');   
           }else{
                if(email_exists($data['email'])) {
                    $user_id=email_exists($data['email']);
                    $getUserType=get_user_meta($user_id,'userType',true);
                    if($getUserType!=$data['userType']){
                      response(0, null, 'Please check your entered login credentials.'); 
                    }
                    $userData=get_user_by('id',$user_id);
                    $userData=convert_array($userData);
                    update_user_meta($user_id, "facebookId", $data['facebookId']);
                    if(!empty($data['deviceToken'])){
                     update_user_meta($user_id, "deviceToken", $data['deviceToken']);  
                    }
                    if(!empty($data['deviceType'])){
                     update_user_meta($user_id, "deviceType", $data['deviceType']);  
                    } 
                    if(!empty($data['profileImage'])){
                      update_user_meta($user_id, "user_image",$data['profileImage']);  
                    }  
                    $profile_image=getUserProfile($user_id);
                    $result['userId']="$user_id";
                    $result['firstName']=get_user_meta($user_id,'firstName',true);
                    $result['lastName']=get_user_meta($user_id,'lastName',true);
                    $result['email']=$data['email'];
                    $result['gender']=getGender($user_id);
                    $result['profileImage']=$profile_image;
                    $result['pushNotification']=isEnablePushNotification($user_id,'push');
                    $result['emailNotification']=isEnablePushNotification($user_id,'email');
                    $result['contactNo']=get_user_meta($user_id,'contactNo',true);
                    $result['address']=get_user_meta($user_id,'address',true);
                    $result['bio']=get_user_meta($user_id,'bio',true);
                    $result['lat']=get_user_meta($user_id,'lat',true);
                    $result['long']=get_user_meta($user_id,'long',true);
                    $result['dob']=get_user_meta($user_id,'dob',true);
                    $result['bannerImage']=getBannerProfile($user_id);
                    response(1,$result,'No Error Found.');                  
                }
                else{
                    $username = strtolower(substr($data['name'], 0, 5)) . '_' . randomString(4);
                    $user_id = wp_create_user($username, $data['password'], $data['email']);
                    wp_update_user(array(
                         'ID' => $user_id,
                         'display_name' => $data['name'],
                    ));
                    if(!empty($data['userType'])){//Traveler
                        $u = new WP_User($user_id);
                        $u->remove_role('subscriber');
                        $u->set_role('traveler');                        
                    }else{//0-photographer
                         $u = new WP_User($user_id);
                         $u->remove_role('subscriber');
                         $u->set_role('photographer');                         
                    }
                    update_user_meta($user_id, "user_image",$data['profileImage']);                    
                    update_user_meta($user_id, "firstName", $data['firstName']);
                    update_user_meta($user_id, "userType", $data['userType']);
                    update_user_meta($user_id, "lastName", $data['lastName']);
                    update_user_meta($user_id, "deviceToken", $data['deviceToken']);
                    update_user_meta($user_id, "deviceType", $data['deviceType']);
                    update_user_meta($user_id, "facebookId", $data['facebookId']);
                     update_user_meta($user_id, "first_name", $data['firstName']);
                    update_user_meta($user_id, "last_name", $data['lastName']);
                    update_user_meta($user_id, "googleId", '');
                    update_user_meta($user_id, "dob",$data['dob']);
                    update_user_meta($user_id, "gender", $data['gender']);
                    update_user_meta($user_id, "pushNotification",1);   
                    update_user_meta($user_id, "emailNotification",1);
                    update_user_meta($user_id, "locationNotification",1);
                    update_user_meta($user_id, "bio",'');
                    update_user_meta($user_id, "bannerImage",'');
                    update_user_meta($user_id, "contactNo",'');
                    update_user_meta($user_id, "address","");
                    update_user_meta($user_id, "lat","");
                    update_user_meta($user_id, "long","");
                    $result['userId']="$user_id";
                    $result['firstName']=get_user_meta($user_id,'firstName',true);
                    $result['lastName']=get_user_meta($user_id,'lastName',true);
                    $result['email']=$data['email'];
                    $result['gender']=getGender($user_id);
                    $profile_image=getUserProfile($user_id);
                    $result['profileImage']=$profile_image;
                    $result['pushNotification']=isEnablePushNotification($user_id,'push');
                    $result['emailNotification']=isEnablePushNotification($user_id,'email');
                    $result['contactNo']=get_user_meta($user_id,'contactNo',true);
                    $result['address']=get_user_meta($user_id,'address',true);
                    $result['lat']=get_user_meta($user_id,'lat',true);
                    $result['long']=get_user_meta($user_id,'long',true);
                    $result['dob']=get_user_meta($user_id,'dob',true);
                    $result['bio']=get_user_meta($user_id,'bio',true);
                    $result['bannerImage']=getBannerProfile($user_id);
                    response(1,$result,'No Error Found.');        
                } 
           }     */  
     }
     elseif(!empty($data['googleId']) and  !empty($data['email'])){//Google Sign up and login
         CheckValidEmail($data['email']);
         loginWithGoogle($data,'app');
       /*  $rows=$wpdb->get_row('select * from `im_usermeta` where  `meta_key`="googleId" and `meta_value`="'.$data['googleId'].'"');
          if(!empty($rows)){
                $rows=convert_array($rows);
                $user_id=$rows['user_id'];
                $getUserType=get_user_meta($user_id,'userType',true);
                if($getUserType!=$data['userType']){
                  response(0, null, 'Please check your entered login credentials.'); 
                }
                if(!empty($data['deviceToken'])){
                update_user_meta($user_id, "deviceToken", $data['deviceToken']);  
                }
                if(!empty($data['deviceType'])){
                update_user_meta($user_id, "deviceType", $data['deviceType']);  
                } 
                if(!empty($data['profileImage'])){
                  update_user_meta($user_id, "user_image",$data['profileImage']);  
                }  
                $result['userId']="$user_id";
                $result['firstName']=get_user_meta($user_id,'firstName',true);
                $result['lastName']=get_user_meta($user_id,'lastName',true);
                $result['email']=$data['email'];
                $result['gender']=getGender($user_id);
                $profile_image=getUserProfile($user_id);
                $result['profileImage']=$profile_image;
                $result['pushNotification']=isEnablePushNotification($user_id);
                $result['contactNo']=get_user_meta($user_id,'contactNo',true);
                $result['address']=get_user_meta($user_id,'address',true);
                $result['bio']=get_user_meta($user_id,'bio',true);
                $result['lat']=get_user_meta($user_id,'lat',true);
                $result['long']=get_user_meta($user_id,'long',true);
                $result['dob']=get_user_meta($user_id,'dob',true);
                $result['bannerImage']=getBannerProfile($user_id);
                response(1,$result,'No Error Found.');   
           }
         else{
                if(email_exists($data['email'])) {
                    $user_id=email_exists($data['email']);
                    $userData=get_user_by('id',$user_id);
                    $getUserType=get_user_meta($user_id,'userType',true);
                    if($getUserType!=$data['userType']){
                      response(0, null, 'Please check your entered login credentials.'); 
                    }
                    $userData=convert_array($userData);
                    update_user_meta($user_id, "googleId", $data['googleId']);
                    $result['userId']="$user_id";
                    $result['firstName']=get_user_meta($user_id,'firstName',true);
                    $result['lastName']=get_user_meta($user_id,'lastName',true);
                    $result['email']=$data['email'];
                    $result['gender']=getGender($user_id);
                    if(!empty($data['deviceToken'])){
                      update_user_meta($user_id, "deviceToken", $data['deviceToken']);  
                    }
                    if(!empty($data['deviceType'])){
                      update_user_meta($user_id, "deviceType", $data['deviceType']);  
                    }
                    if(!empty($data['profileImage'])){
                      update_user_meta($user_id, "user_image",$data['profileImage']);  
                    }                    
                    $profile_image=getUserProfile($user_id);
                    $result['profileImage']=$profile_image;
                    $result['pushNotification']=isEnablePushNotification($user_id,'push');
                    $result['emailNotification']=isEnablePushNotification($user_id,'email');
                    $result['contactNo']=get_user_meta($user_id,'contactNo',true);
                    $result['address']=get_user_meta($user_id,'address',true);
                    $result['bio']=get_user_meta($user_id,'bio',true);
                    $result['lat']=get_user_meta($user_id,'lat',true);
                    $result['long']=get_user_meta($user_id,'long',true);
                    $result['dob']=get_user_meta($user_id,'dob',true);
                    $result['bannerImage']=getBannerProfile($user_id);
                    response(1,$result,'No Error Found.');                  
                }
                else{
                    $username = strtolower(substr($data['name'], 0, 5)) . '_' . randomString(4);
                    $user_id = wp_create_user($username, $data['password'], $data['email']);
                    wp_update_user(array(
                         'ID' => $user_id,
                         'display_name' => $data['name'],
                    ));
                    if(!empty($data['userType'])){//Traveler
                        $u = new WP_User($user_id);
                        $u->remove_role('subscriber');
                        $u->set_role('traveler');                        
                    }else{//0-photographer
                         $u = new WP_User($user_id);
                        $u->remove_role('subscriber');
                         $u->set_role('photographer');                         
                    }
                    update_user_meta($user_id, "user_image",$data['profileImage']);                    
                    update_user_meta($user_id, "firstName", $data['firstName']);
                    update_user_meta($user_id, "userType", $data['userType']);
                    update_user_meta($user_id, "lastName", $data['lastName']);
                    update_user_meta($user_id, "first_name", $data['firstName']);
                    update_user_meta($user_id, "last_name", $data['lastName']);
                    update_user_meta($user_id, "deviceToken", $data['deviceToken']);
                    update_user_meta($user_id, "deviceType", $data['deviceType']);
                    update_user_meta($user_id, "facebookId",'');
                    update_user_meta($user_id, "googleId", $data['googleId']);
                    update_user_meta($user_id, "dob",$data['dob']);
                    update_user_meta($user_id, "gender", $data['gender']);
                    update_user_meta($user_id, "pushNotification",1);      
                    update_user_meta($user_id, "emailNotification",1);
                    update_user_meta($user_id, "locationNotification",1);
                    update_user_meta($user_id, "address","");
                    update_user_meta($user_id, "bio",'');
                    update_user_meta($user_id, "bannerImage",'');
                    update_user_meta($user_id, "lat","");
                    update_user_meta($user_id, "long","");
                    update_user_meta($user_id, "contactNo",'');
                    $result['userId']="$user_id";
                    $result['firstName']=get_user_meta($user_id,'firstName',true);
                    $result['lastName']=get_user_meta($user_id,'lastName',true);
                    $result['email']=$data['email'];
                    $result['gender']=getGender($user_id);
                    $profile_image=getUserProfile($user_id);
                    $result['profileImage']=$profile_image;
                    $result['pushNotification']=isEnablePushNotification($user_id,'push');
                    $result['emailNotification']=isEnablePushNotification($user_id,'email');
                    $result['contactNo']=get_user_meta($user_id,'contactNo',true);
                    $result['address']=get_user_meta($user_id,'address',true);
                    $result['bio']=get_user_meta($user_id,'bio',true);
                    $result['lat']=get_user_meta($user_id,'lat',true);
                    $result['long']=get_user_meta($user_id,'long',true);
                    $result['dob']=get_user_meta($user_id,'dob',true);
                    $result['bannerImage']=getBannerProfile($user_id);
                    response(1,$result,'No Error Found.');        
                } 
           }  
         */
     }else{//simple login
        CheckValidEmail($data['email']);
        $user_id=signup($data,'app');
        $result['userId']="$user_id";
        $result['firstName']=get_user_meta($user_id,'firstName',true);
        $result['lastName']=get_user_meta($user_id,'lastName',true);
        $result['email']=$data['email'];
        $result['gender']=getGender($user_id);
        $profile_image=getUserProfile($user_id);
        $result['profileImage']=$profile_image;
        $result['pushNotification']=isEnablePushNotification($user_id,'push');
        $result['emailNotification']=isEnablePushNotification($user_id,'email');
        $result['locationNotification']=isEnablePushNotification($user_id,'location');
        $result['contactNo']=get_user_meta($user_id,'contactNo',true);
        $result['address']=get_user_meta($user_id,'address',true);
        $result['bio']=get_user_meta($user_id,'bio',true);
        $result['lat']=get_user_meta($user_id,'lat',true);
        $result['long']=get_user_meta($user_id,'long',true);
        $result['dob']=get_user_meta($user_id,'dob',true);
        $result['bannerImage']=getBannerProfile($user_id);    
        /* if(!empty($data['userType'])){
            response(1,$result,'No Error Found.'); 
         }else{
            response(0,null,'You are successfully registered with the website and Your account is awaited for admin approval.');  
         }*/
          response(1,$result,'No Error Found.'); 
      }
}else{
   response(0, null, 'Please enter required fields.'); 
}
?>