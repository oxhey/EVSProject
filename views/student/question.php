<?php
session_start();

if (isset($_SESSION['User_Role_ID']))
	{
	if ($_SESSION['User_Role_ID'] == 2)
		{
		include "../../templates/header.php";

		include "../../config/connect.php";
        include "../../config/functions.php";
		//include "../../templates/nav_student.php";
        
        getQuestion();
    
        
       // echo'<button type="button"  class="waves-effect waves-light btn mcqtest" id="next">Next</button>';
        
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
