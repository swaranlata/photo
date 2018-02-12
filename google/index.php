<?php
//Include GP config file && User class
require '../wp-config.php';
include_once 'gpConfig.php';
if(isset($_GET['code'])){
	$gClient->authenticate($_GET['code']);
	$_SESSION['token'] = $gClient->getAccessToken();
	header('Location: ' . filter_var($redirectURL, FILTER_SANITIZE_URL));
}
if (isset($_SESSION['token'])) {
	$gClient->setAccessToken($_SESSION['token']);
}
if ($gClient->getAccessToken()) {
	$gpUserProfile = $google_oauthV2->userinfo->get();
    $gpUserData = array(
        'googleId'     => $gpUserProfile['id'],
        'firstName'    => $gpUserProfile['given_name'],
        'lastName'     => $gpUserProfile['family_name'],
        'email'         => $gpUserProfile['email'],
        'gender'        => $gpUserProfile['gender'],
        'picture'       => $gpUserProfile['picture'],
        'userType'=> $_SESSION['userType'],
        'deviceToken'=>'',
        'deviceType'=>''
    );
    $_SESSION['adminApproval']='';
    $_SESSION['msg']='';
    $response=loginWithGoogle($gpUserData,'web');
    if(empty($response['success'])){
        $_SESSION['loginResponse']=$response;
        if(isset($response['check']) and !empty($response['check'])){
          $_SESSION['adminApproval']='1';  
          $_SESSION['msg']=$response['error'];  
        }
        header('location:'.get_site_url());
    }
} else {
	$authUrl = $gClient->createAuthUrl();
    $loginUrl=filter_var($authUrl, FILTER_SANITIZE_URL);
	header('location:'.$loginUrl);
}
?>