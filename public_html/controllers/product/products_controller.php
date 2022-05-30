<?php
// เรียกใช้งานทุกครั้งก่อนจะ extends class controller
$part_include = str_replace("controllers/product", "", __DIR__);
require_once realpath($part_include . "/controllers/controller.php");

class ProductsController extends controller
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
}
