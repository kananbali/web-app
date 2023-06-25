<?php
 
//Include Google Client Library for PHP autoload file
require_once 'google/vendor/autoload.php';
 
//Make object of Google API Client for call Google API
$google_client = new Google_Client();
 
//Set the OAuth 2.0 Client ID
$google_client->setClientId("758670487371-5prrjqsqcptj7n4vea7rs5im9sr8bof1.apps.googleusercontent.com");
 
//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret("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");
 
//Set the OAuth 2.0 Redirect URI
// $google_client->setRedirectUri('http://ec2-65-2-11-171.ap-south-1.compute.amazonaws.com/login/dashboard.php');
$google_client->setRedirectUri('http://ec2-13-235-76-10.ap-south-1.compute.amazonaws.com/login/dashboard.php');
// $google_client->setRedirectUri('http://localhost:8888/login/dashboard.php');

 
//
$google_client->addScope('email');
 
$google_client->addScope('profile');
 
//start session on web page
session_start();
 
?>