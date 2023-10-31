<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once('../../config/Database.php');
include_once('../../objects/Customer.php');

$database = new Database();
$pdo = $database->getConnection();
$customer = new Customer($pdo);

$data = json_decode(file_get_contents("php://input"));

$customer->id = $data->id;

if($customer->deleteCustomer()){
    http_response_code(200);
    echo json_encode([
        "message" => "Customer was deleted successfully"
    ]);
}else {
    http_response_code(500);

    echo json_encode([
        "message" => "Unable to delete customer, Customer doesn't exist!!"
    ]);
}