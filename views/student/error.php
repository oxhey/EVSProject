<?php
session_start();

		include "../../templates/header.php";
		include "../../config/connect.php";
        include "../../config/functions.php";
		include "../../templates/nav.php";

     
        
		echo '
        
    <div class="container">
        <div class="row center">
            <div class="col-lg-12">
                <div class="page-header">
                    <h2>Error!</h2>
                </div>
            </div>
        </div>

        <h3 class="center">This is an invalid room</h3>
            <h4 class="center">The room code is invalid or the room is closed!</h4>
        <br>

    </div>';


 include "../../templates/footer.php"; 

?>