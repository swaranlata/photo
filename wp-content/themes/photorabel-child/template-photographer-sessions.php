<?php
/* Template Name: Photographer Sessions Template */
get_header('custom');
$userId=get_custom_user_id();
$url=site_url().'/api/getUserSessions.php?userId='.$userId.'&type=0';
$response=file_get_contents($url);
$todayFinalArray=array();
if($response){
   $response=json_decode($response,true); 
    if(!empty($response['result'])){
        $todayFinalArray=$response['result'];
    }
} 
$url=site_url().'/api/getUserSessions.php?userId='.$userId.'&type=1';
$response=file_get_contents($url);
$upcomingFinalArray=array();
if($response){
   $response=json_decode($response,true); 
    if(!empty($response['result'])){
        $upcomingFinalArray=$response['result'];
    }
} 
?>
<section class="photo-profile">
	<div class="container-fluid">
		<div class="admin-hearder">
			<div class="tabSection">
				<ul>					
					<li class="active"><a href="javascript:void(0);" data-tabtarget="today">Today</a></li>
					<li class=""><a href="javascript:void(0);" data-tabtarget="upcoming">Upcoming</a></li>
				</ul>
			</div>
			<div class="tableContainer tabs upcoming" style="display:none;">
				
                    <?php     
                    if(!empty($upcomingFinalArray)){
                        ?><table class="ttu w100p table">
                <?php
                        foreach($upcomingFinalArray as $kk=>$vv){
                            $image=get_site_url().'/wp-content/uploads/2017/08/avatar.png';
                            if(!empty($vv['profileImage'])){
                               $image = $vv['profileImage'];
                            } 
                            if($vv['userId']==$vv['otherUserId']){
                               $getPhoneUser=$vv['userId'];
                            }else{
                               $getPhoneUser=$vv['userId']; 
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
								<h3>Phone Number</h3>
								<h4><?php echo $vv['phoneNumber'];?></h4>
							</div>
						</td>
						<td>
							<div class="tabCon">
								<h3>Status</h3>
								<h4><?php echo getStatus($vv['requestStatus']); ?></h4>
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
								<a href="<?php echo site_url(); ?>/view-job-detail/<?php echo $vv['jobId']; ?>" class="custom-btn btn-blue">View Details</a>
							</div>
						</td>
					</tr>
                        <?php
                        }
                        ?></table><?php
                    }else{
                        ?><p class="emptyTag">No upcoming jobs.</p>
                        <!--<tbody style="display: block;">
                        	<tr style="display: block;">
                        		<td class="w100p text-center" style="display: block;">No Upcoming Jobs.</td>
                        	</tr>
                        </tbody>-->
                    <?php
                    }  
                    ?> 

				
			</div>
			<div class="tableContainer tabs today">
				                  
                    <?php     
                    if(!empty($todayFinalArray)){
                        ?><table class="ttu w100p table">	  
                    <?php
                        foreach($todayFinalArray as $kk=>$vv){
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
								<h3>Phone Number</h3>
								<h4><?php echo $vv['phoneNumber'];?></h4>
							</div>
						</td>
						<td>
							<div class="tabCon">
								<h3>Status</h3>
								<h4><?php echo getStatus($vv['requestStatus']); ?></h4>
							</div>
						</td>
						<td>
							<div class="tabCon">
								<h3>date time</h3>
								<h4><?php echo $vv['date']; ?> /<?php echo $vv['originalTimeSlot'];?></h4>
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
								<a href="<?php echo site_url(); ?>/view-job-detail/<?php echo $vv['jobId']; ?>" class="custom-btn btn-blue">View Details</a>
							</div>
						</td>
					</tr>
                        <?php
                        }
                        ?> </table>
                <?php
                    }else{
                        ?>
                       <!-- <tbody style="display: block;">
                        	<tr style="display: block;">
                        		<td class="w100p text-center" style="display: block;"> No jobs for Today.</td>
                        	</tr>
                        </tbody>-->
                       <p class="emptyTag">No jobs for today.</p>
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