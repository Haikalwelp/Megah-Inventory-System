<?php
// Include the necessary files and classes
require_once "../config/autoload.php";
include "navigation.php";
// Create an instance of the ProductController
$productController = new ProductController();

// Retrieve the products
$products = $productController->getProductsController();
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<html>
<head>
    <title>Product Information</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        .card-img-top {
            object-fit: cover;
            height: 350px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Product Information</h1>
        <div class="row">
            <?php foreach ($products as $product): ?>
            <div class="col-md-4">
                <div class="card mt-4">
                    <img src="data:image/jpeg;base64,<?php echo $product['productphoto']; ?>" class="card-img-top" alt="Product Image">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product['product_name']; ?></h5>
                        <p class="card-text">Type: <?php echo $product['type']; ?></p>
                        <p class="card-text">Category: <?php echo $product['category']; ?></p>
                        <p class="card-text">Selling Price: <?php echo $product['selling']; ?></p>
                        <p class="card-text">Balance: <?php echo $product['balance']; ?></p>
                        <button class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
                                <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/>
                            </svg>
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>
