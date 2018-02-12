<footer id="footer">
	<div class="main-footer">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-md-6 col-lg-3">
                    <?php  dynamic_sidebar('footer-one');?>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-3 footer-address">
					 <?php  dynamic_sidebar('footer-two');?>
				</div>
				<div class="col-xs-12 col-md-6 col-lg-3">
                    <h5>Get in touch</h5>
							<ul class="slinks">
								<li><a href="<?php echo get_custom('facebook',false);?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
								<li><a href="<?php echo get_custom('twitter',false);?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
								<li><a href="<?php echo get_custom('instagram',false);?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
							</ul>
					
					 <?php  //dynamic_sidebar('footer-three');?>
				</div>
				<div class="col-xs-12 col-md-6 col-lg-3">
                     <?php  dynamic_sidebar('footer-four');?>
				</div>
			</div>
		</div>
	</div>
	<div class="copyright">
		<div class="container">
             <?php  dynamic_sidebar('copyright_section');?>			
		</div>
	</div>
</footer>
<div id="login-pop">
	<div class="container">
		<div class="pop">
			<div id="pop">
				<div class="pop-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
					<h4>Login</h4>
				</div>
				<ul class="tabs">
					<li id="user0" class="active"><a class="selectUserType" data-attr-val="0" href="javascript:void(0)" data-target="photographer">Photographer</a></li>
					<li  id="user1"  class=""><a class="selectUserType" data-attr-val="1" href="javascript:void(0)" data-target="traveler">Traveler</a></li>
				</ul>
				<div class="logform">
					<form id="logform" method="post">
						<div id="responseLogin"></div>
						<input name="userType" id="userTypedata" class="userTypedata" type="hidden" value="0">
						<!--Photographer <input name="userType" id="userTypedata" class="userTypedata" type="radio" value="0">
                               Traveler <input name="userType"  id="userTypedata"  class="userTypedata"  type="radio" value="1">-->
						<input name="action" type="hidden" value="login">
						<input name="email" type="email" placeholder="Email">
						<input name="password" type="password" placeholder="Password">
						<input type="submit" value="Submit">
                        <a href="javascript:void(0);" id="forgotPassword">Forgot Password</a>
					</form>
				</div>
				<div class="logwith">
					<h5>Or</h5>
					<a class="fb-link connectFacebook" href="javascript:void(0);">Sign in with Facebook</a>
					<a class="gp-link connectGoogle" href="javascript:void(0);">Sign in with Google</a>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- start Hire/Send Request Time -->
<div class="modal fade" id="hirePopup" role="dialog" aria-labelledby="gridSystemModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="hireForm" action="javascript:void(0);">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="gridSystemModalLabel">Send Request</h4>
				</div>
				<div class="modal-body">
					<div class="response"></div>
                    <?php 
                    $url = $_SERVER["REQUEST_URI"];
                    $array=array_filter(explode('/',$url));
                    $key=max(array_keys($array));
                    $userId=$array[$key];
                     global $wpdb;
                     $query='select * from `im_schedules` where `userId`="'.$userId.'" order by dayId asc';
                     $checkUser=$wpdb->get_results($query,ARRAY_A); 
                    if(!empty($checkUser)){  ?>
                     <h3>Free Schedule  </h3>
                    <table style="width: 100%;margin-bottom:20px">
                    <tr>
                        <th>Day</th>
                        <th style="text-align: center;">From</th>
                        <th style="text-align: center;">To</th>
                        </tr> <?php 
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
											    <td style="text-align: center;"><?php echo $v['startTime']; ?></td>
                                                    <td style="text-align: center;"><?php echo $v['endTime']; ?></td>
                                                </tr>
										<?php
									} 
							}
						}?> </table> <?php
                         }else{ ?>
                        <h3>Free Schedule : </h3>
                        <h6>No free schedule defined. </h6>
                    <?php } ?>
                  
                    
					<div class="row">
						<div class="col-md-12 form-group">
							<label>Selected Date</label>
							<input class="form-control" value="<?php if(isset($_SESSION['date']) and !empty($_SESSION['date'])){ echo $_SESSION['date']; } ?>" type="text" id="sendRequestDate" name="startDate" value="" onfocus="blur();">
						</div>
						<div class="col-md-6 form-group">
							<label>Start Time</label>
							<input type="text" value="<?php if(isset($_SESSION['startTime']) and !empty($_SESSION['startTime'])){ echo $_SESSION['startTime']; } ?>" name="startTime" class="form-control timepickerclass" onfocus="blur();">
						</div>
						<div class="col-md-6 form-group">
							<label>End Time</label>
							<input type="text" value="<?php if(isset($_SESSION['endTime']) and !empty($_SESSION['endTime'])){ echo $_SESSION['endTime']; } ?>" name="endTime" class="form-control timepickerclass" onfocus="blur();">
						</div>
					</div>	
                    <input type="hidden" class="checkVal" name="check" value="1">
				</div>
				<div class="modal-footer">					
					<button type="button" class="custom-btn btn-blue sendRequest">Send Request</button>
                    <!--<button type="button" class="custom-btn btn-darkBlue" data-dismiss="modal">Close</button>-->
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- end Hire/Send Request Time -->
<!-- start Hire/Send Request Time -->
<div class="modal fade" id="forgotPasswordPopup" role="dialog" aria-labelledby="gridSystemModalLabels">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="forgotPasswordForm" action="javascript:void(0);">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="gridSystemModalLabels">Forgot Password</h4>
				</div>
				<div class="modal-body">
					<div id="responseForgot"></div>
					<div class="row">
						<div class="col-md-12 form-group">
							<label>Email</label>
							<input class="form-control" type="email" id="forgotEmail" name="email">
							<input  type="hidden" value="forgot_password"  name="action">
						</div>						
					</div>
				</div>
				<div class="modal-footer">
                    <button type="button" class="custom-btn btn-blue forgotRequest">Submit</button>
					<!--<button type="button" class="custom-btn btn-darkBlue" data-dismiss="modal">Close</button>-->
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- end Hire/Send Request Time -->

