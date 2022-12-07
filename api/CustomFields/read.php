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

// Instantiate blog Custom field object
$customfield = new CustomFields($db);

// Custom field Query
$customfields = $customfield->read(isset($_GET['email']) ? $_GET['email'] : NULL);

// Get Rows Count
$rows = $customfields->rowCount();

/* IMPORTANT PART: THIS IS WHERE I'M PROCESSING THE DB DATA INTO JSON */

// Check For customfields in The Database
if ($rows > 0) {
    // Custom fields Available
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
    echo  Helpers::responsejson(200,"Get Custom Fields",$customfieldsArr);
} else {
    // No Get Custom Field in the DB
    echo Helpers::responsejson(200,"No Custom Field Found",[]);
}
