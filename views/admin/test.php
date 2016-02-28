<?php
session_start();

if (isset($_SESSION['User_Role_ID']))
	{
	if ($_SESSION['User_Role_ID'] == 1)
		{

		include '../../templates/header.php';
        
        include '../../config/functions.php';
        
        require "../../config/connect.php";

		include '../../templates/nav_admin.php';
        
        if (isset($_POST['opentest']))
	{
    
    $ts = $_POST["testset"];
    
    mysqli_query($conn, "UPDATE test_set SET isOpen = 1 WHERE id=$ts");
    //$last_id = mysqli_insert_id($conn);
    //echo $last_id;
   
     header("Location: results.php?tid=" . $ts);      

}
                
echo '
    <div class="container center">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header">
                    <h2>Test Administration</h2>
                </div>
            </div>
        </div>
        <div class="row">
               <form method="POST" name="opentest" action="">';
        
        getTestSet();

        echo '
        </div>
         <input type="submit" class="waves-effect waves-light btn blue darken-3" name="opentest" value="Open Test">
    </form>
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