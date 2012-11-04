<?php
/*
 * Handles api requests
 * */

$provider = new provider();

$provider->checkrequest();

echo $_GET['query'];
?>