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


// Instantiate setting object
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
    echo  Helpers::responsejson(200,"Get Settings",$settingsArr);
} else {
    // No Get settings Fields in the DB
    echo Helpers::responsejson(200,"No Settings Found",[]);
}
