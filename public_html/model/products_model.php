<?php
class ProductsModel
{
    private $conn;
    private $db_table = "products";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        try {
            $query = "SELECT * FROM " . $this->db_table . " ORDER BY updated_at DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getById($id)
    {
        try {
            $query = "SELECT * FROM " . $this->db_table . " WHERE id= :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return $stmt;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function update()
    {
        try {
            $query = "UPDATE " . $this->db_table . " SET name= :name, description= :description, short_description= :short_description, price = :price WHERE id= :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":short_description", $this->short_description);
            $stmt->bindParam(":price", $this->price);
            $stmt->bindParam(":id", $this->id);
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

    public function insert()
    {
        try {
            $query = "INSERT INTO " . $this->db_table . " (name, description, short_description, price) VALUES (:name, :description, :short_description, :price)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":short_description", $this->short_description);
            $stmt->bindParam(":price", $this->price);
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
        try {
            $query = "DELETE FROM " . $this->db_table . " WHERE id= :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $this->id);
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
}
