<?php

function getFbData() {
	require_once 'facebook.php';

	global $gConfig;

	$app_id = "yourappid";
	$app_secret = "yourappsecret";

	$facebook = new Facebook(array(
	        'appId'  => $gConfig['fb_id'],
	        'secret' => $gConfig['fb_secret'],
	        'cookie' => true
	));

	$user = $facebook->getUser();

  if ($user) {
    try {
      // Proceed knowing you have a logged in user who's authenticated.
      return $facebook->api('/me');
    } catch (FacebookApiException $e) {
      error_log($e);
      $user = null;
    }
  }
  else
  {
    header("Location:{$facebook->getLoginUrl(array('req_perms' => 'email'))}");
    exit;
  }
}

?>
