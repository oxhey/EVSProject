<?php
session_start();

if (isset($_SESSION['User_Role_ID']))
	{
	if ($_SESSION['User_Role_ID'] == 1)
		{

		include '../../templates/header.php';
        
        include '../../config/functions.php';
        
        require "../../config/connect.php";

		include '../../templates/nav.php';
        
if (isset($_POST['adds']))
	{
    
    $name = $_POST["name"];
    $des = $_POST["des"];
    $isOpen = 0;
    $roomCode = $_POST["rc"];
    $Code = $roomCode . rand(10,1000);
    $Group_ID = 1;    
    
   echo '<script>Materialize.toast("Test set &quot; '.$name.' &quot; was added!", 3000)</script>';
    
    mysqli_query($conn, "INSERT INTO test_set (Name,Description,isOpen,Group_ID,Room_Code) VALUES ('$name', '$des','$isOpen', '$Group_ID', '$Code')");
    //$last_id = mysqli_insert_id($conn);
    
    
    

}

        	echo '
    <div class="container center">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header">
                    <h2>Add A Test Set</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col s12">';
            
       
          
        
       echo '
       <form method="POST" name="adds" action="">';
       
      echo' <div class="input-field col s12">
  		<input placeholder="Test Set Name" type="text" name="name" id="name" required>
        <label for="name">Test Set Name</label>
	</div>

	   <div class="input-field col s12">
  		<input placeholder="Description of test" type="text" name="des" id="des" required>
        <label for="des">Description</label>
	</div>
    
    	   <div class="input-field col s12">
  		<input placeholder="Module Initials eg. WAD" type="text" name="rc" id="rc" required>
        <label for="rc">Module Initials</label>
	</div>
    
    <h5>This test is closed by default</h5>
    
      <input type="submit" class="waves-effect waves-light btn blue darken-3" name="adds" value="Add Test Set">
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