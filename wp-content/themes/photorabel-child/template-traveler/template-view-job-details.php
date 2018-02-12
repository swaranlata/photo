<?php
/* Template Name: View Job Requests Page with Login */
get_header('custom');
$userId=get_custom_user_id();
$jobId=getModuleId();
$details = viewJobDetails($jobId);
$getUserType=get_user_meta($userId,'userType',true);

$url=site_url().'/api/getQuestions.php?userId='.$userId.'&jobId='.$jobId;
$response=file_get_contents($url);
$finalArray=array();
if($response) {
	$response=json_decode($response,true);
	if(!empty($response['result'])) {
		$finalArray=$response['result'];
	}
}


?>
<!-- We need the raterater stylesheet -->
<link href="<?php echo get_stylesheet_directory_uri(); ?>/css/raterater.css" rel="stylesheet" />
<style>
	/* Override star colors */
	.raterater-bg-layer {
		color: rgba( 0, 0, 0, 0.25);
	}

	.raterater-hover-layer {
		color: rgba( 255, 255, 0, 0.75);
	}

	.raterater-hover-layer.rated {
		color: rgba( 255, 255, 0, 1);
	}

	.raterater-rating-layer {
		color: rgba( 255, 155, 0, 0.75);
	}

	.raterater-outline-layer {
		color: rgba( 0, 0, 0, 0.25);
	}
