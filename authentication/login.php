<?php

require '../configuration/config.php';
require_once '../configuration/userControl.php';

function auth($conn)
{
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login_submit"])) {
        // Retrieve form data
        $user = new Model($conn);
        $username = $_POST["username"];
        $password = $_POST["password"];

        if ($user->authenticateUser($username, $password)) {
            // sending data url
            $_SESSION['username'] = $username;
            $url = "/auth/base/base.php";

            header("Location: " . $url);
            exit();
        } else {
            echo "Wrong Username or password";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signin</title>
    <!-- Adjust the paths to point to your locally downloaded Bootstrap files -->
    <link href="/auth/lib/bootstrap-5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/auth/authentication/styles/login.css">
</head>

<body>
    <div class="row justify-content-center align-items-center" style="height: 100vh;">
        <div class="container-1 card">
            <h5 class="card-title">Welcome</h5>
            <div class="input-form">
                <form method="post" action="/auth/authentication/login.php">
                    <div class="mb-3">
                        <label for="username" class="form-label">👤</label>
                        <input
                            type="text"
                            class="form-control-lg-1 custom-textarea box-1"
                            name="username"
                            id="username"
                            aria-describedby="helpId"
                            placeholder="username"
                        />
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">🔒</label>
                        <input
                            type="password"
                            class="form-control-lg-1 custom-textarea box-1"
                            name="password"
                            id="password"
                            placeholder=""
                        />
                    </div>
                    <button
                        type="submit"
                        class="btn btn-primary box-2"
                        name="login_submit"
                    >
                        Login
                    </button>
                    <br><?php auth($conn) ?>
                </form>

            </div>
            <div class="container">
                <p class="content-p">Don't have an account <a href="/auth/authentication/register.php"> click here</a></p>
            </div>
        </div>
    </div>
    <!-- Adjust the paths to point to your locally downloaded Bootstrap JS file -->
    <script src="/auth/lib/bootstrap-5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var inputs = document.querySelectorAll('.custom-textarea');

            inputs.forEach(function (input) {
                input.addEventListener('focus', function () {
                    input.classList.add('no-hover');
                });

                input.addEventListener('blur', function () {
                    input.classList.remove('no-hover');
                });
            });
        });
    </script>
</body>

</html>
