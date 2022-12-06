<?php
// Headers for GET Request
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-type,Access-Control-Allow-Origin, Authorization, X-Requested-With");

include_once("../../config/Database.php");
include_once("../../models/User.php");
include_once("../../Helpers.php");


// Instantiate DB and Connect to It
$database = new Database();
$db = $database->connect();


// Instantiate user object
$user = new User($db);

// Get raw POSTed data
$data = file_get_contents("php://input") != null ? json_decode(file_get_contents("php://input")) : die();

$user->id = $data->id;
$user->email = $data->email;
$user->startdate = $data->startdate;
$user->enddate = $data->enddate;
$user->status = $data->status;

try {
    $user->update();
    echo Helpers::responsejson(200,"✅ User Updated!",$user);
} catch(Exception $exception) {
    echo Helpers::responsejson(200,"❌ Cannot Update User!",$exception->getMessage());
}
