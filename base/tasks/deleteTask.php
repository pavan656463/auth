<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../base/veiwFunction.php';


// deleteTask.php

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
    } ; 



?>
