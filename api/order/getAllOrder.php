<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once('../../config/Database.php');
include_once('../../objects/Order.php');

$database = new Database();
$pdo = $database->getConnection();
$order = new Order($pdo);

$stmt = $order->getAllOrder();
$num = $stmt->rowCount();

if($num > 0) {
    $order_arr = [];
    $order_arr["records"] = array();

    while( $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);


        $order_list = [
            "id"=> $id,
            "admin_id"=>$admin_id,
            "customer_id" => $customer_id,
            "order_date" => $order_date,
            "order_total" => $order_total,
            "order_status" => $order_status,
            "created_at" => $created_at
        ];
        array_push($order_arr["records"], $order_list);
    }

    http_response_code(200);
    echo json_encode($order_arr);
} else {
    http_response_code(400);
    echo json_encode([
        "message" => "Unable fetch any order, No ORDER EXISTS!"
    ]);
}