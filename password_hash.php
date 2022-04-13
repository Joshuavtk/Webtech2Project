<?php
session_start();

require_once 'vendor/autoload.php';

?>

    <form method="get" target="_self">
        <label>
            Wachtwoord:
            <input type="password" name="password">
        </label>
        <button type="submit" name="submit">
            Verzend
        </button>
    </form>



    <pre>
<?php

//unset($_SESSION['password_hash']);

//var_dump($_GET);
//var_dump($_POST);

var_dump($_SESSION);

if (isset($_GET['submit'])) {

    $pw = $_GET['password'];



    if (isset($_SESSION['password_hash'])) {
        $hash = $_SESSION['password_hash'];
        $correct = password_verify($pw, $hash);
        $logger->info('password_enter_check', [
            'password' => $pw,
            'password_hash' => $hash,
            'correct' => $correct
        ]);
    } else {
        $hash = password_hash($pw, PASSWORD_DEFAULT);
//        setcookie('password_hash', $hash, time() + 36000);
        $_SESSION['password_hash'] = $hash;
        $logger->info('password_enter_new_hash', [
            'password' => $pw,
            'password_hash' => $hash
        ]);
    }


}
