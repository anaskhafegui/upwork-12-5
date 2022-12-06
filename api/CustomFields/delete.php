<?php
// Headers for GET Request
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-type,Access-Control-Allow-Origin, Authorization, X-Requested-With");

include_once("../../config/Database.php");
include_once("../../models/CustomFields.php");
include_once("../../Helpers.php");


// Instantiate DB and Connect to It
$database = new Database();
$db = $database->connect();


// Instantiate blog post object
$customfield = new CustomFields($db);

// Get raw customfield data
$data = file_get_contents("php://input") != null ? json_decode(file_get_contents("php://input")) : die();

$customfield->id = $data->id;

try {
    $customfield->delete();
    echo Helpers::responsejson(200,"✅ Custom Field Deleted!",[]);
} catch (Exception $error) {
    echo Helpers::responsejson(200,$error->getMessage(),[]);
}
