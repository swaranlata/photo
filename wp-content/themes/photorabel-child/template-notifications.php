<?php 
/*Template Name:Notification*/
get_header('custom');
$userId=get_custom_user_id();
$url=site_url().'/api/getNotifications.php?userId='.$userId;
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
			<h1>Notification</h1>
			<div class="notifications">
				<div class="notification-list">
                    <?php  
                    if(!empty($finalArray)){
                        foreach($finalArray as $k=>$v){
                            $class='';
                            if(!empty($v['isRead'])){
                              $class='markAsRead';  
                            }
                    ?>
                    <div class="notification <?php echo $class; ?>">
						<div class="noti-head">
							<h2><?php echo $v['name']; ?></h2>
							<div class="time"><?php echo $v['dateTime'].' ago'; ?></div>
                            <span class="deleteNoti" data-attr-id="<?php echo $v['id'];?>">x</span>
						</div>
						<div class="noti-con">
							<p><?php echo $v['title']; ?></p>
						</div>
					</div>
                    <?php  }              
                    }else{
                    ?>
                     <div class="notification">						
						<div class="noti-con">
							<p  class="w100p text-center dropdown-item">No Notifications found.</p>
						</div>
					</div>
                    <?php
                    }?>
                    
	
				</div>
			</div>
		</div>
	</div>
</section>
<?php 
get_footer('custom');
?>