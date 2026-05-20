<?php

require_once __DIR__ . '/../public/database.config.php';

class AccountController {

    private $conn;

    function __construct(
        $server_name,
        $username,
        $password,
        $db_name
    ){
        $this->conn = new mysqli(
            $server_name,
            $username,
            $password,
            $db_name
        );
    }

    function register($username,$password){

        $hashedPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $query = "INSERT INTO accounts
                  (username,password)
                  VALUES (?,?)";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param(
            "ss",
            $username,
            $hashedPassword
        );

        return $stmt->execute();
    }

    function login($username,$password){

        $query = "SELECT *
                  FROM accounts
                  WHERE username=?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param(
            "s",
            $username
        );

        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows > 0){

            $user = $result->fetch_assoc();

            if(password_verify(
                $password,
                $user["password"]
            )){

                $_SESSION["user_id"] =
                $user["id"];

                $_SESSION["username"] =
                $user["username"];

                return true;
            }
        }

        return false;
    }

}
?>