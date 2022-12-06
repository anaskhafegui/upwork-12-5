<?php
// Headers for GET Request
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

include_once("../../config/Database.php");
include_once("../../models/User.php");
include_once("../../Helpers.php");


// Instantiate DB and Connect to It
$database = new Database();
$db = $database->connect();


// Instantiate blog post object
$user = new User($db);

// Get the Post ID
$user->id = isset($_GET["id"]) ? htmlspecialchars($_GET["id"]) : die();
try{
    // Get Single User
    $user->single();
   
    // Create the Post Array
    $single = [
        "id" => $user->id,
        "email" => $user->email,
        "startDate" => $user->startdate,
        "endDate" => $user->enddate,
        "status" => $user->status,
    ];

    // Convert Single post to JSON
    echo Helpers::responsejson(200,"Show user Found",$single);
}catch(Exception $error){
    echo Helpers::responsejson(200,"user not Found",[]);
}
