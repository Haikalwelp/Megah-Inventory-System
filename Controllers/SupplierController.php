<?php
require_once "../config/autoload.php";

class SupplierController extends Supplier
{
    public function getSuppliersController()
    {
        return $this->getSuppliers();
    }
}

?>