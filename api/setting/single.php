<?php
// Headers for GET Request
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

include_once("../../config/Database.php");
include_once("../../models/Setting.php");
include_once("../../Helpers.php");


// Instantiate DB and Connect to It
$database = new Database();
$db = $database->connect();


// Instantiate blog post object
$setting = new Setting($db);

// Get the Post ID
$setting->id = isset($_GET["id"]) ? htmlspecialchars($_GET["id"]) : die();

try{

// Get Single Setting
$setting->single();


// Create the Post Array
$single = [
    "id" => $setting->id,
    "type" => $setting->type,
    "value" => $setting->value,
    "user" => $setting->user,
    "timestamp" => $setting->timestamp,
];

// Convert Single setting to JSON

echo Helpers::responsejson(200,"Show setting",$single);
}catch(Exception $error){
    echo Helpers::responsejson(200,$error->getMessage(),[]);
}
