<?php
// Headers for GET Request
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-type,Access-Control-Allow-Origin, Authorization, X-Requested-With");

include_once("../../config/Database.php");
include_once("../../models/Setting.php");


// Instantiate DB and Connect to It
$database = new Database();
$db = $database->connect();

// Instantiate setting object
$setting = new Setting($db);

// Get raw POSTed data
$data = file_get_contents("php://input") != null ? json_decode(file_get_contents("php://input")) : die();


$setting->id = $data->id;

if ($setting->delete()) {
    echo json_encode(["message" => "✅ Setting Deleted!"]);
} else {
    echo json_encode(["message" => "❌ Cannot Delete The Setting!"]);
}
