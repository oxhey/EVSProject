<?php
session_start();

if (isset($_SESSION['User_Role_ID']))
	{
	if ($_SESSION['User_Role_ID'] == 2)
		{
		include "../../templates/header.php";

		include "../../config/connect.php";
        include "../../config/functions.php";
		include "../../templates/nav.php";

        
        
		echo '
    <div class="container center">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header">
                    <h2>In-Depth Results</h2>
                </div>
            </div>
        </div>';

        
           indepthResults();
           

    include "../../templates/footer.php";

		}
	  else
		{
		header("Location: ../../views/error.php?eid=4");
		}
	}
  else
	{
	header("Location: ../../views/error.php?eid=3");
	}

?>