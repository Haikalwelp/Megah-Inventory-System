<?php
class User extends Connection
{
    public function getUser($email, $password)
    {
        $connection = $this->getConnection();

        $query = "SELECT * FROM user WHERE userEmail = '$email' AND userPassword = '$password'";

        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) == 0) {
            return false;
        } else {
            return $result;
        }
    }

    public function getAllUsers()
    {
        $connection = $this->getConnection();

        $query = "SELECT * FROM user";

        $result = mysqli_query($connection, $query);

        if (!$result) {
            return false;
        } else {
            return $result;
        }
    }

    public function addUser($username, $email, $password)
    {
        $connection = $this->getConnection();

        $query = "INSERT INTO user (username, userEmail, userPassword) VALUES ('$username', '$email', '$password')";

        $result = mysqli_query($connection, $query);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserById($userId)
    {
        $connection = $this->getConnection();

        $query = "SELECT * FROM user WHERE userid = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); 
        } else {
            return false;
        }
    }

    public function insertUserbyId($userId, $email, $password, $username)
    {
        $connection = $this->getConnection();

        $query = "UPDATE user SET userEmail = '$email', userPassword = '$password', username = '$username' WHERE userid = $userId";

        $result = mysqli_query($connection, $query);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

}

?>