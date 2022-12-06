<?php
// Headers for GET Request
header("Access-Control-Allow-Origin: *");
header("Content-type: applisettingion/json");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-type,Access-Control-Allow-Origin, Authorization, X-Requested-With");

include_once("../../config/Database.php");
include_once("../../models/Setting.php");
include_once("../../Helpers.php");


// Instantiate DB and Connect to It
$database = new Database();
$db = $database->connect();


// Instantiate Setting object
$setting = new Setting($db);

// Get raw data
$data = file_get_contents("php://input") != null ? json_decode(file_get_contents("php://input")) : die();

$setting->id = $data->id;
$setting->type = $data->type;
$setting->value = $data->value;
$setting->user = $data->user;
$setting->timestamp = $data->timestamp;


try {
    $setting->update();
    echo Helpers::responsejson(200,"✅ Setting Updated!",$setting);
} catch(Exception $exception) {
    echo Helpers::responsejson(200,"❌ Cannot Update Setting!",$exception->getMessage());
}