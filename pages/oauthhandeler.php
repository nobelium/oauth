<?php
function __autoload($class){
	@require_once __DIR__."/../class/class.".$class.".inc.php";
}
?>