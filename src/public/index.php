<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "vendor/autoload.php";

use Joshua\NotSymfony\RequestHandler;

require_once "startup.php";


vardump();
//var_dump($_SERVER);

echo $_SERVER["SCRIPT_FILENAME"];
echo "<br>";
echo $_SERVER["REQUEST_URI"];

//ob_start();
//require('somefile.php');
//$data = ob_get_clean();

?>
