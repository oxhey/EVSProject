<?php
// Project Name : EVS Final Year Project
// Author		 : Stefan Lazic
// Email	 	 : lazis002[at]gmail.com
// Section      : Functions.php

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

	// echo $userID;

	return $userID;
	$stmt->close();
	$conn->close();
	}

// Prepared Login
// This code logs the user in and redirets them based on what type of user they are
// I originaly tried to do this and got it fixed from:
// http://stackoverflow.com/questions/35844355/mysqli-prepared-statement-not-wokring

if (isset($_POST['login']))
	{
	session_start();
	require "connect.php";

	if (count($_POST) > 0)
		{
		if ($stmt = mysqli_prepare($conn, "SELECT id, Login_ID, Name, User_Role_ID FROM user WHERE Login_ID = ?"))
			{
			$lid = $_POST["id"];
			$stmt->bind_param("i", $lid);
			$stmt->execute();
			$stmt->bind_result($id, $Login_ID, $Name, $User_Role_ID);
			$stmt->fetch();
			$_SESSION["Student_DB_ID"] = $id;
			$_SESSION["Login_ID"] = $Login_ID;
			$_SESSION["Name"] = $Name;
			$_SESSION["User_Role_ID"] = $User_Role_ID;
			switch ($User_Role_ID)
				{
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
	switch ($isOpen)
		{
	case "0":
		header("Location: ../views/student/closed.php");
		break;
	case "1":
		$_SESSION["Test_ID"] = $id;
		$room = $id;
		header("Location: ../views/student/question.php?test=" . $room);
		break; 
	default:
		echo "Invalid Room Code!";
		}

	$stmt->close();
	$conn->close();
	}

// Prepared Get Question
// This function gets questions and answers based in the id of the test currenlty being taken
// It has a while loop to get a question and another loop inside that to get the answers
// The answers contain 4 different id's that are passed to a jQuery function to be inserted into the DB

function getQuestion()
	{
	require "connect.php";

	$stmt = mysqli_prepare($conn, "SELECT id, Test_ID, QText FROM question WHERE Test_ID = ?");
	$tid = $_GET["test"];
	$stmt->bind_param("i", $tid);
	$stmt->execute();
	$stmt->bind_result($id, $Test_ID, $QText);
	$stmt->store_result();
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
		$stmt2 = mysqli_prepare($conn, "SELECT id, Question_ID, AText FROM answer WHERE Question_ID = ?");
		$stmt2->bind_param("i", $question);
		$stmt2->execute();
		$stmt2->bind_result($aid, $Question_ID, $AText);
		echo '  <div class="row">
            <div class="col s12">';
		while ($stmt2->fetch())
			{
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
	$stmt->free_result();
	$stmt->close();
	$stmt2->close();
	$conn->close();
	}

// Prepared List Results
// This function displays the each test taken & the number of recived answers
// It has a while loop that gets each test details
// Displays a link to view in depth results for each test

function listResults()
	{
	require "connect.php";

	$userid = getID();

	// echo $userid;

	$stmt = mysqli_prepare($conn, "SELECT DISTINCT(ua.Test_ID),ts.Name,
    (select count(*) from user_answers t where t.Test_ID = ua.Test_ID AND t.User_ID = ?) as UA
    FROM user_answers ua
INNER JOIN test_set ts ON ts.id = ua.Test_ID
WHERE ua.User_ID = ? ");
	$stmt->bind_param("ii", $userid, $userid);
	$stmt->execute();
	$stmt->bind_result($Test_ID, $Name, $UA);
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
	while ($stmt->fetch())
		{
		echo '<tr>
            <td>' . $Name . '</td>
            <td>' . $UA . '</td>
            <td><a href="deep_results.php?test=' . $Test_ID . '&user=' . $userid . '">View Test</a></td>
          </tr>';
		}

	echo '    </tbody>
      </table>
      </div>
        </div>
    </div>';
	$stmt->close();
	$conn->close();
	}

// Prepared In-Depth Results
// This function displays the answers for a test given by the user aswell as the correct answer for a question
// Like othe functions , it has a while loop to get this information
// Uses an if statment to determin if the current question is the final question and then end the table
// Fixed by http://stackoverflow.com/questions/35455705/only-display-once-in-while-loop

function indepthResults()
	{
	$test = $_GET["test"];
	$userid = $_GET["user"];
	require "connect.php";

	$stmt = mysqli_prepare($conn, "SELECT q.QText, q.id AS QId, ua.id, a.AText, ca.id, ca.Answer_ID, case when a.id = ua.Answer_ID then 'x' else NULL end as IsUserAnswer , case when a.id = ca.Answer_ID then 'y' else NULL end as IsCorrectAnswer FROM user_answers ua INNER JOIN question q ON q.id = ua.Question_ID INNER JOIN answer a ON a.Question_ID = q.id INNER JOIN correct_answer ca ON ca.Question_ID = q.id WHERE ua.Test_ID = ? AND ua.User_ID = ? ORDER BY q.id");
	$stmt->bind_param("ii", $test, $userid);
	$stmt->execute();
	$stmt->bind_result($QText, $QId, $uaid, $AText, $caid, $Answer_ID, $IsUserAnswer, $IsCorrectAnswer);
	$lastQuestionID = 0;
	$isTableOpen = false;
	while ($stmt->fetch())
		{
		if ($QId != $lastQuestionID)
			{
			if ($isTableOpen)
				{
				echo '</table>';
				}

			$isTableOpen = true;
			echo $QText;
			echo $QId;
			echo $AText;
			echo $IsUserAnswer;
			echo $IsCorrectAnswer;
			echo '<p>Q. ' . $QText . '</p>
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
  <td>' . $AText . '</td>
  <td class="' . $IsUserAnswer . '">' . $IsUserAnswer . '</td>
  <td class="' . $IsCorrectAnswer . '">' . $IsCorrectAnswer . '</td>
  </tr>';
		$lastQuestionID = $QId;
		}

	if ($isTableOpen)
		{ // Close last table
		echo '</table>';
		}

	$stmt->close();
	$conn->close();
	}

// Prepared Insert Answer
// This takes the posted information from a question when a user selects an answer
// The information is passed here and saved in variables
// It is then insered into the database
// Returns a status code to say if it was successful

if (isset($_POST['answer'], $_POST['question'], $_POST['test'], $_POST['user']))
	{
	require "connect.php";

	$stmt = mysqli_prepare($conn, "INSERT INTO `user_answers`(`User_ID`,`Test_ID`,`Question_ID`,`Answer_ID`) VALUES (?,?,?,?)");
	$stmt->bind_param("iiii", $userid, $testid, $questionid, $answerid);
	$userid = $_POST['user'];
	$answerid = $_POST['answer'];
	$questionid = $_POST['question'];
	$testid = $_POST['test'];
	$stmt->execute();
	if ($stmt->affected_rows)
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

	$stmt->close();
	$conn->close();
	}

// Prepared Get Test Set
// This function is used to diplay a drop down list of available test sets

function getTestSet()
	{
	require "connect.php";

	$stmt = mysqli_prepare($conn, "SELECT id, Name FROM test_set");
	$stmt->execute();
	$stmt->bind_result($id, $Name);
	echo "<div class='input-field col s12'>
<select name='testset' id='testset' required>
<option disabled selected>Please Choose A Test Set</option>";
	while ($stmt->fetch())
		{
		echo "<option value='" . $id . "'>" . $Name . "</option>";
		}

	echo "</select><label>Choose a Test Set</label></div>";
	$stmt->close();
	$conn->close();
	}

// Prepared Get Test Name
// This function gets the Name if the open test for the live results page

function getTestName()
	{
	require "connect.php";

	$test = $_GET["tid"];
	$stmt = mysqli_prepare($conn, "SELECT Name FROM test_set WHERE id = ?");
	$stmt->bind_param("i", $test);
	$stmt->execute();
	$stmt->bind_result($Name);
	while ($stmt->fetch())
		{
		echo $Name;
		}

	$stmt->close();
	$conn->close();
	}

// Prepared Get Questions For Set
// This function gets questions, answers and user answers and displays them in a bar chart
// This is used when a test is live and the results are coming in

function getQuestionsForSet()
	{
	require "connect.php";

	$test = $_GET["tid"];
	$stmt = mysqli_prepare($conn, "SELECT id, QText FROM question WHERE Test_ID = ?");
	$stmt->bind_param("i", $test);
	$stmt->execute();
	$stmt->bind_result($id, $QText);
	$stmt->store_result();
	echo '<div class="section">
    <ul class="chartlist">';
	while ($stmt->fetch())
		{
		$quest = $id;
		$qtxt = $QText;
       echo '<h5 class="chart-title">' . $qtxt . '</h5>';
		$stmt2 = mysqli_prepare($conn, "SELECT id, AText FROM answer WHERE Question_ID = ?");
		$stmt2->bind_param("i", $quest);
		$stmt2->execute();
		$stmt2->bind_result($aid, $AText);
		$stmt2->store_result();
		while ($stmt2->fetch())
			{
			$stmt3 = mysqli_prepare($conn, "SELECT  COUNT(*) AS UA FROM user_answers WHERE Answer_ID = ?");
			$stmt3->bind_param("i", $aid);
			$stmt3->execute();
			$stmt3->bind_result($UA);
            $stmt3->store_result();
			while ($stmt3->fetch())
                
                $UA2 = $UA * 3; // just to get numbers up
            
				{
				echo '<li>
        <a class="bar">' . $AText . '</a> 
        <span class="count">' . $UA . '</span>
        <span class="index" style="width: ' . $UA2 . '%">(' . $UA . '%)</span>
      </li>';
				}
          
			}
  echo '<br>';
		
		}
echo '</ul></div>';
	$stmt->close();
	$stmt2->close();
	$stmt3->close();
	$conn->close();
	}


// Prepared Get Room Code
// This function displays the room code for an open room so that students can join.

function getRoomCode()
	{
	require "connect.php";

	$test = $_GET["tid"];
    
	$stmt = mysqli_prepare($conn, "SELECT Room_Code FROM test_set WHERE id = ?");
	$stmt->bind_param("i", $test);
	$stmt->execute();
	$stmt->bind_result($Room_Code);
    
    	while ($stmt->fetch())
		{
		echo $Room_Code;
		}
	
	$stmt->close();
	$conn->close();
	}
?>
