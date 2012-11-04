<?php

@require_once './config.inc.php';

if(isset($_POST['token'])){
	try {
		$oauth_client = new OAuth(CLIENT_KEY,CLIENT_SECRET);
		$oauth_client->enableDebug();
		$oauth_client->setToken($_POST['token'],$_POST['token_secret']);
		$info = $oauth_client->fetch("http://localhost/oauth/pages/apihandler.php");
		echo "API RESULT : ".print_r($info);
	} catch (OAuthException $e){
		print_r($e);
	}
} else {?>
	<form method="post">
		Access token : <input type="text" name="token" value="<?php echo $_REQUEST['token'];?>" /> <br />
		Access token secret : <input type="text" name="token_secret" value="<?php echo $_REQUEST['token_secret'];?>" /> <br />
		<input type="submit" value="do An api call" />
	</form>
<?php
}
?>