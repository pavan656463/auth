<?php
require_once 'config.php';
require_once 'userControl.php';

session_start();

function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validateUsername($username)
{
    return preg_match('/^[a-zA-Z0-9_]+$/', $username);
}

function displayErrors($errors)
{
    if (!empty($errors)) {
        echo '<div class="alert alert-danger" role="alert">';
        echo '<ul>';
        foreach ($errors as $error) {
            echo '<li>' . $error . '</li>';
        }
        echo '</ul>';
        echo '</div>';
    }
}

function register($conn)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
        $errors = array();

        if (!validateEmail($_POST["email"])) {
            $errors[] = "Invalid email format";
        }

        if (!validateUsername($_POST["username"])) {
            $errors[] = "Invalid username format";
        }

        if (strlen($_POST["password"]) < 6) {
            $errors[] = "Password must be at least 6 characters long";
        }

        displayErrors($errors);

        if (empty($errors)) {
            $user = new Model($conn);
            $email = $_POST["email"];
            $username = $_POST["username"];
            $password = $_POST["password"];

            if ($user->registerUser($email, $username, $password)) {
                echo "Registration Successful";
                $_SESSION['registration_status'] = "success";
                header("Location: ".$_SERVER['PHP_SELF']);
                exit();
            } else { 
                echo "Registration Unsuccessful";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
        crossorigin="anonymous">
    <link rel="stylesheet" href="/auth/authentication/styles/register.css">
</head>

<body>
    <div class="row justify-content-center align-items-center" style="height: 100vh;">
        <div class="card text-center">
            <div class="card-body">
                <h4 class="card-title mb-4">Register</h4>
                <form class="form-control-lg-1" method="post" action="/auth/authentication/register.php"
                    onsubmit="return validateForm()">
                    <div class="mb-3">
                        <label for="" class="form-label label-1mb-3 d-md-none" style="top : 64px"> ✉️ Email</label>
                        <input type="email" class="form-control" name="email" id="emailInput" placeholder="" />
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label label-2 mb-3 d-md-none" style="top : 117px">👤 Username</label>
                        <input type="text" class="form-control" name="username" id="usernameInput" placeholder="" />
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label lable-3 mb-3 d-md-none" style="top : 170px">🔒 Set Password</label>
                        <input type="password" class="form-control" name="password" id="passwordInput" placeholder="" />
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    <br><?php register($conn); ?>
                </form>
            </div>
            <div class="container mb-4 con-2">
                <p>Already have an account? <a href="/demo/login.html">Click here</a></p>
            </div>
        </div>
    </div>
    <script>
        function togglePlaceholders() {
            var passwordInput = document.getElementById("passwordInput");
            var usernameInput = document.getElementById("usernameInput");
            var emailInput = document.getElementById("emailInput");

            if (window.innerWidth < 740 || window.innerHeight < 720) {
                passwordInput.setAttribute("placeholder", "");
                usernameInput.setAttribute("placeholder", "");
                emailInput.setAttribute("placeholder", "");
            } else {
                emailInput.setAttribute("placeholder", "✉️ Email Id");
                passwordInput.setAttribute("placeholder", "🔒 Set Password");
                usernameInput.setAttribute("placeholder", "👤 Username");
            }
        }

        // Call togglePlaceholders on page load
        window.onload = togglePlaceholders;

        // Call togglePlaceholders when the window is resized
        window.onresize = togglePlaceholders;
    </script>
    <script src="/auth/authentication/styles/validation.js"></script>
</body>

</html>
