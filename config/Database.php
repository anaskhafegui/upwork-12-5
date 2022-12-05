<?php
class Database
{

    private $host = "45.84.204.1:3306";
    private $username = "u177344557_crm";
    private $password = "Travis@2022";
    private $dbname = "u177344557_crm";
    private $conn;

    // Connect to the Database
    public function connect()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);

            // get any error information while trying to connect
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
        }

        return $this->conn;
    }
}
