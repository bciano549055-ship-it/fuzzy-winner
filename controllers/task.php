<?php

require_once __DIR__ . '/../public/database.config.php';

class TaskController {

    private $conn;

    function __construct(
        $server_name,
        $username,
        $password,
        $db_name
    ){

        $this->conn=new mysqli(
            $server_name,
            $username,
            $password,
            $db_name
        );
    }

    function addTask(
        $user_id,
        $title,
        $description
    ){

        $query="
        INSERT INTO tasks
        (user_id,title,description)
        VALUES (?,?,?)
        ";

        $stmt=$this->conn
        ->prepare($query);

        $stmt->bind_param(
            "iss",
            $user_id,
            $title,
            $description
        );

        return $stmt->execute();
    }

    function getTasks($user_id){

        $query="
        SELECT *
        FROM tasks
        WHERE user_id=?
        ";

        $stmt=$this->conn
        ->prepare($query);

        $stmt->bind_param(
            "i",
            $user_id
        );

        $stmt->execute();

        return $stmt->get_result();
    }

    function updateTask(
        $id,
        $title,
        $description
    ){

        $query="
        UPDATE tasks
        SET title=?,
        description=?
        WHERE id=?
        ";

        $stmt=$this->conn
        ->prepare($query);

        $stmt->bind_param(
            "ssi",
            $title,
            $description,
            $id
        );

        return $stmt->execute();
    }

    function deleteTask($id){

        $query="
        DELETE FROM tasks
        WHERE id=?
        ";

        $stmt=$this->conn
        ->prepare($query);

        $stmt->bind_param(
            "i",
            $id
        );

        return $stmt->execute();
    }

    function completeTask($id){

        $query="
        UPDATE tasks
        SET status='Completed'
        WHERE id=?
        ";

        $stmt=$this->conn
        ->prepare($query);

        $stmt->bind_param(
            "i",
            $id
        );

        return $stmt->execute();
    }

}