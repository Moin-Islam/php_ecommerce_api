<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once('../../config/Database.php');
include_once('../../objects/Product.php');

$database = new Database();
$pdo = $database->getConnection();
$product = new Product($pdo);

$data = json_decode(file_get_contents("php://input"));

//var_dump($data);
$product->tag = $data->tag;

$stmt = $product->getItemByTag();
$num = $stmt->rowCount();

if ($num > 0){
    $product_arr = [];
    $product_arr["records"] = array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        extract($row);

        $product_item = [
            "id" => $id,
            "name"=> $name,
            "price"=> $price,
            "description"=> $description,
            "image"=>$image,
            "quantity"=> $quantity,
            "size"=> $size,
            "tag" => $tag
        ];

        array_push($product_arr["records"],$product_item);
    }

    http_response_code(200);
    echo json_encode($product_arr);
}else{
    http_response_code(400);
    echo json_encode([
        "message"=> "No such item for that tag"
    ]);
}