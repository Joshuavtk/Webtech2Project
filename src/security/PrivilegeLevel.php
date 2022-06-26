<?php

namespace NotSymfony\security;

class PrivilegeLevel
{
    public function __construct(
        public string $name,
        public int $level
    ) {
    }

}