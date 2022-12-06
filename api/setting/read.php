<?php
// Headers for GET Request
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

include_once("../../config/Database.php");
include_once("../../models/Setting.php");


// Instantiate DB and Connect to It
$database = new Database();
$db = $database->connect();


// Instantiate category object
$setting = new Setting($db);

// Setting Query
$settings = $setting->read();

// Get Rows Count
$rows = $settings->rowCount();

/* IMPORTANT PART: THIS IS WHERE I'M PROCESSING THE DB DATA INTO JSON */

// Check For Settings in The Database
if ($rows > 0) {
    // Setting Available
    $settingsArr = [];

    while ($row = $settings->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $settingItem = [
            "id" => $id,
            "type" => $type,
            "value" => $value,
            "user" => $user,
            "timestamp" => $timestamp
        ];
        // Push post item to data
        array_push($settingsArr, $settingItem);
    }
    // Turn categories array into JSON and display it
    echo json_encode($settingsArr, JSON_PRETTY_PRINT);
} else {
    // No Setting in the DB
    echo json_encode(["error" => "No Settings Found"]);
}
