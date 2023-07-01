<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <?php
    require_once "../config/autoload.php";
    include "adminnavigation.php";
    $success = false;
    $error = false;
    $nothing = false;
    ?>

    <br><br><br>

    <?php
    // Check if the delete form is submitted
    if (isset($_POST['deleteSelected'])) {
        // Check if any products are selected for deletion
        if (isset($_POST['selectedProduct'])) {
            // Create an instance of ProductController
            $productController = new ProductController();

            // Get the selected products from the form
            $selectedProducts = $_POST['selectedProduct'];

            // Call the deleteProducts method to delete the selected products
            $result = $productController->deleteProductsController($selectedProducts);

            if ($result) {
                // Deletion successful
            } else {
                // Deletion failed
                $error = true;
            }
        } else {
            $nothing = true;
        }
    }



    // Check if the form is submitted
    if (isset($_POST['addProduct'])) {
        $productController = new ProductController();
        // Retrieve form data
        $productData = array(
            'product_name' => $_POST['product_name'],
            'product_code' => $_POST['product_code'],
            'type' => $_POST['type'],
            'category' => $_POST['category'],
            'uom' => $_POST['uom'],
            'cost' => $_POST['cost'],
            'selling' => $_POST['selling'],
            'balance' => $_POST['balance'],
            'productphoto' => $_FILES['productphoto']
        );

        // Validate the form inputs (perform your own validation logic here)

        // Add the product
        $result = $productController->addProductController($productData);

        if ($result) {
            // Product added successfully
            echo "Product added successfully!";
        } else {
            // Failed to add the product
            echo "Error: Failed to add the product.";
        }
    }



    if (isset($_POST['edit'])) {
        $productController = new ProductController();
        // Retrieve form data
        $productId = $_POST['productId'];
        $name = $_POST['editProductName'];
        $category = $_POST['editProductCategory'];
        $sellingPrice = $_POST['editProductSelling'];
        $balance = $_POST['editProductBalance'];
        $productPhoto = $_FILES['editProductPhoto'];
    
        // Edit the product
        $result = $productController->editProductController($productId, $name, $category, $sellingPrice, $balance, $productPhoto);
    
        if ($result) {
            // Product edited successfully
            echo "Product edited successfully!";
        } else {
            // Failed to edit the product
            echo "Error: Failed to edit the product.";
        }
    }
    

    ?>


    <div class="container-fluid px-5">
        <h3 class="mt-5">Inventory List</h3>
        <?php
        if ($error == true) {
            echo '
                    <div class="alert alert-danger w-100" role="alert">
                        Action unsuccessful
                    </div>';
        } elseif ($success == true) {
            echo '
                    <div class="alert alert-success w-100" role="alert">
                        Action successful (Refreshing this page in 2 seconds)
                    </div>';
        } elseif ($nothing == true) {
            echo '
                    <div class="alert alert-warning w-100" role="alert">
                        No products selected!
                    </div>';
        }
        ?>

        <div class="card text-left w-90">
            <div class="card-header">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Inventory</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Category</th>
                                <th scope="col">Selling Price</th>
                                <th scope="col">Balance</th>
                                <th scope="col">Select</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php


                            // Create an instance of ProductController
                            $productController = new ProductController();

                            // Call the getProducts method to retrieve the products
                            $products = $productController->getProductsController();

                            // Iterate through the fetched data and populate table rows
                            $rowNumber = 1;
                            foreach ($products as $product) {
                                echo '<tr>';
                                echo '<th scope="row">' . $rowNumber . '</th>';
                                echo '<td>' . $product['product_name'] . '</td>';
                                echo '<td>' . $product['category'] . '</td>';
                                echo '<td>' . $product['selling'] . '</td>';
                                echo '<td>' . $product['balance'] . '</td>';
                                echo '<td>';
                                echo '<input type="checkbox" name="selectedProduct[]" value="' . $product['productid'] . '">';
                                echo '</td>';
                                echo '<td>';
                                echo '<a href="#" data-bs-toggle="modal" data-bs-target="#editModal" data-product-id="' . $product['productid'] . '" data-product-name="' . $product['product_name'] . '" data-product-category="' . $product['category'] . '" data-product-selling="' . $product['selling'] . '" data-product-balance="' . $product['balance'] . '" data-product-photo="' . $product['productphoto'] . '">Edit</a>';
                                echo '</td>';
                                echo '</tr>';
                                $rowNumber++;
                            }
                            ?>
                        </tbody>

                    </table>
                    <div class="modal-footer">
                        <button type="submit" name="deleteSelected" class="btn btn-outline-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                            </svg>
                            Delete
                        </button>
                        <div style="margin-left: 10px;"></div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="add">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"></path>
                            </svg>
                            Add
                        </button>
                    </div>
                </form>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" enctype="multipart/form-data" id="editProductForm">
                                    <input type="hidden" id="editProductId" name="productId">
                                    <div class="mb-3">
                                        <label for="editProductName" class="form-label">Product Name</label>
                                        <input type="text" class="form-control" id="editProductName" name="editProductName">
                                    </div>
                                    <div class="mb-3">
                                        <label for="editProductCategory" class="form-label">Category</label>
                                        <input type="text" class="form-control" id="editProductCategory" name="editProductCategory">
                                    </div>
                                    <div class="mb-3">
                                        <label for="editProductSelling" class="form-label">Selling Price</label>
                                        <input type="text" class="form-control" id="editProductSelling" name="editProductSelling">
                                    </div>
                                    <div class="mb-3">
                                        <label for="editProductBalance" class="form-label">Balance</label>
                                        <input type="text" class="form-control" id="editProductBalance" name="editProductBalance">
                                    </div>
                                    <div class="mb-3">
                                        <label for="currentProductPhoto" class="form-label">Current Product Photo</label>
                                        <img src="" id="currentProductPhoto" width="200" height="200" alt="Current Product Photo">
                                    </div>
                                    <div class="mb-3">
                                        <label for="editProductPhoto" class="form-label">New Product Photo</label>
                                        <input type="file" class="form-control" id="editProductPhoto" name="editProductPhoto">
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="edit">Edit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var editModal = document.getElementById('editModal');
                        var editLink = document.querySelector('a[data-bs-toggle="modal"][data-bs-target="#editModal"]');

                        editModal.addEventListener('show.bs.modal', function(event) {
                            var button = event.relatedTarget;
                            var productId = button.getAttribute('data-product-id');
                            var productName = button.getAttribute('data-product-name');
                            var productCategory = button.getAttribute('data-product-category');
                            var productSelling = button.getAttribute('data-product-selling');
                            var productBalance = button.getAttribute('data-product-balance');
                            var productPhoto = button.getAttribute('data-product-photo');

                            var editForm = document.getElementById('editProductForm');
                            var editProductId = editForm.querySelector('#editProductId');
                            var editProductName = editForm.querySelector('#editProductName');
                            var editProductCategory = editForm.querySelector('#editProductCategory');
                            var editProductSelling = editForm.querySelector('#editProductSelling');
                            var editProductBalance = editForm.querySelector('#editProductBalance');
                            var currentProductPhoto = editForm.querySelector('#currentProductPhoto');

                            // Set the values in the form fields
                            editProductId.value = productId;
                            editProductName.value = productName;
                            editProductCategory.value = productCategory;
                            editProductSelling.value = productSelling;
                            editProductBalance.value = productBalance;
                            currentProductPhoto.src = 'data:image/jpeg;base64,' + productPhoto;
                        });
                    });
                </script>





                <!-- Add Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="product_name" class="col-form-label">Product:</label>
                                        <input type="text" class="form-control" name="product_name" id="product_name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="product_code" class="col-form-label">Code:</label>
                                        <input type="text" class="form-control" name="product_code" id="product_code">
                                    </div>
                                    <div class="mb-3">
                                        <label for="type" class="col-form-label">Type:</label>
                                        <select class="form-control" name="type" id="type">
                                            <option value="" disabled selected>Click For Options</option>
                                            <option value="PRODUCT">Product</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="category" class="col-form-label">Category:</label>
                                        <input type="text" class="form-control" name="category" id="category">
                                    </div>
                                    <div class="mb-3">
                                        <label for="uom" class="col-form-label">UOM:</label>
                                        <select class="form-control" name="uom" id="uom">
                                            <option value="" disabled selected>Click For Options</option>
                                            <option value="UNIT">UNIT</option>
                                            <option value="BOX">BOX</option>
                                            <option value="CASE">CASE</option>
                                            <option value="PCS">PCS</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="cost" class="col-form-label">Cost:</label>
                                        <input type="text" class="form-control" name="cost" id="cost">
                                    </div>
                                    <div class="mb-3">
                                        <label for="selling" class="col-form-label">Selling Price:</label>
                                        <input type="text" class="form-control" name="selling" id="selling">
                                    </div>
                                    <div class="mb-3">
                                        <label for="balance" class="col-form-label">Balance:</label>
                                        <input type="text" class="form-control" name="balance" id="balance">
                                    </div>
                                    <div class="mb-3">
                                        <label for="productphoto" class="col-form-label">Product Photo:</label>
                                        <input type="file" class="form-control" name="productphoto" id="productphoto">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <input type="submit" class="btn btn-primary" name="addProduct" value="Add">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>