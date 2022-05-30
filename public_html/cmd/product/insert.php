<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');

$part = str_replace("cmd/product", "", __DIR__);
require_once realpath($part . "/controllers/product/products_controller.php");

$products = new ProductsController();

$param = array();
$param["name"] = isset($_POST["name"]) && !empty($_POST["name"]) ? $_POST["name"] : "";
$param["description"] = isset($_POST["description"]) && !empty($_POST["description"]) ? $_POST["description"] : "";
$param["short_description"] = isset($_POST["short_description"]) && !empty($_POST["short_description"]) ? $_POST["short_description"] : "";
$param["price"] = isset($_POST["price"]) && !empty($_POST["price"]) ? $_POST["price"] : "";

$data = json_encode($param);
$data = json_decode($data);
$products->name = $data->name;
$products->description = $data->description;
$products->short_description = $data->short_description;
$products->price = $data->price;

if ($data->name == '') {
    http_response_code(200);
    echo json_encode(
        array(
            "code" => 204,
            "status" => "error",
            "title" => "Oops...",
            "message" => "You didn't enter your Product name. Please try again"
        )
    );
} else if ($data->description == '') {
    http_response_code(200);
    echo json_encode(
        array(
            "code" => 204,
            "status" => "error",
            "title" => "Oops...",
            "message" => "You didn't enter your description. Please try again"
        )
    );
} else if ($data->short_description == '') {
    http_response_code(200);
    echo json_encode(
        array(
            "code" => 204,
            "status" => "error",
            "title" => "Oops...",
            "message" => "You didn't enter your short description. Please try again"
        )
    );
} else if ($data->price == '') {
    http_response_code(200);
    echo json_encode(
        array(
            "code" => 204,
            "status" => "error",
            "title" => "Oops...",
            "message" => "You didn't enter your price. Please try again"
        )
    );
} else {
    if ($products->insertProduct()) {
        http_response_code(200);
        echo json_encode(
            array(
                "code" => 200,
                "status" => "success",
                "title" => "Good job!",
                "message" => "You was insert successfully."
            )
        );
    } else {
        http_response_code(200);
        echo json_encode(
            array(
                "code" => 400,
                "status" => "error",
                "title" => "Oops...",
                "message" => "You was not insert successfully. Please try again."
            )
        );
    }
}
