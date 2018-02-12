<?php
// Include FB config file && User class
require_once 'fbConfig.php';
require_once '../wp-config.php';
if(isset($accessToken)){
	if(isset($_SESSION['facebook_access_token'])){
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	}else{
		// Put short-lived access token in session
		$_SESSION['facebook_access_token'] = (string) $accessToken;
		
	  	// OAuth 2.0 client handler helps to manage access tokens
		$oAuth2Client = $fb->getOAuth2Client();
		
		// Exchanges a short-lived access token for a long-lived one
		$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
		$_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
		
		// Set default access token to be used in script
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	}
	
	// Redirect the user back to the same page if url has "code" parameter in query string
	if(isset($_GET['code'])){
		header('Location: ./');
	}
	
	// Getting user facebook profile info
	try {
		$profileRequest = $fb->get('/me?fields=name,first_name,last_name,email,link,gender,locale,picture');
		$fbUserProfile = $profileRequest->getGraphNode()->asArray();
	} catch(FacebookResponseException $e) {
		echo 'Graph returned an error: ' . $e->getMessage();
		session_destroy();
		// Redirect user back to app login page
		header("Location: ./");
		exit;
	} catch(FacebookSDKException $e) {
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}
    $fbUserData = array(
		'facebookId' 	=> $fbUserProfile['id'],
		'firstName' 	=> $fbUserProfile['first_name'],
		'lastName' 	=> $fbUserProfile['last_name'],
		'email' 		=> $fbUserProfile['email'],
		'gender' 		=> $fbUserProfile['gender'],
		'profileImage' 	=> $fbUserProfile['picture']['url'],
        'userType'=>$_SESSION['userType'],
        'deviceToken'=>'',
        'deviceType'=>''
	);
    $response=loginWithFacebook($fbUserData,'web');  
    $_SESSION['adminApproval']='';
    $_SESSION['msg']='';
    if(empty($response['success'])){
        $_SESSION['loginResponse']=$response;
        if(isset($response['check']) and !empty($response['check'])){
          $_SESSION['adminApproval']='1';  
          $_SESSION['msg']=$response['error'];  
        }
        header('location:'.get_site_url());
    }
}else{
	$loginURL = $helper->getLoginUrl($redirectURL, $fbPermissions);
	header('location:'.$loginURL);	
}
?>