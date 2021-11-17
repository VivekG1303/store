<?php

class database {
    const HOST = 'localhost';
    const USERNAME = 'root';
    const PASSWORD = 'Admin@123';
    const DB = 'store';

    protected $conn;

    public function __construct()
    {
        $this->conn = mysqli_connect(self::HOST, self::USERNAME, self::PASSWORD, self::DB);

        return $this->conn;
    }

    public function getConnection(){
        return $this->conn;
    }

}

?>