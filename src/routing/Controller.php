<?php

namespace NotSymfony\routing;

use NotSymfony\core\Router;

class Controller
{
    public Router $router;

    /**
     * @param $router
     */
    public function __construct($router)
    {
        $this->router = $router;
    }
}