<?php

namespace Controller;

use Model\User;
use Model\UserDB;
use Model\DBConnection;

class UserController
{

    public $userDB;

    public function __construct()
    {
        $connection = new DBConnection("mysql:host=localhost;dbname=to_do_list", "root", "");
        $this->userDB = new UserDB($connection->connect());
    }

    public static function send($status, $message, $data = null)
    {
        header("Content-Type: application/json");
        http_response_code($status);
        $json = json_encode(['status' => $status, 'message' => $message, 'data' => $data]);
        if (json_last_error() !== JSON_ERROR_NONE) {
            die('JSON Error: ' . json_last_error_msg());
        }
        echo $json;
        exit;
    }

    public function register($data)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            include 'view/register.php';
        } else {
            $username = $data["username"];
            $password = $data["password"];
            // $username = $_POST['username'];
            // $password = $_POST['password'];
            $user = new User($username, $password);
            $this->userDB->create($user);
            $message = 'User created';
            include 'view/register.php';
        }
    }
    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // $id = $_GET['id'];
            // $user = $this->userDB->get($id);
            include './view/login.php';
        }
        // include './view/login.php';
    }

    public function login($data)
    {
        session_start();
        // if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // $username = $_POST['username'] ?? '';
        // $password = $_POST['password'] ?? '';

        $username = $data["username"];
        $password = $data["password"];

        // var_dump($username);
        // var_dump($password);

        $user = $this->userDB->login($username, $password);
        // var_dump($user);

        if ($user) {

            $_SESSION['user'] = $user;
            // var_dump($_SESSION['user']);
            // header("Location: http://localhost/AHT_Nov/w3/to_do_list/list/");

            UserController::send(200, 'success', $user);
            exit;
            // var_dump($_SESSION['user']);
        } else {
            UserController::send(404, "No user found");
        }

        // header("Location: http://localhost/AHT_Nov/w3/to_do_list/list");
        // exit();
        require './view/login.php';
        // } else {
        //     require './view/login.php';
        // }
    }
}
