<?php

class database {
    const host = 'localhost';
    const username = 'root';
    const password = 'Admin@123';
    const db = 'store';

    protected $conn;

    public function __construct()
    {
        $this->conn = mysqli_connect(self::host, self::username, self::password, self::db);

        return $this->conn;
    }

    public function getConnection(){
        return $this->conn;
    }

}

?>