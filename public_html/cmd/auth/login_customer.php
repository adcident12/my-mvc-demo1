<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');

$part = str_replace("cmd/auth", "", __DIR__);
require_once realpath($part . "/controllers/auth/auth_controller.php");

$auths = new AuthController();

$param = array();
$param["username"] = isset($_POST["username"]) && !empty($_POST["username"]) ? $_POST["username"] : "";
$param["password"] = isset($_POST["password"]) && !empty($_POST["password"]) ? $_POST["password"] : "";

$data = json_encode($param);
$data = json_decode($data);
$auths->username = $data->username;
$auths->password = $data->password;
$auths->role = "customer";

if ($data->username == '') {
    http_response_code(200);
    echo json_encode(
        array(
            "code" => 204,
            "status" => "error",
            "title" => "Oops...",
            "message" => "You didn't enter your username. Please try again"
        )
    );
} else if ($data->password == '') {
    http_response_code(200);
    echo json_encode(
        array(
            "code" => 204,
            "status" => "error",
            "title" => "Oops...",
            "message" => "You didn't enter your password. Please try again"
        )
    );
} else {
    $stmt = $auths->getAuthByUsername();
    if ($stmt) {
        $resultCount = $stmt->rowCount();
        if ($resultCount > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($data->password, $row["password"])) {
                $rs_auth = $auths->auth(json_encode($row));
                http_response_code(200);
                echo json_encode(
                    array(
                        "code" => 200,
                        "status" => "success",
                        "title" => "Good job!",
                        "message" => "You was register successfully.",
                        "response" => $rs_auth
                    )
                );
            } else {
                http_response_code(200);
                echo json_encode(
                    array(
                        "code" => 400,
                        "status" => "error",
                        "title" => "Oops...",
                        "message" => "Your password is incorrect. Please try again."
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
                    "message" => "You don't have an account. Please try again."
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
