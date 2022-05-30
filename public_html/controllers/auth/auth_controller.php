<?php
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
// เรียกใช้งานทุกครั้งก่อนจะ extends class controller
$part_include = str_replace("controllers/auth", "", __DIR__);
require_once realpath($part_include . "/controllers/controller.php");

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class AuthController extends Controller
{

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
        $part = str_replace("controllers/auth", "", __DIR__);

        //เรียกใช้งาน model customers
        require_once realpath($part . "/model/auth_customers_model.php");

        //เรียกใช้งาน model admins
        require_once realpath($part . "/model/auth_admins_model.php");
    }

    public function auth($user)
    {
        $iat = time();
        $exp = $iat + 60 * 60;
        $payload = array(
            'iss' => 'http://localhost/',
            'aud' => 'http://localhost/',
            'iat' => $iat,
            'exp' => $exp
        );
        $jwt = JWT::encode($payload, $this->key, 'HS256');
        return array(
            'id' => json_decode($user)->id,
            'usename' => json_decode($user)->username,
            'token' => $jwt,
            'expires' => $exp
        );
    }

    public function register()
    {
        $this->result = null;
        try {
            if ($this->role == "customer") {
                $auth = new AuthCustomersModel($this->db);
                $auth->username = $this->username;
                $auth->password = password_hash($this->password, PASSWORD_DEFAULT);
            } else {
                $auth = new AuthAdminsModel($this->db);
                $auth->username = $this->username;
                $auth->password = password_hash($this->password, PASSWORD_DEFAULT);
            }
            $this->result = $auth->insert();
        } catch (\Exception $e) {
            $this->result = false;
        }
        return $this->result;
    }

    public function getAuthByUsername()
    {
        $this->result = null;
        try {
            if ($this->role == "customer") {
                $auth = new AuthCustomersModel($this->db);
                $auth->username = $this->username;
            } else {
                $auth = new AuthAdminsModel($this->db);
                $auth->username = $this->username;
            }
            $this->result = $auth->getByUsername();
        } catch (\Exception $e) {
            $this->result = false;
        }
        return $this->result;
    }
}
