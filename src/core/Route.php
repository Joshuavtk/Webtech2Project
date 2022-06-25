<?php

namespace NotSymfony\core;

class Route
{
    private string $name;
    private \Closure|null $executable;
    public View|null $view;
    private $method;

    /**
     * @param string $name
     * @param \Closure|null $executable
     * @param View|null $view
     * @param $method
     */
    public function __construct(string $name, \Closure|null $executable, View|null $view, $method)
    {
        $this->name = $name;
        $this->executable = $executable;
        $this->view = $view;
        $this->method = $method;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function isExecutable(): bool
    {
        return $this->executable !== null;
    }

    /**
     * @return \Closure|null
     */
    public function execute(): ?\Closure
    {
        return $this->executable;
    }

}