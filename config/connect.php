<?php

$servername = "evs.database.windows.net";
$username = "dbadministrator";
$password = "Ramljane1";
$dbname = "evs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

