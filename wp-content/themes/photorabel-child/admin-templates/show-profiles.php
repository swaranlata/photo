<table class="form-table">
    <?php 
    $getUserType=get_user_meta($_GET['user_id'],'userType',true); 
    if(empty($getUserType)){
        ?>
        <tr>
            <th><label for="dateOfBirth">Hourly Rate</label></th>
            <td>
            <input type="text" name="dateOfBirth"  value="<?php echo get_user_meta($_GET['user_id'],'hourlyRate',true); ?>" class="regular-text" /><br />
            </td>
         </tr>
        <tr>
            <th><label for="dateOfBirth">Min Hours</label></th>
            <td>
            <input type="text" name="dateOfBirth"  value="<?php echo get_user_meta($_GET['user_id'],'minHours',true); ?>" class="regular-text" /><br />
            </td>
        </tr> 
        <tr>
            <th><label for="dateOfBirth">Bio</label></th>
            <td>
            <input type="text" name="dateOfBirth"  value="<?php echo get_user_meta($_GET['user_id'],'bio',true); ?>" class="regular-text" /><br />
            </td>
        </tr> 
        <tr>
            <th><label for="dateOfBirth">Experience</label></th>
            <td>
            <input type="text" name="dateOfBirth"  value="<?php echo get_user_meta($_GET['user_id'],'experience',true); ?>" class="regular-text" /><br />
            </td>
        </tr>
    
    
    <?php
        
    }
    
    
    ?>
        <tr>
            <th><label for="dateOfBirth">City</label></th>
            <td>
            <input type="text" name="dateOfBirth"  value="<?php echo get_user_meta($_GET['user_id'],'city',true); ?>" class="regular-text" /><br />
            </td>
        </tr> 
        <tr>
            <th><label for="dateOfBirth">Profile Image</label></th>
            <td>
           <img src="<?php echo getUserProfile($_GET['user_id']); ?>" width="20%"><br />
            </td>
        </tr>
    <?php if(empty($getUserType)){ ?>
        <tr>
            <th><label for="dateOfBirth">Banner Image</label></th>
            <td>
           <img src="<?php echo getBannerProfile($_GET['user_id']); ?>" width="40%"><br />
            </td>
        </tr> 
    <?php } ?>
    
        <tr>
            <th><label for="dateOfBirth">State</label></th>
            <td>
            <input type="text" name="dateOfBirth"  value="<?php echo get_user_meta($_GET['user_id'],'state',true); ?>" class="regular-text" /><br />
            </td>
        </tr> 
        <tr>
            <th><label for="dateOfBirth">Country</label></th>
            <td>
            <input type="text" name="dateOfBirth"  value="<?php echo get_user_meta($_GET['user_id'],'country',true); ?>" class="regular-text" /><br />
            </td>
        </tr> 
        <tr>
            <th><label for="dateOfBirth">Address</label></th>
            <td>
            <input type="text" name="dateOfBirth"  value="<?php echo get_user_meta($_GET['user_id'],'address',true); ?>" class="regular-text" /><br />
            </td>
        </tr>
        <tr>
            <th><label for="dateOfBirth">Phone Number</label></th>
            <td>
            <input type="text" name="dateOfBirth"  value="<?php echo get_user_meta($_GET['user_id'],'contactNo',true); ?>" class="regular-text" /><br />
            </td>
        </tr>   
    
</table>
<?php 
$getReviews=getReviews($_GET['userId']);
$reviews=array();
if(!empty($getReviews)){
  foreach($getReviews as $k=>$vv){
    $reviews[$k]['reviewId']=(int) $vv['id'];  
    $reviews[$k]['rating']=$vv['rateValue'];  
    $reviews[$k]['name']=getUserName($vv['userId']);  
    $reviews[$k]['userId']=(int) $vv['userId'];  
    $reviews[$k]['profileImage']=getUserProfile($vv['userId']);  
    $reviews[$k]['description']=$vv['comments'];  
    $reviews[$k]['dateTime']=getTiming(strtotime($vv['created'])).' ago';  
  }  
}

