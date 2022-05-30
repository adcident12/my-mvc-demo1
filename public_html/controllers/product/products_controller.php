<?php
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
// เรียกใช้งานทุกครั้งก่อนจะ extends class controller
$part_include = str_replace("controllers/product", "", __DIR__);
require_once realpath($part_include . "/controllers/controller.php");

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class ProductsController extends Controller
{

    private $db;
    private $result;
    private $key;

    public function __construct()
    {
        //เรียกใช้งาน __construct ใน class controller
        parent::__construct();

        //เรียกใช้งาน class database ที่สร้างขึ้นในคลาส controller
        $this->db = $this->connect();

        //เซ็ตค่า key ในการ encode และ decode ในการเข้ารหัสข้อมูล
        $this->key = $_ENV['JWTKEY'];

        //replace พาท ก่อนใช้งานคลาส model
        $part = str_replace("controllers/product", "", __DIR__);

        //เรียกใช้งาน model
        require_once realpath($part . "/model/products_model.php");
    }

    public function getProductAll()
    {
        $headers = apache_request_headers();
        $this->result = null;
        if (isset($headers["authorization"])) {
            $token = str_replace('Bearer ', '', $headers['authorization']);
            try {
                $token = JWT::decode($token, new Key($this->key, 'HS256'));
                $product = new ProductsModel($this->db);
                $this->result = $product->getAll();
            } catch (\Exception $e) {
                $this->result = false;
            }
        } else {
            $this->result = false;
        }

        return $this->result;
    }

    public function getProductById()
    {
        $headers = apache_request_headers();
        $this->result = null;
        if (isset($headers["authorization"])) {
            $token = str_replace('Bearer ', '', $headers['authorization']);
            try {
                $token = JWT::decode($token, new Key($this->key, 'HS256'));
                $product = new ProductsModel($this->db);
                $this->result = $product->getById($this->id);
            } catch (\Exception $e) {
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
        return $this->result;
    }

    public function insertProduct()
    {
        $headers = apache_request_headers();
        $this->result = null;
        if (isset($headers["authorization"])) {
            $token = str_replace('Bearer ', '', $headers['authorization']);
            try {
                $token = JWT::decode($token, new Key($this->key, 'HS256'));
                $product = new ProductsModel($this->db);
                $product->name = $this->name;
                $product->description = $this->description;
                $product->short_description = $this->short_description;
                $product->price = $this->price;
                $this->result = $product->insert();
            } catch (\Exception $e) {
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
        return $this->result;
    }

    public function updateProduct()
    {
        $headers = apache_request_headers();
        $this->result = null;
        if (isset($headers["authorization"])) {
            $token = str_replace('Bearer ', '', $headers['authorization']);
            try {
                $token = JWT::decode($token, new Key($this->key, 'HS256'));
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
        } else {
            $this->result = false;
        }
        return $this->result;
    }

    public function deleteProduct()
    {
        $headers = apache_request_headers();
        $this->result = null;
        if (isset($headers["authorization"])) {
            $token = str_replace('Bearer ', '', $headers['authorization']);
            try {
                $token = JWT::decode($token, new Key($this->key, 'HS256'));
                $product = new ProductsModel($this->db);
                $product->id = $this->id;
                $this->result = $product->delete();
            } catch (\Exception $e) {
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
        return $this->result;
    }
}
