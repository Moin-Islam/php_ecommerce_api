<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once('../config/Database.php');
include_once('../objects/Blog.php');

$database = new Database();
$pdo = $database->getConnection();
$blog = new Blog($pdo);

$data = json_decode(file_get_contents("php://input"));

$blog->id = $data->id;
$blog->title = $data->title;
$blog->content = $data->content;

if ($blog->updateBlog()){
    http_response_code(200);
    echo json_encode([
        "message"=>"Updated The Blog Successfully"
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        "message"=> "Unable to Update The Blog"
    ]);
}