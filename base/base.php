<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require '../configuration/config.php';
require 'veiwFunction.php';
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

function getTaskList($conn)
{
    $username = $_SESSION['username'];
    $tasks = taskList($conn, $username);
    echo '<ul class="list-group">';
    foreach ($tasks as $task) {
        echo '<li class="list-group-item task-box" data-description="' . $task['description'] . '" data-title="' . $task['title'] . '" data-date-created="' . $task['date_created'] . '">';
        echo '<h5 class="task-title">' . $task['title'] . '</h5>';
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
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-hWVj5fz3F5sQrlV9R0Z8s82T0UZdyzxpZ8TL3Fx4fe2urAehgJ1aFwnfFZ1hmPKL"
        crossorigin="anonymous"></script>
    <script>
       $(document).ready(function () {
        $(".task-box").click(function () {
            var title = $(this).data("title");
            var description = $(this).data("description");
            var dateCreated = $(this).data("date-created");

            Swal.fire({
                title: title,
                html: '<p>Description: ' + description + '</p><p>Date Created: ' + dateCreated + '</p>',
                icon: 'info',
                showCancelButton: false,
                showConfirmButton: true,
                confirmButtonText: 'OK',
            });
        });
    });

    </script>
</body>

</html>
