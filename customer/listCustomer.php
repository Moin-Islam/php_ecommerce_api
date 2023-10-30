<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once('../config/Database.php');
include_once('../objects/Customer.php');

$database = new Database();
$pdo = $database->getConnection();
$customer = new Customer($pdo);

$stmt = $customer->allCustomer();
$num = $stmt->rowCount();

if($num>0){
    $customer_arr = [];
    $customer_arr['records'] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $customer_list = [
            "id"=> $id,
            "name"=> $name,
            "email"=> $email,
            "password"=> $password,
            "phone"=> $phone,
            "shipping_address"=> $shipping_address,
            "billing_address"=> $billing_address
        ];

        array_push($customer_arr["records"],$customer_list);
    }

    http_response_code(200);
    echo json_encode($customer_arr);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No customer Found")
    );
}