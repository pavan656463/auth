<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/configuration/config.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/base/veiwFunction.php';



session_start();

function task($conn)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
        $title = $_POST["title"];
        $name = $_SESSION['username'];
        $description = $_POST["description"];
        $assignee = $_POST["assignee"];
        addTask($conn, $title, $name, $description, $assignee);
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete-task-id"])) {
    $taskId = $_POST["delete-task-id"];

    // Implement logic to delete the task from the database based on $taskId
    // For example, you can use a function like deleteTaskById($conn, $taskId) to delete the task.
    // Make sure to include your database connection and appropriate functions.
    deleteTaskById($conn, $taskId);
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();

    // Return a success message or appropriate response
} else {
    // Handle invalid request
    echo "";
}

// edit the task 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit-task-id"])) {
    $taskId = $_POST["edit-task-id"];
    $url = '../base/tasks/editTask.php' ; 

    $_SESSION['taskId'] = $taskId ; 
    header("Location: ".$url);
    exit();

    // Return a success message or appropriate response
} else {
    // Handle invalid request
    echo "";
}

function getTaskList($conn)
{
    $username = $_SESSION['username'];
    $tasks = taskList($conn, $username);
    echo '<ul class="list-group">';
    foreach ($tasks as $task) {
        echo '<li class="list-group-item task-box-list" data-description="' . $task['description'] . '" data-title="' . $task['title'] . '" data-date-created="' . $task['date_created'] . '" data-assignee="' . $task['assignee'] . '" data-task-status="' . $task['task_status'] . '">';
        echo $task['task_status'];
        echo '<div class="d-flex justify-content-between align-items-center">';
        
        // Title on the left side
        echo '<h5 class="task-title">' . $task['title'].'- '.$task['assignee']. '</h5>';
        
        // Buttons on the right side
        echo '<div class="d-flex">';
        echo '<button class="btn btn-info btn-sm view-task" style="background-color:#20c997; border:none; margin-left:10px;" data-task-id="' . $task['id'] . '">View</button>';
        echo '<form method="post" action="base.php" style="margin-left:10px;">';
        echo '<input type="hidden" name="edit-task-id" value="' . $task['id'] . '">';
        echo '<button class="btn btn-primary btn-sm edit-task" style="margin-left:10px;" data-task-id="' . $task['id'] . '">Edit</button>';
        echo '</form>';
        echo '<form method="post" action="base.php" style="margin-left:10px;">';
        echo '<input type="hidden" name="delete-task-id" value="' . $task['id'] . '">';
        echo '<button type="submit" class="btn btn-danger btn-sm delete-task" style="margin-left:10px;">Delete</button>';
        echo '</form>';
        echo '</div>'; // Close the d-flex div for buttons
        
        echo '</div>'; // Close the d-flex div for title and buttons
        echo '</li>';
    }
    echo '</ul>';
}


function getAssignList($conn){
    $username = $_SESSION['username'];
    $tasks = taskAssignList($conn, $username);
    echo '<ul class="list-group">';
    foreach ($tasks as $task) {
        echo '<li class="list-group-item task-box" data-description="' . $task['description'] . '" data-title="' . $task['title'] . '" data-date-created="' . $task['date_created'] . '" data-assignee="' . $task['assignee'] . '" data-task-status="' . $task['task_status'] . '">';
        echo $task['task_status'];
        echo '<div class="d-flex justify-content-between align-items-center">';
        
        // Title on the left side
        echo '<h5 class="task-title">' . $task['title'].'- '.$task['name'] . '</h5>';
        // Buttons on the right side
        echo '<div class="d-flex">';
        echo '<button class="btn btn-info btn-sm view-task" style="background-color:#20c997 ;  border:none; margin-left:10px;" data-task-id="' . $task['id'] . '">View</button>';        
        echo '</div>'; // Close the d-flex div for title and buttons
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
    <link href="/auth/lib/bootstrap-5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
        crossorigin="anonymous">
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
    <div class="container" style="margin-left: 0; margin-right:0;">
        <div class="row" style = "padding-bottom: 20px;">
            <div class="col-lg-6">
                <div class="card mb-4 box-1">
                    <div class="card-body">
                        <h4 class="card-title">Add task</h4>
                        <?php include 'tasks/addTask.php' ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card box-1" >
                    <div class="card-body">
                        <h4 class="card-title">Tasks-Assigned to me </h4>
                        <div class="row">
                            <!-- Pending tasks -->
                            <div class="col-lg-8">
                                <div class="card box-1" style="margin-bottom: 20px; padding-bottom: 20px;">
                                    <div class="card-body">
                                        <h5>Pending</h5>
                                    </div>
                                    <?php getAssignList($conn) ?>
                                </div>
                            </div>
                            <!-- Completed tasks -->
                            <div class="col-lg-4">
                                <div class="card box-1">
                                    <div class="card-body">
                                        <h5>Completed</h5>
                                        <!-- Add your content for completed tasks here if needed -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="row">
        <div class="col-lg-8">
                <div class="card box-1">
                    <div class="card-body">
                        <h4 class="card-title">Tasks-List</h4>
                        <!--- Pending task list view ---->
                        <div class = "row">
                        <div class = "col-lg-8"  >
                            <div class = "card box-1" style = "margin-bottom: 20px;padding-bottom: 20px;">
                                <div class = "card-body">
                                    <h5>Pending</h5>
                                </div>
                                <?php getTaskList($conn) ?>
                            </div>
                        </div>
                        <!---Completed task view--->
                        <div class = "col-lg-4">
                            <div class = "card box-1">
                                <div class = "card-body">
                                    <h5>Compeleted</h5>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/auth/bootstrap-5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
    <script src="/auth/bootstrap-5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </script>
    <script src="/auth/base/scripts/taskListView.js">
    </script>
    <script>
    // Function to set the task title in local storage
    function setTaskTitle() {
        var taskTitleInput = document.getElementById("title");
        var taskTitle = taskTitleInput.value;
        localStorage.setItem("taskTitle", taskTitle);
    }

    // Function to get the task title from localStorage
    function getTaskTitle() {
        var taskTitleInput = document.getElementById("title");
        var storedTaskTitle = localStorage.getItem("taskTitle");
        if (storedTaskTitle !== null) {
            taskTitleInput.value = storedTaskTitle;
        }
    }

    // Call the getTaskTitle function when the page loads
    window.onload = function () {
        getTaskTitle();
    };

    // Reload the page after 5 seconds
    setTimeout(function () {
        location.reload();
    }, 5000);

    // Save the task title to localStorage before the page is reloaded
    window.onbeforeunload = function () {
        setTaskTitle();
    };
</script>

</body>

</html>
