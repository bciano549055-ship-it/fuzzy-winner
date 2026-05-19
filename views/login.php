<?php

session_start();

require_once "../controllers/account.php";
require_once "../public/database.config.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $accountController = new AccountController(
        $SERVER_NAME,
        $USERNAME,
        $PASSWORD,
        $DB_NAME
    );

    $user = $accountController->login(
        $username,
        $password
    );

    if ($user) {

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];

        header("Location: dashboard/index.php");
        exit();

    } else {

        $error = "Invalid username or password";
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>

<h1>Login</h1>

<?php if (!empty($error)): ?>
    <p><?= $error ?></p>
<?php endif; ?>

<form method="POST">

    <input
        type="text"
        name="username"
        placeholder="Username"
        required
    >

    <br><br>

    <input
        type="password"
        name="password"
        placeholder="Password"
        required
    >

    <br><br>

    <button type="submit">
        Login
    </button>

</form>

<p>
    No account?
    <a href="register.php">
        Register
    </a>
</p>

</body>

</html>