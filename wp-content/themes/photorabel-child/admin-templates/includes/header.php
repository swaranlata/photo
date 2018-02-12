<html>
<head>
    <link rel="stylesheet" type="text/css" href="<?php  echo get_stylesheet_directory_uri(); ?>/admin-templates/css/jquery.dataTables.css" />
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php  echo get_stylesheet_directory_uri(); ?>/admin-templates/css/bootstrap.min.css" >
    <script src="<?php  echo get_stylesheet_directory_uri(); ?>/admin-templates/js/jquery-1.9.1.min.js"></script>   
    <script src="<?php  echo get_stylesheet_directory_uri(); ?>/admin-templates/js/tether.min.js"></script>
    <script src="<?php  echo get_stylesheet_directory_uri(); ?>/admin-templates/js/jquery.dataTables.min.js"></script>
    <script src="<?php  echo get_stylesheet_directory_uri(); ?>/admin-templates/js/bootstrap.min.js"></script>
    <script src="<?php  echo get_stylesheet_directory_uri(); ?>/admin-templates/js/custom.js"></script>
</head>
    <?php 
    function getJobs($status=null){
        global $wpdb;
        if($status=='all'){
           $results=$wpdb->get_results('select * from `im_requests` order by `startDate` asc',ARRAY_A); 
        }else{
           $results=$wpdb->get_results('select * from `im_requests` where `status`="'.$status.'" order by `startDate` asc',ARRAY_A);
        }
      
      return $results;
    }
    
    
    
    
    ?>