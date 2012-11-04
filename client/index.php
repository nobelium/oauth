<?php

@require_once 'config.inc.php';

$oauth_client = new Oauth(CLIENT_KEY,CLIENT_SECRET);
$oauth_client->enableDebug();


?>