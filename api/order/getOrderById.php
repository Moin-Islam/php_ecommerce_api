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

$order->getOrderById();

if($order->admin_id != null)
{
    $order_arr = [
        "id" => $order->id,
        "admin_id"=> $order->admin_id,
        "customer_id"=> $order->customer_id,
        "order_date" => $order->order_date,
        "order_total" => $order->order_total,
        "order_status" => $order->order_status,
        "created_at" => $order->created_at
    ];

    http_response_code(200);
    echo json_encode($order_arr);
} else {
    http_response_code(400);
    echo json_encode([
        "message"=> "Unable to fetch the order, it doesn't exist"
    ]);
}