<div class="loading_image" style="display:none;">
    <div class="loaderWrapper">
    <img alt="loader" src="<?php echo get_stylesheet_directory_uri();?>/images/loader.gif">
        </div>
</div>
<?php
session_start();
?>
<?php 
$hireType='0';
if(isset($_SESSION['type']) and !empty($_SESSION['type']) and $_SESSION['type']=='hire'){
  $hireType='1';  
}
$loginUserDetails=get_custom_user_id();
if(isset($_SESSION['msg']) and !empty($_SESSION['msg'])){
  $_SESSION['msg']=$_SESSION['msg'];  
}else{
    $_SESSION['msg']=@$_SESSION['loginResponse']['error'];
}
?>
<input type="hidden" id="hiringValue" value="<?php echo $hireType; ?>" name="hT"/>
<script>
	var SITE_URL = '<?php echo get_site_url(); ?>';
	var loginResponse = '<?php echo @$_SESSION['loginResponse']['success']; ?>';
	var adminApproval = '<?php echo @$_SESSION['adminApproval']; ?>';
	var msggg = '<?php echo @$_SESSION['msg']; ?>';
    var hireType='<?php echo $hireType; ?>';
    var userType='<?php echo @$_SESSION['userType']; ?>';
    var loginUserDetails='<?php echo $loginUserDetails; ?>';
    if(loginUserDetails!='' || loginUserDetails!=0){
       $('#menu-item-924').hide(); 
       $('.menu-item-924').hide(); 
    }
</script>
<script src="<?php echo get_stylesheet_directory_uri().'/js/jquery.timepicker.min.js'; ?>"></script>
<script>
	$(document).ready(function() {
        $('.timepickerclass').timepicker();
        $(document).on('blur','#searchDataForm .timepickerclass', function (){
            var current_day=$('#searchDate').val();
            var d = new Date();
            var day = d.getDate();
            var month = d.getMonth() + 1;
            var year = d.getFullYear();
            if (day < 10) {
                day = "0" + day;
            }
            if (month < 10) {
                month = "0" + month;
            }
            var date = day + "/" + month + "/" + year;          
            if(current_day == date)
            {               
              $('#searchDataForm .timepickerclass').timepicker('option', 'minTime', new Date());
            }else{
              $('#searchDataForm .timepickerclass').timepicker('option', 'minTime', '00:00'); 
            }

        }); 
        $(document).on('change','#searchDate',function(){
            var current_day=$('#searchDate').val();
            var d = new Date();
            var day = d.getDate();
            var month = d.getMonth() + 1;
            var year = d.getFullYear();
            if (day < 10) {
                day = "0" + day;
            }
            if (month < 10) {
                month = "0" + month;
            }
            var date = day + "/" + month + "/" + year;          
            if(current_day == date)
            {               
              $('#searchDataForm .timepickerclass').timepicker('option', 'minTime', new Date());
            }else{
              $('#searchDataForm .timepickerclass').timepicker('option', 'minTime', '00:00'); 
            }
        }); 
        $(document).on('blur','#hireForm .timepickerclass', function (){
            var current_day=$('#sendRequestDate').val();
            var d = new Date();
            var day = d.getDate();
            var month = d.getMonth() + 1;
            var year = d.getFullYear();
            if (day < 10) {
                day = "0" + day;
            }
            if (month < 10) {
                month = "0" + month;
            }
            var date = day + "/" + month + "/" + year;          
            if(current_day == date)
            {
             /* $('#hireForm .timepickerclass').timepicker('setTime',new Date()); */ 
              $('#hireForm .timepickerclass').timepicker('option', 'minTime',new Date()); 
            }else{
              $('#hireForm .timepickerclass').timepicker('option', 'minTime', '00:00'); 
            }

        });
        $(document).on('change','#sendRequestDate',function(){
            var current_day=$('#sendRequestDate').val();
            var d = new Date();
            var day = d.getDate();
            var month = d.getMonth() + 1;
            var year = d.getFullYear();
            if (day < 10) {
                day = "0" + day;
            }
            if (month < 10) {
                month = "0" + month;
            }
            var date = day + "/" + month + "/" + year;          
            if(current_day == date)
            {               
              $('#hireForm .timepickerclass').timepicker('option', 'minTime', new Date());
            }else{
              $('#hireForm .timepickerclass').timepicker('option', 'minTime', '00:00'); 
            } 
        });	
	});
</script>
<script src="<?php echo get_stylesheet_directory_uri();?>/js/raterater.jquery.js"></script>
<script>
$(function() {
    $( '.ratebox' ).raterater( { 
        allowChange: false,
        starWidth: 20,
        spaceWidth: 5,
        numStars: 5
    } );
});
</script>
<?php wp_footer(); ?>
</body>
</html>