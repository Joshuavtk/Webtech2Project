<?php

namespace NotSymfony\routing;

use NotSymfony\core\Request;
use NotSymfony\core\Route;

class HomeController extends Controller
{
    /**
     * @param $router
     */
    public function __construct($router)
    {
        parent::__construct($router);
    }

    public function home(Request $request)
    {
        // Database call
        $array = ["user1" => ["test1"], "user2" => ["test2"] ];

        $name = $request->getURLVariable('name') . " last name";

        $this->router->showView("testpage", ["name" => $name, "users" => $array]);
    }

    public function send(Request $request)
    {
        $test = $request->getPOSTValue("test");

        echo "<h1>Test page</h1>";
        echo $test;
    }
}