<?php
session_start();
require_once __DIR__ . "/../config/config.php";

class Auth {
    private $username, $password;

    function set_credentials($username, $password) {
        if (empty(trim($_POST["usernameInput"]))) {
            $this->send_error("Prisijungimo vardas yra būtinas!");
        } else {
            $this->username = $username;
        }

        if (empty(trim($_POST["passwordInput"]))) {
            $this->send_error("Slaptažodis yra būtinas!");
        } else {
            $this->password = $password;
        }
    }

    function login() {
        $query = DB::get()->prepare("SELECT * FROM users WHERE username=?");
        $query->execute([$this->username]);
        $user = $query->fetch();

        if ($user && password_verify($this->password, $user["password"])) {
            $_SESSION["logged_in"] = true;
            $_SESSION["uid"] = $user["id"];
            header("location: ../views/dashboard.php");
        } else {
            $this->send_error("Neteisingai įvesti duomenys!");
        }
    } 

    function send_error($message) {
        $_SESSION["error"] = $message;
        header("location: ../views/login.php");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $auth = new Auth();
    $auth->set_credentials($_POST["usernameInput"], $_POST["passwordInput"]);
    $auth->login();
} else {
    header("location: ../index.php");
}
?>