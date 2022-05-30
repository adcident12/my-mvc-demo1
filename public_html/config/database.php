<?php
class Database
{
    private $host;
    private $database_name;
    private $username;
    private $password;

    public $conn;

    public function __construct($host, $database_name, $username, $password)
    {
        $this->host = $host;
        $this->database_name = $database_name;
        $this->username = $username;
        $this->password = $password;
    }

    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";
                    port=" . $this->port . ";
                    dbname=" . $this->database_name,
                $this->username,
                $this->password
            );
            $this->conn->exec("SET NAMES 'utf8';");
        } catch (PDOException $exception) {
            echo "Database could not be connection:" .
                $exception->getmessage();
        }
        return $this->conn;
    }
}
