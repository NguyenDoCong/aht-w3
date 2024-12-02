<?php
require "model/DBConnection.php";
require "model/TaskDB.php";
require "model/Task.php";
require "controller/TaskController.php";
require "model/UserDB.php";
require "model/User.php";
require "controller/UserController.php";

use Controller\UserController;
use Controller\TaskController;

$method = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];
$scriptName = $_SERVER['SCRIPT_NAME'];

$basePath = dirname($scriptName);

$route = str_replace($basePath, '', $requestUri);
$route = strtok($route, '?');
$request = explode('/', trim($route, '/'));

if ($route === '/' || $route === '') {
    $request = [];
} else {
    $request = explode('/', trim($route, '/'));
}

// var_dump($basePath, $route, $request);
// exit;

$userController = new UserController();
$taskController = new TaskController();

// session_start();

if (empty($request)) {
    include 'View/login.php';
} elseif ($request[0] === 'login') {
    if ($method === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);

        // Kiểm tra dữ liệu nhận được
        if (is_null($data)) {
            echo "Invalid JSON data!";
            exit;
        }

        // var_dump($data);
        $userController->login($data);
    }
} elseif ($request[0] === 'register') {
    if ($method === 'GET') {
        $data = "";
    } elseif ($method === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);

        // Kiểm tra dữ liệu nhận được
        if (is_null($data)) {
            echo "Invalid JSON data!";
            exit;
        }

        // var_dump($data);
    }
    $userController->register($data);
} elseif ($request[0] === 'list') {
    if ($method === 'GET' && count($request) === 1) {
        // Trang danh sách tasks
        $taskController->index();
        // include 'View/list.php';
    } elseif ($method === 'GET' && isset($request[1]) && $request[1] === 'tasks') {
        // API lấy danh sách tasks
        $taskController->getAll();
    } elseif ($method === 'GET' && isset($request[1]) && $request[1] === 'add') {
        // include 'View/create.php';
        $taskController->create();
    } elseif ($method === 'POST' && isset($request[1]) && $request[1] === 'add') {
        $data = json_decode(file_get_contents('php://input'), true);
        $taskController->add($data);
    } elseif ($method === 'GET' && isset($request[1]) && $request[1] === 'edit') {
        if (isset($request[2])) { // Kiểm tra nếu có ID trong URL
            $id = $request[2]; // Lấy ID từ phần tử thứ 2 của request
            $taskController->edit(['id' => $id]);
        } else {
            header("HTTP/1.0 400 Bad Request");
            echo "ID is required for deletion.";
        }
    } elseif ($method === 'POST' && isset($request[1]) && $request[1] === 'edit') {
        $data = json_decode(file_get_contents('php://input'), true);
        $taskController->edit($data);
    } elseif ($method === 'GET' && isset($request[1]) && $request[1] === 'delete') {
        if (isset($request[2])) { // Kiểm tra nếu có ID trong URL
            $id = $request[2]; // Lấy ID từ phần tử thứ 2 của request
            $taskController->delete(['id' => $id]);
        } else {
            header("HTTP/1.0 400 Bad Request");
            echo "ID is required for deletion.";
        }
    } elseif ($method === 'POST' && isset($request[1]) && $request[1] === 'delete') {
        $data = json_decode(file_get_contents('php://input'), true);
        $taskController->delete($data);
    } elseif ($method === 'GET' && isset($request[1]) && $request[1] === 'search') {
        if (isset($request[2])) { // Kiểm tra nếu có ID trong URL
            $query = $request[2]; // Lấy ID từ phần tử thứ 2 của request
            $taskController->search(['query' => $query]);
        } else {
            header("HTTP/1.0 400 Bad Request");
            echo "ID is required for deletion.";
        }
    } elseif ($method === 'GET' && isset($request[1]) && $request[1] === 'filter') {
        if (isset($request[2])) { // Kiểm tra nếu có ID trong URL
            $priority = $request[2]; // Lấy ID từ phần tử thứ 2 của request
            $taskController->filter(['priority' => $priority]);
        } else {
            header("HTTP/1.0 400 Bad Request");
            echo "ID is required for deletion.";
        }
    } elseif ($method === 'POST' && isset($request[1]) && $request[1] === 'update') {
        $data = json_decode(file_get_contents('php://input'), true);
        $taskController->update($data);
    } else {
        header("HTTP/1.0 405 Method Not Allowed");
        echo "Method Not Allowed";
    }
} else {
    header("HTTP/1.0 404 Not Found");
    echo "Page Not Found";
}

?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">