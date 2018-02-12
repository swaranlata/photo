<?php 
include('includes/header.php');
$requests=getJobs(5);
?>
<div class="customAdmin">
    <h2>Cancelled Jobs</h2>

<table id="example" class="display " cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Sr.No</th>
            <th>Sender Name</th>
            <th>Photographer</th>
            <th>Cancellation Reason</th>
            <th>Start Date</th>
            <th>Start Time</th>
            <th>End Time</th>            
            <th>Action</th>           
        </tr>
    </thead>
    
    <tbody>
       <?php if(!empty($requests)){
                $counter=1; 
                foreach($requests as $k=>$v){
                    $senderName='';
                    $receiverName='';
                    $getUserMeta=get_user_meta($v['userId'],'userType',true);
                    if(!empty($getUserMeta)){
                       $senderName=getUserName($v['userId']); 
                       $receiverName=getUserName($v['otherUserId']); 
                    }else{
                       $senderName=getUserName($v['otherUserId']); 
                       $receiverName=getUserName($v['userId']);  
                    }
                    ?>
                    <tr>
                        <td><?php echo $counter; ?></td>
                        <td><?php echo $senderName; ?></td>
                        <td><?php echo $receiverName; ?></td>
                        <td><?php echo $v['reason'];?></td>
                        <td><?php echo getDateFormat($v['startDate']); ?></td>
                        <td><?php echo $v['startTime'];?></td>
                        <td><?php echo $v['endTime'];?></td>
                        
                       <td><a href="<?php echo admin_url();?>?page=view-job.php&id=<?php echo $v['id'];?>"><i class="fa fa-eye"></i></a></td>
                   </tr>        
                    <?php 
                    $counter++;
                }    
                }else{
    
    ?><tr><td colspan="7"> No jobs found.</td></tr>
        <?php
    
}?>
        
    </tbody>
</table>
</div>