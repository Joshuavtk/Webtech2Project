<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/../../vendor/autoload.php";

use NotSymfony\RequestHandler;

//require_once "startup.php";


//var_dump();
//var_dump($_SERVER);

$sf = $_SERVER["SCRIPT_FILENAME"];
echo $sf;
echo "<br>";
$ru = $_SERVER["REQUEST_URI"];
echo $ru;

$path = explode("/", $ru);
echo "<pre>";
echo var_dump($path);
echo "</pre>";


//ob_start();
//require('somefile.php');
//$data = ob_get_clean();

?>
