<?php 
include('includes/header.php');
global $wpdb;
$results=$wpdb->get_results('select * from `im_linkrequests` order by id desc',ARRAY_A);
?>
<div class="customAdmin">
    <h2>All Requests for a link</h2>

<table id="example" class="display " cellspacing="0" width="100%">
    <thead>
        <tr>
           <th>Sr.No</th>
            <th>Sender Name</th>
            <th>Receiver Name</th>
            <th>Start Date</th>
            <th>Start Time</th>
            <th>End Time</th>
          </tr>
    </thead>
   
    <tbody>
       <?php if(!empty($results)){
                $counter=1; 
                foreach($results as $k=>$v){   
                    $job=getJobDetails($v['requestId']);
                    ?>
                    <tr>
                        <td><?php echo $counter; ?></td>
                        <td><?php echo getUserName($v['userId']); ?></td>
                        <td><?php echo getUserName($v['otherUserId']); ?></td>
                        <td><?php echo getDateFormat($job['startDate']); ?></td>
                        <td><?php echo $job['startTime'];?></td>
                        <td><?php echo $job['endTime'];?></td>
                     
                   </tr>        
                    <?php 
                    $counter++;
                }    
                }else{
    
            ?><tr><td colspan="5"> No jobs found.</td></tr>
        <?php
    
        }?>
        
    </tbody>
</table></div>