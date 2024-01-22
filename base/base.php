<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../configuration/config.php';
require '../base/tasks/deleteTask.php'; 
require_once 'veiwFunction.php';


session_start();

function task($conn)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
        $title = $_POST["title"];
        $name = $_SESSION['username'];
        $description = $_POST["description"];
        $assignee = $_POST["assignee"];
        addTask($conn, $title, $name, $description, $assignee);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete-task-id"])) {
    $taskId = $_POST["delete-task-id"];

    // Implement logic to delete the task from the database based on $taskId
    // For example, you can use a function like deleteTaskById($conn, $taskId) to delete the task.
    // Make sure to include your database connection and appropriate functions.

    deleteTaskById($conn, $taskId);

    // Return a success message or appropriate response
    echo "Task deleted successfully!";
} else {
    // Handle invalid request
    echo "Invalid request!";
}

function getTaskList($conn)
{
    $username = $_SESSION['username'];
    $tasks = taskList($conn, $username);
    echo '<ul class="list-group">';
    foreach ($tasks as $task) {
        echo '<li class="list-group-item task-box" data-description="' . $task['description'] . '" data-title="' . $task['title'] . '" data-date-created="' . $task['date_created'] . '" data-assignee="' . $task['assignee'] . '">';
        echo '<div class="d-flex justify-content-between align-items-center">';
        echo '<h5 class="task-title">' . $task['title'] . '</h5>';
        echo '<div class="task-buttons">';
        echo '<button class="btn btn-info btn-sm view-task" style="background-color:#20c997; border:none; margin-right:15px;" data-task-id="' . $task['id'] . '">View</button>';
        echo '<button class="btn btn-primary btn-sm edit-task" style="margin-right:15px;" data-task-id="' . $task['id'] . '">Edit</button>';
        echo '<form method="post" action="base.php">';
        echo '<input type="hidden" name="delete-task-id" value="' . $task['id'] . '">';
        echo '<button type="submit" class="btn btn-danger btn-sm delete-task" style="margin-right:15px;">Delete</button>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
        echo '</li>';
    }
    echo '</ul>';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Base page</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="/auth/base/styles/base.css">
</head>

<body>
    <?php
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        echo "Logged as " . $username;
    } else {
        echo "Not logged";
    }
    ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="card mb-4 box-1">
                    <div class="card-body">
                        <h4 class="card-title">Add task</h4>
                        <?php include 'tasks/addTask.php' ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card box-1">
                    <div class="card-body">
                        <h4 class="card-title">Tasks-List</h4>
                        <?php getTaskList($conn) ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card box-1">
                    <div class="card-body">
                        <h4 class="card-title">Tasks-Assigned to me </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

    </script>
</body>

</html>
