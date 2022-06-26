<?php

namespace NotSymfony\security;

class Authorization
{
    private array $privilegeLevels = [];

    public function addPrivilegeLevel(string $privilegeName, int $privilegeLevel): PrivilegeLevel
    {
        $this->privilegeLevels[$privilegeName] = new PrivilegeLevel(
            $privilegeName, $privilegeLevel
        );

        return $this->privilegeLevels[$privilegeName];
    }

    /**
     * @param string $privilegeName
     * @return mixed
     */
    public function getPrivilegeLevel(string $privilegeName): PrivilegeLevel
    {
        return $this->privilegeLevels[$privilegeName] ?? $this->getDefaultLevel();
    }

    public function getDefaultLevel(): PrivilegeLevel
    {
        return $this->privilegeLevels["default"];
    }

    public function checkIfAllowed(PrivilegeLevel $toBeCheckedLevel, PrivilegeLevel $barrierLevel): bool
    {
        return $toBeCheckedLevel->level >= $barrierLevel->level;
    }

}