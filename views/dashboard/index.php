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

<a href="../auth/logout.php">
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

<?php

if($tasks->num_rows>0):

while(
$task=$tasks->fetch_assoc()
):

?>

<div
style="
border:1px solid black;
padding:10px;
margin-bottom:10px;
"
>

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

<p>

Status:

<?= $task["status"] ?>

</p>

</div>

<?php

endwhile;

else:

?>

<p>No tasks yet.</p>

<?php endif; ?>

<?php require "../partial/footer.php"; ?>