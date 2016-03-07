<?php

// Functions file. This contain all code that edits the DB.
// Random 4 digits SELECT FLOOR(0+ RAND() * 10000)


// Prepared Return User ID
// This is used throughtout the functions file
// It is used as a variable in other functions
function getID()
	{
	require "connect.php";

	$stmt = mysqli_prepare($conn, "SELECT id, Login_ID FROM user WHERE Login_ID = ?");
    
    $lid = $_SESSION["Login_ID"];
    
    $stmt->bind_param("i", $lid);
    $stmt->execute();
    $stmt->bind_result($id, $Login_ID);
    $stmt->fetch();
    
	$userID = $id;

	//echo $userID;

	return $userID;
    
     $stmt->close();
     $conn->close();
	}



// Prepared Login
// This code logs the user in and redirets them based on what type of user they are
// I originaly tried to do this and got it fixed from:
// http://stackoverflow.com/questions/35844355/mysqli-prepared-statement-not-wokring

if (isset($_POST['login'])) {
    require "connect.php";

    session_start();

    if (count($_POST) > 0) {
        if ($stmt = mysqli_prepare($conn, "SELECT id, Login_ID, Name, User_Role_ID FROM user WHERE Login_ID = ?")) {
            
            $lid = $_POST["id"];

            $stmt->bind_param("i", $lid);
            $stmt->execute();
            $stmt->bind_result($id, $Login_ID, $Name, $User_Role_ID);
            $stmt->fetch();

            $_SESSION["Student_DB_ID"] = $id;
            $_SESSION["Login_ID"] = $Login_ID;
            $_SESSION["Name"] = $Name;
            $_SESSION["User_Role_ID"] = $User_Role_ID;

            switch ($User_Role_ID) {
                case "2":
                    header("Location: ../views/student/");
                    break; //Student
                case "1":
                    header("Location: ../views/admin/");
                    break; //Admin
                default:
                    echo "Invalid ID!"; 
            }

            /* close statement */
            $stmt->close();
            $conn->close();
        }
    }
}

// Prepared Enter Room Code
// This checks if the room coe the user enter is correct and if the room is open
// The user is redirected depending on the answer
if (isset($_POST['room']))
	{
	require "connect.php";

	$stmt = mysqli_prepare($conn, "SELECT id, isOpen FROM test_set WHERE Room_Code = ?");
    
    $cd = $_POST["code"];
    
         $stmt->bind_param("s", $cd);
         $stmt->execute();
         $stmt->bind_result($id, $isOpen);
         $stmt->fetch();
    
    
     switch ($isOpen) {
                case "0":
                    header("Location: ../views/student/closed.php");
                    break; //Student
                case "1":
                   $_SESSION["Test_ID"] = $id;
		           $room = $id;
		          header("Location: ../views/student/question.php?test=" . $room);
                    break; //Admin
                default:
                    echo "Invalid Room Code!"; 
            }

     $stmt->close();
     $conn->close();
    
	}

function getQuestion()
	{
	require "connect.php";

	$stmt = mysqli_prepare($conn, "SELECT id, Test_ID, QText FROM question WHERE Test_ID = ?");
        
    $tid = $_GET["test"];
    
         $stmt->bind_param("i", $tid);
         $stmt->execute();
         $stmt->bind_result($id, $Test_ID, $QText);    
    
	while ($stmt->fetch())
		{
		echo '
    <div class="question container center" id="' . $id . '">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header">
                    <h5>Q. ' . $QText . '</h5>
                </div>
            </div>
        </div>';
        
       
		$question = $id;        
		$testid = $Test_ID;
		$userid = getID();
        
        //echo $question;
        //echo $testid;
        //echo $userid;

        
		//$stmt2 = mysqli_prepare($conn, "SELECT id, Question_ID, AText FROM answer WHERE Question_ID = ?");
        
        if ($stmt2 = mysqli_prepare($conn, "SELECT id, Question_ID, AText FROM answer WHERE Question_ID = ?")) {
    $stmt->bind_param(...);
    ...
}
else {
    printf("Errormessage: %s\n", $mysqli->error);
}
        
        $stmt2->bind_param("i", $question);
        $stmt2->execute();
        $stmt2->bind_result($aid, $AText);
         printf("Number of rows: %d.\n", $stmt2->num_rows);
        
		echo '  <div class="row">
            <div class="col s12">';
        
		while ($stmt2->fetch())
			{
            echo "OK";
			echo '<p><a onclick="save(' . $aid . ',' . $question . ',' . $testid . ',' . $userid . ')"  id="AncharID" data-myid="' . $aid . '" class="waves-effect waves-light btn-large blue-grey lighten-2 btn-width mcqtest">' . $AText . '</a></p>';
			}

		echo '</div>
        </div>
    </div>';
		}

	echo '  
        <div class="question container center" style="display: none;">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header">
                    <h5>Thank You</h5>
                    <p>End of test</p>
                </div>
            </div>
        </div>  
    </div>';
    
    $stmt->close();
     $stmt2->close();
     $conn->close();
	}

