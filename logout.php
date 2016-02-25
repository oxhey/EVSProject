<?php 
session_start();
		unset($_SESSION["Login_ID"]);
		unset($_SESSION["Name"]);
		unset($_SESSION["User_Role_ID"]);

session_destroy();


header("Location: index.php");
?>