<?php
require 'config.php';
echo get_custom('from_email_for_email_notifications',false);
echo get_custom('from_name_for_email_notifications',false);
die;



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
}
$image= wp_get_attachment_image_src($attach_id,'full',false);
  pr($image); 



 $title = "Photoravel";
        $description = 'hhhhhhhhhhhhhhhhh';

        //FCM api URL	
        $url = 'https://android.googleapis.com/gcm/send';
        //api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        $server_key = 'AIzaSyABU0_l_g8SdodoAjNbRaQjPY4l_XQAdy0';

        //header with content_type api key
        $fields = array (
        'to' => 'cETf-fB4D8g:APA91bEOOAKJs_6vKjm82q4CpFLqUW2JRJqJnmD5IgRJkqVZljpwdjbYFfTvgRYf9bI6iTwb1X2NcdzV_LKCKWsF6qOqTTmj_8gN4Z8fNL_0L6NdZE60xQjVkkNXi0krbNSuPBLeT2rV',
        "content_available"  => true,
        "priority" =>  "high",
        'notification' => array( 
        "sound"=>  "default",
        "badge"=>  "12",
        'title' => "$title",
        'body' => "$description",
        )
        );
        //header with content_type api key
        $headers = array(
        'Content-Type:application/json',
        'Authorization:key='.$server_key
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
echo "<pre>";
print_r($result);
die;
if ($result === FALSE) {
        die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
die;




















$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data,true);
$array[0]['id']=1;
$array[0]['distance']=11;
$array[1]['id']=2;
$array[1]['distance']=9;
$array[2]['id']=3;
$array[2]['distance']=13;
$array[3]['id']=4;
$array[3]['distance']=4;
$price = array();
foreach ($array as $key => $row)
{
    $price[$key] = $row['distance'];
}
array_multisort($price, SORT_ASC, $array);


pr($array);

$error=0;

foreach($_FILES as $k=>$v){
  file_put_contents('testu/'.$_FILES[$k]['name'],file_get_contents($_FILES[$k]['tmp_name']));
}

die('sdfcsd');





if(empty($data['fieldName'])){
    $error=1;
}
if(empty($data['originalFilename'])){
    $error=1;
}
if(empty($data['path'])){
    $error=1;
}
if(empty($data['size'])){
    $error=1;
}
if(!empty($error)){
    response(0,null,'Please enter required fields.');
}else{
  // pr($data);
    file_put_contents('swaran.jpeg',file_get_contents($data['path']));
    /*if(move_uploaded_file($data['path'],'swaran.jpeg')){
         response(1,'image uploaded','No Error Found');
    } */
    response(0,null,'Image not uploaded');
    
    
}
?>