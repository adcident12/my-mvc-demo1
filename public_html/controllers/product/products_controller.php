<?php
// เรียกใช้งานทุกครั้งก่อนจะ extends class controller
$part_include = str_replace("controllers/product", "", __DIR__);
require_once realpath($part_include . "/controllers/controller.php");

class ProductsController extends Controller
{
    private $db;
    private $result;

    public function __construct()
    {
        //เรียกใช้งาน __construct ใน class controller
        parent::__construct();

        //เรียกใช้งาน class database ที่สร้างขึ้นในคลาส controller
        $this->db = $this->connect();

        //replace พาท ก่อนใช้งานคลาส model
        $part = str_replace("controllers/product", "", __DIR__);

        //เรียกใช้งาน model
        require_once realpath($part . "/model/products_model.php");
    }

    public function getProductAll()
    {
        $this->result = null;
        try {
            $product = new ProductsModel($this->db);
            $this->result = $product->getAll();
        } catch (\Exception $e) {
            $this->result = false;
        }
        return $this->result;
    }

    public function getProductById()
    {
        $this->result = null;
        try {
            $product = new ProductsModel($this->db);
            $this->result = $product->getById($this->id);
        } catch (\Exception $e) {
            $this->result = false;
        }
        return $this->result;
    }

    public function insertProduct()
    {
        $this->result = null;
        try {
            $product = new ProductsModel($this->db);
            $product->name = $this->name;
            $product->description = $this->description;
            $product->short_description = $this->short_description;
            $product->price = $this->price;
            $this->result = $product->insert();
        } catch (\Exception $e) {
            $this->result = false;
        }
        return $this->result;
    }

    public function updateProduct()
    {
        $this->result = null;
        try {
            $product = new ProductsModel($this->db);
            $product->id = $this->id;
            $product->name = $this->name;
            $product->description = $this->description;
            $product->short_description = $this->short_description;
            $product->price = $this->price;
            $this->result = $product->update();
        } catch (\Exception $e) {
            $this->result = false;
        }
        return $this->result;
    }

    public function deleteProduct()
    {
        $this->result = null;
        try {
            $product = new ProductsModel($this->db);
            $product->id = $this->id;
            $this->result = $product->delete();
        } catch (\Exception $e) {
            $this->result = false;
        }
        return $this->result;
    }
}
