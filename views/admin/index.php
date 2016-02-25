<?php
session_start();

if (isset($_SESSION['User_Role_ID']))
	{
	if ($_SESSION['User_Role_ID'] == 1)
		{
        
        $base = "http://localhost:8080/project/";
        
        // echo $base;
        
		include $base.'templates/header.php';

		include $base.'config/connect.php';

		include $base.'templates/nav_admin.php';

		echo '
    <div class="container center">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header">
                    <h2>Academic Home</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col s12">
                <p><a href="addSet.php" class="waves-effect waves-light btn-large yellow darken-4 btn-width">New Test Set</a></p>
                <p><a href="add.php" class="waves-effect waves-light btn-large blue darken-4 btn-width">New Question</a></p>
                <p><a class="waves-effect waves-light btn-large red darken-4 btn-width">Edit Test</a></p>
                <p><a class="waves-effect waves-light btn-large green darken-4 btn-width">View Reports</a></p>
            </div>
        </div>
    </div>';

    include "../../templates/footer.php";

		}
	  else
		{
		header("Location: ../");
		}
	}
  else
	{
	echo "Please Login First";
	} ?>