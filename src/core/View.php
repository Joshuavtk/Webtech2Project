<?php

namespace NotSymfony\core;

class View
{
    public string $viewLocation;

    public function __construct(string $viewLocation)
    {
        $this->viewLocation = $viewLocation;
    }

    /**
     * @param $params
     * @return void
     */
    public function showView($params)
    {
        $data = $params["data"] ?? [];
        $url_params = $params["url_params"] ?? [];
        require_once sprintf("%s/../views/%s.php", __DIR__, $this->viewLocation);
        init($data, $url_params);
    }
}