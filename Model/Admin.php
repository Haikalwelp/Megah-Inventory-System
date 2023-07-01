<?php

class Admin extends Connection
{
    public function getAdmin($email, $password)
    {
        $connection = $this->getConnection();

        $query = "SELECT * FROM admin WHERE adminEmail = '$email' AND adminPassword = '$password'";

        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) == 0) {
            return false;
        } else {
            return $result;
        }
    }

    public function getAllAdmin()
    {
        $connection = $this->getConnection();

        $query = "SELECT * FROM admin";

        $result = mysqli_query($connection, $query);

        if (!$result) {
            return false;
        } else {
            return $result;
        }
    }

    public function getAdminById($adminId) {
        $connection = $this->getConnection();
    
        $query = "SELECT * FROM admin WHERE adminid = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $adminId);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Return the admin data as an associative array
        } else {
            return false;
        }

}

public function insertAdmin($adminId, $adminEmail, $adminPassword, $adminUser)
    {
        $connection = $this->getConnection();

        $query = "UPDATE admin SET adminEmail = ?, adminPassword = ?, adminUser = ? WHERE adminid = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("sssi", $adminEmail, $adminPassword, $adminUser, $adminId);
        
        if ($stmt->execute()) {
            return true; // Admin updated successfully
        } else {
            return false; // Failed to update admin
        }
    }

}
?>