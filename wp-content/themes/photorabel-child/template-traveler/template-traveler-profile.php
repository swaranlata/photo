<?php
/* Template Name: Traveler/User Profile with Login */
get_header('custom');
$userId=get_custom_user_id();
$profileImage=getUserProfile($userId);
if(empty($profileImage)){
  $profileImage=get_site_url().'/wp-content/uploads/2017/08/avatar.png';
}
$getUserType=get_user_meta($userId,'userType',true);
if(!empty($getUserType)){//traveller
    $sectionClass='photo-profile';
    $avatarClass='avatar-section';
}else{//photographer
    $sectionClass='photoGrapher';
    $avatarClass='timeLine'; 
}
?>
<section class="<?php echo $sectionClass; ?>">
	<div class="container-fluid">
		<div class="customHead">
			<div class="customBox">
				<h1>Profile Information</h1>
			</div>
			<div class="customBox">
				<a href="<?php echo site_url(); ?>/update-profile/<?php echo $userId; ?>" class="custom-btn btn-blue">Edit</a>
			</div>
		</div>
        <?php 
        if(empty($getUserType)){
            $banner=getBannerProfile($userId);
            ?>
        <div class="row">
            <div class="col-md-12">
				<div class="<?php echo $avatarClass; ?>">
                    <?php if(!empty($banner)){
                ?>
                    	<span class="profile-img" style="background-image: url('<?php echo $banner; ?>');"></span>
                    <?php
            }else{
                ?>
                 <span class="profile-img" style="background-image: url('<?php echo get_site_url().'/wp-content/uploads/2017/10/banner.png'; ?>');"></span>   
                    
                    <?php
            } ?>
				
				</div>
			</div>
        </div>
        <?php
        }
        ?>
        
		<div class="row">
			<div class="col-md-3">
				<div class="avatar-section">
					<span class="profile-img" style="background-image: url('<?php echo $profileImage; ?>');"></span>
				</div>
			</div>
			<div class="col-md-9 tbctr">
				<table>
					<tr>
						<th>First Name:</th>
						<td><?php echo get_user_meta($userId,'firstName',true);?></td>
					</tr>
					<tr>
						<th>Last Name: </th>
						<td><?php 
                            $lastname=get_user_meta($userId,'lastName',true);
                            if(empty($lastname)){
                                $lastname='';
                            }
                            
                            echo $lastname;?></td>
					</tr>
					<tr>
						<th>Email:</th>
						<td><?php echo getUserEmail($userId);?></td>
					</tr>
					<tr>
						<th>Contact Number:</th>
						<td>  <?php 
                            $contactNo=get_user_meta($userId,'contactNo',true);
                            if(empty($contactNo)){
                               $contactNo=''; 
                            }
                            echo $contactNo;?></td>
					</tr>
					<tr>
						<th>Gender:</th>
						<td><?php  echo getGender($userId); ?></td>
					</tr>
					<tr>
						<th>Date of birth:</th>
						<td><?php
                            $dob=get_user_meta($userId,'dob',true);
                            if(empty($dob)){
                               $dob=''; 
                            }
                            echo $dob;
                            
                            ?></td>
					</tr>
					<tr>
						<th>Location:</th>
						<td><?php
                            $address=get_user_meta($userId,'address',true);
                            if(empty($address)){
                               $address=''; 
                            }
                            echo $address;
                            
                            ?></td>
					</tr>                    
                    <?php  if(empty($getUserType)){ ?>
                    <tr>
						<th>Hourly rate:</th>
						<td>$<?php
                            $hourlyRate=get_user_meta($userId,'hourlyRate',true);
                            if(empty($hourlyRate)){
                               $hourlyRate=''; 
                            }
                            echo $hourlyRate;
                            
                            ?></td>
					</tr>
                    <tr>
						<th>Min hours:</th>
						<td><?php
                            $minHours=get_user_meta($userId,'minHours',true);
                            if(empty($minHours)){
                               $minHours=''; 
                            }
                            echo $minHours;
                            
                            ?> hour(s)</td>
					</tr>
                    <tr>
						<th>Experience:</th>
						<td><?php
                            $experience=get_user_meta($userId,'experience',true);
                            if(empty($experience)){
                               $experience=''; 
                            }
                            echo $experience;
                            
                            ?> year(s)</td>
					</tr>
                    <tr>
						<th>Bio:</th>
						<td><?php
                            $bio=get_user_meta($userId,'bio',true);
                            if(empty($bio)){
                               $bio=''; 
                            }
                            echo $bio;
                            
                            ?></td>
					</tr>
                    <?php } ?>
                 </table>
			</div>
		</div>
	</div>
