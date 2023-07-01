<?php
class Supplier extends Connection
{
    public function getSuppliers()
    {
        $connection = $this->getConnection();

        // Assuming the table name is 'suppliers'
        $query = "SELECT supplierid, supplierName, supplierAddress, supplierTelNo FROM suppliers";
        $result = mysqli_query($connection, $query);

        if ($result) {
            $suppliers = array();

            while ($row = mysqli_fetch_assoc($result)) {
                $suppliers[] = $row;
            }

            // Return the array of suppliers
            return $suppliers;
        } else {
            // Handle the query error
            return false;
        }
    }
}
?>