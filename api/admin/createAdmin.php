<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once('../../config/Database.php');
include_once('../../objects/Admin.php');

$database = new Database();
$pdo = $database->getConnection();
$admin = new Admin($pdo);

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->name) && !empty($data->email) && !empty($data->password)) {
    $admin->name = $data->name;
    $admin->email = $data->email;
    $admin->password = $data->password;

    if($admin->createAdmin()){
        http_response_code(200);
        echo json_encode([
            "message"=> "Successfully New Admin Created"
        ]);
    }else {
        http_response_code(5001);
        echo json_encode([
            "message"=> "Unable to create new admin"
        ]);
    }
}else {
    http_response_code(400);
    echo json_encode([
        "message"=> "Unable to create new admin please input valid email and password"
    ]);
}