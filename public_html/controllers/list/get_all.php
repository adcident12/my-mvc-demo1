<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: GET');


$part = str_replace("controllers/list", "", __DIR__);
require_once realpath($part . "/vendor/autoload.php");
$dotenv = Dotenv\Dotenv::createImmutable($part);
$dotenv->load();

include($part . "/config/database.php");
include($part . "/model/paging.php");
$database = new Database($_ENV['HOST'], $_ENV['DATABASE_NAME'], $_ENV['USERNAME'], $_ENV['PASSWORD']);
$db = $database->getConnection();

$result = new Paging($db);

$stmt = $result->getAll();
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
                "code" => 200,
                "status" => "success",
                "title" => "Good job!",
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
            "message" => "Please contact an Developer.",
        )
    );
}
