<?php

class Product extends Connection
{

    public function getProducts()
    {
        $connection = $this->getConnection();

        // Assuming the table name is 'products'
        $query = "SELECT productid, product_name, product_code, type, category, gst, uom, cost, selling, balance, productphoto FROM products";
        $result = mysqli_query($connection, $query);

        if ($result) {
            $products = array();

            while ($row = mysqli_fetch_assoc($result)) {
                // Handle the productphoto column
                $row['productphoto'] = base64_encode($row['productphoto']);

                $products[] = $row;
            }

            // Return the array of products
            return $products;
        } else {
            // Handle the query error
            return false;
        }
    }


    public function deleteProducts($productIds)
    {
        $connection = $this->getConnection();

        // Assuming the table name is 'products'
        $deleteQuery = "DELETE FROM products WHERE productid IN (";
        $deleteQuery .= implode(',', array_fill(0, count($productIds), '?'));
        $deleteQuery .= ")";
        $deleteStatement = mysqli_prepare($connection, $deleteQuery);

        if ($deleteStatement) {
            // Bind the product ID parameters for deletion
            $types = str_repeat('i', count($productIds));
            mysqli_stmt_bind_param($deleteStatement, $types, ...$productIds);

            // Execute the delete statement
            $deleteSuccess = mysqli_stmt_execute($deleteStatement);

            if ($deleteSuccess) {
                // Update product IDs to maintain coherence
                $updateQuery = "SET @count = 0";
                mysqli_query($connection, $updateQuery);

                $updateQuery = "UPDATE products SET productid = @count:= @count + 1";
                mysqli_query($connection, $updateQuery);

                $updateQuery = "ALTER TABLE products AUTO_INCREMENT = 1";
                mysqli_query($connection, $updateQuery);

                return true;
            }

            return false;
        }

        return false;
    }

    public function editProduct($productId, $name, $category, $sellingPrice, $balance, $productPhoto)
    {
        $connection = $this->getConnection();

        // Process the uploaded product photo
        $photo_tmp_name = $productPhoto['tmp_name'];
        $photo_error = $productPhoto['error'];

        // Convert the photo to binary data
        $photo = '';

        if ($photo_error === UPLOAD_ERR_OK) {
            $photo = file_get_contents($photo_tmp_name);
            $photo = addslashes($photo);
        }

        // Update the product details in the database
        $query = "UPDATE products SET product_name = '$name', category = '$category', selling = '$sellingPrice', balance = '$balance', productphoto = '$photo' WHERE productid = '$productId'";
        $result = mysqli_query($connection, $query);

        if ($result) {
            return true; // Product updated successfully
        } else {
            return false; // Failed to update the product
        }
    }


    public function addProduct($productData)
    {
        $connection = $this->getConnection();

        // Retrieve form data
        $product_name = $productData['product_name'];
        $product_code = $productData['product_code'];
        $type = $productData['type'];
        $category = $productData['category'];
        $uom = $productData['uom'];
        $cost = $productData['cost'];
        $selling = $productData['selling'];
        $balance = $productData['balance'];
        $productphoto = $productData['productphoto'];

        // Convert the photo to binary data
        $photo = '';

        if ($productphoto['error'] === UPLOAD_ERR_OK) {
            $photo_tmp_name = $productphoto['tmp_name'];
            $photo = file_get_contents($photo_tmp_name);
            $photo = addslashes($photo);
        }

        // Assuming the table name is 'products'
        $query = "INSERT INTO products (product_name, product_code, type, category, uom, cost, selling, balance, productphoto) 
            VALUES ('$product_name', '$product_code', '$type', '$category', '$uom', '$cost', '$selling', '$balance', '$photo')";

        $result = mysqli_query($connection, $query);

        if ($result) {
            return true; // Data added successfully
        } else {
            return false; // Error occurred while inserting data
        }
    }

    public function getProductIdByController($productId)
    {
        $connection = $this->getConnection();

        // Assuming the table name is 'products'
        $query = "SELECT productid FROM products WHERE productid = ?";
        $statement = mysqli_prepare($connection, $query);

        if ($statement) {
            mysqli_stmt_bind_param($statement, 'i', $productId);
            mysqli_stmt_execute($statement);

            mysqli_stmt_bind_result($statement, $result);

            if (mysqli_stmt_fetch($statement)) {
                return $result;
            }
        }

        return false;
    }

    public function getProductById($productId)
    {
        $connection = $this->getConnection();
    
        // Assuming the table name is 'products'
        $query = "SELECT productid, product_name, category, selling, balance, productphoto FROM products WHERE productid = ?";
        $statement = mysqli_prepare($connection, $query);
    
        if ($statement) {
            mysqli_stmt_bind_param($statement, 'i', $productId);
            mysqli_stmt_execute($statement);
    
            mysqli_stmt_bind_result($statement, $productid, $product_name, $category, $selling, $balance, $productphoto);
    
            if (mysqli_stmt_fetch($statement)) {
                // Handle the productphoto column
                $productphoto = base64_encode($productphoto);
    
                $result = [
                    'productid' => $productid,
                    'product_name' => $product_name,
                    'category' => $category,
                    'selling' => $selling,
                    'balance' => $balance,
                    'productphoto' => $productphoto
                ];
    
                return $result;
            }
        }
    
        return false;
    }
    

}
