<?php
session_start();

if (isset($_SESSION['User_Role_ID']))
	{
	if ($_SESSION['User_Role_ID'] == 2)
		{
		include "../../templates/header.php";

		include "../../config/connect.php";
        include "../../config/functions.php";
		include "../../templates/nav_student.php";
        
  
    
        
       echo'<h4>Sorry , the room is not open yet</h4>';
        
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
