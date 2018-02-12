<?php
/*Template Name:Payment History*/
get_header('custom');
$userId=get_custom_user_id();
$url=site_url().'/api/getPaymentHistory.php?userId='.$userId;
$response=file_get_contents($url);
$finalArray=array();
if($response){
   $response=json_decode($response,true); 
    if(!empty($response['result'])){
        $finalArray=$response['result'];
    }
} 
$getUserType=get_user_meta($userId,'userType',true);
?>
<section class="photo-profile">
	<div class="container-fluid">
		<div class="admin-hearder">
			<div class="customHead">
				<div class="customBox">
					<h1>payment history</h1>
				</div>
				<div class="customBox">
					<div class="search">
						<input type="text" placeholder="Search">
						<button type="submit"><i class="fa fa-search"></i></button>
					</div>
				</div>
			</div>
            <div class="response" style="display: none;margin-top: 10px;"></div>
            <div class="tabSection">
                <ul>                    
                    <li class="active"><a href="javascript:void(0);" data-tabtarget="today">Working</a></li>
                    <li class=""><a href="javascript:void(0);" data-tabtarget="upcoming">Complete</a></li>
                </ul>
            </div>
			<div class="tableContainer tabs today">
				
                    <?php 
                         if(!empty($finalArray['working'])){
                             ?>
                            <table id="payment" class="ttu w100p table">
                <?php
                            foreach($finalArray['working'] as $k=>$v){
                               ?>
                              <tr>
                                    <td>
                                        <h3>Invoice id1</h3>
                                        <h4><?php echo $v['transactionId']; ?></h4>
                                    </td>
                                    <td>
                                        <h3>Invoice date</h3>
                                        <h4><?php echo str_replace('-','/',$v['date']); ?></h4>
                                    </td>
                                    <td>
                                        <h3>amount</h3>
                                        <h4>$<?php echo $v['amount']; ?></h4>
                                    </td>
                                    <td>
                                        <h3>link</h3>
                                        <h4><?php 
                                    $jobLink=getJobLink($v['jobId']);
                                    if(empty($jobLink)){
                                      echo $jobLink='No Link Provided.';  
                                    }else{
                                      echo '<a target="_blank" href="'.$jobLink.'">'.$jobLink.'</a>';  
                                    }
                                    
                                ?></h4>
                                    </td> 
                                    <td>
                                        <h3>status</h3>
                                        <h4><?php echo getStatus($v['status']); ?></h4>
                                    </td>
                                    <td>
                                        <h3>Action</h3>
                                        <h4>
                                            <?php  if(!empty($getUserType)){//traveller
                                                        ?>
                                            <a href="javascript:void(0);" data-attr-id="<?php echo $v['jobId']; ?>"  class="ratingPopup custom-btn btn-darkBlue" >Complete the job</a>
                                             <a href="javascript:void(0);" data-attr-id="<?php echo $v['jobId']; ?>" class="requestForLink custom-btn btn-blue">Request for a link</a>
                                                    <?php
                                                   }else{
                                                        ?>
                                            <a href="javascript:void(0);" data-attr-id="<?php echo $v['jobId']; ?>"  class="remindTraveler custom-btn btn-darkBlue" >Remind Traveler</a>
                                            <a href="javascript:void(0);" data-attr-id="<?php echo $v['jobId']; ?>"  class="shootLinkClick custom-btn btn-blue" >Submit Link</a>
                                            <?php
                                                   }  ?>
                                            
                                        </h4>
                                    </td>
                                    <td>
                                        <div class="last-div">
                                            <h3>Download invoice</h3>
                                            <h4>
                                                <a href="javascript:void(0);"><i class="fa fa-download"></i></a>
                                            </h4>
                                        </div>
                                    </td>
					       </tr>
                            <?php
                            }
                             ?>
                            </table>
                    <?php
                         }else{
                             ?>
                    <p class="emptyTag">No jobs found.</p>
                    <!--<tbody style="display: block;">
                            <tr style="display: block;">
                                <td class="w100p text-center" style="display: block;">No Upcoming Jobs.</td>
                            </tr>
                        </tbody>-->
                     <?php
                         }
                    ?>       
                   
                     

				
			</div>
			<div class="tableContainer tabs upcoming" style="display:none;">
				  
                     <?php 
                  
                         if(!empty($finalArray['complete'])){
                             ?><table id="payment" class="ttu w100p table">	
                <?php
                            foreach($finalArray['complete'] as $k=>$v){
                               ?>
                              <tr>
                                    <td>
                                        <h3>Invoice id1</h3>
                                        <h4><?php echo $v['transactionId']; ?></h4>
                                    </td>
                                    <td>
                                        <h3>Invoice date</h3>
                                        <h4><?php echo str_replace('-','/',$v['date']); ?></h4>
                                    </td>
                                    <td>
                                        <h3>amount</h3>
                                        <h4>$<?php echo $v['amount']; ?></h4>
                                    </td>
                                  <td>
                                        <h3>link</h3>
                                        <h4><?php 
                                    $jobLink=getJobLink($v['jobId']);
                                    if(empty($jobLink)){
                                      echo $jobLink='No Link Provided.';  
                                    }else{
                                      echo '<a target="_blank" href="'.$jobLink.'">'.$jobLink.'</a>';  
                                    }
                                    
                                ?></h4>
                                    </td> 
                                  
                                  
                                  <?php  if(empty($getUserType)){ ?>
                                    <td> 
                                  <?php }else{
                                   ?><td> 
                                        <?php
                                   } ?>
                                        <h3>status</h3>
                                        <h4><?php echo getStatus($v['status']); ?></h4>
                                  </td>
                                 
                                  <?php  if(empty($getUserType)){ ?>
                                  <td><h3>Action</h3>
                                     
                                        <?php

                                                if($v['isFeedback']=='false'){
                                                  ?>
                                                  <a href="javascript:void(0);" data-attr-id="<?php echo $v['jobId']; ?>"  class="ratingPopup custom-btn btn-darkBlue" >Submit Feedback</a>
                                                <?php
                                                }else{
                                                    ?>
                                      <h4> submitted</h4>
                                      <?php
                                               
                                            }
                                        ?>

                                    </td>
                                   <?php } ?>
                                    <td>
                                        <div class="last-div">
                                            <h3>Download invoice</h3>
                                            <h4>
                                                <a href="javascript:void(0);"><i class="fa fa-download"></i></a>
                                            </h4>
                                        </div>
                                    </td>
					       </tr>
                            <?php
                            }
                             ?> </table>
                    <?php
                         }else{
                             ?>
                     <p class="emptyTag">No jobs found.</p>
                   <!-- <tbody style="display: block;">
                            <tr style="display: block;">
                                <td class="w100p text-center" style="display: block;">No Upcoming Jobs.</td>
                            </tr>
                        </tbody>-->
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