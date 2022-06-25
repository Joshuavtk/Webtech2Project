<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/../../vendor/autoload.php";

use NotSymfony\core\App;
use NotSymfony\routing\HomeController;

try {
    $app = new App();
    global $app;

    ob_start();


    $homeController = $app->router->addController(HomeController::class);


    $app->router->get('test', function () {
        return "Hallo world!";
    });
    $app->router->get('test/test2/test3/test4', function () {
        return "Hallo world 2!";
    });
    $app->router->get('', "home");

    $app->router->get('test', [HomeController::class, "home"]);
    $app->router->post('test', [HomeController::class, "send"]);


    $app->getOutput($_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"]);

    $data = ob_get_clean();
    echo $data;
} catch (Exception $error) {
    echo "Error in project: ";
    echo $error;
}

