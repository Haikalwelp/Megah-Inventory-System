<?php
require_once "../config/autoload.php";
class AdminController extends Admin {

    public function getAdminController($email, $password) {
            return $this->getAdmin($email, $password);
    }

    public function getAdminByIdController($adminId)
    {
        return $this->getAdminById($adminId);
    }

    public function insertAdminController($adminId, $adminEmail, $adminPassword, $adminUser) {
        return $this->insertAdmin($adminId, $adminEmail, $adminPassword, $adminUser);
    }
}



?>