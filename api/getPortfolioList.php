<?php
require 'config.php';
$data =$_GET;
$error = 1;
if(empty($data['userId'])){
   response(0,array(),'Please enter the user id.');
}
$loggedUser=AuthUser($data['userId'],array(),array(0)); 
/* $offset=$data['offset'];
$limit=10;
if(!empty($offset)){
 $offset=$data['offset']*10;
 $limit=$offset*10;   
}*/
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
    if(!empty($portfolioArray)){
       response(1,$portfolioArray,'No Error Found.');    
    }else{
       response(0,array(),'No Portfolio images are found.'); 
    }
    
}else{
   response(0,array(),'No Portfolio images are found.');    
}
 
?>