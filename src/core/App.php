<?php


namespace NotSymfony\core;

/**
 *
 */
class App
{
    public Router $router;

//    public string $

    public function __construct()
    {
        $this->router = new Router();
    }

    /**
     * @param $request
     * @return void
     */
    public function getOutput($request, string $method)
    {
        $this->router->handleRequest($request, $method);
    }
}