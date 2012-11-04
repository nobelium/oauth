<?php
/*
 * Index file for oauth 
 * 
 * routes request to apihandler and oauthhandler
 * 
 * */
 
function __autoload($classname){
	if(file_exists("./class/class.".$classname.".inc.php")){
		require_once "./class/class.".$classname.".inc.php";
	}
}

$provider = new provider();
?>
<html>
	<head><title>Oauth provider</title></head>
	<body>
		<div id="contents">
<?php
	if($_GET['page']=="oauth"){
		require_once './pages/oauthhandler.php';
	} else if($_GET['page']=="login"){
		require_once './pages/apihandler.php';
	}
?>			
		</div>		
		<div id="test">
<?php
	print_r($_GET);
?>	
		</div>
	</body>
</html>
