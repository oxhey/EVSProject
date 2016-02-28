<?php
session_start();

if (isset($_SESSION['User_Role_ID']))
	{
	if ($_SESSION['User_Role_ID'] == 1)
		{

		include '../../templates/header.php';
        
        include '../../config/functions.php';
        
        include "../../config/connect.php";

		include '../../templates/nav_admin.php';
        
        	echo '
    <div class="container center">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header">
                    <h2>Results for'; 
        echo getTestName(); 
        echo'</h2>
                </div>
            </div>
        </div>

        <div class="row">';
        
       getQuestionsforSet();
        
           echo'</div>
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