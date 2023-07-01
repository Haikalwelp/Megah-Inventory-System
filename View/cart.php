<?php
session_start();

include "../config/autoload.php";
include "usernavigation.php";

// Create an instance of the ProductController
$productController = new ProductController();

// Retrieve the logged-in user's ID
$userId = $_SESSION['userId'];

// Retrieve the logged-in user's details
$userController = new UserController();
$user = $userController->getUserByIdController($userId);

// Retrieve the user's name and email
$name = $user['username'];
$email = $user['userEmail'];

// Retrieve the cart items for the logged-in user
$cartItems = [];
if (isset($_SESSION['cart'][$userId])) {
    foreach ($_SESSION['cart'][$userId] as $productId) {
        $cartItems[] = $productController->getProductByIdController($productId);
    }
}

// Calculate the total price
$totalPrice = 0;
foreach ($cartItems as $item) {
    $totalPrice += $item['selling'];
}

if (isset($_POST['clearCart'])) {
    // Clear the cart items for the logged-in user
    if (isset($_SESSION['userId'])) {
        $userId = $_SESSION['userId'];
        unset($_SESSION['cart'][$userId]);
        echo '<script>
        setTimeout(function() {
            window.location.href = "cart.php";
        });
    </script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        .card-img-top {
            object-fit: cover;
            height: 150px;
        }
    </style>
</head>

<body>
    <br><br>
    <div class="container">
        <h1 class="mt-4">Checkout</h1>
        <div class="row">
            <div class="col-md-8">
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Cart Items</h5>
                        <?php foreach ($cartItems as $item) : ?>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <img src="data:image/jpeg;base64,<?php echo $item['productphoto']; ?>" class="card-img-top" alt="Product Image">
                                </div>
                                <div class="col-md-9">
                                    <h6><?php echo $item['product_name']; ?></h6>
                                    <p>Category: <?php echo $item['category']; ?></p>
                                    <p>Price: RM<?php echo $item['selling']; ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <!-- Clear cart button -->
                        <div class="mt-4">
                            <form method="post">
                                <button type="submit" name="clearCart" class="btn btn-danger">Clear Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Total Price</h5>
                        <h6>RM <?php echo $totalPrice; ?></h6>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Checkout Form</h5>
                        <form>
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Payment Method</label>
                                <div>
                                    <input type="radio" id="cod" name="paymentMethod" value="cod" checked>
                                    <label for="cod">Cash On Delivery (COD)</label>
                                </div>
                                <div>
                                    <input type="radio" id="card" name="paymentMethod" value="card" disabled>
                                    <label for="card">Debit/Credit Card</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Place Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>

</html>