<?php
session_start();

if (isset($_SESSION['User_Role_ID']))
	{
	if ($_SESSION['User_Role_ID'] == 1)
		{
        
		include '../../templates/header.php';

		include '../../config/connect.php';

		include '../../templates/nav.php';

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
                <!-- <p><a class="waves-effect waves-light btn-large red darken-4 btn-width">Edit Test</a></p> -->
                <p><a href="openTest.php" class="waves-effect waves-light btn-large green darken-4 btn-width">Open Test</a></p>
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