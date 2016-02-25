<?php
$servername = "localhost";
$username = "dbuser";
$password = "dbpassword";
$dbname = "evs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Timestamp settings
$datum = new DateTime();
$timestamp = $datum->format('Y-m-d H:i:s');

//Inital Check
echo "This is test 1. It will show the current user(in the table)";
echo "<br>";
$users = mysqli_query($conn, "SELECT id, name, timestamp FROM user")  or die(mysqli_error($conn));

while ($data = mysqli_fetch_array($users)) {


echo '

<table class="layout display responsive-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Time</th>
            </tr>
        </thead>
    <tr>
    <td>'.$data['id'].'</td>
    <td>'.$data['name'].'</td>
    <td>'.$data['timestamp'].'</td>
    </table>
	
';

  }

echo "<br>";
echo "This is test 2. After an insert this will show the extra user";
echo "<br>";

// prepare and bind
$stmt = $conn->prepare("INSERT INTO user (name, timestamp) VALUES (?, ?)");
$stmt->bind_param("ss", $name, $timestamp);



// set parameters and execute
$name = "Test User";

$stmt->execute();


//echo "New records created successfully";




// Testing the report section
$users = mysqli_query($conn, "SELECT id, name, timestamp FROM user")  or die(mysqli_error($conn));

while ($data = mysqli_fetch_array($users)) {


echo '

<table class="layout display responsive-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Time</th>
            </tr>
        </thead>
    <tr>
    <td>'.$data['id'].'</td>
    <td>'.$data['name'].'</td>
    <td>'.$data['timestamp'].'</td>
    </table>
	
';

  }

?>