<?php
$servername = "localhost";
$username = "dbuser";
$password = "dbpassword";
$dbname = "evs";

// Create connection

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection

if ($conn->connect_error)
	{
	die("Connection failed: " . $conn->connect_error);
	}

// Check

$users = mysqli_query($conn, "SELECT * FROM user WHERE User_Role_ID=2") or die(mysqli_error($conn));
echo "Display ALL users who are Students (User Role 2)";
echo "<br />";
echo '<table class="layout display responsive-table">
        <thead>
            <tr>
                <th>Login_ID</th>
                <th>Name</th>
                <th>Group ID</th>
            </tr>
        </thead>';

while ($data = mysqli_fetch_array($users))
	{
	echo '
    <tr>
    <td>' . $data['Login_ID'] . '</td>
    <td>' . $data['Name'] . '</td>
    <td>' . $data['Group_ID'] . '</td>
    
	
';
	}

echo "</table><br />";
echo "<br />";

// -------------------------------------------------------------------------------------------------

$qna = mysqli_query($conn, "SELECT q.QText, q.id AS QId, a.id, a.AText FROM question q INNER JOIN answer a ON q.id = a.Question_ID WHERE q.id=1") or die(mysqli_error($conn));
$lastQuestionID = 0;

while ($data2 = mysqli_fetch_array($qna))
	{
	if ($data2['QId'] != $lastQuestionID) echo '<p>Q. ' . $data2['QText'] . '</p>
    <table class="layout display responsive-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Answer</th>
            </tr>
        </thead>';
	$lastQuestionID = $data2['QId'];
	echo '

    <tr>
    <td>' . $data2['id'] . '</td>
    <td>' . $data2['AText'] . '</td>
	
';
	}

echo "</table><br />";
?>










function deepResults() {
    
    require "connect.php";
    
 $result = mysqli_query($conn, "SELECT
    q.QText, q.id AS QId, ua.id, a.AText, ca.id, ca.Answer_ID,
    case when a.id = ua.Answer_ID then 'x' else NULL end as IsUserAnswer , 
    case when a.id = ca.Answer_ID then 'x' else NULL end as IsCorrectAnswer 
    FROM user_answers ua
INNER JOIN question q ON q.id = ua.Question_ID
INNER JOIN answer a ON a.Question_ID = q.id 
INNER JOIN correct_answer ca ON ca.Question_ID = q.id 
WHERE ua.Test_ID=1
ORDER BY q.ID") or die(mysqli_error($conn));


$lastQuestionID = 0;
    
        while ($data2 = mysqli_fetch_array($result))
	{
	if ($data2['QId'] != $lastQuestionID) 
        echo '<p>Q. ' . $data2['QText'] . '</p>
    <table class="layout display responsive-table">
        <thead>
            <tr>
                <th>Answer</th>
                <th>Your Answer</th>
                <th>Correct Answer</th>
            </tr>
        </thead>';
            
	$lastQuestionID = $data2['QId'];

    
    echo '

    <tr>
    <td>' . $data2['AText'] . '</td>
     <td>' . $data2['IsUserAnswer'] . '</td>
     <td>' . $data2['IsCorrectAnswer'] . '</td>

';
            }

echo "</table><br />";   
    
}