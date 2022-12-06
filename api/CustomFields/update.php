<?php
// Headers for GET Request
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-type,Access-Control-Allow-Origin, Authorization, X-Requested-With");

include_once("../../config/Database.php");
include_once("../../models/CustomFields.php");
include_once("../../Helpers.php");


// Instantiate DB and Connect to It
$database = new Database();
$db = $database->connect();


// Instantiate customfield object
$customfield = new CustomFields($db);

// Get raw POSTed data
$data = file_get_contents("php://input") != null ? json_decode(file_get_contents("php://input")) : die();

$customfield->id = $data->id;
$customfield->fieldname = $data->fieldname;
$customfield->user = $data->user;
$customfield->timestamp = $data->timestamp;


try {
    $customfield->update();
    echo Helpers::responsejson(200,"✅ Custom Field Updated!",$customfield);
} catch(Exception $exception) {
    echo Helpers::responsejson(200,"❌ Cannot Update Custom Field!",$exception->getMessage());
}