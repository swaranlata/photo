<?php
require 'config.php';
$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data,true);
$error=0;
if(empty($data['userId'])){
   response(0,null,'Please enter the user id.');
}
if(empty($data['portfolioImagesId'])){
  response(0,null,'Please select Portfolio Images Id.');  
}
$portfolioImages=getPortFolioImages($data['userId']);
$temp=0;
$allImages=array();
if(!empty($portfolioImages)){
    foreach($portfolioImages as $k=>$v){
      $allImages[]=$v['id'];
    }
}
if(!empty($allImages)){
  foreach($data['portfolioImagesId'] as $key=>$val){
     if(!in_array($val,$allImages)){
        $temp=1;     
     } 
  }  
}
else{
  $temp=1;  
}
if(!empty($temp)){
   response(0,null,'Please select your Portfolio Images to delete.');   
}else{
   foreach($data['portfolioImagesId'] as $k=>$v){
       deletePortfolioImages($v);
       
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
}
?>