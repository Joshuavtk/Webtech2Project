<?php

namespace NotSymfony\core;

use Closure;
use NotSymfony\security\PrivilegeLevel;

class Route
{
    /**
     * @param string $name
     * @param Closure|null $executable
     * @param View|null $view
     * @param $method
     * @param PrivilegeLevel $privilegeLevel
     */
    public function __construct(
        public string $name,
        private Closure|null $executable,
        public View|null $view,
        public $method,
        public PrivilegeLevel $privilegeLevel
    ) {
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
     * @return Closure|null
     */
    public function execute(): ?Closure
    {
        return $this->executable;
    }

}