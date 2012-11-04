<?php
function __autoload($class){
	@require_once __DIR__."/../class/class.".$class.".inc.php";
}

if($_GET['query']=="request_token"){
	
} else if($_GET['query']=="access_token"){
	
} else if($_GET['query']=="new_consumer"){
	
}
?>