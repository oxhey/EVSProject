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

if (isset($_POST['login'])) {
    require "connect.php";

    session_start();

    if (count($_POST) > 0) {
        if ($stmt = mysqli_prepare($conn, "SELECT id, Login_ID, Name, User_Role_ID FROM user WHERE Login_ID = ?")) {
            
            $lid = $_POST["id"];
            echo $lid;

            $stmt->bind_param("i", $lid);
            $stmt->execute();
            $stmt->bind_result($id, $Login_ID, $Name, $User_Role_ID);
            $stmt->fetch();

            $_SESSION["Student_DB_ID"] = $id;
            $_SESSION["Login_ID"] = $Login_ID;
            $_SESSION["Name"] = $Name;
            $_SESSION["User_Role_ID"] = $User_Role_ID;

            switch ($User_Role_ID) {
                case "2":
                    header("Location: /views/student/");
                    break; //Student
                case "1":
                    header("Location: /views/admin/");
                    break; //Admin
                default:
                    echo "Invalid ID!"; 
            }

            /* close statement */
            $stmt->close();
            $conn->close();
        }
    }
}

?>

    <div class="container">
        <div class="row center">
            <div class="col-lg-12">
                <div class="page-header">
                    <h2>EVS Login</h2>
                </div>
            </div>
        </div>

        <form method="post" name="login" action="">
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