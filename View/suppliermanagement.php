<?php
require_once "../config/autoload.php";

$supplierController = new SupplierController();
$suppliers = $supplierController->getSuppliersController();

$productController = new ProductController();

?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include "adminnavigation.php"; ?>

    <br><br>
    <div class="container mt-4">
        <h1>Supplier Details</h1>

        <?php
        if (count($suppliers) > 0) {
            foreach ($suppliers as $supplier) {
                $supplierID = $supplier['supplierid'];
                $supplierName = $supplier['supplierName'];
                $supplierAddress = $supplier['supplierAddress'];
                $supplierTelNo = $supplier['supplierTelNo'];

                echo '<div class="card mb-3">';
                echo '<div class="card-header">';
                echo 'Supplier ID: ' . $supplierID;
                echo '</div>';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">Supplier Name: ' . $supplierName . '</h5>';
                echo '<p class="card-text">Supplier Address: ' . $supplierAddress . '</p>';
                echo '<p class="card-text">Supplier Tel No: ' . $supplierTelNo . '</p>';
                echo '<h6 class="card-subtitle mb-2 text-muted">Products:</h6>';
                echo '<ul class="list-group">';
                
                // Fetch products for the current supplier
                $products = $productController->getProductIdBySupplierIDController($supplierID);
                if (count($products) > 0) {
                    foreach ($products as $product) {
                        echo '<li class="list-group-item">' . $product['product_name'] . '</li>';
                    }
                } else {
                    echo '<li class="list-group-item">No products found for this supplier.</li>';
                }
                
                echo '</ul>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>No suppliers found.</p>';
        }
        ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
