<?php



if(isset($_SESSION["user_id"])){

    header(
        "Location: ../dashboard/index.php"
    );

    exit();
}

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
        $accountController->login(
            $username,
            $password
        )
    ){

        header(
        "Location: ../dashboard/index.php"
        );

        exit();
    }

    else{
        $message=
        "Invalid username or password";
    }

}

require "../partial/header.php";

?>

<h1>Login</h1>

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
Login
</button>

</form>

<p><?= $message ?></p>

<a href="register.php">
No account?
Register here
</a>

<?php require "../partial/footer.php"; ?>