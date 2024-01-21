<?php
require_once '../configuration/config.php' ;
require_once '../configuration/userControl.php' ;


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

        // Validate email
        if (!validateEmail($_POST["email"])) {
            $errors[] = "Invalid email format";
        }

        // Validate username
        if (!validateUsername($_POST["username"])) {
            $errors[] = "Invalid username format";
        }

        // Validate password length
        if (strlen($_POST["password"]) < 6) {
            $errors[] = "Password must be at least 6 characters long";
        }

        // Display errors if any
        displayErrors($errors);

        if (empty($errors)) {
            // Use $_POST directly for consistency
            $email = $_POST["email"];
            $username = $_POST["username"];
            $password = $_POST["password"];

            $data = array(
                'email' => $email,
                'username' => $username,
                'password' => $password
            );

            $user = new Model($conn);

            if ($user->insertData('users', $data)) {
                echo "Registration Successful";
                $_SESSION['registration_status'] = "success";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                // Redirect to registration page with an error message
                $_SESSION['registration_status'] = "error";
                header("Location: registration_page.php");
                exit();
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
                <p>Already have an account? <a href="/auth/authentication/login.php">Click here</a></p>
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
