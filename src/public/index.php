<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

require_once __DIR__ . "/../../vendor/autoload.php";

use NotSymfony\core\App;
use NotSymfony\core\Container;
use NotSymfony\core\DatabaseConnection;
use NotSymfony\core\Router;
use NotSymfony\models\User;
use NotSymfony\routing\AuthenticationController;
use NotSymfony\routing\HomeController;
use NotSymfony\security\Authorization;

try {
    $container = new Container();
    $authorization = new Authorization();
    $priv_default = $authorization->addPrivilegeLevel("default", 0);
    $priv_user = $authorization->addPrivilegeLevel("user", 1);
    $priv_admin = $authorization->addPrivilegeLevel("admin", 2);
    $router = new Router($authorization);

    // Default values
    $host = "127.0.0.1:3306";
    $username = "root";
    $password = "root";
    $dbName = "webtech2";

    // Overwrite default values with environment file
    include_once "../config/environment.php";

    $databaseConnection = new DatabaseConnection(
        $host,
        $username,
        $password,
        $dbName
    );

    $app = new App($router, $databaseConnection, $authorization);

    // Get user privilege level
    $loggedInUserPrivilegeLevel = $priv_default;
    if (isset($_SESSION["logged_in_user"])) {
        $user_id = $_SESSION["logged_in_user"];
        $user = User::findOne(['id' => $user_id]);
        if ($user) {
            $loggedInUserPrivilegeLevel = $priv_admin;
            $app->setUser($user);
        }
    }
    $app->setUserPrivilege($loggedInUserPrivilegeLevel);

    // Add router controllers
    $app->router->addController(HomeController::class, $app);
    $app->router->addController(AuthenticationController::class, $app);


    $app->router->get('', [HomeController::class, "redirect"]);

    $app->router->get('home', [HomeController::class, "home"], $priv_user);
    $app->router->get('coin', [HomeController::class, "getCoinData"], $priv_user);
    $app->router->post('coin', [HomeController::class, "coinTransaction"], $priv_user);

    // Authentication routes
    $app->router->get('register', [AuthenticationController::class, "registerView"]);
    $app->router->post('register', [AuthenticationController::class, "registerPost"]);
    $app->router->get('login', [AuthenticationController::class, "loginView"]);
    $app->router->post('login', [AuthenticationController::class, "loginPost"]);
    $app->router->post('logout', [AuthenticationController::class, "logoutPost"], $priv_user);


    $app->getOutput($_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"], $loggedInUserPrivilegeLevel);
} catch (Exception $error) {
    echo "Error in project: ";
    echo "<pre>";
    echo $error;
    echo "</pre>";
}