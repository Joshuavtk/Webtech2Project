<?php

namespace NotSymfony;

class RequestHandler
{
//    public function __construct()
//    {
//    }

    public array $routes = [];

    public function addRoute(string $path, string $view = null, callable $executable = null)
    {
        $this->routes[$path] = ["name" => "test", "executable" => $executable, "view" => $view];
    }

    public function handleRequest(string $path, array $params = null)
    {

        $routeData = explode("?", $path);
        $path = $routeData[0];
        $path = explode("/", $path);
        if ($position = array_search("public", $path)) {
            $path = array_splice($path, $position + 1);
        }

        $path = implode("/", $path);

        if (key_exists($path, $this->routes)) {
            $route = $this->routes[$path];

            if (is_callable($route["executable"])) {
                return $route["executable"]();
            } elseif ($route["view"] !== null) {
                require_once "views/${route['view']}.php";
                init($params);

            }
        } else {
            require_once "views/error.php";
            init([]);
//            throw new \Exception("Route not found");
        }
    }
}