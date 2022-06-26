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
        $parent_layout = "base";
        ob_start();
        require_once sprintf("%s/../views/%s.php", __DIR__, $this->viewLocation);
        init($data, $url_params);
        $page_content = ob_get_clean();

        $engine = new TemplateEngine();

        $page = $engine->render($parent_layout);

        $page = str_replace("@yield('content')", $page_content, $page);

        echo $page;
    }
}