function listResults()
	{
	require "connect.php";

	$userid = getID();

	// echo $userid;

	$result2 = mysqli_query($conn, "SELECT DISTINCT(ua.Test_ID),ts.Name,
    (select count(*) from user_answers t where t.Test_ID = ua.Test_ID AND t.User_ID = '" . $userid . "') as UA
    FROM user_answers ua
INNER JOIN test_set ts ON ts.id = ua.Test_ID
WHERE ua.User_ID = '" . $userid . "' ");
	if (!$result2)
		{
		printf("Error: %s\n", mysqli_error($conn));
		exit();
		}

	echo '<table class="striped centered">
        <thead>
          <tr>
              <th data-field="id">Test Name</th>
              <th data-field="qnum">Number of Answers</th>
              <th data-field="action">Actions</th>
          </tr>
        </thead>

        <tbody>
        <div class="row">
            <div class="col s12">';
	while ($data = mysqli_fetch_array($result2))
		{
		echo '<tr>
            <td>' . $data['Name'] . '</td>
            <td>' . $data['UA'] . '</td>
            <td><a href="deep_results.php?test=' . $data['Test_ID'] . '&user=' . $userid . '">View Test</a></td>
          </tr>';
		}

	echo '    </tbody>
      </table>
      </div>
        </div>
    </div>';
	}

function deepResults()
	{

	// fixed by http://stackoverflow.com/questions/35455705/only-display-once-in-while-loop

	$test = $_GET["test"];
	$userid = $_GET["user"];
	require "connect.php";

	$result = mysqli_query($conn, "SELECT
    q.QText, q.id AS QId, ua.id, a.AText, ca.id, ca.Answer_ID,
    case when a.id = ua.Answer_ID then 'x' else NULL end as IsUserAnswer , 
    case when a.id = ca.Answer_ID then 'y' else NULL end as IsCorrectAnswer 
    FROM user_answers ua
INNER JOIN question q ON q.id = ua.Question_ID
INNER JOIN answer a ON a.Question_ID = q.id 
INNER JOIN correct_answer ca ON ca.Question_ID = q.id 
WHERE ua.Test_ID=$test AND ua.User_ID=$userid 
ORDER BY q.ID") or die(mysqli_error($conn));
	$lastQuestionID = 0;
	$isTableOpen = false;
	while ($data2 = mysqli_fetch_array($result))
		{
		if ($data2['QId'] != $lastQuestionID)
			{
			if ($isTableOpen)
				{
				echo '</table>';
				}

			$isTableOpen = true;
			echo '<p>Q. ' . $data2['QText'] . '</p>
    <table class="striped centered">
      <thead>
        <tr>
          <th>Answer</th>
          <th>Your Answer</th>
          <th>Correct Answer</th>
        </tr>
      </thead>';
			}

		echo '
  <tr>
  <td>' . $data2['AText'] . '</td>
  <td class="' . $data2['IsUserAnswer'] . '">' . $data2['IsUserAnswer'] . '</td>
  <td class="' . $data2['IsCorrectAnswer'] . '">' . $data2['IsCorrectAnswer'] . '</td>
  </tr>';
		$lastQuestionID = $data2['QId'];
		}

	if ($isTableOpen)
		{ // Close last table
		echo '</table>';
		}
	}

if (isset($_POST['answer'], $_POST['question'], $_POST['test'], $_POST['user']))
	{

	// do something with POST data, save in db.. (make sure to include security when inserting to db)

	require "connect.php";

	$userid = $_POST['user'];
	$answerid = $_POST['answer'];
	$questionid = $_POST['question'];
	$testid = $_POST['test'];
	mysqli_query($conn, "INSERT INTO `user_answers`(`User_ID`,`Test_ID`,`Question_ID`,`Answer_ID`) VALUES ('$userid','$testid','$questionid','$answerid')");
	if (mysqli_affected_rows($conn))
		{
		echo json_encode(array(
			'status' => 1
		));
		}
	  else
		{
		echo json_encode(array(
			'status' => 0
		));
		}
	}

// -------------------------------- Admin Stuff -------------------------------

function getTestSet()
	{
	require "connect.php";

	$result = mysqli_query($conn, "SELECT * FROM test_set");
	echo "<div class='input-field col s12'>
<select name='testset' id='testset' required>
<option disabled selected>Please Choose A Test Set</option>";
	while ($data = mysqli_fetch_array($result))
		{
		echo "<option value='" . $data["id"] . "'>" . $data["Name"] . "</option>";
		}

	echo "</select><label>Choose a Test Set</label></div>";
	}

function getTestName()
	{
	require "connect.php";

    $test = $_GET["tid"];
    
	$result = mysqli_query($conn, "SELECT Name FROM test_set WHERE id=$test");
    
while ($data = mysqli_fetch_array($result))
		{
		echo $data['Name'];
		}
    
	}


function getQuestionsForSet()
	{
	require "connect.php";

    $test = $_GET["tid"];
    
	$result = mysqli_query($conn, "SELECT * FROM question WHERE Test_ID= $test");

    echo '        <section class="bar-chart">
  <h3 class="chart-title">Title</h3>
  <p class="chart-prompt">Sub Title</p>
  
  <ul class="chart-xaxis">
    <li>0%</li>
    <li>100%</li>
  </ul> ';
    
	while ($data = mysqli_fetch_array($result))
		{      
        $quest = $data["id"];
        $qtxt = $data["QText"];
        
        echo $qtxt;
    
    $result2 = mysqli_query($conn, "SELECT * FROM answer WHERE Question_ID= $quest");

	while ($data2 = mysqli_fetch_array($result2))
		{
        
        $aid = $data2["id"];
        
        $result3 = mysqli_query($conn, "SELECT  COUNT(*) AS UA FROM user_answers WHERE Answer_ID= $aid");

	while ($data3 = mysqli_fetch_array($result3))
		{
    
        
		echo '   
  <div class="chart-row">
    <p class="chart-caption">' . $data2['AText'] . '</p>
    <div class="bar-wrap">
      <span>' . $data3['UA'] . '%</span>
      <div class="chart-bar" data-bar-value=' . $data3['UA'] . '%><h6>' . $data3['UA'] . '%</h6></div>
    </div>
  </div>';   
		}
    }
    
    echo'</section>';

	}
    
}


?>