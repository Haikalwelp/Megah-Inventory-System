<?php
require_once "../config/autoload.php";

class UserController extends User {
    public function getUserController($email, $password) {
        return $this->getUser($email, $password);
    }

    public function getAllUsersController() {
        return $this->getAllUsers();
    }

    public function addUserController($username, $email, $password) {
        return $this->addUser($username, $email, $password);
    }

    public function getUserByIdController($userId)
    {
        return $this->getUserById($userId);
    }

    public function insertUserByIdController($userId, $email, $password, $username) {
        return $this->insertUserbyId($userId, $email, $password, $username);
    }
}



?>