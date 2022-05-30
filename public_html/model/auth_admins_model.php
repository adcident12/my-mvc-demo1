<?php
class AuthAdminsModel
{
    private $conn;
    private $db_table = "admins";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
    }

    public function getById()
    {
    }

    public function getByUsername()
    {
        try {
            $query = "SELECT * FROM " .$this->db_table. " WHERE username= :username";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":username", $this->username);
            $stmt->execute();
            return $stmt;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function update()
    {
    }

    public function insert()
    {
        try {
            $query = "INSERT INTO " . $this->db_table . " (username, password) VALUES (:username, :password)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":username", $this->username);
            $stmt->bindParam(":password",$this->password);
            if ($stmt->execute()) {
                if ($stmt->rowCount()) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    public function delete()
    {
    }
}
