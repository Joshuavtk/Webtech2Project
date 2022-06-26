<?php

namespace NotSymfony\core;

use Closure;
use Exception;
use NotSymfony\security\Authorization;
use NotSymfony\security\PrivilegeLevel;

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
    private array $controllers = [];
    public Request $request;


    public function __construct(public Authorization $authorization)
    {
    }

    /**
     * @param string $path
     * @param $routeHandler
     * @param string $method
     * @param string $name
     * @return Route
     * @throws Exception
     */
    public function addRoute(
        string $path,
        $routeHandler,
        string $method = self::METHODS['GET'],
        $privilegeLevel = null,
        string $name = ""
    ): Route {
        $executable = null;
        $view = null;

        if ($routeHandler instanceof Closure) {
            $executable = $routeHandler;
        } elseif (is_string($routeHandler)) {
            $view = new View($routeHandler);
        } elseif (is_array($routeHandler)) {
            $controller = $this->controllers[$routeHandler[0]];
            $function = $routeHandler[1];
            $executable = $controller->$function(...);
        } else {
            throw new Exception("Added route is not supported");
        }

        if ($privilegeLevel === null) {
            $privilegeLevel = $this->authorization->getDefaultLevel();
        }

        $route = new Route($name, $executable, $view, $method, $privilegeLevel);

        $this->routes[$method][$path] = $route;

        return $route;
    }

    /**
     * @param $controller
     * @param App $app
     * @return mixed
     */
    public function addController($controller, App $app): mixed
    {
        $created_controller = new $controller($app);
        $this->controllers[$controller] = $created_controller;
        return $created_controller;
    }

    public function showView(string $view, array $data = [])
    {
        $view = new View($view);
        $view->showView(["url_params" => $this->request->URLVariables, "data" => $data]);
    }

    /**
     * @param string $route
     * @param $routeHandler
     * @param null $authorizationLevel
     * @param string $name
     * @return Route
     * @throws Exception
     */
    public function get(
        string $route,
        $routeHandler,
        $authorizationLevel = null,
        string $name = ""
    ): Route {
        return self::addRoute($route, $routeHandler, self::METHODS["GET"], $authorizationLevel, $name);
    }


    /**
     * @param $route
     * @param $routeHandler
     * @param null $authorizationLevel
     * @param string $name
     * @return Route
     * @throws Exception
     */
    public function post($route, $routeHandler, $authorizationLevel = null, string $name = ""): Route
    {
        return self::addRoute($route, $routeHandler, self::METHODS["POST"], $authorizationLevel, $name);
    }


    /**
     * @param string $full_url
     * @param string $method
     * @param PrivilegeLevel $loggedInUserPrivilegeLevel
     * @return void
     */
    public function handleRequest(string $full_url, string $method, PrivilegeLevel $loggedInUserPrivilegeLevel)
    {
        $this->request = new Request($full_url);

        $path = $this->request->getPath();

        if (key_exists($path, $this->routes[$method])) {
            /** @var Route $route */
            $route = $this->routes[$method][$path];

            $userPrivilegeLevel = $this->authorization->getPrivilegeLevel($loggedInUserPrivilegeLevel->name);

            if ($this->authorization->checkIfAllowed($userPrivilegeLevel, $route->privilegeLevel)) {
                if ($route->isExecutable()) {
                    // Turn into Closure executable and then execute
                    echo $route->execute()(...)($this->request);
                } else {
                    $route->view->showView($this->request->URLVariables);
                }
            } else {
                $this->show404($path);
            }
        } else {
            $this->show404($path);
        }
    }

    /**
     * @param $path
     * @return void
     */
    public function show404($path)
    {
        $view = new View("404");
        $view->showView(["url_params" => ["path" => $path]]);
    }
}