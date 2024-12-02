<?php

namespace Controller;

use Model\Task;
use Model\TaskDB;
use Model\DBConnection;

class TaskController
{

    public $TaskDB;

    public function __construct()
    {
        $connection = new DBConnection("mysql:host=localhost;dbname=to_do_list", "root", "");
        $this->TaskDB = new TaskDB($connection->connect());
    }

    public static function send($status, $message, $data = null)
    {
        header("Content-Type: application/json");
        http_response_code($status);
        echo json_encode([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
        exit;
    }

    public function create()
    {
        include 'View/create.php';
    }

    public function add($data)
    {
        session_start();
        $title = $data['title'];
        $status = $data['status'];
        // $status = isset($data['status']) ? 1 : 0;
        $content = $data['content'];
        $userID = $_SESSION['user']['id'];
        $priority = $data['priority'] ?? 'low';

        $task = new Task($title, $status, $content, $userID, $priority);
        $this->TaskDB->create($task);
        $message = 'task created';
        // header("Location: index.php?page=todos");
    }

    public function getAll()
    {
        session_start();

        $userID = $_SESSION['user']['id'];
        // var_dump($userID);

        if ($userID) {
            $tasks = $this->TaskDB->getUID($userID);

            if ($tasks) {
                TaskController::send(200, 'success', $tasks);
                exit(); // Đảm bảo dừng thực thi sau khi gửi JSON
            } else {
                TaskController::send(404, "No tasks found");
                exit();
            }
        } else {
            TaskController::send(403, "Unauthorized");
            exit();
        }
    }

    public function search($data)
    {
        session_start();

        $userID = $_SESSION['user']['id'];
        // var_dump($userID);

        if ($userID) {
            // $tasks = $this->TaskDB->getUID($userID);
            if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($data['query'])) {
                $query = $data['query'];
                // var_dump($query);
                $tasks = $this->TaskDB->find($query, $userID);
            }
            if ($tasks) {
                TaskController::send(200, 'success', $tasks);
                exit(); // Đảm bảo dừng thực thi sau khi gửi JSON
            } else {
                TaskController::send(404, "No tasks found");
                exit();
            }
        } else {
            TaskController::send(403, "Unauthorized");
            exit();
        }
    }

    public function filter($data)
    {

        // var_dump($userID);

        // if ($userID) {
        // $tasks = $this->TaskDB->getUID($userID);
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($data['priority'])) {

            // if (isset($_GET['Low'])) {
            //     $tasks = $this->TaskDB->filter("low");
            // }
            // if (isset($_GET['Medium'])) {
            //     $tasks = $this->TaskDB->filter("medium");
            // }
            // if (isset($_GET['High'])) {
            //     $tasks = $this->TaskDB->filter("high");
            // }
            // if (isset($_GET['All'])) {
            //     $tasks = $this->TaskDB->getUID($userID);
            // }
            $priority = $data['priority'];
            // var_dump($query);
            if ($priority == "All") {
                $tasks = $this->getAll();
            } else {
                session_start();

                $userID = $_SESSION['user']['id'];
                $tasks = $this->TaskDB->filter($priority, $userID);
            }
        }
        if ($tasks) {
            TaskController::send(200, 'success', $tasks);
            exit(); // Đảm bảo dừng thực thi sau khi gửi JSON
        } else {
            TaskController::send(404, "No tasks found");
            exit();
        }
        // } else {
        //     TaskController::send(403, "Unauthorized");
        //     exit();
        // }
    }


    public function index()
    {
        session_start();
        // if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
        //     // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
        //     header("Location: http://localhost/AHT_Nov/w3/to_do_list/");
        //     exit();
        // }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            $userID = $_SESSION['user']['id'] ?? null;
            // var_dump($userID);
        }

        include 'view/list.php';
    }

    public function update($data)
    {
        session_start();

        $userID = $_SESSION['user']['id'];
        // var_dump($userID);

        $tasks = $this->TaskDB->getUID($userID);

        // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // $checkedTaskIds = $_POST['completed'] ?? [];
        // foreach ($checkedTaskIds as $taskId) {
        //     echo "Task ID checked: " . htmlspecialchars($taskId) . "<br>";
        // }
        // $taskIds = ["2", "11", "22"];
        $check = TRUE;
        if (isset($data['taskIds']) && is_array($data['taskIds'])) {
            // $taskIds = array_map('intval', $data['taskIds']);
            $taskIds = $data['taskIds'];
        } else {
            TaskController::send(404, "Invalid taskIds");
            exit();
        }
        error_log(print_r($taskIds, true));
        foreach ($tasks as $task) {
            $newStatus = in_array((string) $task->id, $taskIds) ? 1 : 0;
            // $newStatus = 0;

            if (! $this->TaskDB->updateStatus($task->id, $newStatus)) {
                $check = FALSE;
            }
            // header("Location: index.php?page=todos");
        }
        $tasks = $this->TaskDB->getUID($userID);
        if ($check) {
            TaskController::send(200, 'success', $tasks);
            exit(); // Đảm bảo dừng thực thi sau khi gửi JSON
        } else {
            TaskController::send(404, "No tasks found");
            exit();
        }
        // }
    }

    public function delete($data)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // $title = $data['title'];
            $id = $data['id'];
            print_r($id);
            $task = $this->TaskDB->get($id);
            include 'view/delete.php';
        } else {
            $id = $_GET['id'];
            print_r($id);
            $this->TaskDB->delete($id);
            // header("Location: index.php?page=todos");
        }
    }
    public function edit($data)
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = $data['id'];
            $task = $this->TaskDB->get($id);
            include 'view/edit.php';
        } else {
            // echo '<pre>';
            // print_r($_POST); 
            // echo '</pre>';
            // die();
            $id = $data['id'];
            // print_r($id);
            $title = $data['title'];
            $status = $data['status'];
            // $status = isset($_POST['status']) ? 1 : 0;
            $content = $data['content'];
            $userID = $_SESSION['user']['id'];
            $priority = $data['priority'] ?? 'low';
            // print_r($priority);

            $task = new Task($title, $status, $content, $userID, $priority);
            // $task = new task($_POST['title'], $_POST['status'], $_POST['content'], $_POST['user_id']);
            $this->TaskDB->update($id, $task);
            // header("Location: index.php?page=todos");
            // exit();
        }
    }
}
