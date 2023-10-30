<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once('../config/Database.php');
include_once('../objects/Blog.php');

$database = new Database();
$pdo = $database->getConnection();
$blog = new Blog($pdo);

$stmt = $blog->getBlog();
$num = $stmt->rowCount();

if ($num>0) {
    $blog_arr = [];
    $blog_arr["records"] = array();

    while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ){
        extract($row);

        $blog_list = [
            "id"=>$id,
            "title"=> $title,
            "content"=> $content,
        ];

        array_push($blog_arr["records"],$blog_list);
    }

    http_response_code(200);
    echo json_encode($blog_arr);
}else {
    http_response_code(405);
    echo json_encode([
        "message"=>"No Blogs Found"
    ]);
}