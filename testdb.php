<?php

require_once "public/database.config.php";

$conn = new mysqli(
    $SERVER_NAME,
    $USERNAME,
    $PASSWORD,
    $DB_NAME
);

if($conn->connect_error){
    die("Connection failed");
}

echo "Database connected successfully";

?>