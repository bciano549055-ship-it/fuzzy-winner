<?php

session_start();

require_once "../../controllers/task.php";
require_once "../../public/database.config.php";

$taskController=
new TaskController(
    $SERVER_NAME,
    $USERNAME,
    $PASSWORD,
    $DB_NAME
);

$id=$_GET["id"];

$task=
$taskController
->getTaskById(
$id
);

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $taskController
    ->updateTask(

        $id,
        $_POST["title"],
        $_POST["description"]

    );

    header(
        "Location:index.php"
    );

    exit();

}

require "../partial/header.php";

?>

<h1>Edit Task</h1>

<form method="POST">

<input
type="text"
name="title"
value="<?= $task["title"] ?>"
required>

<br><br>

<textarea
name="description"
><?= $task["description"] ?></textarea>

<br><br>

<button type="submit">

Update Task

</button>

</form>

<?php require "../partial/footer.php"; ?>