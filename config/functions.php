<?php

// Functions file. This contain all code that edits the DB.
// Random 4 digits SELECT FLOOR(0+ RAND() * 10000)

function getID()
	{
	require "connect.php";

	$id = mysqli_query($conn, "SELECT id, Login_ID FROM user WHERE Login_ID = '" . $_SESSION["Login_ID"] . "'") or die(mysqli_error($conn));
	$userID = mysqli_fetch_assoc($id);

	// echo $userID['id'];

	return $userID['id'];
	}

if (isset($_POST['login']))
	{
	require "connect.php";

	session_start();
	if (count($_POST) > 0)
		{
		$result = mysqli_query($conn, "SELECT id, Login_ID, Name, User_Role_ID FROM user WHERE Login_ID='" . $_POST["id"] . "' ");
		if (!$result)
			{
			printf("Error: %s\n", mysqli_error($conn));
			exit();
			}

		$row = mysqli_fetch_array($result);
		if (is_array($row))
			{
			$_SESSION["Student_DB_ID"] = $row['id'];
			$_SESSION["Login_ID"] = $row['Login_ID'];
			$_SESSION["Name"] = $row['Name'];
			$_SESSION["User_Role_ID"] = $row['User_Role_ID'];
			switch ($row["User_Role_ID"])
				{
			case "2":
				header("Location: ../views/student/");
				break; //Student
			case "1":
				header("Location: ../views/admin/");
				break; //Admin
				}
			}
		  else
			{
			echo "Invalid ID!";
			}
		}
	}

if (isset($_POST['room']))
	{
	require "connect.php";

	$sql = mysqli_query($conn, "SELECT id, isOpen FROM test_set WHERE Room_Code='" . $_POST["code"] . "'");
	$row = mysqli_fetch_array($sql);
	if ($row['isOpen'] == true)
		{
		session_start();
		$_SESSION["Test_ID"] = $row['id'];
		$room = $row['id'];
		header("Location: ../views/student/question.php?test=" . $room);
		}
	  else
		{
		header("Location: ../views/student/closed.php");
		}
	}

function getQuestion()
	{
	require "connect.php";

	$sql = mysqli_query($conn, "SELECT id, Test_ID, QText from question WHERE Test_ID = '" . $_SESSION["Test_ID"] . "'");
	while ($data = mysqli_fetch_array($sql))
		{
		echo '
    <div class="question container center" id="' . $data['id'] . '">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header">
                    <h5>Q. ' . $data['QText'] . '</h5>
                </div>
            </div>
        </div>';
		$question = $data['id'];
		$testid = $data['Test_ID'];
		$userid = $_SESSION["Student_DB_ID"];
		$sql2 = mysqli_query($conn, "SELECT id, AText from answer WHERE Question_ID = $question");
		echo '  <div class="row">
            <div class="col s12">';
		while ($data2 = mysqli_fetch_array($sql2))
			{
			echo '<p><a onclick="save(' . $data2['id'] . ',' . $question . ',' . $testid . ',' . $userid . ')"  id="AncharID" data-myid="' . $data2['id'] . '" class="waves-effect waves-light btn-large blue-grey lighten-2 btn-width mcqtest">' . $data2['AText'] . '</a></p>';
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
    
	$result = mysqli_query($conn, "SELECT Name FROM test_set WHERE Test_ID= $test");
    
$testName = mysqli_fetch_assoc($result);
    
		return $userID['Name'];
	}


function getQuestionsforSet()
	{
	require "connect.php";

    $test = $_GET["tid"];
    
	$result = mysqli_query($conn, "SELECT * FROM question WHERE Test_ID= $test");
	echo "<div class='input-field col s12'>
<select name='qiestionset' id='qiestionset' required>
<option disabled selected>Please Choose A Question</option>";
	while ($data = mysqli_fetch_array($result))
		{
		echo "<option value='" . $data["id"] . "'>" . $data["QText"] . "</option>";
		}

	echo "</select><label>Results for Question:</label></div>";
	}

?>