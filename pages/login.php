<?php
/*
 * Handles user login
 * */
 
if(isset($_GET['token'])){
	$request_token = token::findbytoken($_GET['request_token']);
	if(is_object($request_token) && $request_token->isrequest()){
		if(!isset($_POST['login'])){
			//echo form
			?>
			<div id="login_form">
				<form method="post">
					<label for="user_name">User Name:</label>
					<input type="text" name="user_name" /><br/>
					<label for="password">Password:</label>
					<input type="password" name="password"/><br/>
					<input type="submit" name="login"/>
				</form>
			</div>
			<?php
		} else {
			//process form and redirect to callback url
		}
	} else {
		echo "No such request token found in db";
	}
} else {
	echo "Oauth token not found";
}
?>