</section>



<section class="rating<?php echo $getUserType == 1 ? ' bg-gray' : '' ; ?>">
	<div class="container-fluid">
		<div class="rating-section">
			<h2>Review &amp; rating</h2>
            <?php $getReviews=getReviews($userId); 
            
           
            ?>
			<ul>
                <?php
                 if(!empty($getReviews)){
                    foreach($getReviews as $kk=>$vv){
                        $username=getUserName($vv['userId']);
                     ?>
                    <li>
                        <p><?php echo $vv['comments'];?></p>
                        <div class="ratting-footer">
                            <span class="by">Posted by - <?php echo $username; ?></span>
                            <span class="total-time"><?php echo date('M Y',strtotime($vv['created']));?></span>
                        </div>
                        <div class="ratting-starts">
                             <?php 
                                           $rating = $vv['rateValue'];                                        
										?>
				                         <div class="ratebox" data-id="1" data-rating="<?php echo $rating; ?>"></div>
										<span><?php echo $vv['rateValue']; ?></span>
                            
                            
                            
                        </div>
                    </li>
                <?php
                     }
                  }else{
                  ?>
                  <li class="emptyTag"> No ratings are found.  </li>
                   <?php
                }
                ?>
			</ul>
		</div>
	</div>
</section>
 <?php  if(empty($getUserType)){ ?>
<section class="rating bg-gray ports">
	<div class="container-fluid">
		<h2>Portfolio</h2>
		<div class="porfolios">
			<!-- <div class="row"> -->
				<?php 
                $portfolioImages=getPortFolioImages($userId);
                $portfolioArray=array();
                if(!empty($portfolioImages)){
                    $counter=0;
                    echo '<div class="row">';
                    foreach($portfolioImages as $k=>$v){
                        $image=getAttachmentImageById($v['image']);
                        if(!empty($image)){
                            ?>
                            <div class="col-xs-12 col-sm-6 col-md-5div">
                                 <a href="<?php echo $image; ?>" data-toggle="lightbox" data-gallery="example-gallery" class="col-sm-4">
                                <div class="port-img" style="background-image: url('<?php echo $image; ?>');">
                                     </div></a>
                            </div>
                        <?php                           
                        }                  
                    }
                    echo "</div>";
                }else{
                   ?>
                <p class="emptyTag">No portfolio images are found.</p>
                <?php
                 }
                ?>
				
			<!-- </div> -->
		</div>
	</div>
</section>

<section class="rating">
	<div class="container-fluid">
		<div class="rating-section">
			<h2>Schedule</h2>
            <div id="responseSchedule"></div>
            <form id="schedule" action="javascript:void(0);">
                <input type="hidden" name="action" value="post_schedule"/>
                <ul class="schedule">                 
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
                        $sunday=getPhotographerBusySchedule($userId,$counter);                          
                        if(!empty($sunday)){
                            $temp=1;
                            ?> <li>
                         <?php
                            $count=count($sunday);
                            foreach($sunday as $k=>$v){                               
                            ?> 
                          <div>
                                     <div>
                                     <?php  if($k==0){ ?>                               
                                    <strong><?php echo $day; ?></strong>
                                    <?php }?>
                                    
                                    </div>
                                <div>
                                    <div class="form-group">
                                        <label>From</label>
                                        <input type="text" disabled="disabled"  value="<?php echo $v['startTime'];?>" name="<?php echo $counter; ?>[startTime][]" class="form-control ">
                                    </div>
                                    <div class="form-group">
                                        <label>to</label>
                                        <input type="text"  disabled="disabled"  value="<?php echo $v['endTime'];?>"  name="<?php echo $counter; ?>[endTime][]"  class="form-control ">
                                    </div>
                                </div>
                                <div class="inner">
                                   
                                   
                                </div>
                                </div>
                        <?php
                         } 
                      ?>
                     </li>
                    <?php
                    }
               }
                if(empty($temp)){
                    ?>
                     <p class="emptyTag">No free schedule defined.</p>
                    <?php
                    }
                    ?>
                </ul>
                
            </form>
		</div>
	</div>
</section>






<?php }?>

<link rel="stylesheet" href="<?php echo site_url().'/wp-content/themes/photorabel-child/css/ekko-lightbox.css'; ?>">
<script src="<?php echo site_url().'/wp-content/themes/photorabel-child/js/ekko-lightbox.min.js'; ?>"></script>
<script>
$(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox({
                    loadingMessage:true,
                    alwaysShowClose:true
                });
            });
</script>
<?php 
get_footer('custom');
?>