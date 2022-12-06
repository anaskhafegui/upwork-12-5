<?php
// Headers for GET Request
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-type,Access-Control-Allow-Origin, Authorization, X-Requested-With");

include_once("../../config/Database.php");
include_once("../../models/Setting.php");


// Instantiate DB and Connect to It
$database = new Database();
$db = $database->connect();


// Instantiate Setting object
$setting = new Setting($db);

// Get raw POSTed data
$data = file_get_contents("php://input") != null ? json_decode(file_get_contents("php://input")) : die();

$setting->type = $data->type;
$setting->value = $data->value;
$setting->user = $data->user;
$setting->timestamp = $data->timestamp;

if ($setting->create()) {
    echo json_encode(["message" => "Setting Created Successfully"]);
} else {
    echo json_encode(["message" => "Cannot Create Category"]);
}