</style>
<section class="photo-profile">
	<div class="container-fluid">
		<div class="admin-hearder abs-headre">
			<h1>View Job Request Details</h1>
			<div class="response"></div>
			<?php
			if(!empty($details)) {
				if($details['userId'] == $userId) {
					$jobUser=$details['otherUserId'];
				} else {
					$jobUser=$details['userId'];
				}
				$details['profileImage'] = getUserProfile($jobUser);
				$image=get_site_url().'/wp-content/uploads/2017/08/avatar.png';
				if(!empty($details['profileImage'])) {
					$image = $details['profileImage'];
				}
				?>
             
				<div class="avatar-header">
					<div class="avatar-section abs">
						<figure class="profile-img" style="background-image: url('<?php echo $image; ?>');"></figure>
					</div>

					<div class="avatar-content">
						<h2><?php echo getUserName($jobUser); ?></h2>
						<div class="stars">
							<span class="stars-wrapper">
								<?php $rating = getUserRating($jobUser); ?>
								<div class="ratebox" data-id="1" data-rating="<?php echo $rating; ?>"></div>
							</span>
							<span class="star-counter"><?php echo $rating; ?></span>
						</div>
						<div class="about">
							<p><?php echo get_user_meta($jobUser,'bio',true);?></p>
						</div>
                        <div class="tableFormat">
                         <h3>General Information</h3>
						<table>
							<?php
							if(!empty($getUserType)) {
								?>
								<!--<tr>
									<th>Description:</th>
									<td>
										<?php 
										/*$bio=get_user_meta($jobUser,'bio',true);
										if(empty($bio)) {
											$bio="";
										}
										echo $bio;*/
										?>
									</td>
								</tr>-->
								<tr>
									<th>Hourly Rate:</th>
									<td>
										$<?php
										$hourlyRate=get_user_meta($jobUser,'hourlyRate',true);
										if(empty($hourlyRate)) {
											$hourlyRate="0";
										}
										echo $hourlyRate;
										?>
									</td>
								</tr>
								<tr>
									<th>Minimum Hours:</th>
									<td>
										<?php
										$minHours=get_user_meta($jobUser,'minHours',true);
										if(empty($minHours)) {
											$minHours="0";
										}
										echo $minHours;
										?>
									</td>
								</tr>
								<tr>
									<th>Job Success Rate:</th>
									<td>
										<?php
										echo getSuccessRate($jobUser);
										?>
									</td>
								</tr>
								<?php
							}
							?>
							<tr>
								<th>Date:</th>
								<td><?php echo getDateFormat($details['startDate']); ?></td>
							</tr>
							
							<?php
                            if($details['status']=='4'){
                                ?>
                            <tr>
								<th>Phone Number:</th>
								<td><?php echo getPhoneNumber($jobUser); ?></td>
							</tr>
                            <?php
                            }
							if($details['status']=='0') {
								if(!empty($details['newTimeSlot'])) {
									?>
									<tr>
										<?php if(empty($getUserType)) { //photo
											?>
											<th>New Time Slot:</th>
											<?php
										} else {
											?>
											<th>Suggested Time:</th>
											<?php
										} ?>
										<td>
											<?php echo $details['newTimeSlot']; ?>
										</td>
									</tr>
									<?php
								}
							} ?>
							
							<tr>
								<th>Member Since:</th>
								<td><?php echo getMemberSince($jobUser); ?></td>
							</tr>
							<tr>
								<th>Status:</th>
								<td>
									<?php
									if(empty($details['status'])) {
										$count=getEditCount($jobId);
										if(!empty($count)) {
											echo 'Modified';
										} else {
											echo getStatus($details['status']);
										}
									} else {
                                        if($details['status']=='5'){
                                            $cancelUser= getCanceledJob($details['id']);
                                            $hetUserTypeData=getUserType($cancelUser);
                                            if(!empty($hetUserTypeData)){
                                            echo 'Cancelled By Traveler';
                                            }else{
                                            echo 'Cancelled By Photographer'; 
                                            }
                                        }else{
                                            echo getStatus($details['status']);
                                        }
										
									}
									?>
								</td>
							</tr>
							<?php
                            /*
							if($details['status']=='5') {
								?>
								<tr>
									<th>Cancelled by:</th>
									<td><?php $cancelUser= getCanceledJob($details['id']);
                                        $hetUserTypeData=getUserType($cancelUser);
                                if(!empty($hetUserTypeData)){
                                    echo 'Traveler';
                                }else{
                                    echo 'Photographer'; 
                                }
                                        
                                        ?></td>
								</tr>
								<?php
							}*/  ?>
						</table>
                    </div>
                     
                        
                              <?php  
                                $isAnswered=isAnswered($userId,$jobId);
                                if(!empty($isAnswered)){ 
                                    ?>
                                <div class="rating-section">
                                   <h3>Questions</h3>
                                   <ul>
                               
                               
                               <?php                                    
                                    if(!empty($finalArray)) {
                                        foreach($finalArray as $k=>$v) {
                                            ?>
                                           <li>
                                               <div class="ratting-footer"><span><?php echo $v['question']; ?></span></div>
                                               <p><?php echo $v['answer']; ?></p>
                                           </li>                                            
                                            <?php
                                      }
                                    }     
                                    ?>
                                    </ul>
                                </div>
                               <?php
                                }
                                if($details['status']>=4){
                                   
                                if($details['status']=='4' || $details['status']=='6') {
                                     ?>
                          
                                <?php
                                    if(!empty($getUserType)) {
                                        ?>
                                    <div class="sugg">
                                         <h3>Suggested Route</h3>
                                        <table>
                                        <tr>
                                            <th>Route Information</th>
                                            <td><?php                                        
                                        if(!empty(getSuggestedRoutes($details['userId'],$details['id']))){
                                           echo getSuggestedRoutes($details['userId'],$details['id']); 
                                        }else{
                                          echo 'Waiting Suggested Route';  
                                        } ?></td>
                                        </tr></table>                        
                        </div>
                                        <?php
                                    }
                                     ?>
                                  
                                <?php
                                }
                             /*       else{
                                    ?>
                        
                                
                                <?php
                                    
                                    
                                    
                                     if(!empty($getUserType)) {
                                    ?><div class="sugg">
                             <h3>Suggested Route</h3>
                            <table><tr>
                                            <th>Route Information</th>
                                            <td>Waiting Suggested Route.</td></tr>
                                 </table>                        
                        </div>
                                <?php }else{
                                        ?><div class="sugg">
                             <h3>Suggested Route</h3>
                            <table>
                                <tr>
                                            <th>Route Information</th>
                                            <td>Not Provided Yet.</td></tr> </table>                        
                        </div>
                                <?php
                                        }
                                     ?>
                                 
                                <?php
                                } 
                        */
                        ?>                            
                          
                        
                        
                        <?php
                                }
                               ?>
                                 
                          
						<input type="hidden" id="jobId" name="jobId" value="<?php echo $jobId; ?>" />
						<input type="hidden" id="userId" name="userId" value="<?php echo $userId; ?>" />
						<div class="detailsButtons">
							<?php 
							if(!empty($getUserType)) { //traveller
								if($details['status']=='0') {
									$count=getEditCount($details['id']);
									if(!empty($count) and $count<2) {
										?>
										<a href="javascript:void(0);" data-attr-action="0" class="custom-btn btn-blue changeJobStatus">Accept</a>
										<a href="javascript:void(0);" data-attr-action="1" class="custom-btn btn-darkBlue changeJobStatus">Decline</a>
										<a href="javascript:void(0);" id="replyOnNewTimeSlot" class="custom-btn btn-transparant">Reply for Original time</a>
										<?php
									} elseif($count>1) {
										?>
										<a href="javascript:void(0);" class="custom-btn btn-darkBlue cancelBtn">Cancel</a>
										<?php
									} else {
										?>
										<a href="javascript:void(0);" class="custom-btn btn-darkBlue cancelBtn">Cancel</a>
										<?php
									}
								} elseif($details['status']=='4') {
									?>
	                                <a href="<?php echo site_url().'/questions/?jobId='.$jobId; ?>" class="custom-btn btn-darkBlue">View Questions</a>
									<a href="javascript:void(0);" class="custom-btn btn-darkBlue cancelBtn">Cancel</a>
									<?php
								} elseif($details['status']=='1') {
									?>
									<a href="javascript:void(0);" class="custom-btn btn-blue payment">Pay</a>
									<a href="javascript:void(0);" class="custom-btn btn-darkBlue cancelBtn">Cancel</a>
									<?php
								}
							} else { //photographer
								if($details['status']=='0') {
									$count=getEditCount($details['id']);
									if(!empty($count) and $count<2) { //modified
										?>
										<a href="javascript:void(0);" class="custom-btn btn-darkBlue cancelBtn">Cancel</a>
										<?php
									} elseif($count==2) {
										?>
										<a href="javascript:void(0);" data-attr-action="0" class="custom-btn btn-blue changeJobStatus">Accept</a>
										<a href="javascript:void(0);" data-attr-action="1" class="custom-btn btn-darkBlue changeJobStatus">Decline</a>
										<?php
									} else {
										?>
										<a href="javascript:void(0);" data-attr-action="0" class="custom-btn btn-blue changeJobStatus">Accept</a>
										<a href="javascript:void(0);" data-attr-action="1" class="custom-btn btn-darkBlue changeJobStatus">Decline</a>
										<a href="javascript:void(0);" id="suggestTime" class="custom-btn btn-transparant">Suggest Time</a>
										<?php
									}
								}
								if($details['status']=='1') {
									?>
									<a href="javascript:void(0);" class="custom-btn btn-darkBlue cancelBtn">Cancel</a>
									<?php
								}
								if($details['status']=='4') {
                                    $isAnswered=isAnswered($userId,$jobId);
									?>
	                                <a href="<?php echo site_url().'/questions/?jobId='.$jobId; ?>" class="custom-btn btn-darkBlue"><?php  if(!empty($isAnswered)){
                                        echo 'View Answers';
                                    }else{
                                       echo 'Waiting User Response for questions'; 
                                    }?></a>
									<a href="javascript:void(0);" class="custom-btn btn-darkBlue cancelBtn">Cancel</a>
									<?php
								}
							}
							?>
						</div>
					</div>
				</div>
               
				<?php
			} else {
				?>
				<p class="w100p text-center">No Data Found.</p>
				<?php
			} ?>
		</div>
	</div>
</section>
<?php
get_footer('custom');
?>