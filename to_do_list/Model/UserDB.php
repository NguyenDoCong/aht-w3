<?php

namespace Model;

use PDO;

class UserDB
{
    public $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function create($user)
    {
        $sql = "INSERT INTO `user`(`id`, `username`, `password`) VALUES (NULL,?, ?)";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(1, $user->username);
        $statement->bindParam(2, $user->password);
        return $statement->execute();
    }

    public function get($id)
    {
        $sql = "SELECT * FROM user WHERE id = ?";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(1, $id);
        $statement->execute();
        $row = $statement->fetch();
        $user = new user($row['username'], $row['password']);
        $user->id = $row['id'];
        return $user;
    }

    public function login($username, $password)
    {
        // echo $username . $password;
        // $username = "a";
        // $password = "a";
        $query = "SELECT * FROM user WHERE username = :username LIMIT 1";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $password == $user['password']) {
            return $user;
        }

        return false;
    }
}
