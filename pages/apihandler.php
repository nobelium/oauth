<?php
/*
 * Handles api requests
 * */

function __autoload($classname){
	if(file_exists("../class/class.".$classname.".inc.php")){
		require_once "../class/class.".$classname.".inc.php";
	}
}

//print_r($expression)
$provider = new provider();

$provider->checkrequest();

//echo $provider->getuser()->getid();
?>