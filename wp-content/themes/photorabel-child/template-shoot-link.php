<?php
/* Template Name: Shoot link Template */
get_header('custom');
$userId=get_custom_user_id();
$url=site_url().'/api/getUsersListForRequestLink.php?userId='.$userId;
$response=file_get_contents($url);
$finalArray=array();
if($response){
   $response=json_decode($response,true); 
    if(!empty($response['result'])){
        $finalArray=$response['result'];
    }
} 
?>
	<section class="photo-profile">
		<div class="container-fluid">
			<div class="admin-hearder">
				<h1>Shoot Link</h1>
				<div class="tableContainer">
					
						<?php if(!empty($finalArray)){
                                echo '<table class="ttu table">';
                                foreach($finalArray as $k=>$vv){
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
									<h4><?php echo getStatus($vv['status']); ?></h4>
								</div>
							</td>
							<td>
								<div class="tabCon">
									<h3>Rating</h3>
									<h4>
                                     <div class="ratebox" data-id="1" data-rating="<?php echo $vv['rating']; ?>"></div>
                                    </h4>
								</div>
							</td>
							<td>
								<div class="tabCon">
									<h3>Link</h3>
									<h4>
                                <?php 
                                    $jobLink=getJobLink($vv['jobId']);
                                    if(empty($jobLink)){
                                      $jobLink='No Link Provided.';  
                                         echo $jobLink;
                                    }else{
                                        if (strpos($jobLink, 'http://') === false and strpos($jobLink, 'https://') === false) {
                                           $jobLink='http://'.$jobLink;
                                        }
                                      echo '<a href="'.$jobLink.'" target="_blank">'.$jobLink.'</a>';   
                                    }
                                   
                                ?>
                                </h4>
								</div>
							</td>
							<td>
								<div class="tabCon">
									<h3>action</h3>   <a href="javascript:void(0);" data-attr-id="<?php echo $vv['jobId']; ?>" class="custom-btn btn-blue shootLinkClick">Submit Link</a>
                                </div>
                            </td>
                        </tr>
                        <?php
                                }
                                echo ' </table>';
                            }else{
                        ?>  
                    <p class="emptyTag">No jobs found.</p>
                           <!-- <tbody style="display: block;">
                        	<tr style="display: block;">
                        		<td class="w100p text-center" style="display: block;">No Upcoming Jobs.</td>
                        	</tr>
                        </tbody>-->
                            <?php
} ?>
                   
                </div>
            </div>
        </div>
    </section>
    <?php 
get_footer('custom');
?>