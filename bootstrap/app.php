<?php
ob_start();
session_start();

//set timezone
date_default_timezone_set('Europe/Kiev');

//database credentials

define('DBHOST','localhost');
define('DBUSER','dev');
define('DBPASS','ghbdtn');
define('DBNAME','webdev');

$db = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
