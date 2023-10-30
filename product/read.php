<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once('../config/Database.php');
include_once('../objects/Product.php');

$database = new Database();
$pdo = $database->getConnection();
$product = new Product($pdo);

$stmt = $product->read();
$num = $stmt->rowCount();
//print_r($stmt->fetch(PDO::FETCH_ASSOC));
//Die();

if($num > 0){
    $products_arr = [];
    $products_arr["records"] = array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $product_item = [
            "id" => $id,
            "name"=> $name,
            "price"=> $price,
            "description"=> $description,
            "image"=>$image,
            "quantity"=> $quantity,
            "size"=> $size,
        ];

        array_push($products_arr["records"], $product_item);
    }

    http_response_code(200);
    print_r($products_arr);

    echo json_encode($products_arr);
} else {
    http_response_code(404);

    echo json_encode(
        array("message"=> "No Products Found")
    );
}

