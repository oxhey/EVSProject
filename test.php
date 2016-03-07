<?php

if (isset($_POST['login']))
	{
	require "connect.php";

	session_start();
	if (count($_POST) > 0)
		{
		if ($stmt = mysqli_prepare($conn, "SELECT id, Login_ID, Name, User_Role_ID FROM user WHERE Login_ID = ?"));
        
        $lid = $_POST["id"];
        
        $lid = "14083313";
            
        mysqli_stmt_bind_param($stmt, "s", $lid);
        
        mysqli_stmt_execute($stmt);
            
        mysqli_stmt_bind_result($stmt, $id, $Login_ID, $Name, $User_Role_ID);
            
        mysqli_stmt_fetch($stmt);

    printf("%s is in district %s\n", $city, $district);
            
            if (is_array($stmt))
			{
            $_SESSION["Student_DB_ID"] = $id;
			$_SESSION["Login_ID"] = $Login_ID;
			$_SESSION["Name"] = $Name;
			$_SESSION["User_Role_ID"] = $User_Role_ID;
			switch ($row["User_Role_ID"])
				{
			case "2":
				header("Location: ../views/student/");
				break; //Student
			case "1":
				header("Location: ../views/admin/");
				break; //Admin
				}
            }
		  else
			{
			echo "Invalid ID!";
			}
            

    /* close statement */
    mysqli_stmt_close($stmt);
        
		}
	}

?>