<?php
echo require '../wp-config.php';
$users=get_users();
$users=convert_array($users);
foreach($users as $k=>$v){
  echo $v['ID']. get_user_meta($v['ID'],'tokenfield',randomString(8)).' </br>';  
}
die;
pr($users);

?>