<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    echo "NO SESSION";
    exit();
}

echo "LOGGED IN";