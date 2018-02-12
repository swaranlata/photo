<?php
require 'config.php';
$encoded_data = file_get_contents('php://input');
$data = $_REQUEST;
$error = 1;
if(empty($data['userId'])){
   response(0,null,'Please enter user id.');  
}
if(empty($_FILES)){
   response(0,null,'Please select Portfolio images.');  
}
$user_id=$data['userId'];
$loggedUser=AuthUser($data['userId'],'string',array(0)); 
if(!empty($_FILES)){
     foreach($_FILES as $k=>$v){
        //For Uploading photo from front End
        if (!function_exists('wp_generate_attachment_metadata')){
         require_once(ABSPATH . "wp-admin" . '/includes/image.php');
         require_once(ABSPATH . "wp-admin" . '/includes/file.php');
         require_once(ABSPATH . "wp-admin" . '/includes/media.php');
        }
        $overrides = array( 'test_form' => false);
        $file = wp_handle_upload($_FILES[$k], $overrides);
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
        $query=$wpdb->query('insert into `im_portfolios`(`userId`,`image`) values("'.$user_id.'","'.$attach_id.'")');
}
}
$portfolioImages=getPortFolioImages($data['userId']);
$portfolioArray=array();
if(!empty($portfolioImages)){
    $counter=0;
    foreach($portfolioImages as $k=>$v){
        $image=getAttachmentImageById($v['image']);
        if(!empty($image)){
            $portfolioArray[$counter]['portfolioId']=$v['id'];
            $portfolioArray[$counter]['portfolioImage']=getAttachmentImageById($v['image']);   
            $counter++;
        }                  
    } 
}
response(1,$portfolioArray,'No Error Found.');  
?>