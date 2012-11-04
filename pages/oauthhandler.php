<?php
/*function __autoload($class){
	@require_once __DIR__."/../class/class.".$class.".inc.php";
}*/

$provider = new provider();

if($_GET['query']=="request_token"){
	$provider->setrequesttokenquery();
	$provider->checkrequest();
	echo $provider->generaterequesttoken();
} else if($_GET['query']=="access_token"){
	$provider->checkrequest();
	echo $provider->generateaccesstoken();
} else if($_GET['query']=="new_consumer"){
	$consumer = provider::createconsumer();
	echo "<div id='new'><h4>consumer key:".$consumer->getkey()."</h4>";
	echo "<br/><h4>consumer secret:".$consumer->getsecret()."</h4></div>";
}
?>