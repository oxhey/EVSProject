<?php
session_start();

		include "../templates/header.php";
		include "../templates/nav.php";
        

$error = $_GET["eid"];
$_SESSION['User_Role_ID'] = null;

if ($error == 1)
{
    $title = "Invalid ID!";
    $message = "You have entered an invalid id.";
    $btnName = "Back to Login";
    $btnLink = "../index.php";   
}
else if ($error == 2)
{
    $title = "Invalid Room Code!";
    $message = "The code you have entered is invalid. This may be because it has been mistyped or the room is not open yet.";
    $btnName = "Back to Take Test";
    $btnLink = "student/room.php";   
}
else if ($error == 3)
{
    $title = "Not Logged-in!";
    $message = "To access this page you need to login first.";
    $btnName = "Back to Login";
    $btnLink = "../index.php";    
}
else if ($error == 4)
{
    $title = "Access Denied!";
    $message = "You dont have access to this page.";
    $btnName = "Back to Login";
    $btnLink = "../index.php";  
}







		echo '
    <div class="container center">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header">
                    <h2>'. $title .'</h2>
                    <h5>'. $message .'</h5>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col s12">
                <p><a href="' . $btnLink .'" class="waves-effect waves-light btn-large blue darken-4 btn-width">' . $btnName .'</a></p>
                
            </div>
        </div>
    </div>';
        

    include "../templates/footer.php";

?>