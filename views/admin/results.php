<?php
session_start();

if (isset($_SESSION['User_Role_ID']))
	{
	if ($_SESSION['User_Role_ID'] == 1)
		{

		include '../../templates/header.php';
        
        include '../../config/functions.php';
        
        include "../../config/connect.php";

		include '../../templates/nav.php';
        
        	echo '
    <div class="container center">
        <div class="row">
            <div class="col-lg-12">
                <div id="testtitle" class="page-header">
                    <h2>Room code: <strong>'; 
        getRoomCode(); 
        echo'</strong></h2>
                </div>
            </div>
        </div>';
        
        echo '<div id="testform" class=""> <form method="POST" name="closetest" action="">
         <input type="submit" class="waves-effect waves-light btn blue darken-3" name="closetest" value="Close Test">
    </form></div>';
            
if (isset($_POST['closetest']))
{

    $ts = $_GET["tid"];

    $stmt = mysqli_prepare($conn, "UPDATE test_set 
                                          SET isOpen = 0 WHERE id= ?");
    $stmt->bind_param("i", $ts);
    $result = $stmt->execute();
    if ( $result === FALSE ) {
        echo 'Test Not closed, in fact the query failed ' . $stmt->error;
    } else {
         echo ' <script>
        Materialize.toast("Test Closed!", 3000)
        
        $("#testtitle").css( "display", "none" );
        $("#testform").css( "display", "none" );
        </script>
        ';   
    }
    $stmt->close();
    $conn->close();

}

    
        echo '<div class="row">';
        
       getQuestionsForSet();
        
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