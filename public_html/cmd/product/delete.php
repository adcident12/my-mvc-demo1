<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');

$part = str_replace("cmd/product", "", __DIR__);
require_once realpath($part . "/controllers/product/products_controller.php");

$products = new ProductsController();

$param = array();
$param["id"] = isset($_POST["id"]) && !empty($_POST["id"]) ? $_POST["id"] : "";

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
    if ($products->deleteProduct()) {
        http_response_code(200);
        echo json_encode(
            array(
                "code" => 200,
                "status" => "success",
                "title" => "Good job!",
                "message" => "You was delete successfully."
            )
        );
    } else {
        http_response_code(200);
        echo json_encode(
            array(
                "code" => 204,
                "status" => "error",
                "title" => "Oops...",
                "message" => "You was not delete successfully. Please try again"
            )
        );
    }
}
