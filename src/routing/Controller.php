<?php

namespace NotSymfony\routing;

use NotSymfony\core\App;
use NotSymfony\core\DatabaseConnection;
use NotSymfony\core\Router;
use NotSymfony\security\Authorization;

class Controller
{
    public App $app;
    public Router $router;
    public DatabaseConnection $db;
    public Authorization $authorization;

    public function __construct(App $app)
    {
        $this->app = $app;
        $this->router = $this->app->router;
        $this->db = $this->app->databaseConnection;
        $this->authorization = $this->app->authorization;
    }

}