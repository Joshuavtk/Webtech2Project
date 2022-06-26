<?php

namespace NotSymfony\routing;

use NotSymfony\core\App;
use NotSymfony\core\Request;
use NotSymfony\models\User;

class AuthenticationController extends Controller
{
    public function __construct(App $app)
    {
        parent::__construct($app);
    }

    public function registerView(Request $request)
    {
        $error = $request->getURLVariable("error");

        $this->router->showView("register", ["error" => $error]);
    }

    public function registerPost(Request $request)
    {
        $username = $request->getPOSTValue("username");
        $password = $request->getPOSTValue("password");
        $password_repeat = $request->getPOSTValue("password_repeat");
        $email = $request->getPOSTValue("email");

        if ($password !== $password_repeat) {
            header("Location: ./register?error=password_not_matching");
            exit();
        }

        $user = new User();
        $user->loadData([
            "username" => $username,
            "password" => $password,
            "password_repeat" => $password_repeat,
            "email" => $email
        ]);
        if ($user->validate() && $user->save()) {
            $_SESSION["logged_in_user"] = $user->id;
            header("Location: ./home");
        } else {
            header("Location: ./register?error=password_not_matching");
        }
        exit();
    }

    public function loginView(Request $request)
    {
        $error = $request->getURLVariable("error");

        $this->router->showView("login", ["error" => $error]);
    }

    public function loginPost(Request $request)
    {
        $email = $request->getPOSTValue("email");
        $password = $request->getPOSTValue("password");

        $user = User::login($email, $password);
        $_SESSION["logged_in_user"] = $user->id;

        header("Location: ./home");
        exit();
    }

    public function logoutPost()
    {
        unset($_SESSION["logged_in_user"]);
        session_destroy();
        header("Location: ./login");
        exit();
    }
}