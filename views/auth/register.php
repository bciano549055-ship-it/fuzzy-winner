<?php

session_start();

require_once "../../controllers/account.php";
require_once "../../public/database.config.php";

$message="";

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $username=$_POST["username"];
    $password=$_POST["password"];

    $accountController=
    new AccountController(
        $SERVER_NAME,
        $USERNAME,
        $PASSWORD,
        $DB_NAME
    );

    if(
        $accountController->register(
            $username,
            $password
        )
    ){
        $message="Registration successful!";
    }
    else{
        $message="Registration failed";
    }
}

require "../partial/header.php";

?>

<h1>Register</h1>

<form method="POST">

    <input
    type="text"
    name="username"
    placeholder="Username"
    required>

    <input
    type="password"
    name="password"
    placeholder="Password"
    required>

    <button type="submit">
    Register
    </button>

</form>

<p><?= $message ?></p>

<a href="login.php">
Already have an account?
Login here
</a>

<?php require "../partial/footer.php"; ?>