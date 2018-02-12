<?php
/*Template Name:Photographer User Profile*/
get_header();
$post=get_post();
$src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
$bgImage='';
if(isset($src[0])){
			$bgImage =$src[0];
}
$url = $_SERVER["REQUEST_URI"];
$array=array_filter(explode('/',$url));
$key=max(array_keys($array));
$userId=$array[$key];
$loginUserId=get_custom_user_id();
$bannerImage=getBannerProfile($userId);
$bannerClass='';
if(empty($bannerImage)){
    $bannerClass='no-border';
    $bannerImage=site_url().'/wp-content/uploads/2017/10/banner.png';
}
?>
	<main class="main">
		<div class="photographer-profile">
			<section class="banner" style="background-image: url('<?php echo $bgImage; ?>');">
				<h1><?php echo $post->post_title;?></h1>
			</section>
			<section class="photo-profile">
				<div class="before <?php echo $bannerClass; ?>" style="background-image:url('<?php echo $bannerImage; ?>')"></div>
				<div class="container">
					<div class="row">
						<div class="col-md-3">
							<div class="avatar-section">
								<?php
							$userImage=getUserProfile($userId);
							if(empty($userImage)) {
								$userImage= get_site_url().'/wp-content/uploads/2017/08/avatar.png';
							}
							?>
									<span class="profile-img" style="background-image: url('<?php echo $userImage; ?>');"></span>
							</div>
						</div>
						<div class="col-md-9">
							<h2 class="pull-left"><?php echo ucwords(getUserName($userId)); ?></h2>
							<div class="pull-right">
								<input type="hidden" id="otherUserId" value="<?php echo $userId; ?>" />
								<input type="hidden" id="userId" value="<?php echo $loginUserId; ?>" />
								<?php
							if(!empty($loginUserId)) {
								$getUserType=get_user_meta($loginUserId,'userType',true);
								if(!empty($getUserType)) {
									?>
									<button class="custom-btn btn-blue" name="hire" type="button" id="hirePhotographer">Hire</button>
									<?php
								}
							} else {
								?>
										<a href="javascript:void(0);" id="hireWithoutLogin" class="custom-btn btn-blue log-in-form" name="hire">Hire</a>
										<?php
							}
							?>
							</div>
							<div class="clearfix"></div>
							<div class="info">
								<div class="row">
									<div class="col-sm-5">
										<div class="info-list left-border">
											<h3 class="loc hasicon">
											<?php
											$address = get_user_meta($userId,'address',true);
											if(empty($address)) {
												$address="";
											}
											echo $address;
											?>
										</h3>
											<?php
										$hourlyRate = get_user_meta($userId,'hourlyRate',true);
										$minHours = get_user_meta($userId,'minHours',true);
                                        $exp=get_user_meta($userId,'experience',true);
                                       if(empty($exp)){
                                         $exp=0;  
                                       }
                                        
										?>
												<h3>
											Experience: <span><?php echo $exp; ?> year(s)</span>
										</h3>
												<h3>
											<?php
											if(empty($hourlyRate)) {
												$hourlyRate = "0";
											}
											?>

											Hourly Rate: <span>$<?php echo $hourlyRate; ?></span>
										</h3>
												<h3>
											<?php
											if(empty($minHours)) {
												$minHours = "0";
											}
											?>

											Minimum Hour: <span><?php echo $minHours; ?> hour(s)</span>
										</h3>
										</div>
									</div>
									<div class="col-sm-7">
										<div class="info-list">
											<h3 class="jbs hasicon"><?php echo getContacts($userId); ?> Contracts</h3>
											<h3>
                                                <span>Contract Success</span>
                                                <i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-html="true" title="Success Jobs Done"></i>
                                                <span class="bar" data-pre="0"><span style="width:<?php echo getSuccessRatePercentage($userId);?>%"></span></span>
                                                <span class="counter"><?php echo getSuccessRate($userId); ?></span>
                                            </h3>
                                              <?php 
                                            /*  global $wpdb;
                                             $query='select * from `im_schedules` where `userId`="'.$userId.'" order by dayId asc';
                                             $checkUser=$wpdb->get_results($query,ARRAY_A); 
                                            if(!empty($checkUser)){  ?>
                                             <h3>Free Schedule : </h3>
                                            <table>
                                            <tr>
                                                <th>Day</th>
                                                <th>From</th>
                                                <th>To</th>
                                                </tr>
                                            
                                            <?php 
						for($counter=0;$counter<=6;$counter++) {
							if($counter==0) {
								$day='sunday';
							} elseif($counter==1) {
								$day='monday';
							} elseif($counter==2) {
								$day='tuesday';
							} elseif($counter==3) {
								$day='wednesday';
							} elseif($counter==4) {
								$day='thursday';
							} elseif($counter==5) {
								$day='friday';
							} else {
								$day='saturday';
							}
							$day=ucfirst($day);
							$sunday=getPhotographerBusySchedule($userId,$counter);
							if(!empty($sunday)) {
								
									$count=count($sunday);
									foreach($sunday as $k=>$v) {
										?>
										<tr><td>	<?php
												if($k==0) {
													?>
                                              <?php echo $day; ?>
												<?php
												} ?></td>
											    <td><?php echo $v['startTime']; ?></td>
                                                    <td><?php echo $v['endTime']; ?></td>
                                                </tr>
										<?php
									} 
							}
						}?> </table> <?php
                         } */?>
                                            
                                            
                                          
										</div>
									</div>
								</div>
							</div>
							<div class="about">
								<p>
									<strong>
										<?php 
										$bio=get_user_meta($userId,'bio',true);
										if(empty($bio)) {
											$bio="";
										}
										echo $bio;
										?>
									</strong>
								</p>
							</div>
						</div>
					</div>
				</div>
			</section>
			<section class="rating">
				<div class="container">
					<div class="row">
						<div class="col-md-3 text-center">
							<div class="collapes">
								<a href="javascript:void(0)"><i class="fa fa-chevron-down"></i></a>
							</div>
						</div>
					</div>
					<h2>Portfolio</h2>
					<div class="porfolios">
						<!-- <div class="row"> -->
							<?php
						$portfolioImages = array();
						$portfolioImages = getPortFolioImages($userId);
						$portfolioArray=array();
						if(!empty($portfolioImages)) {
							$counter=0;
							echo '<div class="row">';
							foreach($portfolioImages as $k=>$v) {
								$image=getAttachmentImageById($v['image']);
								if(!empty($image)) {
									$portfolioArray[]=$v['id'];
									?>
								<div class="col-xs-12 col-sm-6 col-md-4">
                                    <a href="<?php echo $image; ?>" data-toggle="lightbox" data-gallery="example-gallery" class="col-sm-4">
               <div class="port-img" style="background-image: url('<?php echo $image; ?>');"></div>
            </a>
									
								</div>
								<?php
								}
							} 
							echo "</div>";
							if(empty($portfolioArray)) {
								?>
									<p class="w100p text-center">No portfolio images are found.</p>
									<?php
							}
						} else {
							?>
										<p class="w100p text-center">No portfolio images are found.</p>
										<?php
						}
						?>
						</div>
					</div>
				</div>
			</section>
			<section class="rating bg-gray">
				<div class="container">
					<div class="rating-section">
						<h2 class="text-left">Reviews &amp; rating</h2>
						<?php $getReviews=getReviews($userId); ?>
						<ul>
							<?php
						if(!empty($getReviews)) {
							foreach($getReviews as $kk=>$vv) {
								$username=getUserName($vv['userId']);
								?>
								<li>
									<p>
										<?php echo $vv['comments'];?>
									</p>
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
						} else {
							?>
									<li class="w100p text-center"> No ratings found. </li>
									<?php
						}
						?>
						</ul>
					</div>
				</div>
			</section>
		</div>
	</main>
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
	<?php get_footer(); ?>