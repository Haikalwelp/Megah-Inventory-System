<?php
session_start();

require_once "../config/autoload.php";

$show_error = false;
$show_success = false;
$show_passwordmismatch = false;

$userController = new UserController();

$userId = $_SESSION['userId']; // Get the user ID from the session

$userData = $userController->getUserByIdController($userId);
if ($userData) {
    $userEmail = $userData['userEmail'];
    $username = $userData['username'];
    $censoredPassword = str_repeat("*", strlen($userData['password']));
}

// Handle form submission
if (isset($_POST['Update'])) {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($password !== $confirmPassword) {
        // Passwords don't match
        $show_passwordmismatch = true;
    } else {
    // Update user details in the database
    $result = $userController->insertUserByIdController($userId, $email, $password, $username);
    if ($result) {
        // User details updated successfully
        $show_success = true;
    } else {
        // Error updating user details
        // Set a flag to show the error message
        $show_error = true;
    }
}
}

?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <?php include "usernavigation.php"; ?>
    <div class="d-flex flex-column justify-content-center align-item-center vh-100" style="padding-left: 400px; padding-right: 400px">
        <form action="" method="post">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page">Manage User</li>
                        <li class="breadcrumb-item active" aria-current="page">Update User Details</li>
                    </ol>
                </nav>
                <h3 class="my-4">Update User</h3>
            </div>

            <?php
            if ($show_error) {
                echo '
                <div class="my-3 alert alert-danger" role="alert">
                    Incorrect password
                </div>
                ';
            } elseif ($show_success) {
                echo '
    <div class="my-3 alert alert-success" role="alert">
        Admin details updated successfully!
    </div>
    ';
                // Refresh the page in 2 seconds
                echo '
    <script>
        setTimeout(function(){
            location.reload();
        }, 2000);
    </script>
    ';
            } elseif ($show_passwordmismatch) {
                echo '
                <div class="my-3 alert alert-danger" role="alert">
                    Passwords don\'t match
                </div>
                ';
            }
            ?>


            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $userEmail ?>" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $username ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" value="" placeholder="**********" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="" placeholder="**********" required>
            </div>
            <div class="mb-3">
                <input type="submit" value="Update" name="Update" class="btn btn-primary w-100">
            </div>
        </form>
    </div>


</body>

</html>