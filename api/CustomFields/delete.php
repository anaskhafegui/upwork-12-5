<?php
// Headers for GET Request
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-type,Access-Control-Allow-Origin, Authorization, X-Requested-With");

include_once("../../config/Database.php");
include_once("../../models/CustomFields.php");


// Instantiate DB and Connect to It
$database = new Database();
$db = $database->connect();


// Instantiate blog post object
$user = new CustomFields($db);

// Get raw usered data
$data = file_get_contents("php://input") != null ? json_decode(file_get_contents("php://input")) : die();

$user->id = $data->id;

try {
    $user->delete();
    echo json_encode(["message" => "✅ Custom Field Deleted!"]);
} catch (Exception $e) {
    echo json_encode(["message" => "Cannot Create User", "error" =>$e->errorInfo]);
}
