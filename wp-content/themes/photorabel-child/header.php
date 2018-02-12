<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
session_start();
//header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
$custom_logo_id = get_theme_mod( 'custom_logo' );
$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
$imageAlt=explode('/',@$image[0]);
$alt=explode('.',$imageAlt[max(array_keys($imageAlt))]);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
        <meta name="google-site-verification" content="UY_BnzOA7p_gv_HH54Ln2WGuZIK7jXyHlARL9Kx3nWY" />
		<?php wp_head(); ?>
        <script>
                var removeSession='';                
                </script> 
	</head>
	<body <?php body_class(); ?> onLoad="removeClassTest()">
		<header id="header">
			<div class="logo-section">
				<a href="<?php echo get_site_url(); ?>">
					<img src="<?php echo @$image[0]; ?>" alt="<?php echo @$alt[0]; ?>">
				</a>
			</div>
			<div class="mainmenu-section">
				<ul>
                    <?php 
                    $loginStatus=0;
                    $userdata['ID']=get_custom_user_id();
                    if(is_user_logged_in() || !empty($userdata['ID'])){
                        $loginStatus=1; 
                    }
                    if(!empty($loginStatus) and !is_admin()){
                        unset($_SESSION['hireType']);
                        unset($_SESSION['type']);
                        $userType=get_user_meta($userdata['ID'],'userType',true);
                        if(!empty($userType)){
                          $dahboardUrl='/job-requests';  
                        }else{
                          $dahboardUrl='/photographer-job-requests';    
                        }
                        ?>
                    <li><a href="<?php echo site_url().$dahboardUrl; ?>">Dashboard</a></li>
					<li><a href="<?php echo wp_logout_url(site_url()); ?>">Logout</a></li>                    
                    <?php
                        
                    }else{
                        ?>
                    <li><a class="log-in-form" href="javascript:void(0);">Login</a></li>
					<li><a href="<?php echo get_site_url().'/registration';?>">Signup</a></li>
                    <?php
                        }
                    
                    ?>
					
					<li>
						<a class="menu-toggle" href="javascript:void(0)">
							<span></span>
							<span></span>
							<span></span>
						</a>
					</li>
				</ul>
			</div>
			<div class="search-section"></div>
		</header>
        
		<nav class="main-manu">
			<?php echo  wp_nav_menu(array(
				'menu'              => 'primary',
				'container'         => 'div',
				'container_class'   => '',
				'menu_class'        => 'navbar-nav nav',
				));
			?>
		</nav>
