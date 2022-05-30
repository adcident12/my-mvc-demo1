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

    public function getById()
    {
    }

    public function update()
    {
    }

    public function insert()
    {
    }

    public function delete()
    {
    }
}
