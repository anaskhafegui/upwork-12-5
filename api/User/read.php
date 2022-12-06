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

// Blog Post Query
$users = $user->read();

// Get Rows Count
$rows = $users->rowCount();

/* IMPORTANT PART: THIS IS WHERE I'M PROCESSING THE DB DATA INTO JSON */
$usersArr = [];
// Check For Users in The Database
if ($rows > 0) {
    // Posts Available
    while ($row = $users->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $userItem = [
            "id" => $id,
            "email" => $email,
            "startdate" => $startdate,
            "endtdate" => $enddate,
            "status" => $status,
        ];

        // Push user item to data
        array_push($usersArr, $userItem);
    }

    // Turn users array into JSON and display it
    echo  Helpers::responsejson(200,"Get Users",$usersArr);
} else {
    // No users in the DB
    echo Helpers::responsejson(200,"No users Found",[]);
}
