<?php
echo 'crnt time '. date('Y-m-d h:i:s A');
$endTimeCustom=strtotime(date('Y-m-d h:i:s'));
$getDate=date("Y-m-d h:i A", strtotime("+120 minutes",$endTimeCustom));
echo 'final time '. $getDate;
die('working');
?>