<?php

@require_once 'config.inc.php';

$oauth_client = new Oauth(CLIENT_KEY,CLIENT_SECRET);
$oauth_client->enableDebug();

echo "created oauth_client object";

try{
	$info =  $oauth_client->getRequestToken("http://localhost/oauth/pages/oauthhandler.php?query=request_token&oauth_callback=http://localhost/oauth/client/callback.php");
	print_r($info);
	echo "<br/><br/><br/><br/>";
	
	
	echo "Request token has been obtained";
	echo "Request token:".$info['oauth_token'];
	echo "Request token secret:".$info['oauth_token_secret'];
	echo "visit <a href='".$info['auth_url']."&request_token=".$info['request_token']."'>this page</a> to authenticate";
} catch(OAuthException $e){
	print_r($e);
}
?>