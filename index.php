<!--
Project Name : EVS Final Year Project
Author		 : Stefan Lazic
Email	 	 : lazis002[at]gmail.com
Section      : Login
-->

<?php 
include "templates/header.php";
include "templates/nav.php";
include "config/functions.php";
include "config/connect.php";

?>

    <div class="container">
        <div class="row center">
            <div class="col-lg-12">
                <div class="page-header">
                    <h2>EVS Login</h2>
                </div>
            </div>
        </div>

        <form method="post" name="login" action="config/functions.php">
            <div class="message">
            </div>
            <label for="id" class="sr-only">Your ID</label>
            <input type="text" id="id" name="id" class="form-control" placeholder="Please Login With Your ID" required>
            <br>
            <input type="submit" class="waves-effect waves-light btn blue darken-3" name="login" value="Login">
        </form>

        <br>

    </div>

    <?php include "templates/footer.php"; ?>