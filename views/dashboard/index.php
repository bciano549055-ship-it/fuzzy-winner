<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.php");
    exit();
}

require_once "../../controllers/task.php";
require_once "../../public/database.config.php";

$taskController = new TaskController(
    $SERVER_NAME,
    $USERNAME,
    $PASSWORD,
    $DB_NAME
);

$tasks = $taskController->getTasks(
    $_SESSION["user_id"]
);

require "../partial/header.php";

?>

<h1>Dashboard</h1>

<p>
    Welcome <?= $_SESSION["username"] ?>
</p>

<a href="../auth/logout.php">
Logout
</a>

<h2>Add Task</h2>

<form method="POST">

    <input
        type="text"
        name="title"
        placeholder="Task title"
        required
    >

    <textarea
        name="description"
        placeholder="Description"
    ></textarea>

    <button type="submit">
        Add
    </button>

</form>

<h2>Your Tasks</h2>

<?php while ($task = $tasks->fetch_assoc()): ?>

<div>

    <h3>
        <?= $task["title"] ?>
    </h3>

    <p>
        <?= $task["description"] ?>
    </p>

    <p>
        <?= $task["status"] ?>
    </p>

    <a href="#">Edit</a>
    <a href="#">Delete</a>
    <a href="#">Complete</a>

</div>

<?php endwhile; ?>

<?php require "../partial/footer.php"; ?>