?>
<h2>Ratings and Reviews</h2>
<table>
     <?php if(!empty($reviews)){
          foreach($reviews as $kk=>$v){
              ?>
            <tr>
                <th><label for="dateOfBirth"><?php echo $v['name'];?></label></th>
                <td>Feedback : <?php echo $v['description']; ?></td>
                <td>Rating Value : <?php echo $v['rating']; ?></td>
                <td>Profile Image : <?php echo $v['profileImage']; ?></td>
                <td>DateTime : <?php echo $v['dateTime']; ?></td>
              
           </tr>
            <?php
          }
        }else{
    ?><tr>
       <td colspan="4">No Reviews Found.</td>
     </tr>
    <?php
}?>

</table>

<?php 
  if(empty($getUserType)){
    ?>
<h2>Portfolio Images</h2>
    <div class="responsePort"></div>
    <table>
      
       <?php
        $portfolioImages=getPortFolioImages($_GET['user_id']);
        $portfolioArray=array();
        if(!empty($portfolioImages)){
            $counter=0;
            foreach($portfolioImages as $k=>$v){
                $image=getAttachmentImageById($v['image']);
                if(!empty($image)){
                    ?>
                    <tr class="port">
                       <td colspan="1">
                           <span data-attr-id="<?php echo $v['id'];?>" class="deletePortfolio">x</span></td>
                       <td colspan="2"><img width="100%" src="<?php echo $image; ?>"/></td>
                    </tr>
                    <?php
                }
            }
        }else{
            ?>
            <tr>
                <td colspan="3">No Portfolio Image Found.</td>
            </tr>

        <?php
        }
            ?>
     
    </table>
<h2>Free Schedule</h2>
<table>
    <?php 
    $temp=0;
    for($counter=0;$counter<=6;$counter++){
        if($counter==0){
          $day='sunday';        
        }elseif($counter==1){
          $day='monday';  
        }elseif($counter==2){
          $day='tuesday';  
        }elseif($counter==3){
          $day='wednesday';   
        }elseif($counter==4){
          $day='thursday';   
        }elseif($counter==5){
          $day='friday';  
        }else{
          $day='saturday';    
        }
        $day=ucfirst($day);
        $sunday=getPhotographerBusySchedule($_GET['user_id'],$counter);     
        if(!empty($sunday)){
            $temp=1;
            ?> 
         <?php
            $count=count($sunday);
            foreach($sunday as $k=>$v){                               
            ?> <tr>
             <?php  if($k==0){ ?>                               
            <td><strong><?php echo $day; ?></strong></td>
            <?php }else{
                ?><td></td>
            <?php
            }?>
           <td><?php echo $v['startTime'];?></td>
           <td><?php echo $v['endTime'];?></td>
            </tr>
        <?php
         } 
      ?>
    <?php
    }
}
    if(empty($temp)){
    ?>
     No Free Schedule added.
    <?php
    }
    ?>
</table>
<?php } ?>





<style>
.port{
    width:200px;
    display: inline-block;        
}
    .alert-success{
        background:darkseagreen;
        color:green;
    }
</style>
<script>
    var SITE_URL='<?php echo site_url(); ?>';
    jQuery(document).on('click','.deletePortfolio',function(){
     var img=jQuery(this).attr('data-attr-id');
     var checkthis=jQuery(this);
     jQuery.ajax({
            data: {action:'delete_portfolio',delId:img},
            url: SITE_URL + '/wp-admin/admin-ajax.php',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if(response.status=='true'){
                   checkthis.parent().parent().remove();
                   jQuery('.responsePort').html('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Portfolio image deleted successfully.</div>');
                    jQuery('.responsePort').delay(3000).fadeOut();                    
                }else{
                    jQuery('.responsePort').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>No images are deleted.</div>');
                    jQuery('.responsePort').delay(3000).fadeOut(); 
                }
            }
		 });  
});

</script>









