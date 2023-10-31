<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once('../../config/Database.php');
include_once('../../objects/Order.php');

$database = new Database();
$pdo = $database->getConnection();
$order = new Order($pdo);

$data = json_decode(file_get_contents("php://input"));

$order->id = $data->id;
$order->admin_id = $data->admin_id;
$order->customer_id = $data->customer_id;
$order->order_total = $data->order_total;
$order->order_status = $data->order_status;

if($order->updateOrder()){
    http_response_code(200);
    echo json_encode([
        "message"=> "Successfully updated the order"
    ]);
}else {
    http_response_code(500);
    echo json_encode([
        "message"=> "Unable to update the order"
    ]);
}