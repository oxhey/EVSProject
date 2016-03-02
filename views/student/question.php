<?php
session_start();

if (isset($_SESSION['User_Role_ID']))
	{
	if ($_SESSION['User_Role_ID'] == 2)
		{
		include "../../templates/header.php";

		include "../../config/connect.php";
        include "../../config/functions.php";
        
        getQuestion();
        
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
