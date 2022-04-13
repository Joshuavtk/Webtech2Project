<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/../../vendor/autoload.php";

use NotSymfony\RequestHandler;

//require_once "startup.php";

$requestHandler = new RequestHandler("shit");

echo $requestHandler->parseURL("test");

//var_dump();
//var_dump($_SERVER);

$sf = $_SERVER["SCRIPT_FILENAME"];
echo $sf;
echo "<br>";
$ru = $_SERVER["REQUEST_URI"];
echo $ru;

$path = explode("/", $ru);
$path2 = explode("/", $sf);
echo "<pre>";
var_dump($path);
var_dump($path2);
echo "</pre>";


//ob_start();
//require('somefile.php');
//$data = ob_get_clean();


