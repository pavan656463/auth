<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require '../configuration/config.php';
require 'veiwFunction.php';
 // Include the file containing the addTask function
session_start();

function call($conn)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
        // Retrieve form data
        $title = $_POST["title"];
        $name = $_SESSION['username'];
        $description = $_POST["description"];
        $assignee = $_POST["assignee"];

        echo "" . $title;

        // Call the addTask function
        addTask($conn , $title, $name, $description, $assignee);
    }
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
</head>

<body>
    <?php

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    echo "Logged as " . $username;
} else {
    echo "Not logged";
}
include 'tasks/addTask.php'
?>
    
</body>

</html>
