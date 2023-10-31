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

if (!empty($data->admin_id) && !empty($data->customer_id)  && !empty($data->order_total) 
    && !empty($data->order_status)){
    
   $order->admin_id = $data->admin_id;
   $order->customer_id = $data->customer_id;
   $order->order_status = $data->order_status;
   $order->order_total = $data->order_total;

   if($order->createOrder()){
        http_response_code(200);
        echo json_encode([
            "message"=> "New Order created at"
        ]);
   }else {
        http_response_code(500);
        echo json_encode([
            "message"=> "Unable to create new Order"
        ]);
   }

}else {
    http_response_code(400);
    echo json_encode([
        "message" => "Please give proper order inputs"
    ]);
}