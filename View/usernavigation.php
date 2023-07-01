<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.min.js" integrity="sha512-3dZ9wIrMMij8rOH7X3kLfXAzwtcHpuYpEgQg1OA4QAob1e81H8ntUQmQm3pBudqIoySO5j0tHN4ENzA6+n2r4w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>

    <?php


    $show_login = false;

    if (isset($_COOKIE['user_data'])) {
        $data = json_decode($_COOKIE['user_data'], true);

        if ($data['login'] == true) {
            $show_login = true;
        }
    }

    $logged_out = isset($_SESSION['user_logged_out']) && $_SESSION['user_logged_out'];

    ?>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm py-3 px-2 fixed-top z-3">
        <form class="container-fluid" action="" method="post">
            <a class="btn btn-outline-secondary me-3" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                <span class="navbar-toggler-icon"></span>
            </a>

            <a class="navbar-brand" href="catalog.php"><b>Megah Holdings</b></a>

            <?php
            if ($logged_out || !$show_login) {
                // No user logged in or login flag not set in the cookie
                echo '
        <div class="navbar-nav ms-auto">
            <a class="btn btn-light mx-2" href="registration.php">Register</a>
            <a class="btn btn-light mx-2" href="userlogin.php">Login</a>
            <button type="button" class="btn btn-secondary" onclick="window.location.href = \'adminlogin.php\'">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-lock" viewBox="0 0 16 16">
                    <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h5v-1a1.9 1.9 0 0 1 .01-.2 4.49 4.49 0 0 1 1.534-3.693C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Zm7 0a1 1 0 0 1 1-1v-1a2 2 0 1 1 4 0v1a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1v-2Zm3-3a1 1 0 0 0-1 1v1h2v-1a1 1 0 0 0-1-1Z"></path>
                </svg>
            </button>
        </div>
    ';
            } else {
                // User logged in
                echo '
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"> 
                            <a class="nav-link" href="userupdate.php"><i class="fa-solid fa-user"></i> Profile</a>
                        </li>
                        <li class="nav-item"> 
                            <a class="nav-link" href="catalog.php"><i class="fas fa-th-list mr-2"></i> Catalog</a>
                        </li>
                        <li class="nav-item"> 
                            <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i> Cart</a>
                        </li>                 
                        <li class="nav-item"> 
                            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#qrCodeModal">
                                <i class="fa-solid fa-qrcode"></i> Suggest a Product!
                            </a>
                        </li> 
                        <button class="btn btn-light mx-2" name="logout">Logout</button>
                    </ul>
                </div>
            ';

                if (isset($_POST['logout'])) {
                    $_SESSION['user_logged_out'] = true;
                    unset($_COOKIE['user_data']);
                    setcookie('user_data', null, -1, '/');
                    header('Location: ' . $_SERVER['REQUEST_URI']);
                    exit;
                }
            }
            ?>
        </form>
    </nav>

    <!-- QR Code Modal -->
    <div class="modal fade" id="qrCodeModal" tabindex="-1" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrCodeModalLabel">Scan the QR Code to Suggest a Product!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="qrCodeImage" src="" alt="QR Code">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Get the QR code image element
        const qrCodeImage = document.getElementById('qrCodeImage');

        // Get the link for the QR code
        const qrCodeLink = 'https://forms.gle/kAaEi9TaueGtwjHq6';

        // Generate the QR code and set the source of the image
        qrCodeImage.src = `https://api.qrserver.com/v1/create-qr-code/?data=${encodeURIComponent(qrCodeLink)}`;
    </script>
    <?php include "sidebar.php" ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" integrity="sha512-q2atopRwMJytL05LzTJUw0yGnEe9A3mBSWnJ0gb1VGSd54D9sntuN3yQhq9riK9ahzJ0EYyOGvzKGG5Ju9lRbQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>