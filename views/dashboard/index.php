<?php

session_start();

if(!isset($_SESSION["user_id"])){

    header(
        "Location: ../auth/login.php"
    );

    exit();
}

require_once "../../controllers/task.php";
require_once "../../public/database.config.php";

$taskController =
new TaskController(
    $SERVER_NAME,
    $USERNAME,
    $PASSWORD,
    $DB_NAME
);


/* ADD TASK */

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $title=$_POST["title"];
    $description=$_POST["description"];

    $taskController->addTask(
        $_SESSION["user_id"],
        $title,
        $description
    );

    header("Location: index.php");
    exit();
}

/* DELETE */

if(isset($_GET["delete"])){

    $taskController
    ->deleteTask(
        $_GET["delete"]
    );

    header(
        "Location:index.php"
    );

    exit();
}


/* COMPLETE */

if(isset($_GET["complete"])){

    $taskController
    ->completeTask(
        $_GET["complete"]
    );

    header(
        "Location:index.php"
    );

    exit();
}
/* GET TASKS */

$tasks=
$taskController->getTasks(
    $_SESSION["user_id"]
);

require "../partial/header.php";

?>

<h1>Dashboard</h1>

<p>
Welcome:
<?= $_SESSION["username"] ?>
</p>

<a
class="logout"
href="../auth/logout.php">

Logout

</a>

<hr>

<h2>Add Task</h2>

<form method="POST">

<input
type="text"
name="title"
placeholder="Task title"
required>

<br><br>

<textarea
name="description"
placeholder="Task description">
</textarea>

<br><br>

<button type="submit">
Add Task
</button>

</form>

<hr>

<h2>My Tasks</h2>

<?php if($tasks->num_rows > 0): ?>

<?php while($task = $tasks->fetch_assoc()): ?>

<div class="task-card">

<h3>

<?= htmlspecialchars(
$task["title"]
) ?>

</h3>

<p>

<?= htmlspecialchars(
$task["description"]
) ?>

</p>

<p class="task-status">

Status:
<?= $task["status"] ?>

</p>

<a
href="edit.php?id=<?= $task["id"] ?>"
>
Edit
</a>

|

<a
href="?delete=<?= $task["id"] ?>"
onclick="return confirm('Delete this task?')"
>
Delete
</a>

|

<?php if($task["status"] != "Completed"): ?>

<a
href="?complete=<?= $task["id"] ?>"
>
Mark Complete
</a>

<?php endif; ?>

</div>

<?php endwhile; ?>

<?php else: ?>

<p>No tasks yet.</p>

<?php endif; ?>