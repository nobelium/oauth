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


<?php
	if($_GET['page']=="oauth"){
		require_once './pages/oauthhandler.php';
	} else if($_GET['page']=="api"){
		require_once './pages/apihandler.php';
	} else if($_GET['page']=="login"){
		require_once './pages/login.php';
	}
?>		


	
<?php
	//print_r($_GET);
?>	
