<?php
session_start();

include "../config/autoload.php";
$show_error = false;

if (isset($_SESSION['logged_out']) && !$_SESSION['logged_out']) {
    header("Location: catalog.php");
    exit();
}

$userController = new UserController();

if (isset($_POST['Register'])) {
    // Retrieve the submitted form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Add the user to the database using the UserController
    $userAdded = $userController->addUserController($username, $email, $password);

    if ($userAdded) {
        // User registration successful
        $_SESSION['logged_out'] = false;
        
        // Create the user data array for the cookie
        $userData = [
            'login' => true,
            // Other relevant user data
        ];
        
        // Set the cookie with the user data
        setcookie('user_data', json_encode($userData), time() + (86400 * 30), '/');
        
        header("Location: catalog.php"); // Redirect to login page or any other desired page
        exit();
    } else {
        // User registration failed
        $_SESSION['logged_out'] = true;
        $show_error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Megah Holdings - User Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body>
    <?php include "usernavigation.php"; ?>

    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card px-5 w-50">
            <div class="card-body">
                <div class="mt-3">
                    <h1>Welcome to Megah Holdings - User Registration</h1>
                </div>
                <div class="mt-3 mb-4">
                    <h3>Create a New User Account</h3>
                </div>
                <form action="#" method="post">
                    <?php
                    if ($show_error) {
                        echo '
                           <div class="my-3 alert alert-danger" role="alert">
                                User registration failed. Please try again.
                           </div>
                        ';
                    }
                    ?>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" placeholder="Enter your username" name="username"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input type="email" class="form-control" placeholder="name@example.com" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" placeholder="**********" name="password" required>
                    </div>
                    <div class="my-3">
                        <input type="submit" value="Register" name="Register" class="btn btn-primary w-100">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ"
        crossorigin="anonymous"></script>
</body>

</html>
