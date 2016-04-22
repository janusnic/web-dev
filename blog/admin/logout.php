<?php
//include config
require_once __DIR__.'/../bootstrap/app.php';

//log user out
$user->logout();
header('Location: /index.php'); 

?>