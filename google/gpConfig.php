<?php
session_start();
require '../wp-config.php';
//Include Google client library 
include_once 'src/Google_Client.php';
include_once 'src/contrib/Google_Oauth2Service.php';

/*
 * Configuration and setup Google API
 */
$clientId = '590872927532-lh463lr6t3v830i2fe9dp8dm37gk19nd.apps.googleusercontent.com'; //Google client ID
$clientSecret = 'k7f69fDFkG18IEKVwzPAgmKC'; //Google client secret
$redirectURL = get_site_url().'/google/index.php'; //Callback URL

//Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('PhotoRabel');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectURL);
$google_oauthV2 = new Google_Oauth2Service($gClient);
?>