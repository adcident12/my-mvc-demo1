<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: GET');

$part = str_replace("cmd/product", "", __DIR__);
require_once realpath($part . "/controllers/product/products_controller.php");

$products = new ProductsController();

$param = array();
$param["id"] = isset($_GET["id"]) && !empty($_GET["id"]) ? $_GET["id"] : "";

$data = json_encode($param);
$data = json_decode($data);
$products->id = $data->id;

if ($data->id == '') {
    http_response_code(200);
    echo json_encode(
        array(
            "code" => 204,
            "status" => "error",
            "title" => "Oops...",
            "message" => "You didn't enter your id. Please try again."
        )
    );
} else {
    $stmt = $products->getProductById();
    if ($stmt) {
        $resultCount = $stmt->rowCount();
        if ($resultCount > 0) {
            http_response_code(200);
            $arr = array();
            $arr['response'] = array();
            $arr['count'] = $resultCount;
            $arr['code'] = 200;
            $arr['status'] = "success";
            $arr['message'] = $resultCount . " records";

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $e = $row;
                array_push($arr['response'], $e);
            }
            echo json_encode($arr);
        } else {
            http_response_code(200);
            echo json_encode(
                array(
                    "response" => array(),
                    "count" => 0,
                    "code" => 400,
                    "status" => "error",
                    "title" => "Oops...",
                    "message" => "No records found.",
                )
            );
        }
    } else {
        http_response_code(200);
        echo json_encode(
            array(
                "code" => 400,
                "status" => "error",
                "title" => "Oops...",
                "message" => "Please contact an Developer."
            )
        );
    }
}
