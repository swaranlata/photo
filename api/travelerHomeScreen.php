<?php
require 'config.php';
$data =$_GET;
if(empty($data['userId'])){
  response(0,array(),'Please enter the user id.');
}
$args = array(
 'role' => 'photographer',
 'orderby' => 'ID',
 'order' => 'DESC'
);
$photographer = get_users($args);
if(!empty($photographer)){
    $i=0;
   foreach($photographer as $k=>$v){
       
   $i++;
   }     
}else{
    
    
}




?>