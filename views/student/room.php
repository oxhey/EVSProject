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

     
        
		echo '
        
    <div class="container">
        <div class="row center">
            <div class="col-lg-12">
                <div class="page-header">
                    <h2>Room Code</h2>
                </div>
            </div>
        </div>

        <form method="POST" name="room" action="../../config/functions.php">
            <div class="message">
            </div>
            <label for="code" class="sr-only">Room Code</label>
            <input type="text" id="code" name="code" class="form-control" placeholder="Please Enter Room Code">
            <br>
            <input type="submit" class="waves-effect waves-light btn blue darken-3" name="room" value="room">
        </form>

        <br>

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