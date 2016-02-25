<?php
session_start();

if (isset($_SESSION['User_Role_ID']))
	{
	if ($_SESSION['User_Role_ID'] == 1)
		{
        
        $base = "http://localhost:8080/project/";
        
        // echo $base;
        
		include $base.'templates/header.php';
        
        include '../../config/functions.php';

		include $base.'templates/nav_admin.php';
        
if (isset($_POST['addq']))
	{
    
    $q = $_POST["question"];
    $ts = $_POST["testset"];
    $a1 = $_POST["a1"];
    $a2 = $_POST["a2"];
    $a3 = $_POST["a3"];
    $a4 = $_POST["a4"];
    
    $group = $_POST["group1"];

    
   echo ' <script>
        Materialize.toast("&quot; '.$q.' &quot; added to Questions!", 3000) // 4000 is the duration of the toast
        </script>';
    
	
	require "../../config/connect.php";
    
    mysqli_query($conn, "INSERT INTO question (Test_ID, QText) VALUES ('$ts', '$q')");
    $last_id = mysqli_insert_id($conn);
    //echo $last_id;
    mysqli_query($conn, "INSERT INTO answer (Question_ID, AText) VALUES ('$last_id', '$a1')");
     $last_a1 = mysqli_insert_id($conn);
    mysqli_query($conn, "INSERT INTO answer (Question_ID, AText) VALUES ('$last_id', '$a2')");
    $last_a2 = mysqli_insert_id($conn);
    mysqli_query($conn, "INSERT INTO answer (Question_ID, AText) VALUES ('$last_id', '$a3')");
    $last_a3 = mysqli_insert_id($conn);
    mysqli_query($conn, "INSERT INTO answer (Question_ID, AText) VALUES ('$last_id', '$a4')");
    $last_a4 = mysqli_insert_id($conn);
    
    
    switch ($group)
				{
			case "4":
				  mysqli_query($conn, "INSERT INTO correct_answer (Question_ID, Answer_ID) VALUES ('$last_id', '$last_a4')");
				break; //Student
			case "3":
				mysqli_query($conn, "INSERT INTO correct_answer (Question_ID, Answer_ID) VALUES ('$last_id', '$last_a3')");
				break; //Admin
            case "2":
				mysqli_query($conn, "INSERT INTO correct_answer (Question_ID, Answer_ID) VALUES ('$last_id', '$last_a2')");
				break; //Student
			case "1":
				mysqli_query($conn, "INSERT INTO correct_answer (Question_ID, Answer_ID) VALUES ('$last_id', '$last_a1')");
				break; 
				}

    

}

        	echo '
    <div class="container center">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header">
                    <h2>Add A Question</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col s12">';
            
       
          
        
       echo '
       <form method="POST" name="addQ" action="">';
        
         getTestSet();
       
      echo' <div class="input-field col s12">
  		<input placeholder="What is the Question?" type="text" name="question" id="question" required>
        <label for="question">Question</label>
	</div>

	   <div class="input-field col s12">
  		<input placeholder="The first Answer is" type="text" name="a1" id="a1" required>
        <label for="a1">Answer 1</label>
	</div>
    
       <div class="input-field col s12">
  		<input placeholder="The second Answer is" type="text" name="a2" id="a2" required>
        <label for="a2">Answer 2</label>
	</div>
    
       <div class="input-field col s12">
  		<input placeholder="The third Answer is" type="text" name="a3" id="a3" required>
        <label for="a3">Answer 3</label>
	</div>
    
       <div class="input-field col s12">
  		<input placeholder="The fourth Answer is" type="text" name="a4" id="a4" required>
        <label for="a4">Answer 4</label>
	</div>
    
    
     <fieldset class="input-field col s12">
     <legend>The Correct Answer Is:</legend>
     <ul>
     <li>
<input name="group1" type="radio" id="ca1" value="1" required />
      <label for="ca1">Answer 1</label>
      </li>
      <li>
   <input name="group1" type="radio" id="ca2" value="2" />
      <label for="ca2">Answer 2</label>
      </li>
      <li>
<input name="group1" type="radio" id="ca3" value="3" />
      <label for="ca3">Answer 3</label>
      </li>
      <li>
 <input name="group1" type="radio" id="ca4" value="4" />
      <label for="ca4">Answer 4</label>
       </li>
       </ul>
   </fieldset>
    
      <input type="submit" class="waves-effect waves-light btn blue darken-3" name="addq" value="Add Question">
    </form>
                    
        
           </div>
        </div>
    </div>';
	
        

    include "../../templates/footer.php";

		}
	  else
		{
		echo "No";
		}
	}
  else
	{
	echo "Please Login First";
	} ?>	