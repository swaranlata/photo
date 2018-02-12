<?php 
   include('includes/header.php');
   global $wpdb;    
   $msg='';
   if(isset($_GET['action']) and !empty($_GET['action'])){
        if( $_GET['action']=='active'){
            update_user_meta($_GET['id'],'userStatus',1);
            $msg='User status has been changed to active.';
            $emailTemplate=file_get_contents(get_stylesheet_directory_uri().'/email-template.php');
            $emailTemplate=str_replace('[NAME]',getUserName($_GET['id']),$emailTemplate);
            $message='You account has been approved by Admin.Now you can login with the website.<br><br>Site url : '.site_url();
            $emailTemplate=str_replace('[MESSAGE]',$message,$emailTemplate);
            send_email(getUserName($_GET['id']),'Photoravel Account Approval',$emailTemplate);
        }else{
            update_user_meta($_GET['id'],'userStatus',2);
            $emailTemplate=file_get_contents(get_stylesheet_directory_uri().'/email-template.php');
            $emailTemplate=str_replace('[NAME]',getUserName($_GET['id']),$emailTemplate);
            $message='You account has been blocked by Admin.';
            $emailTemplate=str_replace('[MESSAGE]',$message,$emailTemplate);
            send_email(getUserName($_GET['id']),'Photoravel Account Approval',$emailTemplate);            
            $msg='User status has been changed to Inactive.';
        }
    }
    $args = array(
     'role' => 'photographer',
     'orderby' => 'ID',
     'order' => 'DESC',
     'fields'=>'ID'
   );
   $allPhotographer=array();
   $photographer = get_users($args);
   foreach($photographer as $k=>$v){
       $getUserType= get_user_meta($v,'userType',true);
       $getUserStatus= get_user_meta($v,'userStatus',true);
       if(empty($getUserType)){
           if(empty($getUserStatus)){
               $allPhotographer[]=$v;
           }
           
       }
   }
    
 ?>
<div class="customAdmin">
    <h2>Pending Photographer</h2>

<?php
 if(!empty($msg)){
         ?>
    <div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><?php echo $msg; ?></div>     
    <?php   
     }  
    ?>



<table id="example" class="display " cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Sr.No</th>
            <th>Name</th>
            <th>Address</th>
            <th>Hourly Rate</th>
            <th>Min Hours</th>
            <th>Experience</th>
            <th>Date Of Birth</th>
            <th>Status</th>           
        </tr>
    </thead>
    <tbody>
       <?php if(!empty($allPhotographer)){
                $allPhotographer=convert_array($allPhotographer);
                $counter=1; 
                foreach($allPhotographer as $k=>$v){
                    ?>
                    <tr>
                        <td><?php echo $counter; ?></td>
                        <td><?php echo getUserName($v); ?></td>
                        <td style="width:20%"><?php echo get_user_meta($v,'address',true); ?></td>
                        <td><?php echo get_user_meta($v,'hourlyRate',true); ?></td>
                        <td><?php echo get_user_meta($v,'minHours',true); ?></td>
                        <td><?php echo get_user_meta($v,'experience',true); ?></td>
                        <td><?php echo get_user_meta($v,'dob',true); ?></td>
                        <td>
                            <a class="custom-btn btn-darkBlue removeCrnt" href="javascript:void(0);" data-att-href="<?php echo admin_url(); ?>?page=photographers&action=active&id=<?php echo $v;?>"><i class="fa fa-check" aria-hidden="true"></i></a>
                            &nbsp;&nbsp;&nbsp;
                            <a class="custom-btn btn-blue" href="javascript:void(0);"  data-att-href="<?php echo admin_url(); ?>?page=photographers&action=inactive&id=<?php echo $v;?>"><i class="fa fa-times" aria-hidden="true"></i></a> &nbsp;&nbsp;&nbsp;
                            <a class="custom-btn btn-transparant" href="<?php echo site_url(); ?>/wp-admin/user-edit.php?user_id=<?php echo $v;?>&wp_http_referer=%2Fphotorabel%2Fwp-admin%2Fusers.php"><i class="fa fa-eye" aria-hidden="true"></i></a>
                        </td>
        </tr>        
                    <?php 
                    $counter++;}    
                } ?>
        
    </tbody>
</table>
    </div>
