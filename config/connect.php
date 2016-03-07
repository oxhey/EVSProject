<?php

$servername = "eu-cdbr-azure-west-d.cloudapp.net";
$username = "b675727a3851c7";
$password = "886747ac";
$dbname = "evs";
$port = "3306";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>