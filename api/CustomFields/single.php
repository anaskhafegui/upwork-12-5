<?php
// Headers for GET Request
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

include_once("../../config/Database.php");
include_once("../../models/CustomFields.php");
include_once("../../Helpers.php");


// Instantiate DB and Connect to It
$database = new Database();
$db = $database->connect();


// Instantiate blog post object
$customfield = new CustomFields($db);

// Get the Post ID
$customfield->id = isset($_GET["id"]) ? htmlspecialchars($_GET["id"]) : die();

try {
// Get Single customfield
$customfield->single();


// Create the customfields Array
$single = [
    "id" => $customfield->id,
    "fieldname" => $customfield->fieldname,
    "user" => $customfield->user,
    "timestamp" => $customfield->timestamp,
];

// Convert Single custom field to JSON
echo Helpers::responsejson(200,"Show customfield",$single);
}catch(Exception $exception){
    echo Helpers::responsejson(200,$exception->getMessage(),[]);
}
