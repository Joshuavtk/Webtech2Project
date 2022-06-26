<?php


namespace NotSymfony\core;

use NotSymfony\models\User;
use NotSymfony\security\Authorization;
use NotSymfony\security\PrivilegeLevel;

/**
 *
 */
class App
{
    public static App $app;
    public PrivilegeLevel $userPrivilegeLevel;
    public User $user;

    public function __construct(
        public Router $router,
        public DatabaseConnection $databaseConnection,
        public Authorization $authorization,
    ) {
        self::$app = $this;
    }

    /**
     * @param $loggedInUserPrivilegeLevel
     * @return void
     */
    public function setUserPrivilege($loggedInUserPrivilegeLevel)
    {
        $this->userPrivilegeLevel = $loggedInUserPrivilegeLevel;
    }

    /**
     * @param $user
     * @return void
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @param $request
     * @param string $method
     * @param $loggedInUserPrivilegeLevel
     * @return void
     */
    public function getOutput($request, string $method, $loggedInUserPrivilegeLevel)
    {
        $this->router->handleRequest($request, $method, $loggedInUserPrivilegeLevel);
    }
}