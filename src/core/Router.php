<?php

namespace NotSymfony\core;

use Closure;
use Exception;

/**
 * Handles all routing business
 *
 * @package NotSymfony\core
 * @property
 */
class Router
{
    public const METHODS = ["GET" => "GET", "POST" => "POST"];

    private array $routes = ["GET" => [], "POST" => [], "PUT" => []];
    public Request $request;


    /**
     * @param string $path
     * @param $routeHandler
     * @param string $method
     * @return Route
     * @throws Exception
     */
    public function addRoute(string $path, $routeHandler, string $method = self::METHODS['GET'], string $name = ""): Route
    {
        $executable = null;
        $view = null;

        if ($routeHandler instanceof Closure) {
            $executable = $routeHandler;
        } elseif (is_string($routeHandler)) {
            $view = new View($routeHandler);
        } elseif (is_array($routeHandler)) {
            $controller = $this->addController($routeHandler[0]);
            $function = $routeHandler[1];
            $executable = $controller->$function(...);
        } else {
            throw new Exception("Added route is not supported");
        }

        $route = new Route($name, $executable, $view, $method);

        $this->routes[$method][$path] = $route;

        return $route;
    }

    /**
     * @param $controller
     * @return mixed
     */
    public function addController($controller): mixed
    {
        return new $controller($this);
    }

    public function showView(string $view, array $data = [])
    {
        $view = new View($view);
        $view->showView(["url_params" => $this->request->URLVariables, "data" => $data]);
    }

    /**
     * @param string $route
     * @param $routeHandler
     * @return Route
     * @throws Exception
     */
    public function get(string $route, $routeHandler, string $name = ""): Route
    {
        return self::addRoute($route, $routeHandler, self::METHODS["GET"], $name);
    }


    /**
     * @param $route
     * @param $routeHandler
     * @return Route
     * @throws Exception
     */
    public function post($route, $routeHandler, string $name = ""): Route
    {
        return self::addRoute($route, $routeHandler, self::METHODS["POST"], $name);
    }


    /**
     * @param string $full_url
     * @param string $method
     * @return void
     */
    public function handleRequest(string $full_url, string $method)
    {
        $this->request = new Request($full_url);

        $path = $this->request->getPath();

        if (key_exists($path, $this->routes[$method])) {
            /** @var Route $route */
            $route = $this->routes[$method][$path];

            if ($route->isExecutable()) {
                // Turn into Closure executable and then execute
                echo $route->execute()(...)($this->request);
            } else {
                $route->view->showView($this->request->URLVariables);
            }
        } else {
            // 404 Page not found.
            $view = new View("404");
            $view->showView(["url_params" => ["path" => $path]]);
        }
    }
}