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

// Blog Post Query
$customfields = $customfield->read();

// Get Rows Count
$rows = $customfields->rowCount();

/* IMPORTANT PART: THIS IS WHERE I'M PROCESSING THE DB DATA INTO JSON */

// Check For customfields in The Database
if ($rows > 0) {
    // Posts Available
    $customfieldsArr = [];
    while ($row = $customfields->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $customfieldItem = [
            "id" => $id,
            "fieldname" => $fieldname,
            "user" => $user,
            "timestamp" => $timestamp,
        ];

        // Push customfield item to data
        array_push($customfieldsArr, $customfieldItem);
    }
    $response = [
        'status'=>200,
        'message'=>"Get custom fields",
        'data'=>$customfieldsArr,
    ];

    // Turn customfields array into JSON and display it
    echo json_encode($response, JSON_PRETTY_PRINT);
   
} else {
    $response = [
        'status'=>200,
        'message'=>"No custom field Found",
        'data'=>[],
    ];
    // No customfields in the DB
    echo json_encode($response);
}
