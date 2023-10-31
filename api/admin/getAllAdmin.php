<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once('../../config/Database.php');
include_once('../../objects/Admin.php');

$database = new Database();
$pdo = $database->getConnection();
$admin = new Admin($pdo);

$stmt = $admin->getAdminList();
$num = $stmt->rowCount();

if($num >0){
    $admin_arr = [];
    $admin_arr["records"] = array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $admin_list = [
            "id" => $id,
            "name" => $name,
            "email" => $email,
            "password" => $password,
        ];

        array_push($admin_arr["records"], $admin_list);
    }

    http_response_code(200);

    echo json_encode($admin_arr);
} else {
    http_response_code(400);
    echo json_encode([
        "message"=> "Unable to Get admin list, No admin"
    ]);
}