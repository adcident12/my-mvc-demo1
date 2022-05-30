<?php

use AltoRouter as Router;

require_once realpath(__DIR__ . "/vendor/autoload.php");

$router = new Router();

// User routes
$router->map("GET", "/", function () {
    require __DIR__ . "/views/home.php";
});

$router->map("GET", "/about", function () {
    require __DIR__ . "/views/about.php";
});

$router->map("GET", "/categories", function () {
    require __DIR__ . "/views/categories.php";
});

$router->map("GET", "/products", function () {
    require __DIR__ . "/views/products.php";
});

$router->map("GET", "/products/detail/[i:product_id]", function ($product_id) {
    require __DIR__ . "/views/detail.php";
});


// Admin routes
$router->map("GET", "/admin", function () {
    require __DIR__ . "/views/admin/index.php";
});

$router->map("GET", "/admin/categories/[i:category_id]/[create|edit:mode]", function ($category_id, $mode) {
    require __DIR__ . "/views/admin/categories.php";
});

$router->map("GET", "/admin/products/[i:product_id]/[create|edit:mode]", function ($product_id, $mode) {
    require __DIR__ . "/views/admin/products.php";
});

//Api routes
$router->map("GET", "/api/v1/list", function () {
    require __DIR__ . "/cmd/product/get_list_all.php";
});

$router->map("POST", "/api/v1/list/[i:id]", function ($id) {
    require __DIR__ . "/cmd/product/get_by_id.php";
});

$router->map("POST", "/api/v1/product/create", function () {
    require __DIR__ . "/cmd/product/insert.php";
});

$router->map("POST", "/api/v1/product/edit", function () {
    require __DIR__ . "/cmd/product/update.php";
});

$router->map("POST", "/api/v1/product/delete", function () {
    require __DIR__ . "/cmd/product/delete.php";
});

$match = $router->match();

if (is_array($match) && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    require __DIR__ . "/views/404.php";
}
