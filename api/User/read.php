<?php
// Headers for GET Request
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

include_once("../../config/Database.php");
include_once("../../models/User.php");

// Instantiate DB and Connect to It
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$user = new User($db);

// Blog Post Query
$users = $user->read();

// Get Rows Count
$rows = $users->rowCount();

/* IMPORTANT PART: THIS IS WHERE I'M PROCESSING THE DB DATA INTO JSON */

// Check For Users in The Database
if ($rows > 0) {
    // Posts Available
    $usersArr = [];

    while ($row = $users->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $postItem = [
            "id" => $id,
            "email" => $email,
            "startdate" => $startdate,
            "endtdate" => $enddate,
            "status" => $status,
        ];

        // Push post item to data
        array_push($usersArr, $postItem);
    }

    // Turn users array into JSON and display it
    echo json_encode($usersArr, JSON_PRETTY_PRINT);
} else {
    // No users in the DB
    echo json_encode(["error" => "No User Found"]);
}
