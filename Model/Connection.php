<?php

class Connection {
    protected $servername;
    protected $username;
    protected $password;
    protected $database;

    protected $connection;

    public function __construct() {
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->database = "megah";
        $this ->connection = mysqli_connect($this->servername, $this->username, $this->password, $this->database);
    }

    protected function getConnection() {
        if (!$this->connection) {
            die("Error connect server :" .mysqli_connect_error());
        } else {
            return $this->connection;
        }
    }
}

?>