hi -- this is call back

<?php
@require_once './config.inc.php';

//print_r($_REQUEST);
if(isset($_REQUEST['request_token']) && isset($_REQUEST['verifier'])){
	if(isset($_POST['request_token'])){
		//echo "into inner if";
		try{
			$oauth_client = new OAuth(CLIENT_KEY,CLIENT_SECRET);
			$oauth_client->enableDebug();
			$oauth_client->setToken($_POST['request_token'],$_POST['request_token_secret']);
			$info = $oauth_client->getAccessToken("http://localhost/oauth/pages/oauthhandler.php?query=access_token",null,$_POST['verifier']);
			echo "<br/><br/>Fetching access token<br/><br/>";
			print_r($info);
		} catch(OAuthException $e){
			print_r($e);
		}
	} else {?>
	<form method="post" action="callback.php">
		<label>token</label>
		<input type="text" name="request_token" value="<?=$_REQUEST['request_token'];?>" /><br />
		<label>secret</label>
		<input type="text" name="request_token_secret" value="" />
		<label>verifier</label>
		<input type="text" name="verifier" value="<?=$_REQUEST['verifier']?>" />
		<input type="submit" value="GET Access token" name="submit">
	</form>	
	<?php
	}
}
?>