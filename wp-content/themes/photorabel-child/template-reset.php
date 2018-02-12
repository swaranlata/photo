<?php
/*Template Name:Reset Password*/
get_header();
$page=get_post();
$token='';
$email='';
$temp=0;
$msg='';
if(isset($_GET['token']) and !empty($_GET['token'])){
  $token=$_GET['token'];  
}else{
      $temp=1;
}
if(isset($_GET['email']) and !empty($_GET['email'])){
  $email=$_GET['email'];   
  $getUserByEmail=get_user_by('email',$email);  
    if(empty($getUserByEmail)){
     $temp=1;   
    }
}else{
    $temp=1;
}
if(!empty($temp)){
  $msg=  'You are accessing the invalid reset password link.';
}
$getUserByEmail=get_user_by('email',$email);
if(!empty($getUserByEmail)){
   $getUserByEmail=convert_array($getUserByEmail); 
    $userId=$getUserByEmail['ID'];
    $token= get_user_meta($userId,'tokenfield',true);
    if($token!=$_GET['token']){
        $msg='You are accessing the invalid reset password link.';
    }
}

?>
	<main class="main">
			<div class="photographer">
				<section class="banner" style="background-image: url('https://imarkclients.com/photorabel/wp-content/themes/photorabel-child/images/inner-banner.jpg');">
					<h1>photographer</h1>
				</section>
				<section id="signup">
					<div class="container">
						<h2><?php echo $page->post_title;?></h2>						
						<div class="row">
							<div class="col-md-6 centerDiv">
								<div class="form-wrapper">
                                    <div id="response">
                                        </div>
                                    <?php  if(!empty($msg)){
                                        ?>
                                    <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><?php  echo $msg; ?></div>
                                    <?php
                                       
                                    }?>
									<form enctype="multipart/form-data" id="resetpassword" method="post" action="">
                                        <input type="hidden" name="action" value="reset_password_web"/>
                                        <input type="hidden" name="data" value="true"/>
                                        <input type="hidden" name="email" value="<?php echo $email;?>"/>
                                         <?php  if(!empty($msg)){
                                        ?>
                                        <input type="hidden" name="data" value="false"/>
                                        <?php }?>
										<div class="form-group">
											<div class="row">
												<div class="col-sm-6">
													<input type="password" class="form-control" placeholder="Password" id="pwd" name="password" value="">
												</div>
												<div class="col-sm-6">
													<input type="password" name="confirmPassword" class="form-control" placeholder="Confirm Password" value="">
												</div>
											</div>
										</div>					
										<input type="submit" value="Submit" class="blue-btn">
									</form>								
								</div>
							</div>
							
						</div>
					</div>
				</section>
			</div>
		</main>

<?php
get_footer();
?>