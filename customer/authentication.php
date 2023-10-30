<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once('../config/Database.php');
include_once('../objects/Customer.php');

use Firebase\JWT\JWT;
require_once('../vendor/autoload.php');

$database = new Database();
$pdo = $database->getConnection();
$customer = new Customer($pdo);

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->email) && !empty($data->password)) {
    $customer->email = $data->email;
    $customer->password = $data->password;

    if($customer->customerAuthentication()){
        $secret_key = 'JHxfxTlUMhyA7FLi81Hk0kis4w0RDBWOqEZWPCiG63k=';
        $date = new DateTimeImmutable();
        $expire_at = $date->modify('+6 minutes')->getTimestamp();
        $domainName = 'localhost';
        $username = $customer->name;
        $request_data = [
            'iat'=>$date->getTimestamp(),
            'iss'=>$domainName,
            'nbf'=>$date->getTimestamp(),
            'exp'=>$expire_at,
            'userName'=>$username
        ];

        echo JWT::encode(
            $request_data,
            $secret_key,
            'HS512'
        );
    }else {
        http_response_code(500);
        echo json_encode([
            "message"=>"Invalid Username & Password"
        ]);
    }
}else {
    http_response_code(501);
    echo json_encode([
        "message"=>"Invalid Username and Password"
    ]);
}