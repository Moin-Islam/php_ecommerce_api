<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once('../../config/Database.php');
include_once('../../objects/Product.php');

$database = new Database();
$pdo = $database->getConnection();
$product = new Product($pdo);

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->name) && !empty($data->price) && !empty($data->description) && !empty($data->image) && !empty($data->quantity) && !empty($data->size)) {
    $product->name = $data->name;
    $product->price = $data->price;
    $product->description = $data->description;
    $product->image = $data->image;
    $product->quantity = $data->quantity;
    $product->size = $data->size;
    $product->tag = $data->tag;

    if($product->create()){
        http_response_code(201);

        echo json_encode([
            "message" => "The Product was Created"
        ]);
    }else {
        http_response_code(503);

        echo json_encode([
            "message"=> "Product creation failed"
        ]);
    }
} else {
    http_response_code(400);

    echo json_encode(array("message"=> "Unable to create the product. Data is incomplete"));
}