<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once('../config/Database.php');
include_once('../objects/Customer.php');

$database = new Database();
$pdo = $database->getConnection();
$customer = new Customer($pdo);

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->name) && !empty($data->email) && !empty($data->password) && !empty($data->phone) && !empty($data->shipping_address) && !empty($data->billing_address)) {
    $customer->name = $data->name;
    $customer->email = $data->email;
    $customer->password = $data->password;
    $customer->phone = $data->phone;
    $customer->shipping_address = $data->shipping_address;
    $customer->billing_address = $data->billing_address;

    if($customer->create()){
        http_response_code(200);
        echo json_encode([
            "message"=>"New Customer Added"
        ]);
    }else {
        http_response_code(401);

        echo json_encode([
            "message"=> "Unable to create new customer"
        ]);
    }
}else {
    http_response_code(400);

    echo json_encode([
        "message"=> "Unable to get customer data to create new customers"
    ]);
}