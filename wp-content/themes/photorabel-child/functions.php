<?php
    session_cache_limiter ('private, must-revalidate');    
    $cache_limiter = session_cache_limiter();
    session_cache_expire(60);
    date_default_timezone_set("Asia/Calcutta");
    $encoded_data = file_get_contents('php://input');
    $data = json_decode($encoded_data, true);
    define('FROM_MAIL',get_custom('from_email_for_email_notifications',false));
    define('RADIUS',get_custom('radius',false));
    define('FROM_NAME',get_custom('from_name_for_email_notifications',false));
    define('CUSTOM_ADMIN_URL',site_url().'/'.get_option('whl_page'));

    add_action( 'wp_enqueue_scripts', 'enqueue_child_theme_styles', PHP_INT_MAX);
    function enqueue_child_theme_styles() {
      $user_id=get_custom_user_id();
      if(!empty($user_id)){
        $getUserType=get_user_meta($user_id,'userType',true);  
        $user_roles=$user_meta->roles; 
      }
      wp_enqueue_style('parent-style', get_template_directory_uri().'/style.css' );  
      wp_enqueue_style('font-api-style','https://fonts.googleapis.com/css?family=Anton|Lato:300,400,700,900,900i|Open+Sans:300,400,600,700,800' );
      wp_enqueue_style('awesome-style','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"' );
      wp_enqueue_style('owl-min-style',get_stylesheet_directory_uri().'/css/owl.carousel.min.css' );
      wp_enqueue_style('bootstrap-style', get_stylesheet_directory_uri().'/css/bootstrap.min.css' );
      wp_enqueue_style('datepicker-style', get_stylesheet_directory_uri().'/css/jquery-ui.css' );
      wp_enqueue_style('timepicker-style', get_stylesheet_directory_uri().'/css/jquery.timepicker.min.css' );
      wp_enqueue_style('rating-style', get_stylesheet_directory_uri().'/css/rating.css');     
      wp_enqueue_style('scrollbar-style', get_stylesheet_directory_uri().'/css/mCustomScrollbar.min.css');     
      wp_enqueue_style('ratingr-style', get_stylesheet_directory_uri().'/css/raterater.css');     
      wp_enqueue_style('bootstrap-style-main', get_stylesheet_directory_uri().'/css/style.css');   
      wp_enqueue_script('min-js', get_stylesheet_directory_uri().'/js/jquery.min.js',array(),true  );
      wp_enqueue_script('bootstrap-js', get_stylesheet_directory_uri().'/js/bootstrap.min.js',array(),true  );
      wp_enqueue_script('carousel-js', get_stylesheet_directory_uri().'/js/owl.carousel.min.js' ,array(),true );
      wp_enqueue_script('validate-js', get_stylesheet_directory_uri().'/js/jquery.validate.js',array(),true );
      wp_enqueue_script('datepicker-js', get_stylesheet_directory_uri().'/js/jquery-ui.js',array(),true );  
      wp_enqueue_script('app-js', get_stylesheet_directory_uri().'/js/app.js',array(),true ); 
      wp_enqueue_script('rating-js', get_stylesheet_directory_uri().'/js/rating.js',array(),true ); 
      wp_enqueue_script('scrollerbar-js', get_stylesheet_directory_uri().'/js/mCustomScrollbar.concat.min.js',array(),true ); 
      
    }

    /* Update Photographer Business Profile */
    function updateBusinessProfile($userId=null,$data=null){
         if(!empty($data['hourlyRate'])){
            update_user_meta($userId,'hourlyRate',$data['hourlyRate']);  
         }
         if(!empty($data['minHours'])){
           update_user_meta($userId,'minHours',$data['minHours']);  
         }
         if(!empty($data['minHours'])){
             update_user_meta($userId,'experience',$data['experience']); 
         }
         return true;
    }

    function wpdocs_enqueue_custom_admin_style() {
        wp_register_style('custom_wp_admin_css', get_stylesheet_directory_uri() . '/css/admin-dev-style.css', false, '1.0.0' );
        wp_enqueue_style('custom_wp_admin_css');
    }
    add_action( 'admin_enqueue_scripts', 'wpdocs_enqueue_custom_admin_style' );




    function prd($array=null){
        echo "<pre>";
        print_r($array);
        die;
    }

    function pr($array = null) {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
        die;
    }

    function response($success = null, $result = null, $error = null) {
    echo json_encode(array(
    'success' => $success,
    'result' => $result,
    'error' => $error));
    die;
    }

    function randomString($length = 6) {
        $str = "";
        $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
        $rand = mt_rand(0, $max);
        $str .= $characters[$rand];
        }
        return $str;
    }

    function convert_array($array = null) {
    $finalArray = json_decode(json_encode($array), true);
    return $finalArray;
    }

    function AuthUser($id = null, $error_type = null,$userType=null) {
        global $wpdb;
        $query='SELECT * FROM `im_users` WHERE `ID`="'.$id.'"';
        $results = $wpdb->get_row($query);
        $array = convert_array($results);
        if(empty($array)){
            if ($error_type == 'string') {
                response(0, null, 'You are not authorise to access this content.');
            } else {
                response(0, $error_type, 'You are not authorise to access this content.');
            }
        }else{
            $userTypeData=get_user_meta($id,'userType',true);
            if(!in_array($userTypeData,$userType)){
                if ($error_type == 'string') {
                   response(0, null, 'Please check your user type.'); 
                }else{
                   response(0, array(), 'Please check your user type.');  
                }
                
            }
            return $array;
        }    
    }

    function getAllUser(){
        global $wpdb;
        $results = $wpdb->get_results('SELECT `ID` FROM `wp_users`');
        $array = convert_array($results);
        return $array;
    }

    function getUserType($userId=null){
        $userType=get_user_meta($userId,'userType',true);
        return $userType;
    }

    function checkPhoneValid($phone=null){
        if(!empty($phone)){
          if(!is_numeric($phone) || strlen($phone)<10){
           // response(0, null, 'Please enter valid Phone number.');    
          }  
        }        
    }

    /* Get User Profile */
    function getUserProfile($user_id=null){
        //$user_id=370;
        $profile=get_user_meta($user_id,'user_image',true);
        if(empty($profile)){
            $image="";
        }else{
            $facebookId= get_user_meta($user_id,'facebookId',true);
            $googleId= get_user_meta($user_id,'googleId',true);
            if (!empty($facebookId)) {                
                if(is_numeric($profile)){                   
                  $image= wp_get_attachment_image_src($profile,'full',false);
                  $finalImage=$image[0];
                  $image=$finalImage;  
                }else{
                  $image=$profile;  
                }             
            }elseif(!empty($googleId)){
                if(is_numeric($profile)){                    
                  $image= wp_get_attachment_image_src($profile,'full',false);
                  $finalImage=$image[0];
                  $image=$finalImage;  
                }else{
                  $image=$profile;  
                } 
            }else{              
              $image= wp_get_attachment_image_src($profile,'full',false);
                if(isset($image[0]) and !empty($image[0])){
                   $finalImage=$image[0]; 
                }else{
                   $finalImage=''; 
                }
              
              $image=$finalImage;
            }
        }
        if(!empty($image) and $image=='null'){
          $image='';  
        }   
        /*echo $image;
        die;*/
        return $image;
    }

   /* Get User Profile */
    function getBannerProfile($user_id=null){
        $profile=get_user_meta($user_id,'bannerImage',true);
        if(empty($profile)){
            $image="";
        }else{
            $image= wp_get_attachment_image_src($profile,'full',false);     
            if(isset($image[0]) and !empty($image[0])){
                   $finalImage=$image[0]; 
             }else{
                   $finalImage=''; 
             }
            /*$finalImage=$image[0];
            $image=$finalImage;*/
             $image=$finalImage;
        }
       // return $image;
        return $image;
    }

    /* Get Success Rate*/
    function getSuccessRate($user_id=null){
        global $wpdb;
        $result=$wpdb->get_results('select * from `im_requests` where (`otherUserId`="'.$user_id.'" or `userId`="'.$user_id.'" ) and status="6"',ARRAY_A);
        $totalCount=0;
        $count=0;
        $completed=array();
        if(!empty($result)){
            $count=count($result);   
            /*$totalCount=count($result);
            foreach($result as $k=>$v){
                if($v['status']=='6'){
                  $completed[]=$v['id'];  
                }                
            }   */         
                      
        }
        $getContacts=getContacts($user_id);
        $calCulatedResponse=$count.'/'.$getContacts;
        return $calCulatedResponse;
    } 
   function getSuccessRatePercentage($user_id=null){
        global $wpdb;
        $result=$wpdb->get_results('select * from `im_requests` where `otherUserId`="'.$user_id.'" and status in("4","5","6")',ARRAY_A);
        $totalCount=0;
        $count=0;
        $completed=array();
        if(!empty($result)){
            $totalCount=count($result);
            foreach($result as $k=>$v){
                if($v['status']=='6'){
                  $completed[]=$v['id'];  
                }                
            }            
            $count=count($completed);             
        }
        $getContacts=getContacts($user_id);
        $calCulatedResponse=$count/$getContacts*100;
        return $calCulatedResponse;
    }

    /* Get User Rating */
    function getUserRating($user_id=null){
        global $wpdb;
        $result=$wpdb->get_results('select * from `im_reviews` where `otherUserId`="'.$user_id.'"',ARRAY_A);
        $count=0;
        if(!empty($result)){
            $totalCount=count($result);
            foreach($result as $k=>$v){
              $count += $v['rateValue'];
            }  
           $count=$count/$totalCount; 
            $count=number_format($count,1);
        }
        return "$count";
    }

   /* Get Reviews Count*/
    function getReviewsCount($user_id=null){
        global $wpdb;
        $result=$wpdb->get_results('select `id` from `im_reviews` where `otherUserId`="'.$user_id.'"',ARRAY_A);
        $count="0";
        if(!empty($result)){
           $count=count($result); 
        }
        return "$count";

    }

    /* Get today session count*/
    function getTodaySessionsCount($user_id=null){
        $row=getUserSessionsCount($user_id,0);
        $count="0";
        if(!empty($row)){
          $count=count($row);  
        }
        return "$count";

    }

    /* Get upcoming session count*/
    function getUpcomingSessionsCount($user_id=null){
        $row=getUserSessionsCount($user_id,1);
        $count="0";
        if(!empty($row)){
          $count=count($row);  
        }
        return "$count";
    }

    /* Get Job request count*/
    function getJobRequestsCount($user_id=null){
        global $wpdb;
        $query='select * from `im_requests` where (`userId`="'.$user_id.'" and status in("0","1","2")) or (`otherUserId`="'.$user_id.'" and status in("0","1","2"))';
        $results=$wpdb->get_results($query,ARRAY_A);
        $count="0";
        if(!empty($results)){
            foreach($results as $kk=>$vv){
                $createdDate = strtotime($vv['created']);
                $after24hours=date('Y-m-d H:i:s', strtotime('+1 day', $createdDate));
                if(strtotime($after24hours)<time()){
                   continue; 
                }
                $requestCount=getEditCount($vv['id']); 
                if($requestCount=="1"){
                    if($vv['userId']==$data['userId']){//count is 1 userid is sender Id
                      $allRequests[]= $vv['id']; 
                    }
                }else{
                   $allRequests[]=$vv['id']; 
                }        
            }
            $count=count($allRequests); 
       }
       return "$count";

    }
    /* GEt User name*/
    function getUserName($user_id=null){
        $firstName=get_user_meta($user_id,'firstName',true); 
        $lastName=get_user_meta($user_id,'lastName',true); 
        if(!empty($lastName)){
            $firstName .= ' '.$lastName;
        }
        return ucwords($firstName);

    }
 /* GEt User Email*/
    function getUserEmail($user_id=null){
        global $wpdb;
        $query='select `user_email` from `im_users` where `ID`="'.$user_id.'"';
        $result=$wpdb->get_row($query,ARRAY_A);
        $email='';
        if(!empty($result)){
           $email = $result['user_email'];
        }
        return strtolower($email);

    }

    /* Get Notification Count*/
    function getNotificationCount($userId=null){
        global $wpdb;
        $count=0;
        $records=$wpdb->get_results('select `id` from `im_notifications` where `opponentId`="'.$userId.'" and `status`="0"',ARRAY_A);        
        if(!empty($records)){
            $count=count($records);
        }
        return "$count";
    }

    /* Valid Email Format Check*/
    function CheckValidEmail($email=null){
        if (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^",$email)){ 
            response(0, null, 'Please enter valid email address.');  
        }        
    }

    function isEnablePushNotification($userId=null,$type=null){
        if($type=='email'){
            $pushnotification=get_user_meta($userId,'emailNotification',true);
        }elseif($type=='push'){
            $pushnotification=get_user_meta($userId,'pushNotification',true);
        }else{
           $pushnotification=get_user_meta($userId,'locationNotification',true);
        } 
        if($pushnotification==''){
         $pushnotification='1';           
        }
        return $pushnotification;
    }

     /* return date in dateFormat*/
    function getDateFormat($date=null){
        $date=date('d/m/Y',strtotime($date));
        return $date;
    }

    /* Check Password valid or not*/
    function confirmPassword($password=null,$confirm=null){
        if($password!=$confirm){
          response(0, null, 'Please confirm your password.'); 
        }
    }

    /* Get User Type */
    function getGender($user_id=null){
        if(!empty(get_user_meta($user_id,'gender',true))){
            $gender=ucfirst(get_user_meta($user_id,'gender',true));
        }else{
            $gender='';
        }
       return "$gender";
    }

    /*calculate age */
    function getAge($dob=null){
        $birthDate = date('Y-m-d',strtotime($dob));
        $date = date_create($birthDate);
        $interval = $date->diff(new DateTime);
        $interval=convert_array($interval);
        $years=$interval['y'];
        if(!empty($years)){
           if($years>1){
                 $day='years';
                }else{
                  $day='year';  
                }
             $age=$years.' '.$day;           
            
        }else{            
            $month=$interval['m'];
            if(!empty($month)){
                if($month>1){
                 $dayM='months';
                }else{
                  $dayM='month';  
                }
               $age=$month.' '.$dayM;                
            }else{
                if($interva['d']>1){
                 $day='days';
                }else{
                  $day='day';  
                }
               $age=$interval['d'].' '.$day; 
            }
            
        }
        return "$age";
     }

    /* getRequestEditTimes */
    function getRequestEditTimes($rquestId=null){
        global $wpdb;
        $row=$wpdb->get_results('select `id` from `im_request_counts` where `requestId`="'.$rquestId.'"');
        $count=0;
        if(!empty($row)){
          $count=count($row);  
        }
        return "$count";
    }

    /* start Push Notifications */
    function pushMessageNotification($user_id,$message){
        global $wpdb;
        $tokens = trim(get_user_meta($user_id,'deviceToken',true));
        $deviceName = get_user_meta($user_id,'deviceType',true);
        $pushNotification = get_user_meta($user_id,'pushNotification',true);
        if(!empty($tokens) and !empty($pushNotification))
        {
            if($deviceName=='android')
            {
                $res=sendMessageAndroid($tokens,$message);
                return $res;
            }else{
                $res=sendMessageIos($tokens,$message);
                return $res;
            }
        } 
    } 

    function sendMessageIos($token_id,$checkNotification){
        $title = "Photoravel";
        $description = strip_tags($checkNotification);
        //FCM api URL	
        $url = 'https://fcm.googleapis.com/fcm/send';
        //api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        $server_key='AAAAiZLFXSw:APA91bF8Bf_yqb_gqLo3dvKreOCXJU9LJErIK4UizOMSTeSl3zVHmyF0nt9Zt6tLkTEoBNXeBzKE5bYUCZxMFgt_CRGWhemLuMYtb9bn55B6KT7LLktpwfNTxB523P-kEmPzlB6q5slx';
        //header with content_type api key
        $fields = array (
            'to' => $token_id,
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
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

    function sendMessageAndroid($token_id,$checkNotification){
        $title = "Photoravel";
        $description = $checkNotification;

        //FCM api URL	
        $url = 'https://android.googleapis.com/gcm/send';
        //api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        $server_key = 'AAAAiZLFXSw:APA91bF8Bf_yqb_gqLo3dvKreOCXJU9LJErIK4UizOMSTeSl3zVHmyF0nt9Zt6tLkTEoBNXeBzKE5bYUCZxMFgt_CRGWhemLuMYtb9bn55B6KT7LLktpwfNTxB523P-kEmPzlB6q5slx';

        //header with content_type api key
        $fields = array (
        'to' => $token_id,
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
        if ($result === FALSE) {
        die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

    /* end Push Notifications */
    function mime_content_types($filename) {
        $mime_types = array(
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );
    if(isset($mime_types)){
        foreach($mime_types as $k=>$v){
            if(strtolower($v)==$filename){
                return $k;
            }
        }
     }
      /*  $ext = strtolower(array_pop(explode('.',$filename)));
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }
        elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        }
        else {
            return 'application/octet-stream';
        } */
    }

    /*REMOVE ADMIN BAR */
    add_action('after_setup_theme', 'remove_admin_bar');
    function remove_admin_bar() {
        if (!current_user_can('administrator') && !is_admin()) {
            show_admin_bar(false);
        }
    }

    /* get portfolio image by attachment id*/
    function getAttachmentImageById($attachId=null){
        $portfolioImage='';
        $image= wp_get_attachment_image_src($attachId,'full',false);
        if(isset($image[0]) and !empty($image[0])){
           $portfolioImage=$image[0];
        }
        return $portfolioImage;
    }

    function addPortfolioImages($user_id=null,$portfolioImages=null){
        global $wpdb;
        if(!empty($portfolioImages)){
          foreach($portfolioImages as $k=>$v){
                $upload_dir = wp_upload_dir();                
                $image=explode(',',$v);
                $data['profileImage']=$image[1];
                $dataSource = base64_decode($data['profileImage']);
                $file_name = uniqid() . '.png';
                $file = $upload_dir['path'].'/'.$file_name;
                $return = $upload_dir['url'].'/'.$file_name;
                $success = file_put_contents($file, $dataSource);
                $filetype = wp_check_filetype( basename( $file ), null );
                $parent_post_id="";
                $attachment = array(
                    'guid'           => $return,
                    'post_author'	=>	$user_id,
                    'post_mime_type' => $filetype['type'],
                    'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $file ) ),
                    'post_content'   => '',
                    'post_status'    => 'inherit'
                );
                $attach_id = wp_insert_attachment( $attachment, $file, $parent_post_id );
                require_once(ABSPATH . 'wp-admin/includes/image.php');
                $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
                $res1= wp_update_attachment_metadata( $attach_id, $attach_data );             
                $query=$wpdb->query('insert into `im_portfolios`(`userId`,`image`) values("'.$user_id.'","'.$attach_id.'")');              
          }   
        }       
    }

    function getLatLong($address=null){
        $address=str_replace(' ','+',$address);
        $geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyBngH_ry9-rMngp9m2xWCxsqAuzVPpy3uI&sensor=false');        
        $lat='';
        $long='';
        $output= json_decode($geocode); 
        if(isset($output->results[0]->geometry->location->lat)){
          $lat = $output->results[0]->geometry->location->lat;  
        }
        if(isset($output->results[0]->geometry->location->lng)){
          $long = $output->results[0]->geometry->location->lng;  
        }        
        return array('lat'=>$lat,'long'=>$long);
    }

    function getPortFolioImages($user_id=null){
        global $wpdb;
       // $query='select `id`,`image` from `im_portfolios` where `userId`="'.$user_id.'" order by id desc limit '.$offset.','.$limit;
        $query='select `id`,`image` from `im_portfolios` where `userId`="'.$user_id.'" order by id desc';
        $portfolioImages=$wpdb->get_results($query,ARRAY_A); 
         return $portfolioImages;
    }

    function deletePortfolioImages($attachmentId=null){
        global $wpdb;
        wp_delete_attachment($v,true);
        $wpdb->query('delete from `im_portfolios` where `id`="'.$attachmentId.'"');
        return true;        
    }

    /* Add Notifications*/
    function insert_notification($userId=null,$type=null,$moduleId=null,$opponentId=null,$title=null,$opType=null){
        global $wpdb;
        $wpdb->query('insert into `im_notifications`(`userId`,`type`,`created`,`title`,`moduleId`,`opponentId`,`optype`) values("'.$userId.'","'.$type.'","'.date('Y-m-d H:i:s').'","'.$title.'","'.$moduleId.'","'.$opponentId.'","'.$opType.'")');
        if($opType=='app'){
            if(!empty($opponentId)){
                $emailStatus=isEnablePushNotification($opponentId,'email');
                if(!empty($emailStatus)){
                    sendEmailNotification($userId,$opponentId,$type,$moduleId,$title,$opType);
                }                
            }                        
        }else{
            if(!empty($opponentId)){
                sendEmailNotification($userId,$opponentId,$type,$moduleId,$title,$opType);               
            }             
        }       
        if(!empty($opponentId)){
          pushMessageNotification($opponentId,$title);   
        }      
    }

    /* Email Notifications */
    function sendEmailNotification($userId=null,$opponentId=null,$type=null,$moduleId=null,$title=null,$opType=null){       
        $senderName=getUserName($userId);
        $senderEmail=getUserEmail($userId);
        $receiverName=getUserName($opponentId);
        $receiverEmail=getUserEmail($opponentId);
        $emailTemplate=file_get_contents(get_stylesheet_directory_uri().'/email-template.php');
        $emailTemplate=str_replace('[NAME]',$receiverName,$emailTemplate);
        $emailTemplate=str_replace('[MESSAGE]',$title,$emailTemplate);
        $headers[] = 'From: '.$senderName.' <'.$senderEmail.'>';
        $headers[] = 'Content-Type: text/html; charset=UTF-8';
        wp_mail($receiverEmail,'Photoravel',$emailTemplate, $headers);  
     }

    /* Send Email */
    function send_email($email=null,$subject=null,$content=null){
        $headers[] = 'From: '.FROM_NAME.' <'.FROM_MAIL.'>';
        $headers[] = 'Content-Type: text/html; charset=UTF-8';
        wp_mail($email,$subject,$content,$headers); 
    }

    add_action('wp_ajax_signup', 'signup');
    add_action('wp_ajax_nopriv_signup', 'signup');

    function signup($data=null,$opType=null){            
            if($opType!='app'){
               $data=$_POST; 
            }
            $data['name']=$data['firstName'].' '.$data['lastName'];
            if (email_exists($data['email'])) {
                response(0, null, 'Email already exists.');
            }
            $username = strtolower(substr($data['name'], 0, 5)) . '_' . randomString(4);            
            $user_id = wp_create_user($data['email'], $data['password'], $data['email']);
            wp_update_user(array(
                 'ID' => $user_id,
                 'display_name' => $data['name'],
            ));
            update_user_meta($user_id, "user_image",'');
            if($opType!='app'){
               if(!empty($data['profileImage'])){            
                $upload_dir = wp_upload_dir();
                if($opType!='app'){
                   $image=explode(',',$data['profileImage']);
                   $data['profileImage']=$image[1];
                }              
                $dataSource = base64_decode($data['profileImage']);
                $file_name = uniqid() . '.png';
                $file = $upload_dir['path'].'/'.$file_name;
                $return = $upload_dir['url'].'/'.$file_name;
                $success = file_put_contents($file, $dataSource);
                $filetype = wp_check_filetype( basename( $file ), null );
                $parent_post_id="";
                $attachment = array(
                    'guid'           => $return,
                    'post_author'	=>	$user_id,
                    'post_mime_type' => $filetype['type'],
                    'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $file ) ),
                    'post_content'   => '',
                    'post_status'    => 'inherit'
                );
                $attach_id = wp_insert_attachment( $attachment, $file, $parent_post_id );
                require_once(ABSPATH . 'wp-admin/includes/image.php');
                $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
                $res1= wp_update_attachment_metadata( $attach_id, $attach_data );
                update_user_meta($user_id,'user_image',$attach_id);
             }
            }else{
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
            }            
            if(!empty($data['userType'])){//Traveler
                $u = new WP_User($user_id);
                $u->remove_role('subscriber');
                $u->set_role('traveler');                        
            }else{//0-photographer
                 $u = new WP_User($user_id);
                 $u->remove_role('subscriber');
                 $u->set_role('photographer');                         
            }
            update_user_meta($user_id, "lat",'');
            update_user_meta($user_id, "long",''); 
            if(empty($data['userType']) and $opType!='app'){                 
                if(!empty($data['portfolio'])){
                  addPortfolioImages($user_id,$data['portfolio']);  
                }              
            }
            update_user_meta($user_id, "firstName", $data['firstName']);        
            update_user_meta($user_id, "userType", $data['userType']);
            update_user_meta($user_id, "lastName", $data['lastName']);
            update_user_meta($user_id, "first_name", $data['firstName']);
            update_user_meta($user_id, "last_name", $data['lastName']);
            if($opType=='app'){
                update_user_meta($user_id, "deviceToken", $data['deviceToken']);
                update_user_meta($user_id, "deviceType", $data['deviceType']); 
                update_user_meta($user_id, "pushNotification",1);      
                update_user_meta($user_id, "emailNotification",1);
                update_user_meta($user_id, "locationNotification",1);
                update_user_meta($user_id, "contactNo",$data['contactNo']);
                /*updateLatLong($_SERVER['REMOTE_ADDR'],$user_id); */
                update_user_meta($user_id, "address",$data['address']);
                update_user_meta($user_id, "lat",$data['latitude']);
                update_user_meta($user_id, "long",$data['longitude']); 
            }else{
                update_user_meta($user_id,'hourlyRate',$data['hourlyRate']); 
                update_user_meta($user_id,'bio',trim($data['bio'])); 
                update_user_meta($user_id,'minHours',$data['minHours']); 
                update_user_meta($user_id,'experience',$data['experience']);
                update_user_meta($user_id, "address",$data['address']);
             /*   update_user_meta($user_id, "state",$data['state']);
                update_user_meta($user_id, "city",$data['city']);
                update_user_meta($user_id, "country",$data['country']);*/
                update_user_meta($user_id, "pushNotification",1);      
                update_user_meta($user_id, "emailNotification",1);
                update_user_meta($user_id, "locationNotification",1);
                $tokenfield=randomString(8);
                update_user_meta($user_id, "tokenfield",$tokenfield);
                $latLong=getLatLong($data['address']);
                if(!empty($latLong)){
                  update_user_meta($user_id, "lat",$latLong['lat']);
                  update_user_meta($user_id, "long",$latLong['long']);  
                }
                 
            }    
            update_user_meta($user_id, "facebookId", '');
            update_user_meta($user_id, "googleId", '');
            if(!empty($data['dob'])){
                $dob=str_replace('/','-',$data['dob']);
                $dob=date('m/d/Y',strtotime($dob));
                update_user_meta($user_id, "dob",$dob);
            }            
            update_user_meta($user_id, "gender", $data['gender']);          
            update_user_meta($user_id, "bannerImage",'');
            update_user_meta($user_id, "contactNo",$data['contactNo']);            
            $emailTemplate=file_get_contents(get_stylesheet_directory_uri().'/email-template.php');
            $emailTemplate=str_replace('[NAME]',$data['name'],$emailTemplate);
            if(!empty($data['userType'])){//traveller
              $message='You are successfully registered with the website.Your login credentials are mentioned below.<br><br> Email : '.$data['email'].'<br> Password : '.$data['password']; 
              $adminMessage='New User has been registered as a Traveler with the website.You can view the Traveler  information from admin panel.<br><br> Url : '.CUSTOM_ADMIN_URL;
            }else{//photographer
              $message='You are successfully registered with the website.Your account needs admin approval to accept the job requests.After admin approval,traveler can send you job request.<br><br>Your login credentials are mentioned below.<br><br> Email : '.$data['email'].'<br> Password : '.$data['password']; 
              $adminMessage='New Photographer has been registered with the website.Photographer has requested to approve their account.You can approve the photographer account by login Admin Panel.<br><br> Url : '.CUSTOM_ADMIN_URL;  
            }                       
            $emailTemplate=str_replace('[MESSAGE]',$message,$emailTemplate);
            send_email($data['email'],'Photoravel Registration Successfull',$emailTemplate);            
            $adminTemp=file_get_contents(get_stylesheet_directory_uri().'/email-template.php');
            $adminTemp=str_replace('[NAME]',FROM_NAME,$adminTemp);
            $adminTemp=str_replace('[MESSAGE]',$adminMessage,$adminTemp);
            send_email(FROM_MAIL,'Photoravel Registration Approval',$adminTemp);   
            $credentials['user_login']=$data['email'];
            $credentials['user_password']=$data['password'];
            $loginResponse=wp_signon($credentials);
            session_start();
            $_SESSION['firstSignup']='true';            
            if($opType!='app'){ 
                if(!empty($data['userType'])){//traveller
                    create_custom_session($user_id);
                    response(1,"User Registered Successfully.", 'No Error Found');                    
                }else{
                     create_custom_session($user_id);
                    update_user_meta($user_id,'userStatus',0);            
                    response(1,"User Registered Successfully.", 'No Error Found');   
                }
                
            }else{
               update_user_meta($user_id,'userStatus',0);  
               return $user_id; 
            }            
    
    }//

    add_action('wp_ajax_login', 'login');
    add_action('wp_ajax_nopriv_login', 'login');

    /* Simple Login */
    function login($data=null,$opType=null){
        global $wpdb;
        if($opType!='app'){
          $data=$_POST;  
        }
        $credentials['user_login']=$data['email'];
        $credentials['user_password']=$data['password'];
       // $credentials['remember']=true;
        if(!email_exists($data['email'])){
             response(0,null,'Email address is not registered with the Photoravel.');
        } 
        $user = get_user_by( 'email', $data['email'] );
        if($user && wp_check_password($data['password'],$user->data->user_pass, $user->ID) ) 
        {
            $loginResponse=convert_array($user);
            $userType=get_user_meta($loginResponse['ID'],'userType',true);
            if($userType!=$data['userType']){
                if(empty($userType)){//photo
                    $m='This email id is registered as a Photographer, so please login as Photographer.';
                }else{
                   $m='This email id is registered as a Traveler, so please login as Traveler.'; 
                }

                response(0,null,$m);     
            }
        }else{
          response(0,null,'Invalid email and password combination.');   
        }
        $loginResponse=wp_signon($credentials);
        if(!empty($loginResponse)){       
           $loginResponse=convert_array($loginResponse);  
           if(isset($loginResponse['ID']) and !empty($loginResponse['ID'])){
                $user_id=$loginResponse['ID'];
                $userStatus=get_user_meta($loginResponse['ID'],'userStatus',true);
                
               if(empty($userType)){
                 /*  if($userStatus!='1'){
                    response(0,null,'Your account is not approved by admin yet.');     
                   } */                 
               }
               if($opType=='app'){
                    if(isset($data['deviceToken']) and !empty($data['deviceToken'])){
                      update_user_meta($user_id, "deviceToken", $data['deviceToken']);  
                    } 
                    if(isset($data['deviceType']) and !empty($data['deviceType'])){
                       update_user_meta($user_id, "deviceType", $data['deviceType']); 
                    }
                    $profile_image=get_user_meta($user_id,'user_image',true);
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
                   $contact=get_user_meta($user_id,'contactNo',true);
                   if(!empty($contact)){
                     $result['contactNo']=get_user_meta($user_id,'contactNo',true);  
                   }else{
                       $result['contactNo']="";
                   }            
                   $address=get_user_meta($user_id,'address',true);
                   if(!empty($address)){
                     $result['address']=get_user_meta($user_id,'address',true);
                   }else{
                     $result['address']="";
                   }
                   $bio=get_user_meta($user_id,'bio',true);
                   if(!empty($bio)){
                     $result['bio']=get_user_meta($user_id,'bio',true);  
                   }else{
                      $result['bio']=""; 
                   }
                   $lat=get_user_meta($user_id,'lat',true);
                   if(!empty($lat)){
                     $result['lat']=get_user_meta($user_id,'lat',true);  
                   }else{
                      $result['lat']=""; 
                   }
                   $long=get_user_meta($user_id,'long',true);
                   if(!empty($long)){
                     $result['long']=get_user_meta($user_id,'long',true);  
                   }else{
                      $result['long']=""; 
                   }
                   $dob=get_user_meta($user_id,'dob',true);
                   if(!empty($dob)){
                     $result['dob']=get_user_meta($user_id,'dob',true);  
                   }else{
                      $result['dob']=""; 
                   }
                   $bannerImage=get_user_meta($user_id,'bannerImage',true);
                   if(!empty($bannerImage)){
                     $result['bannerImage']=getBannerProfile($user_id);  
                   }else{
                      $result['bannerImage']=""; 
                   }
               }
               create_custom_session($user_id);
               response(1,$result,'No Error Found.');  
            }else{
                response(0,null,'Invalid email and password combination.');  
            }
        }
    }//

    add_action('wp_ajax_resetsession', 'resetsession');
    add_action('wp_ajax_nopriv_resetsession', 'resetsession'); 

    function resetsession(){
        session_start();
        if(isset($_SESSION['userType']) and !empty($_SESSION['userType'])){
          unset($_SESSION['userType']);   
        }
        if(isset($_SESSION['loginResponse']) and !empty($_SESSION['loginResponse'])){
          unset($_SESSION['loginResponse']);  
          unset($_SESSION['adminApproval']);  
        }     
        echo "true";
    }

    add_action('wp_ajax_setusertype', 'setusertype');
    add_action('wp_ajax_nopriv_setusertype', 'setusertype');

    /* Set UserType */
    function setusertype(){
        session_start();
        $_SESSION['userType']=$_GET['userType'];
        echo json_encode(array('status'=>'true'));die;
    }

    /* Signup/Login With Facebook */
    function loginWithFacebook($data=null,$opType=null){
        global $wpdb;
        session_start();
        $data['name']=$data['firstName'].' '.$data['lastName'];
        $rows=$wpdb->get_row('select `user_id` from `im_usermeta` where  `meta_key`="facebookId" and `meta_value`="'.$data['facebookId'].'"');
        if(!empty($rows)){
                $rows=convert_array($rows);                 
                $user_id=$rows['user_id'];
                $getUserType=get_user_meta($user_id,'userType',true);
                if($getUserType!=$data['userType']){
                    if($opType=='web'){
                       if(empty($getUserType)){//photo
                        $m='This email id is registered as a Photographer, so please login as Photographer.';
                    }else{
                       $m='This email id is registered as a Traveler, so please login as Traveler.'; 
                    }
                    $_SESSION['msg']=$m;
                    return  $array=array(
                        'success'=>0,
                        "result"=>null,
                         "userType"=>$data['userType'],
                        "error"=>$m
                        );                        
                    }else{
                      response(0, null, 'Please check your entered login credentials.');  
                    }                   
                 
                }
                $getUserStatus=get_user_meta($user_id,'userStatus',true);
               /* if(empty($getUserType)){
                    if($getUserStatus!='1'){
                     if($opType=='web'){
                         return  $array=array(
                            'success'=>0,
                            "result"=>null,
                             "userType"=>$data['userType'],
                            'check'=>1,
                            "error"=>'Your account is not approved by admin yet.'
                        );

                    }else{
                      response(0, null, 'Your account is not approved by admin yet.');  
                    } 

                }
                } */
                if(isset($data['deviceToken']) and !empty($data['deviceToken'])){
                    update_user_meta($user_id, "deviceToken", $data['deviceToken']);  
                }
                if(isset($data['deviceType']) and !empty($data['deviceType'])){
                    update_user_meta($user_id, "deviceType", $data['deviceType']);  
                } 
                if(!empty($data['profileImage'])){
                  //update_user_meta($user_id, "user_image",$data['profileImage']);  
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
                $result['locationNotification']=isEnablePushNotification($user_id,'location');
                $result['contactNo']=get_user_meta($user_id,'contactNo',true);
                $result['address']=get_user_meta($user_id,'address',true);
                $result['bio']=get_user_meta($user_id,'bio',true);
                $result['lat']=get_user_meta($user_id,'lat',true);
                $result['long']=get_user_meta($user_id,'long',true);
                $result['dob']=get_user_meta($user_id,'dob',true);
                $result['bannerImage']=getBannerProfile($user_id);
                create_custom_session($user_id);
                //  
           }
          else{
                if(email_exists($data['email'])) {
                    $user_id=email_exists($data['email']);
                    $getUserType=get_user_meta($user_id,'userType',true);
                     if($getUserType!=$data['userType']){
                        if($opType=='web'){
                              if(empty($getUserType)){//photo
                        $m='This email id is registered as a Photographer, so please login as Photographer.';
                    }else{
                       $m='This email id is registered as a Traveler, so please login as Traveler.'; 
                    }
                            $_SESSION['msg']=$m;
                             return  $array=array(
                            'success'=>0,
                                "result"=>null,
                                 "userType"=>$data['userType'],
                                "error"=>$m
                            );

                        }else{
                          response(0, null, 'Please check your entered login credentials.');  
                        }                       
                    }
                    $getUserStatus=get_user_meta($user_id,'userStatus',true);
                   /* if(empty($data['userType'])){
                        if($getUserStatus!='1'){
                         if($opType=='web'){
                             return  $array=array(
                                'success'=>0,
                                "result"=>null,
                                 "userType"=>$data['userType'],
                                'check'=>1,
                                "error"=>'Your account is not approved by admin yet.'
                            );

                        }else{
                          response(0, null, 'Your account is not approved by admin yet.');  
                        } 
                          
                      }
                    }*/                    
                    $userData=get_user_by('id',$user_id);
                    $userData=convert_array($userData);
                    update_user_meta($user_id, "facebookId", $data['facebookId']);
                    if(isset($data['deviceToken']) and !empty($data['deviceToken'])){
                     update_user_meta($user_id, "deviceToken", $data['deviceToken']);  
                    }
                    if(isset($data['deviceType']) and !empty($data['deviceType'])){
                     update_user_meta($user_id, "deviceType", $data['deviceType']);  
                    } 
                    if(!empty($data['profileImage'])){
                      //update_user_meta($user_id, "user_image",$data['profileImage']);  
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
                    $result['locationNotification']=isEnablePushNotification($user_id,'location');
                    $result['contactNo']=get_user_meta($user_id,'contactNo',true);
                    $result['address']=get_user_meta($user_id,'address',true);
                    $result['bio']=get_user_meta($user_id,'bio',true);
                    $result['lat']=get_user_meta($user_id,'lat',true);
                    $result['long']=get_user_meta($user_id,'long',true);
                    $result['dob']=get_user_meta($user_id,'dob',true);
                    $result['bannerImage']=getBannerProfile($user_id);
                    create_custom_session($user_id);
                    //response(1,$result,'No Error Found.');                  
                }
                else{
                    $username = strtolower(substr($data['name'], 0, 5)) . '_' . randomString(4);
                    $user_id = wp_create_user($data['email'], $data['password'], $data['email']);
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
                    $tokenfield=randomString(8);
                    update_user_meta($user_id, "tokenfield",$tokenfield);
                    if($opType=='web'){
                      updateLatLong($_SERVER['REMOTE_ADDR'],$user_id);  
                    }else{
                      update_user_meta($user_id, "address",$data['address']);
                      if(empty($data['address'])){
                         $address=getAddressFromLatLong($data['latitude'],$data['longitude']);
                         update_user_meta($user_id, "address",$address);
                      }
                      update_user_meta($user_id, "lat",$data['latitude']);
                      update_user_meta($user_id, "long",$data['longitude']);                         
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
                    $result['locationNotification']=isEnablePushNotification($user_id,'location');
                    $result['contactNo']=get_user_meta($user_id,'contactNo',true);
                    $result['address']=get_user_meta($user_id,'address',true);
                    $result['lat']=get_user_meta($user_id,'lat',true);
                    $result['long']=get_user_meta($user_id,'long',true);
                    $result['dob']=get_user_meta($user_id,'dob',true);
                    $result['bio']=get_user_meta($user_id,'bio',true);
                    $result['bannerImage']=getBannerProfile($user_id);
                    /*$emailTemplate=file_get_contents(get_stylesheet_directory_uri().'/email-template.php');
                    $emailTemplate=str_replace('[NAME]',$data['name'],$emailTemplate);
                    $message='You are successfully registered with the website and Your account is awaited for admin approval.You will receive an email from admin to continue login with mentioned.<br><br> Email : '.$data['email'];
                    $emailTemplate=str_replace('[MESSAGE]',$message,$emailTemplate);
                    send_email($data['email'],'Photoravel Registration Successfull',$emailTemplate);
                    $adminMessage='New User has been registered with the website.User has requested to approve their account.You can approve their account by login Admin Panel.<br><br> Url : '.CUSTOM_ADMIN_URL;
                    $adminTemp=file_get_contents(get_stylesheet_directory_uri().'/email-template.php');
                    $adminTemp=str_replace('[NAME]',FROM_NAME,$adminTemp);
                    $adminTemp=str_replace('[MESSAGE]',$adminMessage,$adminTemp);
                    send_email(FROM_MAIL,'Photoravel Registration Approval',$adminTemp); */  
                    $emailTemplate=file_get_contents(get_stylesheet_directory_uri().'/email-template.php');
                    $emailTemplate=str_replace('[NAME]',$data['name'],$emailTemplate);
                    if(!empty($data['userType'])){//traveller
                      $message='You are successfully registered with the website.Your login credentials are mentioned below.<br><br> Email : '.$data['email'].'<br> Password : '.$data['password']; 
                      $adminMessage='New User has been registered as a Traveler with the website.You can view the Traveler  information from admin panel.<br><br> Url : '.CUSTOM_ADMIN_URL;
                    }else{//photographer
                      $message='You are successfully registered with the website.Your account needs admin approval to accept the job requests.After admin approval,traveler can send you job request.<br><br>Your login credentials are mentioned below.<br><br> Email : '.$data['email'].'<br> Password : '.$data['password']; 
                      $adminMessage='New Photographer has been registered with the website.Photographer has requested to approve their account.You can approve the photographer account by login Admin Panel.<br><br> Url : '.CUSTOM_ADMIN_URL;  
                    }                       
                    $emailTemplate=str_replace('[MESSAGE]',$message,$emailTemplate);
                    send_email($data['email'],'Photoravel Registration Successfull',$emailTemplate);            
                    $adminTemp=file_get_contents(get_stylesheet_directory_uri().'/email-template.php');
                    $adminTemp=str_replace('[NAME]',FROM_NAME,$adminTemp);
                    $adminTemp=str_replace('[MESSAGE]',$adminMessage,$adminTemp);
                    send_email(FROM_MAIL,'Photoravel Registration Approval',$adminTemp);  
                    session_start();
                    $_SESSION['firstSignup']='true';
                    if($opType=='web'){
                        if(empty($data['userType'])){
                            update_user_meta($user_id,'userStatus',0);  
                           /* return $array=array(
                                'success'=>0,
                                "result"=>null,
                                 'check'=>1,   
                                "userType"=>$data['userType'],
                                  "error"=>'You are successfully registered with the website and Your account is awaited for admin approval.'
                             );  
                               die; */
                            
                        }else{
                            create_custom_session($user_id);  
                        }
                         create_custom_session($user_id);  
                    }else{
                        if(empty($data['userType'])){
                            update_user_meta($user_id,'userStatus',0);  
                           /* $array=array(
                                'success'=>0,
                                "result"=>null,
                                 'check'=>1,   
                                  "error"=>'You are successfully registered with the website and Your account is awaited for admin approval.'
                             );  
                            echo json_encode($array);
                            die; */
                            
                        }                    
                        
                    }
                    
                    response(1,$result,'No Error Found.');        
                } 
           } 
        if($opType=='web'){
            create_custom_session($user_id);  
           if(!empty($data['userType'])){//traveller
             header('location:'.get_site_url().'job-requests/');   
           }else{
             if(isset($_SESSION['type']) and $_SESSION['type']=='hire'){
                header('location:'.get_site_url().'/find-photographer');  
             }else{
                header('location:'.get_site_url().'/photographer-job-requests/');     
             }             
           }           
        }else{
          response(1,$result,'No Error Found.');   
        }        
    }//

    /* Signup/Login with Google*/
    function loginWithGoogle($data=null,$opType=null){
        global $wpdb;
        session_start();
        $data['name']=$data['firstName'].' '.$data['lastName'];
        $rows=$wpdb->get_row('select * from `im_usermeta` where  `meta_key`="googleId" and `meta_value`="'.$data['googleId'].'"');
        if(!empty($rows)){
                    $rows=convert_array($rows);
                    $user_id=$rows['user_id'];
                    $getUserType=get_user_meta($user_id,'userType',true);
                    if($getUserType!=$data['userType']){
                        if($opType=='web'){
                         if(empty($getUserType)){//photo
                            $m='This email id is registered as a Photographer, so please login as Photographer.';
                        }else{
                           $m='This email id is registered as a Traveler, so please login as Traveler.'; 
                        }
                            $_SESSION['msg']=$m;
                       return  $array=array(
                        'success'=>0,
                        "result"=>null,
                           "userType"=>$data['userType'],
                        "error"=>$m
                    );  
                        }else{
                           response(0, null, 'Please check your entered login credentials.');  
                        }                      
                    }
                    $getUserStatus=get_user_meta($user_id,'userStatus',true);
                   /* if(empty($getUserType)){
                        if($getUserStatus!='1'){
                             if($opType=='web'){
                                 return  $array=array(
                                    'success'=>0,
                                    "result"=>null,
                                    'check'=>1,
                                     "userType"=>$data['userType'],
                                    "error"=>'Your account is not approved by admin yet.'
                                );

                            }else{
                              response(0, null, 'Your account is not approved by admin yet.');  
                            } 

                        }

                    }*/                    
                    if(!empty($data['deviceToken'])){
                    update_user_meta($user_id, "deviceToken", $data['deviceToken']);  
                    }
                    if(!empty($data['deviceType'])){
                    update_user_meta($user_id, "deviceType", $data['deviceType']);  
                    } 
                    if(!empty($data['profileImage'])){
                      //update_user_meta($user_id, "user_image",$data['profileImage']);  
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
                    $result['locationNotification']=isEnablePushNotification($user_id,'location');
                    create_custom_session($user_id);
                    //response(1,$result,'No Error Found.');   
               }
            else{
                    if(email_exists($data['email'])) {
                        $user_id=email_exists($data['email']);
                        $userData=get_user_by('id',$user_id);
                        $getUserType=get_user_meta($user_id,'userType',true);
                        if($getUserType!=$data['userType']){
                            if($opType=='web'){
                                  if(empty($getUserType)){//photo
                        $m='';
                    }else{
                       $m='This email id is registered as a Traveler, so please login as Traveler.'; 
                    }
                                $_SESSION['msg']=$m;
                               return  $array=array(
                                'success'=>0,
                                "result"=>null,
                                   "userType"=>$data['userType'],
                                "error"=>$m
                                );  
                            }else{
                               response(0, null, 'Please check your entered login credentials.');  
                            }  
                        }
                        $getUserStatus=get_user_meta($user_id,'userStatus',true);
                        /*if(empty($data['userType'])){
                           if($getUserStatus!='1'){
                             if($opType=='web'){
                                 return  $array=array(
                                    'success'=>0,
                                    "result"=>null,
                                    'check'=>1,
                                     "userType"=>$data['userType'],
                                    "error"=>'Your account is not approved by admin yet.'
                                );

                            }else{
                              response(0, null, 'Your account is not approved by admin yet.');  
                          } 

                        }                            
                        }*/                        
                        $userData=convert_array($userData);
                        update_user_meta($user_id, "googleId", $data['googleId']);
                        $result['userId']="$user_id";
                        $result['firstName']=get_user_meta($user_id,'firstName',true);
                        $result['lastName']=get_user_meta($user_id,'lastName',true);
                        $result['email']=$data['email'];
                        $result['gender']=getGender($user_id);
                        if(isset($data['deviceToken']) and !empty($data['deviceToken'])){
                          update_user_meta($user_id, "deviceToken", $data['deviceToken']);  
                        }
                        if(isset($data['deviceType']) and  !empty($data['deviceType'])){
                          update_user_meta($user_id, "deviceType", $data['deviceType']);  
                        }
                        if(!empty($data['profileImage'])){
                          //update_user_meta($user_id, "user_image",$data['profileImage']);  
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
                        $result['locationNotification']=isEnablePushNotification($user_id,'location');
                        create_custom_session($user_id);
                        //response(1,$result,'No Error Found.');                  
                    }
                    else{                        
                        $username = strtolower(substr($data['name'], 0, 5)) . '_' . randomString(4);
                        $user_id = wp_create_user($data['email'], $data['password'], $data['email']);
                        wp_update_user(array(
                             'ID' => $user_id,
                             'display_name' => $data['name'],
                        ));
                        $_SESSION['firstSignup']='true';
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
                        update_user_meta($user_id, "bio",'');
                        update_user_meta($user_id, "bannerImage",'');
                        $tokenfield=randomString(8);
                        update_user_meta($user_id, "tokenfield",$tokenfield);
                        if($opType=='web'){
                          updateLatLong($_SERVER['REMOTE_ADDR'],$user_id);  
                        }else{
                          update_user_meta($user_id, "address",$data['address']);
                          if(empty($data['address'])){
                             $address=getAddressFromLatLong($data['latitude'],$data['longitude']);
                             update_user_meta($user_id, "address",$address);
                          }
                          update_user_meta($user_id, "lat",$data['latitude']);
                          update_user_meta($user_id, "long",$data['longitude']);                         
                        }
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
                        $result['locationNotification']=isEnablePushNotification($user_id,'location');
                        /*$emailTemplate=file_get_contents(get_stylesheet_directory_uri().'/email-template.php');
                        $emailTemplate=str_replace('[NAME]',$data['name'],$emailTemplate);
                        $message='You are successfully registered with the website and Your account is awaited for admin approval.You will receive an email from admin to continue login with mentioned.<br><br> Email : '.$data['email'];
                        $emailTemplate=str_replace('[MESSAGE]',$message,$emailTemplate);
                        send_email($data['email'],'Photoravel Registration Successfull',$emailTemplate);
                        $adminMessage='New User has been registered with the website.User has requested to approve their account.You can approve their account by login Admin Panel.<br><br> Url : '.CUSTOM_ADMIN_URL;
                        $adminTemp=file_get_contents(get_stylesheet_directory_uri().'/email-template.php');
                        $adminTemp=str_replace('[NAME]',FROM_NAME,$adminTemp);
                        $adminTemp=str_replace('[MESSAGE]',$adminMessage,$adminTemp);
                        send_email(FROM_MAIL,'Photoravel Registration Approval',$adminTemp);  */   
                        $emailTemplate=file_get_contents(get_stylesheet_directory_uri().'/email-template.php');
                        $emailTemplate=str_replace('[NAME]',$data['name'],$emailTemplate);
                        if(!empty($data['userType'])){//traveller
                          $message='You are successfully registered with the website.Your login credentials are mentioned below.<br><br> Email : '.$data['email'].'<br> Password : '.$data['password']; 
                          $adminMessage='New User has been registered as a Traveler with the website.You can view the Traveler  information from admin panel.<br><br> Url : '.CUSTOM_ADMIN_URL;
                        }else{//photographer
                          $message='You are successfully registered with the website.Your account needs admin approval to accept the job requests.After admin approval,traveler can send you job request.<br><br>Your login credentials are mentioned below.<br><br> Email : '.$data['email'].'<br> Password : '.$data['password']; 
                          $adminMessage='New Photographer has been registered with the website.Photographer has requested to approve their account.You can approve the photographer account by login Admin Panel.<br><br> Url : '.CUSTOM_ADMIN_URL;  
                        }                       
                        $emailTemplate=str_replace('[MESSAGE]',$message,$emailTemplate);
                        send_email($data['email'],'Photoravel Registration Successfull',$emailTemplate);            
                        $adminTemp=file_get_contents(get_stylesheet_directory_uri().'/email-template.php');
                        $adminTemp=str_replace('[NAME]',FROM_NAME,$adminTemp);
                        $adminTemp=str_replace('[MESSAGE]',$adminMessage,$adminTemp);
                        send_email(FROM_MAIL,'Photoravel Registration Approval',$adminTemp);  
                        session_start();
                        $_SESSION['firstSignup']='true';
                        if($opType=='web'){
                            if(empty($data['userType'])){
                                update_user_meta($user_id,'userStatus',0);  
                               /*return $array=array(
                                'success'=>0,
                                "result"=>null,
                                 'check'=>1,   
                                    "userType"=>$data['userType'],
                                  "error"=>'You are successfully registered with the website and Your account is awaited for admin approval.'
                                );  
                                die;*/
                            }else{
                                create_custom_session($user_id);  
                            }
                        }else{
                             if(empty($data['userType'])){
                                update_user_meta($user_id,'userStatus',0);  
                             /*   $array=array(
                                    'success'=>0,
                                    "result"=>null,
                                     'check'=>1,   
                                    "userType"=>$data['userType'],
                                      "error"=>'You are successfully registered with the website and Your account is awaited for admin approval.'
                                 );  
                                echo json_encode($array);
                                die;
                            */
                            } 
                        }
                        response(1,$result,'No Error Found.');        
                    } 
               }
                if($opType=='web'){
                     create_custom_session($user_id);  
                    if(!empty($data['userType'])){//traveller
                     header('location:'.get_site_url().'job-requests/');   
                   }else{
                     if(isset($_SESSION['type']) and $_SESSION['type']=='hire'){
                        header('location:'.get_site_url().'find-photographer');  
                     }else{
                        header('location:'.get_site_url().'photographer-job-requests/');     
                     }    
                   }                    
                }else{
                    response(1,$result,'No Error Found.');  
                }
    }//

    /* differnce between locations */ 
    function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'Mi') {
        $theta = $longitude1 - $longitude2;
        $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
        $distance = acos($distance);
        $distance = rad2deg($distance);
        $distance = $distance * 60 * 1.1515;
        switch ($unit) {
            case 'Mi': break;
            case 'Km' : $distance = $distance * 1.609344;
        }
        return (round($distance, 2));
    }

    /* Get member since */
    function getMemberSince($user_id=null){
        global $wpdb;
        $getUser=$wpdb->get_row('select `user_registered` from `im_users` where `ID`="'.$user_id.'"',ARRAY_A);
        $date="";
        if(!empty($getUser)){
           $date= date('Y',strtotime($getUser['user_registered']));
        }
        return $date;
    }

    /* Add Busy schedule*/
    function addBusySchedule($data=null){
        global $wpdb;
        $getBusySchedule=$wpdb->get_row('select `id` from `im_schedules` where `userId`="'.$data['userId'].'" and `dayId`="'.$data['dayId'].'" and `startTime`="'.$data['startTime'].'" and `endTime`="'.$data['endTime'].'"');
        if(empty($getBusySchedule)){
           $wpdb->query('insert into `im_schedules`(`userId`,`dayId`,`startTime`,`endTime`) values("'.$data['userId'].'","'.$data['dayId'].'","'.$data['startTime'].'","'.$data['endTime'].'")'); 
            return $wpdb->insert_id;
        }else{
            return false;
        }        
    }

    /* Get Busy Schedule*/
    function getPhotographerBusySchedule($user_id=null,$dayId=null){
        global $wpdb;
        $getList=$wpdb->get_results('select `id`,`startTime`,`endTime` from `im_schedules` where `userId`="'.$user_id.'" and `dayId`="'.$dayId.'"',ARRAY_A);
        return $getList;        
    }


    /* Get Day */
    function getDay($date=null){
        $day=date('D',strtotime($date));
        $day=strtolower($day);
        if($day=='mon'){
            $dayId=1;
        }elseif($day=='tue'){
            $dayId=2;
        }elseif($day=='wed'){
            $dayId=3;
        }elseif($day=='thu'){
            $dayId=4;
        }elseif($day=='fri'){
            $dayId=5;
        }elseif($day=='sat'){
            $dayId=6;
        }else{
            $dayId=0;
        }
        return $dayId;
        
    }
     function getDayName($day=null){
        if($day=='1'){
            $dayId='Monday';
        }elseif($day=='2'){
            $dayId='Tuesday';
        }elseif($day=='3'){
            $dayId='Wednesday';
        }elseif($day=='4'){
            $dayId='Thursday';
        }elseif($day=='5'){
            $dayId='Friday';
        }elseif($day=='6'){
            $dayId='Saturday';
        }else{
            $dayId='Sunday';
        }
        return $dayId;
        
    }

    /* Check User Schedule */
    function CheckUserSchedule($user_id=null,$date=null,$time=null){
        global $wpdb;
        $dayId=getDay($date);
        $crntdate=date('Y-m-d');
        $temp=0;       
        if(empty($time)){
           $start = $time[0]=strtotime($date);
           $end = $time[1]=strtotime($date); 
           $query='select * from `im_schedules` where `userId`="'.$user_id.'" and `dayId`="'.$dayId.'"';
           $checkUser=$wpdb->get_results($query,ARRAY_A); 
           if(!empty($checkUser)){
            $temp=1;
           }else{
              $temp=1;    
              }          
        }else{
              $time=explode('-',$time);       
              $start = $time[0]=strtotime($date." ".$time[0]);
              $end = $time[1]=strtotime($date." ".$time[1]); 
              $query='select * from `im_schedules` where `userId`="'.$user_id.'" and `dayId`="'.$dayId.'"';
              $checkUser=$wpdb->get_results($query,ARRAY_A);
              if(!empty($checkUser)){
                foreach($checkUser as $value) {
                   $StartDate = strtotime($date." ".$value['startTime']);
                   $EndDate = strtotime($date." ".$value['endTime']);
                   if(($start >= $StartDate && $start <= $EndDate)  and ($end >= $StartDate && $end <= $EndDate)) {
                      $temp=1;
                   }
                }            
            }else{
              $temp=1;    
            }          
        }  
        return $temp;        
    }

    /* Send Request */
    function sendRequest($data=null,$optype=null){
        global $wpdb;      
        $startDate= date('Y-m-d',strtotime($data['startDate']));
        $inputStartTime=strtotime($startDate.' '.$data['startTime']);
        $inputEndTime=strtotime($startDate.' '.$data['endTime']);
        $getCheckDateQuery='select * from  `im_requests` where (`startDate`="'.$startDate.'" and  `userId`="'.$data['userId'].'" and `otherUserId`="'.$data['otherUserId'].'" and `status` not in("2","5")) or  (`startDate`="'.$startDate.'" and `otherUserId`="'.$data['userId'].'" and `userId`="'.$data['otherUserId'].'" and `status` not in("2","5"))';
        $res=$wpdb->get_results($getCheckDateQuery,ARRAY_A);
        $tempo=0;
        $temp=0;
        if(!empty($res)){
            foreach($res as $kk=>$vv){                
                $startTime=strtotime($vv['startDate'].' '.$vv['startTime']);
                $endTime=strtotime($vv['startDate'].' '.$vv['endTime']);
                if( ( $inputStartTime >= $startTime  && $inputStartTime<=$endTime ) || ( $inputEndTime >= $startTime && $inputEndTime <= $endTime ) )
                {                    
                $temp=1;
                }
           }  
        } 
        if(!empty($temp)){
          response(0,null,'You have already requested for this time interval.');   
        }
        if(!empty($res)){
            foreach($res as $kk=>$vv){
                $startTime=strtotime($vv['startDate'].' '.$vv['startTime']);
                $endTimeCustom=strtotime($vv['startDate'].' '.$vv['endTime']);
                $freeIntervalByAdmin=get_custom('time_interval');
                $getDate=date("Y-m-d h:i A", strtotime("+$freeIntervalByAdmin",$endTimeCustom));
                /* New code subtract 1 minute */
                $getNewtime = strtotime($getDate);
                $time = $getNewtime - (1 * 60);
                $getDate = date("Y-m-d H:i:s", $time);
                /* end code subtract 1 minute */
                $endTime=strtotime($getDate);  
                if( ( $inputStartTime >= $startTime  && $inputStartTime<=$endTime ) || ( $inputEndTime >= $startTime && $inputEndTime <= $endTime ) )
                {                    
                   if(($inputStartTime>=$endTimeCustom && $inputStartTime<=$endTime) || ($inputEndTime<=$endTime and $inputEndTime>=$endTimeCustom)){
                            $tempo=2;  
                    }
                }
                             
            }  
        }
        if(!empty($tempo)){
          response(0,null,'Photographer is busy for this time interval.');   
        }
        $getCheckDateQueryRecord='select * from  `im_requests` where (`startDate`="'.$startDate.'" and  `userId`="'.$data['otherUserId'].'" and `status` in("1","4","6")) or  (`startDate`="'.$startDate.'" and `otherUserId`="'.$data['otherUserId'].'" and `status` in("1","4","6"))';
        $resRecord=$wpdb->get_results($getCheckDateQueryRecord,ARRAY_A);
        $tempLast=0;
        if(!empty($resRecord)){
            foreach($resRecord as $kk=>$vv){
                $startTime=strtotime($vv['startDate'].' '.$vv['startTime']);
                $endTime=strtotime($vv['startDate'].' '.$vv['endTime']);
               /* $endTimeCustom=strtotime($vv['startDate'].' '.$vv['endTime']);
                $freeIntervalByAdmin=get_custom('time_interval');
                $getDate=date("Y-m-d h:i A", strtotime("+$freeIntervalByAdmin",$endTimeCustom));
                $endTime=strtotime($getDate); 
                if(($inputStartTime>=$startTime and $inputStartTime<=$endTime) || ($inputEndTime>=$startTime and $inputEndTime<=$endTime)){
                  $tempLast=1;  
                }*/   
                if( ( $inputStartTime >= $startTime  && $inputStartTime<=$endTime ) || ( $inputEndTime >= $startTime && $inputEndTime <= $endTime ) )
                {                    
                $tempLast=1;
                }
            }
        }
        if(!empty($tempLast)){
          response(0,null,'Photographer is already booked for this time interval.');    
        }  
        $query='insert into `im_requests`(`userId`,`otherUserId`,`startDate`,`startTime`,`endTime`,`status`,`created`,`modified`) values("'.$data['userId'].'","'.$data['otherUserId'].'","'.$startDate.'","'.$data['startTime'].'","'.$data['endTime'].'","0","'.date('Y-m-d H:i:s').'","'.date('Y-m-d H:i:s').'")';
        $wpdb->query($query);
        $moduleId=$wpdb->insert_id;   
        $senderName=getUserName($data['userId']);
        if($optype!='app'){
            $mes=$senderName.' sent you a request to hire you for photoshoot.<br><br><strong>Date :</strong> '.date('d/m/Y',strtotime($data['startDate'])).'<br><strong>Timings : </strong>'.$data['startTime'].' - '.$data['endTime'];
         // insert_notification($data['userId'],'0',$moduleId,$data['otherUserId'],'You have received a request from '.$senderName.'.','web');  
          insert_notification($data['userId'],'0',$moduleId,$data['otherUserId'],$mes,'web');  
        }        
        return $moduleId;
    } 

    /* get All photographers*/
    function getAllPhotographers(){
       global $wpdb;
       $args = array(
         'role' => 'photographer',
         'orderby' => 'ID',
         'order' => 'DESC',
         'fields'=>array('ID')
       );
        $photographer = get_users($args);
        $array=array();
        if(!empty($photographer)){
            $photographer=convert_array($photographer);
          foreach($photographer as $k=>$v){
              $array[]=$v['ID'];
          }  
        }
        return $array;
    }

    /* get Request Details*/
    function getRequestDetails($id=null){
        global $wpdb;
        $query=$wpdb->get_row('select * from  `im_requests` where  `id`="'.$id.'"',ARRAY_A);
        if(!empty($query)){
          $result['requestId']=$query['id'];
          $result['userId']=$query['userId'];
          $result['otherUserId']=$query['otherUserId'];
          $result['startDate']=date('m/d/Y',strtotime($query['startDate']));
          $result['startTime']=$query['startTime'];
          $result['endTime']=$query['endTime'];
        }else{
            $result=array();
        }
        return $result;
    }

    /* Get canceled by job*/
    function getCanceledJob($jobId=null){
        global $wpdb;
        $query=$wpdb->get_row('select * from  `im_user_cancelled_job` where  `jobId`="'.$jobId.'"',ARRAY_A);
        if(!empty($query)){
            $user=$query['userId'];
        }
        return $user;
    }

    /* Count the edit request */
    function getEditCount($id=null){
        global $wpdb;
        $getCheckDateQuery='select `requestId` from  `im_editcount` where `requestId`="'.$id.'"';
        $res=$wpdb->get_results($getCheckDateQuery,ARRAY_A);
        $count=0;
        if(!empty($res)){
          $count= count($res); 
        }
        return "$count";
    }

    /* get modified time slot*/
    function getModifiedRequestTime($requestId=null){
        global $wpdb;
        $getCheckDateQuery='select * from  `im_editcount` where `requestId`="'.$requestId.'" order by id desc';
        $res=$wpdb->get_row($getCheckDateQuery,ARRAY_A);
        return $res;
    }

    /* search/filter get all getAllPhotographerList */
    function getAllPhotographerList($data=null,$optype=null){
        global $wpdb;
        $offset=$data['offset'];
       if(!empty($data['country'])){
            /*if($data['country']==$data['city']){
              $location=$data['city'];  
            }else{
              $location=$data['city'].' '.$data['country'];  
            } */ 
            $location=$data['country'];           
            $latLong=getLatLong($location); 
           //pr($latLong);
        }else{
          $latLong=array('lat'=>'','long'=>'');  
        }  
        if(!empty($latLong['lat']) and !empty($latLong['long']) and empty($data['currentLat']) and empty($data['currentLong'])){
          $inputLat=$latLong['lat'];
          $inputLong=$latLong['long'];
        }elseif(!empty($latLong['lat']) and !empty($latLong['long']) and !empty($data['currentLat']) and !empty($data['currentLong'])){
           $inputLat=$data['currentLat'];
           $inputLong=$data['currentLong'];  
        }elseif(!empty($data['currentLat']) and !empty($data['currentLong'])){  
          $inputLat=$data['currentLat'];
          $inputLong=$data['currentLong'];  
        }elseif(empty($latLong['lat']) and empty($latLong['long']) and !empty($data['country'])){
           return false;
        }
        $args = array(
             'role' => 'photographer',
             'orderby' => 'ID',
             'order' => 'DESC',
             'fields'=>array('ID')
        );
        $photographer = get_users($args);
        $userArray=array();
        $filteredPhotographer=array();
        $photographerList=array();
        if(!empty($photographer)){
            $photographer=convert_array($photographer);
            foreach($photographer as $k=>$v){   
                $lat=get_user_meta($v['ID'],'lat',true);
                $long=get_user_meta($v['ID'],'long',true);
                 if(empty($lat) and empty($long)){
                        continue;    
                 }
                $getUserStatus=get_user_meta($v['ID'],'userStatus',true);
                if($getUserStatus!='1'){
                  continue;    
                } 
                if(!empty($lat) and !empty($long) and !empty($inputLat) and !empty($inputLong)){
                  $distance=getDistanceBetweenPointsNew($lat,$long,$inputLat,$inputLong);
                  $distance=(int) $distance;
                  if(!empty($data['currentLat']) and !empty($data['currentLong'])){
               
                  }else{
                    if($distance>RADIUS){
                      continue;
                    }   
                  }                          
                }
                if(!empty($data['date']) and !empty($data['time'])){
                    $CheckUserSchedule = CheckUserSchedule($v['ID'],$data['date'],$data['time']);  
                    if(empty($CheckUserSchedule)){
                       continue; 
                    }
                }elseif(!empty($data['date']) and empty($data['time'])){
                    $CheckUserSchedule = CheckUserSchedule($v['ID'],$data['date'],'');  
                    if(empty($CheckUserSchedule)){
                       continue; 
                    }
                } 
                $userArray[$v['ID']]=$distance;                
                
            }   
            if(!empty($userArray)){
               asort($userArray);
               foreach($userArray as $k=>$v){
                   if($v<=RADIUS){
                     $filteredPhotographer[]=$k; 
                    }                   
               }
            }
            if(!empty($filteredPhotographer)){     
              $allUsers=implode('","',$filteredPhotographer);
              $getQuery='select `ID` from `im_users` where `ID` in ("'.$allUsers.'")';
              $getPhotographer=$wpdb->get_results($getQuery,ARRAY_A);
              $photographerList=array();
              if(!empty($getPhotographer)){             
                foreach($getPhotographer as $key=>$values){
                  $val= $values['ID'];
                  $lat=get_user_meta($val,'lat',true);
                  $long=get_user_meta($val,'long',true);
                  $distance=0;
                  if(!empty($lat) and !empty($long) and !empty($inputLat) and !empty($inputLong)){
                      $distance=getDistanceBetweenPointsNew($lat,$long,$inputLat,$inputLong);
                      $distance=(int) $distance;                                                
                  }
                  $photographerList[$key]['userId']=$val;  
                  $photographerList[$key]['distance']=$distance;                   
                  $photographerList[$key]['profileImage']=getUserProfile($val);  
                  $photographerList[$key]['rating']=getUserRating($val);  
                  $photographerList[$key]['name']=getUserName($val);
                  $bio=get_user_meta($val,'bio',true);
                  if(empty($bio)){
                    $bio="";  
                  }
                  $photographerList[$key]['bio']=$bio; 
                  //if($optype!='web'){
                      $photographerList[$key]['bannerImage']=getBannerProfile($val);  
                      $address=get_user_meta($val,'address',true);
                      if(empty($address)){
                         $address="";   
                      }
                      $photographerList[$key]['address']=$address;                      
                      $photographerList[$key]['memberSince']=getMemberSince($val);
                      $hourlyRate=get_user_meta($val,'hourlyRate',true);
                      if(empty($hourlyRate)){
                        $hourlyRate="0";  
                      }
                      $photographerList[$key]['hourlyRate']=$hourlyRate;  
                      $photographerList[$key]['successRate']=getSuccessRate($val);
                      $minHours=get_user_meta($val,'minHours',true);
                      if(empty($minHours)){
                        $minHours="0";  
                      }
                      $photographerList[$key]['minHours']=$minHours;                        
                      $experience=get_user_meta($val,'experience',true);
                      if(empty($experience)){
                        $experience="";  
                      }
                        $photographerList[$key]['experience']=$experience;  
                        $photographerList[$key]['reviewsCount']=(string) getReviewsCount($val);  
                        $portfolioImages=getPortFolioImages($val);
                        $portfolioArray=array();
                        if(!empty($portfolioImages)){
                            $counter=0;
                            foreach($portfolioImages as $k=>$v){
                                $imag=getAttachmentImageById($v['image']);
                                if(!empty($imag)){
                                    $portfolioArray[$counter]['portfolioId']=$v['id'];
                                    $portfolioArray[$counter]['portfolioImage']=getAttachmentImageById($v['image']);     $counter++;
                                }                               
                            }   
                        }            
                        $photographerList[$key]['portfolioImages']=$portfolioArray; 
                 //}
                  
                } 
                if($optype=='web'){
                       if(is_page_template('template-home.php')){
                            $photo = array();
                            foreach ($photographerList as $key => $row)
                            {
                                $d[$key] = $row['distance'];
                                $r[$key] = $row['rating'];
                            }
                            array_multisort($r,SORT_DESC,$d, SORT_ASC, $photographerList);   
                        }else{
                            $photo = array();
                            foreach ($photographerList as $key => $row)
                            {
                                $photo[$key] = $row['distance'];                           
                            } 
                            array_multisort($photo, SORT_ASC, $photographerList); 
                        }                                            
                  }else{
                        $photo = array();
                        foreach ($photographerList as $key => $row)
                        {
                            $photo[$key] = $row['distance'];                           
                        } 
                        array_multisort($photo, SORT_ASC, $photographerList);   
                  }                
                if($offset==0) {
                    $offset=0;
                } else {
                    if($optype=='web'){
                        $offset=($offset-1)*8;                     
                    }else{
                        if(empty($offset)){
                           $offset=0; 
                        }else{
                         $offset=$offset*10;    
                        }                        
                    }                   
                }
                if($optype=='web'){
                  $photographerList = array_slice($photographerList,$offset,8); 
                }else{
                  $photographerList = array_slice($photographerList,$offset,10); 
                }
                
            }      
          }
         }
         return $photographerList; 
    }

    /* Count for pagination */
    function getAllPhotographerListCount($data=null,$optype=null){
       global $wpdb; 
       $offset=$data['offset'];
       if(!empty($data['country'])){
            /*if($data['country']==$data['city']){
              $location=$data['city'];  
            }else{
              $location=$data['city'].' '.$data['country'];  
            } */ 
            $location=$data['country'];           
            $latLong=getLatLong($location); 
           //pr($latLong);
        }else{
          $latLong=array('lat'=>'','long'=>'');  
        }  
        if(!empty($latLong['lat']) and !empty($latLong['long']) and empty($data['currentLat']) and empty($data['currentLong'])){
          $inputLat=$latLong['lat'];
          $inputLong=$latLong['long'];
        }elseif(!empty($latLong['lat']) and !empty($latLong['long']) and !empty($data['currentLat']) and !empty($data['currentLong'])){
           $inputLat=$data['currentLat'];
           $inputLong=$data['currentLong'];  
        }elseif(!empty($data['currentLat']) and !empty($data['currentLong'])){  
          $inputLat=$data['currentLat'];
          $inputLong=$data['currentLong'];  
        }elseif(empty($latLong['lat']) and empty($latLong['long']) and !empty($data['country'])){
           return false;
        }
        $args = array(
             'role' => 'photographer',
             'orderby' => 'ID',
             'order' => 'DESC',
             'fields'=>array('ID')
        );
        $photographer = get_users($args);
        $userArray=array();
        $filteredPhotographer=array();
        $photographerList=array();
        if(!empty($photographer)){
            $photographer=convert_array($photographer);
            foreach($photographer as $k=>$v){   
                $lat=get_user_meta($v['ID'],'lat',true);
                $long=get_user_meta($v['ID'],'long',true);
                 if(empty($lat) and empty($long)){
                        continue;    
                 }
                $getUserStatus=get_user_meta($v['ID'],'userStatus',true);
                if($getUserStatus!='1'){
                  continue;    
                } 
                if(!empty($lat) and !empty($long) and !empty($inputLat) and !empty($inputLong)){
                  $distance=getDistanceBetweenPointsNew($lat,$long,$inputLat,$inputLong);
                  $distance=(int) $distance;
                  if(!empty($data['currentLat']) and !empty($data['currentLong'])){
               
                  }else{
                    if($distance>RADIUS){
                      continue;
                    }   
                  }                          
                }
                if(!empty($data['date']) and !empty($data['time'])){
                    $CheckUserSchedule = CheckUserSchedule($v['ID'],$data['date'],$data['time']);  
                    if(empty($CheckUserSchedule)){
                       continue; 
                    }
                }elseif(!empty($data['date']) and empty($data['time'])){
                    $CheckUserSchedule = CheckUserSchedule($v['ID'],$data['date'],'');  
                    if(empty($CheckUserSchedule)){
                       continue; 
                    }
                } 
                $userArray[$v['ID']]=$distance;                
                
            }   
            if(!empty($userArray)){
               asort($userArray);
               foreach($userArray as $k=>$v){
                   if($v<=RADIUS){
                     $filteredPhotographer[]=$k; 
                    }                   
               }
            }
            $count=0;
            if(!empty($filteredPhotographer)){     
              $allUsers=implode('","',$filteredPhotographer);
              $getQuery='select `ID` from `im_users` where `ID` in ("'.$allUsers.'")';
              $getPhotographer=$wpdb->get_results($getQuery,ARRAY_A);
              $count=count($getPhotographer);
            }
            return $count;
        
     
    }
    }

    /* get photographer basic details */
    function getPhotoGrapherBasicDetails($userId=null){
        global $wpdb;
        

    }

    /* Add Rating or review */
    function addRating($data=null){
        global $wpdb;
        $row=$wpdb->get_row('select `id` from `im_reviews` where `userId`="'.$data['userId'].'" and `requestId`="'.$data['jobId'].'"',ARRAY_A);
        if(!empty($row)){
            return false;
        }else{
           $query='insert into `im_reviews`(`userId`,`otherUserId`,`requestId`,`rateValue`,`comments`,`created`) values("'.$data['userId'].'","'.$data['otherUserId'].'","'.$data['jobId'].'","'.$data['rateValue'].'","'.$data['comment'].'","'.date('Y-m-d H:i:s').'")';
           $wpdb->query($query); 
            return true;
        }
        
    }

    /* Get Ratings or reviews */
    function getReviews($userId=null){
         global $wpdb;
         $reviews=$wpdb->get_results('select * from `im_reviews` where `otherUserId`="'.$userId.'" order by `created` desc',ARRAY_A);
         return $reviews;
    }

    /*check time ago */
    function getTiming($time){
       $time = time() - $time; // to get the time since that moment
       $time = ($time<1)? 1 : $time;
       $tokens = array (
           31536000 => 'year',
           2592000 => 'month',
           604800 => 'week',
           86400 => 'day',
           3600 => 'hour',
           60 => 'minute',
           1 => 'second'
       );
       foreach ($tokens as $unit => $text) {
           if ($time < $unit) continue;
           $numberOfUnits = floor($time / $unit);
           return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
       }

    }

    /* Get User sessions */
    function getUserSessions($userId=null,$type=null){
        global $wpdb;
        $date=date('Y-m-d');
        if($type==0){//today session
          /*$query='select * from `im_requests` where (`status` in("4","5") and `startDate`="'.date('Y-m-d').'" and `userId`="'.$userId.'") or (`status`in("4","5") and `startDate`="'.date('Y-m-d').'" and `otherUserId`="'.$userId.'") order by `startDate` ASC,`startTime` DESC';  */
          $query='select * from `im_requests` where (`status` in("4") and `startDate`="'.date('Y-m-d').'" and `userId`="'.$userId.'") or (`status`in("4") and `startDate`="'.date('Y-m-d').'" and `otherUserId`="'.$userId.'") order by `startDate` ASC,`startTime` DESC';  
        }else{//upcoming sessions
          /* $query='select * from `im_requests` where (`status`in("4","5") and UNIX_TIMESTAMP(`startDate`)> "'.time().'" and `userId`="'.$userId.'") or (`status`in("4","5") and UNIX_TIMESTAMP(`startDate`)> "'.time().'" and `otherUserId`="'.$userId.'")  order by `startDate` ASC,`startTime` DESC';*/  $query='select * from `im_requests` where (`status`in("4") and UNIX_TIMESTAMP(`startDate`)> "'.time().'" and `userId`="'.$userId.'") or (`status`in("4") and UNIX_TIMESTAMP(`startDate`)> "'.time().'" and `otherUserId`="'.$userId.'")  order by `startDate` ASC,`startTime` DESC'; 
        }
        $sessions=$wpdb->get_results($query,ARRAY_A); 
        return $sessions;
    }

    function getUserSessionsCount($userId=null,$type=null){
            global $wpdb;
            $date=date('Y-m-d');
            if($type==0){//today session
              $query='select * from `im_requests` where (`status` in("4") and `startDate`="'.date('Y-m-d').'" and `userId`="'.$userId.'") or (`status`in("4") and `startDate`="'.date('Y-m-d').'" and `otherUserId`="'.$userId.'") order by `startDate` DESC,`startTime` DESC';  
            }else{//upcoming sessions
               $query='select * from `im_requests` where (`status`in("4") and UNIX_TIMESTAMP(`startDate`)> "'.time().'" and `userId`="'.$userId.'") or (`status`in("4") and UNIX_TIMESTAMP(`startDate`)> "'.time().'" and `otherUserId`="'.$userId.'")  order by `startDate` DESC,`startTime` DESC'; 
            }
            $sessions=$wpdb->get_results($query,ARRAY_A); 
            return $sessions;
        }

    function getPhoneNumber($userId=null){
       $phoneNumber='Not Provided';
       if(!empty(get_user_meta($userId,'phoneNumber',true))){
           $phoneNumber=get_user_meta($userId,'phoneNumber',true);
       } 
       return $phoneNumber;
    }

    /*Unset Session*/
    function unsetSession($key=null){
        session_start();
        if(isset($_SESSION[$key])){
          unset($_SESSION[$key]);  
        }        
    }

    /* check is answered */
    function isAnswered($userId=null,$jobId=null){
        global $wpdb;
        $query='select `id` from `im_answers` where (`userId`="'.$userId.'" and `requestId`="'.$jobId.'") or (`otherUserId`="'.$userId.'" and `requestId`="'.$jobId.'")';
        $record=$wpdb->get_row($query,ARRAY_A);
        $response="0";
        if(!empty($record)){
            $response="1";
        }
        return "$response";
    }

    /* get Questions*/
    function getQuestions($userId=null,$jobId=null){
        global $wpdb;
        $checkJob=$wpdb->get_row('select `id` from `im_requests` where (`userId`="'.$userId.'" and `id`="'.$jobId.'") or (`otherUserId`="'.$userId.'" and `id`="'.$jobId.'")');
        if(!empty($checkJob)){
            $args = array(
             'post_type'  => 'questions',
             'post_status'  => 'publish',
             'orderby' => 'date',
             'order' => 'DESC'
            );
            $questions = get_posts($args);
            return $questions;
        }else{
           return 2; 
        }       
    }

    /* Get Suggested routes */
    function getSuggestedRoutes($userId=null,$jobId=null){
        global $wpdb;
        $query=$wpdb->get_results('select * from `im_routes` where `requestId`="'.$jobId.'"',ARRAY_A);
        $route="";
        $routesArray=array();
        if(!empty($query)){
            foreach($query as $k=>$v){
              $routesArray[]=$v['suggestRoute'];  
            }
            $route=implode(',',$routesArray); 
        }
        return $route;
    }
    /* check start date and end date*/
    function checkDateTimeSelectionPattern($start=null,$end=null){
       $crnt=time();
       $start=strtotime($start);
       $end=strtotime($end);
       if($crnt<$start and $end>$start){
           return true; 
       }
       return false;        
    }
    
    /* Send Answer */
    function sendAnswer($userId=null,$otherUserId=null,$jobId=null,$answer=null){
        global $wpdb;
        $record=$wpdb->get_row('select `id` from `im_answers` where `userId`="'.$userId.'" and `requestId`="'.$jobId.'"',ARRAY_A);
        $response=0;
        if(!empty($record)){//already answered
          return false;  
        }else{
          foreach($answer as $k=>$v){
            $wpdb->query('insert into `im_answers`(`userId`,`otherUserId`,`requestId`,`questionId`,`answer`,`created`) values("'.$userId.'","'.$otherUserId.'","'.$jobId.'","'.$v['questionId'].'","'.$v['answer'].'","'.date('Y-m-d H:i:s').'")');      
          }
          return true;
        }      
        
    }
    /* GEt Answers*/ 
    function getAnswer($jobId=null,$questionId=null,$userId=null){
        global $wpdb;
        $row=$wpdb->get_row('select * from `im_answers` where (`requestId`="'.$jobId.'" and `questionId`="'.$questionId.'" and `userId`="'.$userId.'") or (`requestId`="'.$jobId.'" and `questionId`="'.$questionId.'" and `otherUserId`="'.$userId.'")',ARRAY_A);
        if(!empty($row)){
           return $row['answer']; 
        }else{
            return "";
        }
    }
    /* suggest Route*/
    function suggestRoute($jobId=null,$userId=null,$suggestRoute=null,$optype=null){
        global $wpdb;
        $wpdb->query('insert into `im_routes`(`userId`,`requestId`,`suggestRoute`,`created`) values("'.$userId.'","'.$jobId.'","'.$suggestRoute.'","'.date('Y-m-d H:i:s').'")');
        $getRequestDetails=$wpdb->get_row('select `id`,`startDate`,`startTime`,`endTime`,`userId`,`otherUserId` from `im_requests` where `id`="'.$jobId.'"',ARRAY_A);
        if(!empty($getRequestDetails)){
            $otherUserId='';
           if($userId==$getRequestDetails['userId']){
              $otherUserId = $getRequestDetails['otherUserId'];
           }else{
             $otherUserId = $getRequestDetails['userId'];
           }
           $senderName=getUserName($userId);
           insert_notification($userId,'0',$getRequestDetails['id'],$otherUserId,$senderName.' suggested a new route.',$optype); 
           return true;
        }else{
            if($optype=='app'){
               response(0,null,'No Job Found.');  
            }               
        }
    }

    /* Update Lat Long*/
    function updateLatLong($ip=null,$userId=null){
        $getUserLocation=@file_get_contents('http://www.geoplugin.net/json.gp?ip='.$ip);
        if(!empty($getUserLocation)){
            $getUserLocation=json_decode($getUserLocation,true);
            $getUserLocation=convert_array($getUserLocation);
            if(isset($getUserLocation['geoplugin_status']) and $getUserLocation['geoplugin_status']=='200'){
                if(!empty($getUserLocation['geoplugin_city'])){
                    $city=$getUserLocation['geoplugin_city'];
                }else{
                   if(!empty($getUserLocation['geoplugin_region'])){
                      $city=$getUserLocation['geoplugin_region'];
                    } 
                }
                update_user_meta($userId, "address",$city.','.$getUserLocation['geoplugin_countryName']);
                update_user_meta($userId, "lat",$getUserLocation['geoplugin_latitude']);
                update_user_meta($userId, "long",$getUserLocation['geoplugin_longitude']);              
            }
        }       
        /*   $getUserLocation=@file_get_contents('http://ip-api.com/json/'.$ip);
        if(!empty($getUserLocation)){
          $getUserLocation=json_decode($getUserLocation);
          if(isset($getUserLocation->status) and $getUserLocation->status=='success'){
            update_user_meta($userId, "address",$getUserLocation->city.','.$getUserLocation->country);
            update_user_meta($userId, "lat",$getUserLocation->lat);
            update_user_meta($userId, "long",$getUserLocation->lon);              
          }
        }*/
        
    }

    function getLatLongByIp($ip=null){
        $getUserLocation=@file_get_contents('http://www.geoplugin.net/json.gp?ip='.$ip);
        $lat='';
        $long='';
        if(!empty($getUserLocation)){
            $getUserLocation=json_decode($getUserLocation,true);
            $getUserLocation=convert_array($getUserLocation);
            if(isset($getUserLocation['geoplugin_status']) and $getUserLocation['geoplugin_status']=='200'){
               $lat=$getUserLocation['geoplugin_latitude'];
               $long=$getUserLocation['geoplugin_longitude'];                            
            }
        }
        return array('lat'=>$lat,'long'=>$long); 
    }

    /* get address from lat long*/
    function getAddressFromLatLong($lat=null,$lng=null){
         $api='http://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$lng.'&sensor=true';
         $json = @file_get_contents($api);
         $data=json_decode($json);
         $status = $data->status;
         if($status=="OK")
         {
           return $data->results[0]->formatted_address;
         }
    }

    /* Create Session Data*/
    function create_custom_session($userid=null) {
        session_start();
        $user = get_user_by('id',$userid);
        $_SESSION['userdata']=$user->data;  
    }

   /* Delete Session Data*/
   function logout_redirect(){
      $current_user = wp_get_current_user(); 
      session_start();
      unset($_SESSION['userdata']);
      unset($_SESSION['FBRLH_state']);
      unset($_SESSION['facebook_access_token']);
      wp_redirect(home_url()); 
      exit; 
   }

   add_action('wp_logout','logout_redirect');

   /* Get login user id */
   function get_custom_user_id(){
       session_start();
       if(is_user_logged_in()){
            $user['ID']=get_current_user_id();
            if(!empty($user['ID'])){
              $userId=$user['ID'];
            }
           return $userId;
       }
       if(isset($_SESSION['userdata']) and !empty($_SESSION['userdata'])){
            $user=convert_array($_SESSION['userdata']);
            if(!empty($user['ID'])){
              $userId=$user['ID'];
            }

        }
       return $userId;
    }

   /* Get status */
   function getStatus($status=null){
       $status=(string) $status;
       if($status=='0'){
           $title='pending';
       }elseif($status=='1'){
           $title='accepted';
       }elseif($status=='2'){
           $title='declined';
       }elseif($status=='3'){
           $title='modified';
       }elseif($status=='4'){
           $title='paid';
       }elseif($status=='5'){
           $title='cancel';
       }else{
          $title='completed'; 
       }
       return ucfirst($title);
    
   }

   /* View Job Details */
   function viewJobDetails($jobId=null){
       global $wpdb;
       $query='select * from `im_requests` where `id`="'.$jobId.'"';
       $row=$wpdb->get_row($query,ARRAY_A);       
       if(!empty($row)){
           $row['newTimeSlot']="";
           $editTime=$wpdb->get_row('select * from `im_editcount` where `requestId`="'.$jobId.'" order by id desc',ARRAY_A);
           $row['newTimeSlot']="";
           if(!empty($editTime)){
              if(!empty($editTime) and !empty($editTime['startTime'])){
                $row['newTimeSlot'] = $editTime['startTime'].'-'.$editTime['endTime'];
              } 
           }
        }
       return $row;       
   }

   /* Get Module Id*/
   function getModuleId(){
    $url = $_SERVER["REQUEST_URI"];
    $array=array_filter(explode('/',$url));
    $key=max(array_keys($array));
    return $moduleId=$array[$key];
   }
   
   add_action('wp_ajax_reset_session_data', 'reset_session_data');
   add_action('wp_ajax_nopriv_reset_session_data', 'reset_session_data'); 

   function reset_session_data(){
    session_start();
    unset($_SESSION['firstSignup']);
    echo json_encode(array('status'=>'true'));
    die;
   }
 add_action('wp_ajax_latlong', 'latlong');
   add_action('wp_ajax_nopriv_latlong', 'latlong'); 

   function latlong(){
    session_start();
    $_SESSION['lat']=$_POST['lat'];
    $_SESSION['long']=$_POST['long'];
    echo json_encode(array('status'=>'true'));
    die;
   }

   add_action('wp_ajax_changejobstatus', 'changejobstatus');
   add_action('wp_ajax_nopriv_changejobstatus', 'changejobstatus'); 
   
   function changejobstatus(){
       global $wpdb;
       $response=changeRequestStatus($_POST,'web');
       echo json_encode(array('status'=>'true','message'=>$response));
       die;
   }

   /* Change Request Status */
   function changeRequestStatus($data=null,$opType=null){
         global $wpdb;
         if($data['status']==2){            
            if(empty($data['reason'])){
                if($opType=='app'){            
                  response(0,null,'Please enter your reason for cancel.');  
                }
            }
            $query='select `id`,`startTime`,`endTime`,`userId`,`otherUserId` from `im_requests` where (`id`="'.$data['requestId'].'" and `otherUserId`="'.$data['userId'].'" and `status` in("1","4","0")) or (`id`="'.$data['requestId'].'" and `userId`="'.$data['userId'].'" and `status` in("1","4","0"))';
            $getRequestDetails=$wpdb->get_row($query,ARRAY_A);
         }
         elseif($data['status']==3){
            $userType=getUserType($data['userId']);
            if(!empty($userType)){
              $getRequestDetails=$wpdb->get_row('select `id`,`startTime`,`endTime`,`userId`,`otherUserId` from `im_requests` where (`id`="'.$data['requestId'].'" and `otherUserId`="'.$data['userId'].'" and `status`="1") or (`id`="'.$data['requestId'].'" and `userId`="'.$data['userId'].'" and `status`="1")',ARRAY_A);  
            }else{
               $getRequestDetails=array();
                if($opType=='app'){
                    response(0,null,'Please check your user type.');  
                }
            }    
        }else{
           $getRequestDetails=$wpdb->get_row('select `id`,`startTime`,`endTime`,`userId`,`otherUserId` from `im_requests` where `id`="'.$data['requestId'].'" and `otherUserId`="'.$data['userId'].'" and `status`="0" order by id desc',ARRAY_A);   
        }
        if(!empty($getRequestDetails)){
            $senderName=getUserName($data['userId']);
            if($getRequestDetails['userId']==$data['userId']){
              $receiver=$getRequestDetails['otherUserId'];
            }else{
              $receiver=$getRequestDetails['userId'];
            }
            if($data['status']==0){//0-accept
                $status=1;
                $start=$getRequestDetails['startTime'];
                $end=$getRequestDetails['endTime'];
                $findQueryEditTime=$wpdb->get_row('select * from `im_editcount` where `requestId`="'.$getRequestDetails['id'].'" order by id desc',ARRAY_A);
                if(!empty($findQueryEditTime)){
                    if(!empty($findQueryEditTime['startTime'])){
                      $start=$findQueryEditTime['startTime'];
                      $end=$findQueryEditTime['endTime'];                        
                    }
                }
                $wpdb->query('update `im_requests` set `startTime`="'.$start.'",`endTime`="'.$end.'",`status`="'.$status.'",`modified`="'.date('Y-m-d H:i:s').'"  where `id`="'.$getRequestDetails['id'].'"');                 
                 if($opType=='app'){ 
                     insert_notification($data['userId'],'0',$getRequestDetails['id'],$receiver,'Request has been accepted by '.$senderName,$opType);
                     response(1,'Request has been accepted.','No Error Found.'); 
                 } 
                $msg='Request has been successfully accepted.';
            }elseif($data['status']==1){//1-decline
               $status=2; 
                $msg='Request has been declined';
            }elseif($data['status']==3){
               $status=4;  
               $msg='Request has been paid';
            }else{//2-cancel
               $status=5;  
               $msg='Request has been cancelled by '.$senderName.' due to '.$data['reason'].'.';
               $wpdb->query('insert into `im_user_cancelled_job`(`userId`,`jobId`) values("'.$data['userId'].'","'.$getRequestDetails['id'].'")');
               $wpdb->query('update `im_requests` set `status`="'.$status.'",`reason`="'.$data['reason'].'",`modified`="'.date('Y-m-d H:i:s').'"   where `id`="'.$getRequestDetails['id'].'"');                
                if($opType=='app'){
                   insert_notification($data['userId'],'0',$getRequestDetails['id'],$receiver,$msg,$opType); 
                   $msg='Request has been cancelled.';
                   response(1,$msg,'No Error Found.');                
                }      
            }
           insert_notification($data['userId'],'0',$getRequestDetails['id'],$receiver,$msg,$opType); 
           $wpdb->query('update `im_requests` set `status`="'.$status.'",`modified`="'.date('Y-m-d H:i:s').'"  where `id`="'.$getRequestDetails['id'].'"');
           return $msg;
        }else{
           return false;  
        }
       
     }

   add_action('wp_ajax_pay', 'pay');
   add_action('wp_ajax_nopriv_pay', 'pay'); 

    function pay(){
        global $wpdb;
        $getRequestDetails=$wpdb->get_row('select `id`,`startTime`,`endTime`,`userId`,`otherUserId` from `im_requests` where `id`="'.$_POST['jobid'].'"',ARRAY_A);
        $userType=getUserType($getRequestDetails['userId']);
        if(!empty($userType)){//traveler
            $sender=$getRequestDetails['userId'];
            $receiver=$getRequestDetails['otherUserId'];
        }else{//photographer
            $receiver=$getRequestDetails['userId'];
            $sender=$getRequestDetails['otherUserId'];
        }
        $test='update `im_requests` set `status`="4",`modified`="'.date('Y-m-d H:i:s').'"   where `id`="'.$_POST['jobid'].'"';
        $wpdb->query($test);
        insert_notification($sender,'0',$_POST['jobid'],$receiver,'Request has been paid by '.getUserName($sender).'.','web'); 
        echo json_encode(array('status'=>'true'));
        die;

    }


   add_action('wp_ajax_suggesttime', 'suggesttime');
   add_action('wp_ajax_nopriv_suggesttime', 'suggesttime'); 
    /* Suggest time */
   function suggesttime(){
       global $wpdb;
       $record=$wpdb->get_row('select `startDate` from `im_requests` where `id`="'.$_POST['requestId'].'"',ARRAY_A);
       if(!empty($record)){
           $date=getDateFormat($record['startDate']);
         echo json_encode(array('status'=>'true','response'=>$date));
         die;  
       }
   }

   add_action('wp_ajax_edit_time_request', 'edit_time_request');
   add_action('wp_ajax_nopriv_edit_time_request', 'edit_time_request'); 

   /* edit time request web */
   function edit_time_request(){
       global $wpdb;
       $getRequestDetails=$wpdb->get_row('select `id`,`startDate`,`startTime`,`endTime`,`userId`,`otherUserId` from `im_requests` where `id`="'.$_POST['requestId'].'" and status="0"',ARRAY_A);
       if(!empty($getRequestDetails)){
          if($_POST['userId']==$getRequestDetails['userId']){
               $receiverId=$getRequestDetails['otherUserId'];
           }else{
               $receiverId=$getRequestDetails['userId'];
           }
           $getEditTime=$wpdb->get_row('select * from `im_editcount` where  `requestId`="'.$getRequestDetails['id'].'"'); 
           if(empty($getEditTime)){
               $wpdb->query('update `im_requests` set  `userId`="'.$_POST['userId'].'",`otherUserId`="'.$receiverId.'",`modified`="'.date('Y-m-d H:i:s').'"   where `id`="'.$getRequestDetails['id'].'"');
               $wpdb->query('insert into `im_editcount`(`requestId`,`userId`,`startTime`,`endTime`) values("'.$getRequestDetails['id'].'","'.$_POST['userId'].'","'.$_POST['startTime'].'","'.$_POST['endTime'].'")');  
               $senderName=getUserName($_POST['userId']);
               insert_notification($_POST['userId'],'0',$getRequestDetails['id'],$receiverId,$senderName.' Suggested New time for your request.','web'); 
               echo json_encode(array('status'=>'true','response'=>'Time suggested successfully.')); 
               die;
           }else{
              echo json_encode(array('status'=>'false','response'=>'You have already suggested time for this job.')); 
              die;               
           }
       }else{
            echo json_encode(array('status'=>'false','response'=>'No Request found.')); 
            die;
       }
   }

   add_action('wp_ajax_send_request','send_request');
   add_action('wp_ajax_nopriv_send_request','send_request');

   /* send request from web */
   function send_request(){
        global $wpdb;
        $data=$_POST;
        $photographers = getAllPhotographers();
        $data['startDate']=inputChangeDate($data['startDate']);
        $CheckUserSchedule = CheckUserSchedule($data['otherUserId'],$data['startDate'],$data['startTime'].'-'.$data['endTime']);
        if(empty($CheckUserSchedule)){
          response(0,null,"Photographer is not available for this time duration.");         
        }
        $startDate = $data['startDate'].' '.$data['startTime'];
        $endDate = $data['startDate'].' '.$data['endTime'];
        $checkTime = checkDateTimeSelectionPattern($startDate,$endDate);
        if(empty($checkTime)){
          response(0,null,"Please check your selected date time.");   
        }
        if(!in_array($data['otherUserId'],$photographers)){
          response(0,null,"No Photographer found.");       
        }
        $getTimeDifference=strtotime($endDate) - strtotime($startDate);
        $getHireHours= $getTimeDifference/3600;
        $getMinHours=get_user_meta($data['otherUserId'],'minHours',true);
        if($getMinHours>$getHireHours){
            if(!empty($data['checkVal'])){
             response(2,null,"This Photographer will work for minimum $getMinHours hour(s), To hire this Photographer you need to pay minimum for $getMinHours hour(s). Please click on the continue button to proceed.");    
            }               
        }
        if($data['userId']==$data['otherUserId']){
          response(0,null,"Please do not try to send request to yourself.");      
        } 
        $response=sendRequest($data);
        if(!empty($response)){
            session_start();
            unset($_SESSION['date']);
            unset($_SESSION['startTime']);
            unset($_SESSION['endTime']);
           response(1,'Request sent successfully.',"No Error Found.");   
        }else{
           response(0,null,"Request not sent.");    
        }
   }

   add_action('wp_ajax_reply_on_new_time','reply_on_new_time');
   add_action('wp_ajax_nopriv_reply_on_new_time','reply_on_new_time');

   /* Reply on new time*/
   function reply_on_new_time(){
       global $wpdb;
       $data=$_POST;
       $getRequestDetails=$wpdb->get_row('select `id`,`startDate`,`startTime`,`endTime`,`userId`,`otherUserId` from `im_requests` where `id`="'.$data['requestId'].'" and `otherUserId`="'.$data['userId'].'" and `status`="0"',ARRAY_A);
        if(!empty($getRequestDetails)){
            $getAddedRecords=$wpdb->get_row('select * from `im_editcount` where `requestId`="'.$getRequestDetails['id'].'"',ARRAY_A);
            if(empty($data['startTime']) and empty($data['endTime'])){
                if($getRequestDetails['userId']==$data['userId']){
                   $receiverId = $getRequestDetails['otherUserId'];
                }else{
                   $receiverId = $getRequestDetails['userId']; 
                }
                $getAddedRecords=$wpdb->get_row('select * from `im_editcount` where `requestId`="'.$getRequestDetails['id'].'"',ARRAY_A);
                if(!empty($getAddedRecords)){
                   $wpdb->query('update `im_requests` set `userId`="'.$getRequestDetails['otherUserId'].'",`otherUserId`="'.$getRequestDetails['userId'].'",`modified`="'.date('Y-m-d H:i:s').'" where `id`="'.$getRequestDetails['id'].'"');
                   $clearTimeslot=$wpdb->query('update `im_editcount` set `startTime`="",`endTime`="" where `requestId`="'.$getRequestDetails['id'].'"'); 
                   $wpdb->query('insert into `im_editcount`(`requestId`,`userId`,`startTime`,`endTime`) values("'.$getRequestDetails['id'].'","'.$data['userId'].'","","")');
                   $senderName=getUserName($data['userId']);
                   insert_notification($data['userId'],'0',$getRequestDetails['id'],$receiverId,$senderName.' requested for original time.','web');  
                }  
                response(1,'Original time slot selected successfully.','No Error Found.');
            }
        }else{
           response(0,null,'No Job Request Found.');   
        }  
        
   }

    add_action('wp_ajax_change_password','change_password');
    add_action('wp_ajax_nopriv_change_password','change_password');

   function change_password(){
        session_start();
        $data=$_POST;
        $checkOldPassword= wp_check_password($data['currentPassword'],$_SESSION['userdata']->user_pass,$data['userId']);
        if(!empty($checkOldPassword)){
           wp_set_password($data['newPassword'],$data['userId']); 
           response(1,1,'No Error Found.');    
        }else{
           response(0,null,'You have entered incorrect old Password.');    
        }
   }

    /* Update Personal Information */
    function updatePersonalInformation($data=null,$userId=null){
        $loggedUser['ID']=$userId;
        $userType=get_user_meta($userId,'userType',true);
        if(!empty($data['contactNo'])){
          checkPhoneValid($data['contactNo']);  
        }    
        update_user_meta($loggedUser['ID'],'bio',trim($data['bio']));  
        if(!empty($data['address'])){
          update_user_meta($loggedUser['ID'],'address',$data['address']);   
        }
        if($data['optype']=='web'){
           $latLongData= getLatLong($data['address']);
           update_user_meta($loggedUser['ID'],'lat',$latLongData['lat']); 
           update_user_meta($loggedUser['ID'],'long',$latLongData['long']);  
        }
        if(!empty($data['lat'])){
          update_user_meta($loggedUser['ID'],'lat',$data['lat']);   
        }
        if(!empty($data['long'])){
          update_user_meta($loggedUser['ID'],'long',$data['long']);   
        }
        if(!empty($data['profileImage']) and $data['optype']=='web'){
            $upload_dir = wp_upload_dir();                
            $image=explode(',',$data['profileImage']);
            $data['profileImage']=$image[1];
            $dataSource = base64_decode($data['profileImage']);
            $file_name = uniqid() . '.png';
            $file = $upload_dir['path'].'/'.$file_name;
            $return = $upload_dir['url'].'/'.$file_name;
            $success = file_put_contents($file, $dataSource);
            $filetype = wp_check_filetype( basename( $file ), null );
            $parent_post_id="";
            $attachment = array(
                'guid'           => $return,
                'post_author'	=>	$loggedUser['ID'],
                'post_mime_type' => $filetype['type'],
                'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $file ) ),
                'post_content'   => '',
                'post_status'    => 'inherit'
            );
            $attach_id = wp_insert_attachment( $attachment, $file, $parent_post_id );
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
            $res1= wp_update_attachment_metadata( $attach_id, $attach_data ); 
            update_user_meta($loggedUser['ID'],'user_image',$attach_id);  
        }
        if(!empty($data['bannerImage']) and $data['optype']=='web'){
            $upload_dir = wp_upload_dir();                
            $image=explode(',',$data['bannerImage']);
            $data['bannerImage']=$image[1];
            $dataSource = base64_decode($data['bannerImage']);
            $file_name = uniqid() . '.png';
            $file = $upload_dir['path'].'/'.$file_name;
            $return = $upload_dir['url'].'/'.$file_name;
            $success = file_put_contents($file, $dataSource);
            $filetype = wp_check_filetype( basename( $file ), null );
            $parent_post_id="";
            $attachment = array(
                'guid'           => $return,
                'post_author'	=>	$loggedUser['ID'],
                'post_mime_type' => $filetype['type'],
                'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $file ) ),
                'post_content'   => '',
                'post_status'    => 'inherit'
            );
            $attach_id = wp_insert_attachment( $attachment, $file, $parent_post_id );
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
            $res1= wp_update_attachment_metadata( $attach_id, $attach_data ); 
            update_user_meta($loggedUser['ID'],'bannerImage',$attach_id);  
        }
        update_user_meta($loggedUser['ID'],'firstName',$data['firstName']);  
        update_user_meta($loggedUser['ID'],'lastName',$data['lastName']); update_user_meta($loggedUser['ID'],'first_name',$data['firstName']);  
        update_user_meta($loggedUser['ID'],'last_name',$data['lastName']);  
        update_user_meta($loggedUser['ID'],'gender',$data['gender']);
        if(!empty($data['contactNo'])){
            update_user_meta($loggedUser['ID'],'contactNo',$data['contactNo']);    
        }
        update_user_meta($loggedUser['ID'],'dob',$data['dob']);  
        if($data['optype']=='web'){
            if(empty($userType)){
                update_user_meta($loggedUser['ID'],'bio',trim($data['bio']));  
                update_user_meta($loggedUser['ID'],'hourlyRate',$data['hourlyRate']);  
                update_user_meta($loggedUser['ID'],'minHours',$data['minHours']);             
                update_user_meta($loggedUser['ID'],'experience',$data['experience']);             
            }            
        }        
    }

    add_action('wp_ajax_update_profile','update_profile');
    add_action('wp_ajax_nopriv_update_profile','update_profile');

    function update_profile(){
        updatePersonalInformation($_POST,$_POST['userId']);
        echo json_encode(array('status'=>'true','message'=>'Profile information updated successfully.'));
        die;
    }

    add_action('wp_ajax_create_session','create_session');
    add_action('wp_ajax_nopriv_create_session','create_session');

    function create_session(){
        session_start();
        if(isset($_POST['type'])){
         $_SESSION['type']=$_POST['type'];
        }
        echo json_encode(array('status'=>'true'));
        die;
        
    }

    add_action('wp_ajax_delete_portfolio','delete_portfolio');
    add_action('wp_ajax_nopriv_delete_portfolio','delete_portfolio');

    function delete_portfolio(){
        global $wpdb;
        $response=deletePortfolioImages($_POST['delId']);
        if(!empty($response)){
           echo json_encode(array('status'=>'true')); 
        }else{
           echo json_encode(array('status'=>'false'));  
        }
        die;       
    }
    /* get Payment History*/
    function getPaymentHistory($userId=null,$type=null){
        global $wpdb;
        if(!empty($type)){//working
           $history=$wpdb->get_results('select * from `im_requests` where (`userId`="'.$userId.'" and `status`="4") or (`otherUserId`="'.$userId.'" and `status`="4") order by `startDate` desc',ARRAY_A); 
        }else{//complete
           $history=$wpdb->get_results('select * from `im_requests` where (`userId`="'.$userId.'" and `status`="6") or (`otherUserId`="'.$userId.'" and `status`="6")  order by `startDate` desc',ARRAY_A); 
        }
        return $history;
    }
    /* GEt Job details*/
    function getJobDetails($jobId=null){
        global $wpdb;
        $history=$wpdb->get_row('select * from `im_requests` where `id`="'.$jobId.'"',ARRAY_A); 
        return $history;
    }

    add_action('wp_ajax_update_portfolio','update_portfolio');
    add_action('wp_ajax_nopriv_update_portfolio','update_portfolio');

    /* Update Portfolio*/
    function update_portfolio(){
        addPortfolioImages($_POST['userId'],$_POST['portfolio']);
        echo json_encode(array('status'=>'true')); 
        die;         
    }

    function isFeedback($jobId=null,$userId=null){
        global $wpdb;
        $rec=$wpdb->get_row('select * from `im_reviews` where `requestId`="'.$jobId.'" and `userId`="'.$userId.'"',ARRAY_A);
        $resp='false';
        if(!empty($rec)){
         $resp='true';  
        }
        return $resp;      
    }

    add_action('wp_ajax_show_notifications','show_notifications');
    add_action('wp_ajax_nopriv_show_notifications','show_notifications');

    /* Show notifications */
    function show_notifications(){
        $userId=get_custom_user_id(); 
        $url=site_url().'/api/getNotifications.php?userId='.$userId;
        $response=file_get_contents($url);
        $finalArray=array();
        $html='';
        if($response){
           $response=json_decode($response,true); 
            if(!empty($response['result'])){
                $finalArray=$response['result'];
                foreach($finalArray as $k=>$v){
                    $class='';
                    if(!empty($v['isRead'])){
                        $class='markAsRead'; 
                    }
                  $html.='<div class="notificationWrapper"><a class="dropdown-item  markAsReadNotify '.$class.'"  data-attr-id="'.$v['id'].'" href="javascript:void(0);"><span>'.$v['name'].'</span><p>'.$v['title'].'</p></a></div>';  
                }
            }else{
             $html.='<p class="dropdown-item">No Notifications found</p>'; 
          }
        }else{
           $html='<p class="dropdown-item">No Notifications found</p>'; 
        } 
        echo $html;
        die;
        
    }
     
    add_action('wp_ajax_mark_as_read','mark_as_read');
    add_action('wp_ajax_nopriv_mark_as_read','mark_as_read');

    function mark_as_read(){
        $res=markReadNotification($_POST['userId'],$_POST['notificationId']);
        if(!empty($res)){            
          $count=getNotificationCount($_POST['userId']);
          response(1,'Notification marked read successfully.',$count);
        }else{
           response(0,null,'No Notification found.'); 
        }
    }

   add_action('wp_ajax_notification_counts','notification_counts');
   add_action('wp_ajax_nopriv_notification_counts','notification_counts');

   function notification_counts(){
       $user=get_custom_user_id();
       $count=getNotificationCount($user);
       echo $count;die;
       
   }


   /* Mark read notifications */
   function markReadNotification($userId=null,$notificationId=null){
        global $wpdb;
        $query='select * from `im_notifications` where `id`="'.$notificationId.'" and `opponentId`="'.$userId.'" and `status`="0"';
        $res=$wpdb->get_row($query,ARRAY_A);
        if(!empty($res)){
           $query=$wpdb->query('update `im_notifications` set `status`="1"  where `id`="'.$notificationId.'"');
           return true;
        }else{
           return false;
        }
   }
   
    add_action('wp_ajax_delete_notification','delete_notification');
    add_action('wp_ajax_nopriv_delete_notification','delete_notification');

    function delete_notification(){
        pr($_POST);
    }

    /*get request link */
    function getJobLink($jobId=null){
        global $wpdb;
        $link='';
        $res=$wpdb->get_row('select `link` from `im_shootlinks` where `requestId`="'.$jobId.'" order by id desc',ARRAY_A);
        if(!empty($res)){
            $link=$res['link']; 
            $a = 'How are you?';
            if (strpos($link, 'http://') === false and strpos($link, 'https://') === false) {
               $link='http://'.$link;
            }
        }
        return $link;
    }

    add_action('wp_ajax_mark_complete_job','mark_complete_job');
    add_action('wp_ajax_nopriv_mark_complete_job','mark_complete_job');

    /* Mark complete JOb*/
    function mark_complete_job(){        
        $data=$_POST;
        $data['optype']='web';
        sendLinkRequest($data);
    }
    
    function sendLinkRequest($data=null){
        global $wpdb;
        if($data['type']=='0'){//complete the job
          $query=$wpdb->get_row('select * from `im_requests` where (`userId`="'.$data['userId'].'" and `status`="4" and `id`="'.$data['jobId'].'") or (`otherUserId`="'.$data['userId'].'" and `status`="4" and `id`="'.$data['jobId'].'")',ARRAY_A); 
            if(!empty($query)){
                if($query['userId']==$data['userId']){
                    $otherUserId=$query['otherUserId'];
                }else{
                    $otherUserId=$query['userId'];
                }
                $senderName=getUserName($data['userId']);
                $wpdb->query('update `im_requests` set `status`="6",`modified`="'.date('Y-m-d H:i:s').'" where `id`="'.$data['jobId'].'"'); 
                insert_notification($data['userId'],'0',$data['jobId'],$otherUserId,'Job Marked as completed.',$data['optype']);
                response(1,'Job marked as completed.','No Error found.');
            }else{
              response(0,null,'No Job found.');  
            }
        }
        elseif($data['type']=='1'){//send request for link
            $query=$wpdb->get_row('select * from `im_requests` where (`userId`="'.$data['userId'].'" and `status` in ("4","6") and `id`="'.$data['jobId'].'") or (`otherUserId`="'.$data['userId'].'" and `status` in ("4","6") and `id`="'.$data['jobId'].'")',ARRAY_A); 
            if(!empty($query)){               
                if($query['userId']==$data['userId']){
                    $otherUserId=$query['otherUserId'];
                }else{
                    $otherUserId=$query['userId'];
                }
                $senderName=getUserName($data['userId']);
                $wpdb->query('insert into `im_linkrequests`(`userId`,`otherUserId`,`requestId`,`created`) values("'.$data['userId'].'","'.$otherUserId.'","'.$data['jobId'].'","'.date('Y-m-d H:i:s').'")'); 
                insert_notification($data['userId'],'0',$data['jobId'],$otherUserId,$senderName.' requested for a link.',$data['optype']);
                response(1,'Link request sent successfully.','No Error found.');
            }else{
              response(0,null,'No Job found.');  
            }
        }
        else{//Reminder
            $query=$wpdb->get_row('select * from `im_requests` where (`userId`="'.$data['userId'].'" and `status`="4" and `id`="'.$data['jobId'].'") or (`otherUserId`="'.$data['userId'].'" and `status`="4" and `id`="'.$data['jobId'].'")',ARRAY_A); 
            if(!empty($query)){
                if($query['userId']==$data['userId']){
                    $otherUserId=$query['otherUserId'];
                }else{
                    $otherUserId=$query['userId'];
                }
                $senderName=getUserName($data['userId']);    
                $otherSenderName=getUserName($otherUserId);    
                insert_notification($data['userId'],'0',$data['jobId'],$otherUserId,$senderName.' sent reminder to '.$otherSenderName.' for complete a job.',$data['optype']);
                response(1,'You have sent reminder to '.$otherSenderName.' to complete this job.','No Error found.');
            }else{
                response(0,null,'No Job found.');  
            }
         }
    }

    add_action('wp_ajax_shoot_link','shoot_link');
    add_action('wp_ajax_nopriv_shoot_link','shoot_link');

    function shoot_link(){
        global $wpdb;
        $record=$wpdb->get_row('select * from `im_requests` where `id`="'.$_POST['jobId'].'"',ARRAY_A);
        if(!empty($record)){
          if($record['userId']==$_POST['userId']){
              $otherUserId=$record['otherUserId'];
          }else{
              $otherUserId=$record['userId'];
          }
          echo json_encode(array('status'=>'true','response'=>$otherUserId));  
          die;
        }else{
          echo json_encode(array('status'=>'false','response'=>'No data found.'));  
          die;
            
        }
    }

    add_action('wp_ajax_send_reminder_to_traveler','send_reminder_to_traveler');
    add_action('wp_ajax_nopriv_send_reminder_to_traveler','send_reminder_to_traveler');

    function send_reminder_to_traveler(){
        $data=$_POST;
        $data['optype']='web';
        sendLinkRequest($data);
    }

    add_action('wp_ajax_post_shoot_link','post_shoot_link');
    add_action('wp_ajax_nopriv_post_shoot_link','post_shoot_link');

    function post_shoot_link(){ 
       $_POST['optype']='web';
       sendLinkTotraveler($_POST);         
    }

    function sendLinkTotraveler($data=null){
        global $wpdb;
        $query=$wpdb->get_row('select * from `im_requests` where (`userId`="'.$data['userId'].'" and `otherUserId`="'.$data['otherUserId'].'" and `id`="'.$data['jobId'].'" and `status` in("4","6")) or (`userId`="'.$data['otherUserId'].'" and `otherUserId`="'.$data['userId'].'" and `id`="'.$data['jobId'].'" and `status` in("4","6") )');
        if(!empty($query)){
            $wpdb->query('insert into `im_shootlinks`(`userId`,`otherUserId`,`requestId`,`link`,`created`) values("'.$data['userId'].'","'.$data['otherUserId'].'","'.$data['jobId'].'","'.$data['link'].'","'.date('Y-m-d H:i:s').'")');
            $senderName=getUserName($data['userId']);
            insert_notification($data['userId'],'0',$data['jobId'],$data['otherUserId'],$senderName.' posted a link .',$data['optype']);   
            response(1,'Link sent successfully.','No Error Found.');
        }else{
            response(0,null,'No Job Found.');
        }
    }

    add_action('wp_ajax_post_schedule','post_schedule');
    add_action('wp_ajax_nopriv_post_schedule','post_schedule');

    /* Post schedule */
    function post_schedule(){
        global $wpdb;
        $finalArray=array();
        $crntUserLoginid=get_custom_user_id();        
        $lastTemp=0;
        if(!empty($_POST)){
           unset($_POST['action']);
           $wpdb->query('delete from `im_schedules` where `userId`="'.$crntUserLoginid.'"');
           foreach($_POST as $k=>$v){              
             $start=array();
             $end=array();           
             $count= count($_POST[$k]['startTime']);
             for($counter=0;$counter<$count;$counter++){                     
               $start=$_POST[$k]['startTime'][$counter];
               $end=$_POST[$k]['endTime'][$counter];
                 if(!empty($start) and !empty($end)){
                      $wpdb->query('insert into `im_schedules`(`userId`,`dayId`,`startTime`,`endTime`) values("'.$crntUserLoginid.'","'.$k.'","'.$start.'","'.$end.'")');
                      $lastTemp=1;
                 }                     
             }                
          }           
        }
        if(!empty($lastTemp)){  
            echo json_encode(array('status'=>'true'));
            die;
        }else{
            echo json_encode(array('status'=>'false'));
            die;
            
        }
    }
    
    function add_free_schedule($day=null,$start=null,$end=null){
        $data['userId']=get_custom_user_id();
        $data['startTime']=$start;
        $data['endTime']=$end;
        $data['dayId']=$day;
        $resp=addBusySchedule($data);
        return $resp;
        
    }

    add_action('wp_ajax_forgot_password','forgot_password');
    add_action('wp_ajax_nopriv_forgot_password','forgot_password');

    function forgot_password(){                
        if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^",$_POST['email']))
        {
          echo json_encode(array('status'=>'false','message'=>'Please enter valid Email Id.')); 
           die;   
        }
        $email=get_user_by('email',$_POST['email']);
        if(!empty($email)){  
            $email=convert_array($email);
            $id=$email['data']['ID'];
            $token=get_user_meta($id,'tokenfield',true);
            $emailTemplate=file_get_contents(get_stylesheet_directory_uri().'/email-template.php');
            $emailTemplate=str_replace('[NAME]',getUserName($email['data']['ID']),$emailTemplate);
            $message='To reset password click on the link <a href="https://imarkclients.com/photorabel/reset-password/?token='.$token.'&email='.$email['data']['user_email'].'">Click Here</a>. This link helps you to reset your password.';
            $emailTemplate=str_replace('[MESSAGE]',$message,$emailTemplate);
            send_email($email['data']['user_email'],'Reset Password',$emailTemplate);
            update_user_meta($email->ID,'tokenfield',randomString(8));
            echo json_encode(array('status'=>'true','message'=>'Reset password link has been sent to your email.')); 
            die;
        }else{
            echo json_encode(array('status'=>'false','message'=>'Please check your entered Email Id.')); 
            die;
        }
    }

    add_action('wp_ajax_reset_password_web','reset_password_web');
    add_action('wp_ajax_nopriv_reset_password_web','reset_password_web');

    function reset_password_web(){
        if($_POST['data']=='true'){
             if(!empty($_POST['email'])){
                $get=get_user_by('email',$_POST['email']);
                if(!empty($get)){
                    $get=convert_array($get);
                    if($_POST['password']==$_POST['confirmPassword']){
                        update_user_meta($get['ID'],'tokenfield',randomString(8));
                        wp_set_password($_POST['password'],$get['ID']);
                        echo json_encode(array('status'=>'true','message'=>'Password has been reset.'));
                        die; 
                    }

                }else{
                     echo json_encode(array('status'=>'false','message'=>'No Email found.'));
                     die;                
                }          

            }else{
                echo json_encode(array('status'=>'false','message'=>'No Email found.'));
                die;
            }            
        }else{
             echo json_encode(array('status'=>'exist','message'=>'No Email found.'));                
           die;
        }
              
    }

    add_action('wp_ajax_post_rating','post_rating');
    add_action('wp_ajax_nopriv_post_rating','post_rating');

    /* POST rating*/
    function post_rating(){
        global $wpdb;
        $data=$_POST;           
        $userType=get_user_meta($_POST['userId'],'userType',true);
        $job=$wpdb->get_row('select * from `im_requests` where `id`="'.$_POST['jobId'].'"',ARRAY_A);
        if(!empty($job)){
            if($job['userId']==$_POST['userId']){
                $otherUserId=$job['otherUserId'];
            }else{
                $otherUserId=$job['userId'];
            }
            $data['otherUserId']=$otherUserId;
            $data['type']="0";
            $addRating = addRating($data);  
            if(!empty($userType)){//traveller
              $status='4';  
            }else{//photographer
              $status='6';    
            }
             $query=$wpdb->get_row('select * from `im_requests` where (`userId`="'.$data['userId'].'" and `status`="'.$status.'" and `id`="'.$data['jobId'].'") or (`otherUserId`="'.$data['userId'].'" and `status`="'.$status.'" and `id`="'.$data['jobId'].'")',ARRAY_A); 
            if(!empty($query)){
                if($query['userId']==$data['userId']){
                    $otherUserId=$query['otherUserId'];
                }else{
                    $otherUserId=$query['userId'];
                }
                $senderName=getUserName($data['userId']);
                if(!empty($userType)){
                    $wpdb->query('update `im_requests` set `status`="6",`modified`="'.date('Y-m-d H:i:s').'" where `id`="'.$data['jobId'].'"'); 
                    insert_notification($data['userId'],'0',$data['jobId'],$otherUserId,'Job marked completed by  '.$senderName.'.');                    
                }
            }
            insert_notification($_POST['userId'],'1',$data['jobId'],$data['otherUserId'],'Rating has been added by '.$senderName); 
            echo json_encode(array('status'=>'true','message'=>"Review added successfully."));
            die;            
        }else{
            echo json_encode(array('status'=>'false','message'=>'No Job found.'));
            die;
        }
    }

    add_action('wp_ajax_suggest_route','suggest_route');
    add_action('wp_ajax_nopriv_suggest_route','suggest_route');

    function suggest_route(){
        $data=$_POST;
        $suggestRoute=suggestRoute($data['jobId'],$data['userId'],$data['route'],'web');
        if(!empty($suggestRoute)){
          response(1,'Route suggested successfully.','No Error Found.');    
        }else{
          response(0,null,'Error Found.');    
        }       
    }

    function getContacts($userId=null){
        global $wpdb;
        $records=$wpdb->get_results('select * from `im_requests` where (`userId`="'.$userId.'" or  `otherUserId`="'.$userId.'") and  status not in ("0","2")');
        return count($records);        
    }

    /* change Date format*/
    function inputChangeDate($inputDate=null){
      $date=str_replace('/','-',$inputDate);
      $date=date('m/d/Y',strtotime($date));
      return $date;
    }

    add_action('admin_menu', 'admin_custom_menus');
    function admin_custom_menus(){
       add_menu_page('Pending Photographer', 'Pending Photographer', 'manage_options', 'photographers', 'allPhotographer','dashicons-media-interactive',10);
       add_menu_page('All jobs', 'All Jobs', 'manage_options', 'jobs', 'allJobs','dashicons-portfolio',10);
       add_submenu_page('jobs','New Requests','New Requests', 'manage_options','new-requests','newRequests');
       add_submenu_page('jobs','Paid Requests','Paid Requests', 'manage_options','completed-jobs','paidRequests');
       add_submenu_page('jobs','Accepted Jobs','Accepted Jobs', 'manage_options','accepted-jobs','acceptedJobs');
       add_submenu_page('jobs','Declined Jobs','Declined Jobs', 'manage_options','declined-jobs','declinedJobs');
       add_submenu_page('jobs','Cancelled Jobs','Cancelled Jobs', 'manage_options','cancelled-jobs','cancelledjobs');
       add_submenu_page('jobs','Completed Jobs','Completed Jobs', 'manage_options','completed-jobs','cancelledjobs');
       add_menu_page('All Requests for a link', 'All Requests for a link', 'manage_options', 'all-requests-for-a-link', 'allRequestsForALink','dashicons-admin-links',10);
       add_menu_page('Shoot Links', 'Shoot links', 'manage_options', 'shoot-link', 'shootLink','dashicons-editor-unlink',10);
    } 

    function allJobs(){
       include('admin-templates/all-jobs.php'); 
    }

    function newRequests(){
       include('admin-templates/new-requests.php'); 
    }

    function paidRequests(){
       include('admin-templates/paid-requests.php'); 
    }

    function declinedJobs(){
       include('admin-templates/declined-jobs.php'); 
    }

    function acceptedJobs(){
       include('admin-templates/accepted-jobs.php'); 
    }

    function cancelledjobs(){
       include('admin-templates/cancelled-jobs.php'); 
    }

    function allPhotographer(){
        include('admin-templates/all-photographers.php');
    }
    function allRequestsForALink(){
       include('admin-templates/all-requests-for-a-link.php'); 
    }
    function shootLink(){
       include('admin-templates/shoot-link.php'); 
    }

    add_action( 'show_user_profile', 'extra_user_profile_fields' );
    add_action( 'edit_user_profile', 'extra_user_profile_fields' );

    function extra_user_profile_fields($userid=null){
        include('admin-templates/show-profiles.php'); 
    }
    add_action('wp_ajax_paginate_function','paginate_function');
    add_action('wp_ajax_nopriv_paginate_function','paginate_function');
    
    function paginate_function($item_per_page, $current_page, $total_records, $total_pages){
        $pagination = '';
        if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages){
            //verify total pages and current page number
            $pagination .= '<nav aria-label="Page navigation example"><ul class="pagination">';

            $right_links    = $current_page + 3; 
            $previous       = $current_page - 3; //previous link 
            $next           = $current_page + 1; //next link
            $first_link     = true; //boolean var to decide our first link

            if($current_page > 1){
                $previous_link = ($previous==0)?1:$previous;
                $pagination .= '<li class="first page-item"><a href="javascript:void(0);"  class="paging page-link"  data-page="1" title="First">&laquo;</a></li>'; //first link
                $pagination .= '<li><a href="javascript:void(0);"  class="paging page-link" data-page="'.$previous_link.'" title="Previous">&lt;</a></li>'; //previous link
                    for($i = ($current_page-2); $i < $current_page; $i++){ //Create left-hand side links
                        if($i > 0){
                            $pagination .= '<li class="page-item"><a  class="paging page-link"  href="javascript:void(0);" data-page="'.$i.'" title="Page'.$i.'">'.$i.'</a></li>';
                        }
                    }   
                $first_link = false; //set first link to false
            }

            if($first_link){ //if current active page is first link
                $pagination .= '<li class="first active page-item"><a href="javascript:void(0);" class="active" >'.$current_page.'</a></li>';
            }elseif($current_page == $total_pages){ //if it's the last active link
                $pagination .= '<li class="last active page-item"><a href="javascript:void(0);" class="active" >'.$current_page.'</a></li>';
            }else{ //regular current link
                $pagination .= '<li class="active page-item"><a href="javascript:void(0);" class="active" >'.$current_page.'</a></li>';
            }

            for($i = $current_page+1; $i < $right_links ; $i++){ //create right-hand side links
                if($i<=$total_pages){
                    $pagination .= '<li class="page-item"><a href="javascript:void(0);" class="paging page-link" data-page="'.$i.'" title="Page '.$i.'">'.$i.'</a></li>';
                }
            }
            if($current_page < $total_pages){ 
                    $next_link = ($i > $total_pages)? $total_pages : $i;
                    $pagination .= '<li  class="page-item"><a href="javascript:void(0);"  class="paging page-link" data-page="'.$next_link.'" title="Next">&gt;</a></li>'; //next link
                    $pagination .= '<li class="last page-item"><a href="javascript:void(0);"  class="paging page-link" data-page="'.$total_pages.'" title="Last">&raquo;</a></li>'; //last link
            }

            $pagination .= '</ul></nav> '; 
     
        }
        echo  $pagination;
    }

    add_action('wp_ajax_pagination','pagination');
    add_action('wp_ajax_nopriv_pagination','pagination');

    function pagination(){        
        if(isset($_POST['page']) and !empty($_POST['page'])){
         $_POST['offset']=$_POST['page']; 
        }
        $allPhotographer=getAllPhotographerList($_POST,'web');
        include('admin-templates/photo.php'); 
        exit();
     }

    function my_login_logo() { 
       $custom_logo_id = get_theme_mod( 'custom_logo' );
       $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
    ?>
        <style type="text/css">
            #login h1 a,.login h1 a {
                background-image: url(<?php echo $image[0]; ?>);
                height:65px;
                width:320px;
                background-size: 320px 65px;
                background-repeat: no-repeat;
                padding-bottom: 30px;
            }
            body {
                background-color: #001d2f !important;
            }
            .login #backtoblog a, .login #nav a { color: #fff !important; }
            .login #backtoblog a:focus, .login #nav a:focus, .login #backtoblog a:hover, .login #nav a:hover { color: #2cc0d9 !important; }
        </style>
    <?php }
    add_action( 'login_enqueue_scripts', 'my_login_logo' );
    /* start Website functions */
    add_action('init', 'questions');
    function questions() {
        register_post_type('questions', array(
            'labels' => array(
                'name' => __("Questions"),
                'singular_name' => __("Question"),
                'all_items' => __("All Questions"),
                'edit_item' => __("Edit Question"),
                'add_new' => __("Add New")
            ),
            'rewrite' => array('slug' => 'questions', 'with_front' => true),
            'capability_type' => 'post',
            'public' => true,
            'hierarchical' => true,
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'author',
            )
                )
        );
        register_taxonomy('questions', 'questions', array('label' => __("Question Categories"), 'show_ui' => true, 'show_admin_column' => true, 'rewrite' => false, 'hierarchical' => true,));
    }

    add_action('init', 'testimonials');
    function testimonials() {
        register_post_type('testimonials', array(
            'labels' => array(
                'name' => __("Testimonials"),
                'singular_name' => __("testimonial"),
                'all_items' => __("All Testimonials"),
                'edit_item' => __("Edit testimonial"),
                'add_new' => __("Add New")
            ),
            'rewrite' => array('slug' => 'testimonials', 'with_front' => true),
            'capability_type' => 'post',
            'public' => true,
            'hierarchical' => true,
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'author',
            )
                )
        );
        register_taxonomy('testimonials', 'testimonials', array('label' => __("Testimonials Categories"), 'show_ui' => true, 'show_admin_column' => true, 'rewrite' => false, 'hierarchical' => true,));
    }
    /* end Website functions */
function custom_menu_page_removing() {
    //  remove_menu_page('wpcf7');
   // remove_menu_page('index.php');
    remove_menu_page('edit.php');
    remove_menu_page('themes.php');
    //  remove_menu_page('options-general.php');
    remove_menu_page('upload.php');
    remove_menu_page('tools.php');
    remove_menu_page('plugins.php');
    remove_menu_page('edit-comments.php');
}

add_action( 'admin_menu', 'custom_menu_page_removing' );
function modify_menu()
{
  global $submenu;
  unset($submenu['edit.php?post_type=page'][10]);
}
add_action('admin_menu','modify_menu');

function remove_acf_menu(){ 
    remove_menu_page( 'edit.php?post_type=acf' );
} 
add_action( 'admin_menu', 'remove_acf_menu', 100 );
add_action('admin_head', 'mytheme_remove_help_tabs'); 
function mytheme_remove_help_tabs() { 
    $screen = get_current_screen();
    $screen->remove_help_tabs();
}

add_filter( 'init', 'blockusers_init' );
function blockusers_init() {
   if(is_user_logged_in())
   {
       if (is_admin() && !current_user_can('administrator') && !( defined('DOING_AJAX') && DOING_AJAX)) {
           wp_redirect(home_url().'/wp-login.php');
           exit;
       }
   }
} 



add_filter( 'screen_options_show_screen', '__return_false' );   
function my_custom_admin_head() {
?>
<style>
.user-description-wrap{
display:none;
}.user-profile-picture{
display:none;
}.user-rich-editing-wrap{
display:none;
}
    .user-admin-color-wrap{
display:none;
}
    .user-comment-shortcuts-wrap{
display:none;
}
    .user-admin-bar-front-wrap,.update-nag,#wp-admin-bar-wp-logo{
display:none;
}
    #wpfooter,#wp-admin-bar-updates,#wp-admin-bar-comments,#wp-admin-bar-new-content{
        display: none;
    }
</style>
<script>
jQuery(document).ready(function(){
    jQuery('#menu-dashboard ul li:last-child').hide();
    jQuery('#menu-settings ul li').hide();
    jQuery('#menu-settings ul li:nth-child(9)').show();
    jQuery('#menu-settings ul li:nth-child(9) a').html('Custom Options');
});

</script>
<?php
}
add_action( 'admin_head', 'my_custom_admin_head' );

//Disable Plugin Update
function filter_plugin_updates( $value ) {
   if( isset( $value->response['wps-hide-login/wps-hide-login.php'] ) ){
       unset( $value->response['wps-hide-login/wps-hide-login.php'] );
   }   
   return $value;
}
add_filter( 'site_transient_update_plugins', 'filter_plugin_updates' ); 

function add_this_script_footer(){ ?>
<script>
    
document.addEventListener( 'wpcf7mailsent', function( event ) {
    if ( '919' == event.detail.contactFormId ) {
        location = '<?php echo site_url(); ?>/thank-you/';
    }

}, false );
</script>

<?php } 
add_action('wp_footer', 'add_this_script_footer'); 


?>