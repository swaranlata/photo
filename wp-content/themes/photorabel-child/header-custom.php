<?php
ob_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
$custom_logo_id = get_theme_mod( 'custom_logo' );
$image = wp_get_attachment_image_src($custom_logo_id , 'full' );
$getJob=explode('/',$_SERVER['REQUEST_URI']);
$getJob=array_filter($getJob);
$key=max(array_keys($getJob));
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
	<title>PhotoRavel</title>
	<?php wp_head(); ?>
      <script>
                var removeSession='';                
                </script> 
</head>
<body <?php body_class(); ?> onLoad="removeClassTest()">
	<?php
	session_start();
	$userId=get_custom_user_id();
	if(empty($userId)) {
		unset($_SESSION['type']);
		unset($_SESSION['hireType']);
       /* wp_redirect( site_url(),301); 
        exit;*/
		header('location:'.site_url());    
	}

	$profileImage=getUserProfile($userId);
	$notificationTab='';
	$profileTab='';
	$paymentTab='';
	$shootTab='';
	$requestLinkTab='';
	$viewJobTab='';
	$sessionTab='';
	$jobRequestTab='';

	if (is_page_template('template-notifications.php')) {
		$notificationTab='active';
	} elseif(is_page_template('template-edit-profile.php') || is_page_template('template-traveler/template-traveler-profile.php')) {
		$profileTab='active';
	} elseif(is_page_template('template-payment-history.php')) {
		$paymentTab='active';
	} elseif(is_page_template('template-shoot-link.php')) {
		$shootTab='active';
	} elseif(is_page_template('template-traveler/template-request-for-link.php')) {
		$requestLinkTab='active';
	} elseif(is_page_template('template-traveler/template-view-job-details.php')) {
		if(isset($getJob[$key]) and !empty($getJob[$key])) {
			$j=$getJob[$key];
			$viewJob=getJobDetails($j);
			if(in_array($viewJob['status'],array(0,1,5))) {
				$jobRequestTab='active';
			} else {
				$sessionTab='active';
			}
		}
	} elseif(is_page_template('template-photographer-sessions.php')) {
		$sessionTab='active';
	} elseif(is_page_template('template-photographer-job-requests.php') || is_page_template('template-traveler/template-job-requests.php')) {
		$jobRequestTab='active';
	}
	?>
	<!-- Navigation -->
	<nav id="mainNav" class="navbar static-top navbar-toggleable-md navbar-inverse bg-inverse">
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarExample" aria-controls="navbarExample" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<input type="hidden" id="crntUserLogin" value="<?php echo $userId; ?>" />
		<a class="navbar-brand" href="<?php echo site_url(); ?>"><img src="<?php echo @$image[0];?>" alt="Logo"></a>
		<div class="collapse navbar-collapse" id="navbarExample">
			<div class="sidebar-nav navbar-nav">
				<ul>
					<li id="sidebarAvatar" class="adminAvatar">
						<?php
						if(empty($profileImage)) {
							$profileImage=get_site_url().'/wp-content/uploads/2017/08/avatar.png';
						}
						?>

						<figure style="background-image: url('<?php echo $profileImage; ?>');">
							<a  href="<?php echo site_url(); ?>/profile/" class="fa fa-pencil" aria-hidden="true"></a>
						</figure>
						<div class="welcomeMsg">
							<p><?php echo ucwords(getUserName($userId));?></p>
							<p><?php echo get_user_meta($userId,'address',true);?></p>
						</div>
					</li>
					<?php
					$getUserType=get_user_meta($userId,'userType',true);
                    $notificationCount=getNotificationCount($userId);
					if(!empty($getUserType)) { //travller
						?>
						<li class="link"><a href="<?php echo site_url(); ?>"><img src="<?php echo get_stylesheet_directory_uri().'/images/'; ?>job-request.png" alt=""> <span>Hire Photographer</span></a></li>
						<li class="link <?php echo $jobRequestTab;?>"><a href="<?php echo site_url().'/job-requests'; ?>"><img src="<?php echo get_stylesheet_directory_uri().'/images/'; ?>job-request.png" alt=""> <span>Job Requests</span></a></li>
						<li class="link <?php echo $profileTab;?>"><a href="<?php echo site_url(); ?>/profile/"><img src="<?php echo get_stylesheet_directory_uri().'/images/'; ?>user.png" alt=""> <span>Profile</span></a></li>
						<li class="link <?php echo $paymentTab;  ?>"><a href="<?php echo site_url(); ?>/payment-history"><img src="<?php echo get_stylesheet_directory_uri().'/images/'; ?>pay.png" alt=""> <span>Payment History</span></a></li>
						<li class="link <?php echo $sessionTab; ?>"><a href="<?php echo site_url().'/sessions'; ?>"><img src="<?php echo get_stylesheet_directory_uri().'/images/'; ?>book.png" alt=""> <span>Booking</span></a></li>
						<!--<li class="link <?php //echo $requestLinkTab; ?>"><a href="<?php //echo site_url(); ?>/request-for-a-link"><img src="<?php //echo get_stylesheet_directory_uri().'/images/'; ?>book.png" alt=""> <span>Request for a link</span></a></li>-->
                    
						<li class="link <?php echo $notificationTab; ?>"><a href="<?php echo site_url(); ?>/notifications/"><img src="<?php echo get_stylesheet_directory_uri().'/images/'; ?>notification.png" alt=""><span>Notification  <?php 
                        if(!empty($notificationCount)){
                            ?>
                            <span class="noti-count"><small>
                            <?php
                                echo getNotificationCount($userId);   
                             ?>
                            </small></span>
                            <?php
                        }
                            ?></span></a></li>
						<?php
					} else { //photographer
						?>
						<li class="link <?php echo $jobRequestTab; ?>"><a href="<?php echo site_url().'/photographer-job-requests'; ?>"><img src="<?php echo get_stylesheet_directory_uri().'/images/'; ?>job-request.png" alt=""> <span>Job Requests</span></a></li>
						<li class="link <?php echo $sessionTab; ?>"><a href="<?php echo site_url().'/sessions'; ?>"><img src="<?php echo get_stylesheet_directory_uri().'/images/'; ?>job-request.png" alt=""> <span>Job Sessions</span></a></li>
						<li class="link <?php echo $profileTab;?>"><a href="<?php echo site_url(); ?>/profile/"><img src="<?php echo get_stylesheet_directory_uri().'/images/'; ?>user.png" alt=""> <span>Profile</span></a></li>
						<li class="link <?php echo $paymentTab;  ?>"><a href="<?php echo site_url(); ?>/payment-history"><img src="<?php echo get_stylesheet_directory_uri().'/images/'; ?>pay.png" alt=""> <span>Payment History</span></a></li>
						<li class="link <?php echo $shootTab; ?>"><a href="<?php echo site_url(); ?>/shoot-link"><img src="<?php echo get_stylesheet_directory_uri().'/images/'; ?>book.png" alt=""> <span>Shoot Link</span></a></li>
						<li class="link <?php echo $notificationTab; ?>"><a href="<?php echo site_url(); ?>/notifications/"><img src="<?php echo get_stylesheet_directory_uri().'/images/'; ?>notification.png" alt=""><span>Notification <span class="noti-counts  <?php 
                        if(!empty($notificationCount)){
                          echo 'noti-count';  
                        }
                        ?>">  <?php 
                        if(!empty($notificationCount)){
                            ?>
                           <small>
                            <?php
                                echo getNotificationCount($userId);   
                             ?>
                            </small>
                            <?php
                        }
                            ?></span></span></a></li>
						<?php
					}
					?>
				</ul>
			</div>
			<ul class="navbar-nav ml-auto">
				<li class="noti-icon-wrapper">
					<a class="notificationModule nav-link dropdown-toggle mr-lg-2" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="noti-icon"></i><span class="noti-counts <?php if(!empty($notificationCount)){ echo 'noti-count';}?>">
                        <?php if(!empty($notificationCount)){?>
						<small>
                            <?php 
                         echo getNotificationCount($userId);   ?>
                           </small>
                         <?php
                        } ?></span>
					</a>
					<div class="dropdown-menu" aria-labelledby="messagesDropdown">
						<div class="notificationContent"></div>
					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle mr-lg-2" href="#" id="messagesDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<figure style="background-image: url('<?php echo $profileImage; ?>');"></figure>
						<span><?php echo ucwords(getUserName($userId));?></span>
					</a>
					<div class="dropdown-menu" aria-labelledby="messagesDropdown">
						<a class="dropdown-item" href="<?php echo wp_logout_url(site_url()); ?>">Logout</a>
					</div>
				</li>
			</ul>
		</div>
	</nav>
	<main class="admin-section">