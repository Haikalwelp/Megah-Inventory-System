<?php
require_once "../config/autoload.php";

class ProductController extends Product
{
    public function getProductsController()
    {
        return $this->getProducts();
    }

    public function deleteProductsController($productIds)
    {
        return $this->deleteProducts($productIds);
    }

    public function editProductController($oldProductId, $newProductId, $name, $category, $sellingPrice, $balance, $productPhoto)
    {
        return $this->editProduct($oldProductId, $newProductId, $name, $category, $sellingPrice, $balance, $productPhoto);
    }

    public function addProductController($productData)
    {
        return $this->addProduct($productData);
    }

    public function getProductIdByController($productId)
    {
        return $this->getProductIdByController($productId);
    }

    public function getProductByIdController($productId)
    {
        return $this->getProductById($productId);
    }

    public function getProductIdBySupplierIDController($supplierID)
    {
        return $this->getProductIdBySupplierID($supplierID);
    }
}
?>
