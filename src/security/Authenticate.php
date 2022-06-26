<?php

namespace NotSymfony\security;

class Authenticate
{

    /**
     * @param $pw
     * @return string
     */
    public function hashPassword($pw): string
    {
        return password_hash($pw, PASSWORD_DEFAULT);
    }

    /**
     * @param $hash
     * @return void
     */
    public function saveHashInCookie($hash)
    {
        setcookie('password_hash', $hash, time() + 36000);
    }

    /**
     * @param $pw
     * @param $hash
     * @return bool
     */
    public function verifyPassword($pw, $hash): bool
    {
        return password_verify($pw, $hash);
    }

}