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
$product->id = $data->id;

$product->readOne();

if($product->name != null){
    $product_arr = [
        "id" => $product->id,
        "name" => $product->name,
        "price"=> $product->price,
        "description"=> $product->description,
        "image"=> $product->image,
        "quantity"=> $product->quantity,
        "size"=> $product->size,
        "tag"=> $product->tag,
    ];

    http_response_code(200);

    echo json_encode($product_arr);
} else {
    http_response_code(400);

    echo json_encode([
        "message"=> "Product not found"
    ]);
}