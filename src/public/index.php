<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/../../vendor/autoload.php";

use NotSymfony\RequestHandler;

//require_once "startup.php";

$path = $_SERVER["REQUEST_URI"];

$requestHandler = new RequestHandler();

$requestHandler->addRoute("test", null, function () { return "Hallo world!";});
$requestHandler->addRoute("test2", "home");

ob_start();
//echo $requestHandler->handleRequest("test");
echo $requestHandler->handleRequest($path, ["name" => "World"]);


//echo "</pre>";


//require('somefile.php');

$data = ob_get_clean();
echo $data;
