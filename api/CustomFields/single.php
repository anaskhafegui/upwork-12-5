<?php
// Headers for GET Request
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

include_once("../../config/Database.php");
include_once("../../models/CustomFields.php");


// Instantiate DB and Connect to It
$database = new Database();
$db = $database->connect();


// Instantiate blog post object
$customfield = new CustomFields($db);

// Get the Post ID
$customfield->id = isset($_GET["id"]) ? htmlspecialchars($_GET["id"]) : die();

// Get Single Post
$customfield->single();


// Create the Post Array
$single = [
    "id" => $customfield->id,
    "fieldname" => $customfield->fieldname,
    "user" => $customfield->user,
    "timestamp" => $customfield->timestamp,
];

// Convert Single post to JSON
echo json_encode($single, JSON_PRETTY_PRINT);
