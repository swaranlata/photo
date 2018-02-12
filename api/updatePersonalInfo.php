<?php
require 'config.php';
$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data,true);
$data = $_REQUEST;
$error=0;
if(empty($data['userId'])){
    $error=1;
}
if(empty($data['firstName'])){
    $error=1;
}
if(empty($data['address'])){
    $error=1;
}
if(!empty($error)){
   response(0,null,'Please enter the required fields.'); 
}else{
    $loggedUser=AuthUser($data['userId'],'string',array(0,1)); 
    updatePersonalInformation($data,$data['userId']);
    $user_id=$loggedUser['ID'];
    if(isset($_FILES['profileImage']['name']) and !empty($_FILES['profileImage']['name'])){
        //For Uploading photo from front End
        if (!function_exists('wp_generate_attachment_metadata')){
         require_once(ABSPATH . "wp-admin" . '/includes/image.php');
         require_once(ABSPATH . "wp-admin" . '/includes/file.php');
         require_once(ABSPATH . "wp-admin" . '/includes/media.php');
        }
        $overrides = array( 'test_form' => false);
        $file = wp_handle_upload($_FILES['profileImage'], $overrides);
        $content = $file['url'];
        // The ID of the post this attachment is for.
        $parent_post_id = $vendorId;
        // Check the type of file. We'll use this as the 'post_mime_type'.
        $filetype = wp_check_filetype( basename( $content ), null );
        // Prepare an array of post data for the attachment.
        $attachment = array(
        'guid'           => $content, 
        'post_mime_type' => $filetype['type'],
        'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $content ) ),
        'post_content'   => '',
        'post_status'    => 'inherit'
        );
        // Insert the attachment.
        $attach_id = wp_insert_attachment( $attachment, $content, $parent_post_id );
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
        $res1= wp_update_attachment_metadata( $attach_id, $attach_data );
        update_user_meta($user_id,'user_image',$attach_id);  
     }
    if(isset($_FILES['bannerImage']['name']) and !empty($_FILES['bannerImage']['name'])){
        //For Uploading photo from front End
        if (!function_exists('wp_generate_attachment_metadata')){
         require_once(ABSPATH . "wp-admin" . '/includes/image.php');
         require_once(ABSPATH . "wp-admin" . '/includes/file.php');
         require_once(ABSPATH . "wp-admin" . '/includes/media.php');
        }
        $overrides = array( 'test_form' => false);
        $file = wp_handle_upload($_FILES['bannerImage'], $overrides);
        $content = $file['url'];
        // The ID of the post this attachment is for.
        $parent_post_id = $vendorId;
        // Check the type of file. We'll use this as the 'post_mime_type'.
        $filetype = wp_check_filetype( basename( $content ), null );
        // Prepare an array of post data for the attachment.
        $attachment = array(
            'guid'           => $content, 
            'post_mime_type' => $filetype['type'],
            'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $content ) ),
            'post_content'   => '',
            'post_status'    => 'inherit'
        );
        // Insert the attachment.
        $attach_id = wp_insert_attachment( $attachment, $content, $parent_post_id );
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
        $res1= wp_update_attachment_metadata( $attach_id, $attach_data );
        update_user_meta($user_id,'bannerImage',$attach_id);  
     }    
    $result['profileImage']='';
    $result['bannerImage']='';
    if(!empty(getUserProfile($user_id))){
      $result['profileImage']=getUserProfile($user_id);  
    }
    if(!empty(getBannerProfile($user_id))){
      $result['bannerImage']=getBannerProfile($user_id);    
    }    
    response(1,$result,'No Error Found.');   
}
?>