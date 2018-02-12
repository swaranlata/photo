<?php
/* Template Name: Photographer Job Requests Template */
get_header('custom');
unsetSession('hireType');
$userId=get_custom_user_id();
$url=site_url().'/api/getJobRequests.php?userId='.$userId;
$response=file_get_contents($url);
$finalArray=array();
$jobR=0;
$jobC=0;
if($response){
   $response=json_decode($response,true); 
    if(!empty($response['result'])){
        $finalArray=$response['result'];
        foreach($finalArray as $k=>$v){
           if($v['requestStatus']=='5'){
             $jobC=1;  
           }else{
             $jobR=1;  
           } 
        }
    }
} 
$user = wp_get_current_user();
$allowed_roles = array( 'administrator');
if( array_intersect($allowed_roles, $user->roles ) ) { 
header('location:'.site_url());
}

?>
<section class="photo-profile">
	<div class="container-fluid">
		<div class="admin-hearder">
            <h4 class="messageLine">After 24 hours requests will be deleted.</h4>
			<div class="tabSection">
				<ul>
					<li class="active"><a href="javascript:void(0);" data-tabtarget="today">Job Requests</a></li>
                    <li class=""><a href="javascript:void(0);" data-tabtarget="upcoming">Cancelled Job Requests</a></li>
				</ul>
			</div>
			<div class="tableContainer tabs today">
                <?php
                  if(isset($_SESSION['firstSignup']) and !empty($_SESSION['firstSignup'])){
                    ?>
                <div class="alert alert-success signMup" style="margin-top:18px;">
    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
    <strong>Success!</strong> You are successfully registered with the Photoravel.
</div>
              <script>
                var removeSession='1';                
                </script>  
                <?php
                 unset($_SESSION['firstSignup']);
                }                
                ?>
                
				
                    <?php     
                
                    if(!empty($jobR)) {
                        ?>
                <table class="ttu table <?php echo empty($finalArray) ? ' w100p' : '' ?>">
                    <?php
                        foreach($finalArray as $kk=>$vv){
                            if($vv['requestStatus']!='5'){
                            $image=get_site_url().'/wp-content/uploads/2017/08/avatar.png';
                            if(!empty($vv['profileImage'])){
                               $image = $vv['profileImage'];
                            } 
                            ?>                    
                            <tr>
						<td>
							<div class="tableAvatar">
								<figure style="background-image: url('<?php echo $image;?>');"></figure>
							</div>
						</td>
						<td>
							<div class="tabCon">
								<h3>Name</h3>
								<h4><?php echo $vv['name'];?></h4>
							</div>
						</td>
						<td>
							<div class="tabCon">
								<h3>Status</h3>
								<h4><?php 
                            if($vv['requestStatus']=='5'){
                                            $cancelUser= getCanceledJob($vv['requestId']);
                                            $hetUserTypeData=getUserType($cancelUser);
                                            if(!empty($hetUserTypeData)){
                                            echo 'Cancelled By Traveler';
                                            }else{
                                            echo 'Cancelled By Photographer'; 
                                            }
                            }else{
                              echo getStatus($vv['requestStatus']);   
                            }
                            
                           
                                    
                                    ?></h4>
							</div>
						</td>
						<td>
							<div class="tabCon">
								<h3>date time</h3>
								<h4><?php echo $vv['date']; ?> <br><?php echo $vv['originalTimeSlot'];?></h4>
							</div>
						</td>
						<td>
							<div class="tabCon">
								<h3>place</h3>
								<h4><?php echo $vv['address']; ?></h4>
							</div>
						</td>
						<td>
							<div class="tabCon">
								<h3>action</h3>
								<a href="<?php echo site_url(); ?>/view-job-detail/<?php echo $vv['requestId']; ?>" class="custom-btn btn-blue">View Details</a>
							</div>
						</td>
					</tr>
                        <?php
                            }
                        }
                   ?></table> 
                  <?php } else{
                        ?>
                    <p class="emptyTag">No job request found.</p>
                    <?php
                    } 
                    ?>
				
			</div>
            <div class="tableContainer tabs upcoming" style="display:none;">
				  <?php     
                
                    if(!empty($jobC)) {
                        ?>
                <table class="ttu table <?php echo empty($finalArray) ? ' w100p' : '' ?>">
                    <?php
                        foreach($finalArray as $kk=>$vv){
                            if($vv['requestStatus']=='5'){
                            $image=get_site_url().'/wp-content/uploads/2017/08/avatar.png';
                            if(!empty($vv['profileImage'])){
                               $image = $vv['profileImage'];
                            } 
                            ?>                    
                            <tr>
						<td>
							<div class="tableAvatar">
								<figure style="background-image: url('<?php echo $image;?>');"></figure>
							</div>
						</td>
						<td>
							<div class="tabCon">
								<h3>Name</h3>
								<h4><?php echo $vv['name'];?></h4>
							</div>
						</td>
						<td>
							<div class="tabCon">
								<h3>Status</h3>
								<h4><?php 
                            if($vv['requestStatus']=='5'){
                                            $cancelUser= getCanceledJob($vv['requestId']);
                                            $hetUserTypeData=getUserType($cancelUser);
                                            if(!empty($hetUserTypeData)){
                                            echo 'Cancelled By Traveler';
                                            }else{
                                            echo 'Cancelled By Photographer'; 
                                            }
                            }else{
                              echo getStatus($vv['requestStatus']);   
                            }
                            
                           
                                    
                                    ?></h4>
							</div>
						</td>
						<td>
							<div class="tabCon">
								<h3>date time</h3>
								<h4><?php echo $vv['date']; ?> <br><?php echo $vv['originalTimeSlot'];?></h4>
							</div>
						</td>
						<td>
							<div class="tabCon">
								<h3>place</h3>
								<h4><?php echo $vv['address']; ?></h4>
							</div>
						</td>
						<td>
							<div class="tabCon">
								<h3>action</h3>
								<a href="<?php echo site_url(); ?>/view-job-detail/<?php echo $vv['requestId']; ?>" class="custom-btn btn-blue">View Details</a>
							</div>
						</td>
					</tr>
                        <?php
                        }
                        }
                   ?></table> 
                  <?php } else{
                        ?>
                    <p class="emptyTag">No job request found.</p>
                    <?php
                    } 
                    ?>
                   

				
			</div>
		</div>
	</div>
</section>
<?php 
get_footer('custom');
?>