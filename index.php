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



// Prepared Login
// This code logs the user in and redirets them based on what type of user they are
// I originaly tried to do this and got it fixed from:
// http://stackoverflow.com/questions/35844355/mysqli-prepared-statement-not-wokring

?>

    <div class="container">
        <div class="row center">
            <div class="col-lg-12">
                <div class="page-header">
                    <h2>EVS Login</h2>
                </div>
            </div>
        </div>

        <form method="POST" name="login" action="config/login.php">
            <label for="id" class="sr-only">Your ID</label>
            <input type="text" id="id" name="id" class="form-control" placeholder="Please Login With Your ID" required>
            <br>
            <input type="submit" class="waves-effect waves-light btn blue darken-3" name="login" value="Login">
        </form>

        <br>

    </div>

    <?php include "templates/footer.php"; ?>