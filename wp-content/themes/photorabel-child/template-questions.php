<?php
/*Template Name:Questions*/

get_header('custom');
$userId=get_custom_user_id();
$getUserType=get_user_meta($userId,'userType',true);
$url=site_url().'/api/getQuestions.php?userId='.$userId.'&jobId='.$_GET['jobId'];
$response=file_get_contents($url);
$finalArray=array();
if($response) {
	$response=json_decode($response,true);
	if(!empty($response['result'])) {
		$finalArray=$response['result'];
	}
}

$select='select * from `im_requests` where `id`="'.$_GET['jobId'].'"';
$res=$wpdb->get_row($select,ARRAY_A);
$otherUserId='';
if(!empty($res)) {
	if($res['userId']==$userId) {
		$otherUserId=$res['otherUserId'];
	} else {
		$otherUserId=$res['userId'];
	}
}

$message='';
$ermessage='';

if(isset($_POST['submit']) and !empty($_POST['submit'])) {
	$sendAnswer=sendAnswer($userId,$otherUserId,$_GET['jobId'],$_POST['answerArray']);
	if(!empty($sendAnswer)) {
		$message='Answer submitted successfully.';
	} else {
		$ermessage='You have already answered the questions for this job.';
	}
}
$isAnswered=isAnswered($userId,$_GET['jobId']);
?>
<section class="photo-profile">
	<div class="container-fluid">
		<div class="customHead">
			<div class="customBox"><h1>Questions</h1></div>
		</div>
		<!-- <div class="row"> -->
			<?php
			if(!empty($ermessage)) {
				?>
				<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><?php echo $ermessage; ?></div>
				<?php
			}
			if(!empty($message)) {
				?>
				<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><?php echo $message; ?></div>
                <script>
                $('.alert-success').delay(3000).fadeOut();
                </script>
				<?php
			}
			?>
			<form name="questions" action="" method="post">
				<ul>
					<?php 
                    $disabled='';
                    $isAnswered=isAnswered($userId,$_GET['jobId']);
                    if(empty($getUserType)) {
                        $disabled='disabled="disabled"';
                    }else{
                        if(!empty($isAnswered)){
                           $disabled='disabled="disabled"'; 
                        }
                    }
                    if(!empty($finalArray)) {
						foreach($finalArray as $k=>$v) {
							?>
							<li>
								<div class="form-group">
									<label><?php echo $v['question']; ?></label>
									<input type="hidden" name="answerArray[<?php echo $k; ?>][questionId]" value="<?php echo $v['questionId']; ?>" />
									<input <?php echo $disabled; ?> class="form-control" type="text" name="answerArray[<?php echo $k; ?>][answer]" value="<?php echo $v['answer']; ?>" />
								</div>
							</li>
							<?php
						}
						if(!empty($getUserType)) {
							if(empty($isAnswered)) {
								?>
								<li>
									<input type="submit" name="submit" class="custom-btn btn-blue" value="Submit" />
								</li>
								<?php
							}
						}
						if(empty($getUserType)) {
							?>
							<li><a href="javascript:void(0);" class="custom-btn btn-blue" id="suggestRouteBtn">Suggest Route</a></li>
							<?php
						}else{
                             $suggestRoute= getSuggestedRoutes($userId,$_GET['jobId']);
                            if(!empty($suggestRoute)){
                                ?>
                    <li><a href="<?php echo site_url().'/view-job-detail/'.$_GET['jobId']; ?>" class="custom-btn btn-blue" id="">Route suggested</a></li>
                            <?php
                            }else{
                                /*?>
                    <li><a href="javascript:void(0);" class="custom-btn btn-darkBlue" id="">Waiting Suggested Route</a></li>
                    <?php*/
                                
                            }
                        }  
					} else {
						?>
						<li><p class="w100p text-center">No Questions found.</p></li>
						<?php
					}
					?>
				</ul>
			</form>
		<!-- </div> -->
	</div>
</section>
<?php 
get_footer('custom');
?>