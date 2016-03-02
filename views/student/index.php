<?php
session_start();

if (isset($_SESSION['User_Role_ID']))
	{
	if ($_SESSION['User_Role_ID'] == 2)
		{
		include "../../templates/header.php";

		include "../../config/connect.php";

		include "../../templates/nav.php";
        
		echo '
    <div class="container center">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header">
                    <h2>Student Home</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col s12">
                <p><a href="room.php" class="waves-effect waves-light btn-large blue darken-4 btn-width">Take Test</a></p>
                <p><a href="results.php" class="waves-effect waves-light btn-large green darken-4 btn-width">View Results</a></p>
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