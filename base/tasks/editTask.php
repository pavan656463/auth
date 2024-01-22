<?php
require $_SERVER['DOCUMENT_ROOT'] . '/auth/configuration/config.php';
require $_SERVER['DOCUMENT_ROOT'] . '/auth/configuration/userControl.php';

session_start();

$taskId = intval($_SESSION['taskId']);

$task = selectFromTable($conn, 'tasks', ['id' => "$taskId"]);

// Check if data is retrieved
if ($task) {
    // Extract values from the data array
    $title = $task[0]['title'];
    $description = $task[0]['description'];
    $assignee = $task[0]['assignee'];
} else {
    // Handle the case where data retrieval fails
    echo "Error: Unable to retrieve data from the database.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Task</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <form method="post" action="">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title"
                    value="<?php echo isset($title) ? htmlspecialchars($title) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description"
                    required><?php echo isset($description) ? htmlspecialchars($description) : ''; ?></textarea>
            </div>

            <div class="form-group">
                <label for="assignee">Assignee:</label>
                <input type="text" class="form-control" id="assignee" name="assignee"
                    value="<?php echo isset($assignee) ? htmlspecialchars($assignee) : ''; ?>" required>
            </div>

            <button type="submit" class="btn btn-primary" name="submit">
                Update
            </button>
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
            $title = $_POST["title"];
            $description = $_POST["description"];
            $assignee = $_POST["assignee"];

            // Corrected the array key from 'assingnee' to 'assignee'
            $dataUpdate = array('title' => $title, 'description' => $description, 'assignee' => $assignee);
            $conditions = array('id' => $taskId);
            // Assuming you have a function updateRecord defined
            updateRecord($conn, 'tasks', $dataUpdate, $conditions);

            $url = "/auth/base/base.php";
            header("Location: " . $url);
            exit();
        } else {
            echo "Not Updated";
        }
        ?>
    </div>

    <!-- Include Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
